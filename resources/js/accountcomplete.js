//MINIMAP ---------------------------------------------------------
var map = L.map('minimap',
{
    maxBounds: [[-90,-180],   [90,180]],
}).locate({setView: true, maxZoom: 16});

function onLocationFound(e) {
  console.log("Locatie gevonden")
}
map.on('locationfound', onLocationFound);

function onLocationError(e) {
    console.log(e.message);
    map.setView([51.050499, 4.410550], 9);
}
map.on('locationerror', onLocationError);


L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            minZoom: 3,
            id: 'mapbox.light',
            accessToken: 'pk.eyJ1IjoiZGR2bWFwcyIsImEiOiJjamhuaTNlNzgzcWtlM2NwZTA0MDF1YmE5In0._G6QYZsmQZpYEuCD3br8VA',
            noWrap: true
        }).addTo(map);



//ALGOLIA SEARCH ---------------------------------------------------
(function() {
  var placesAutoComplete = places({
    appId: 'plL558Q5UN5X',
    apiKey: 'b5ab61c4e307a747f2dd28a70860d19a',
    container: document.querySelector('#address'),
    templates: {
      value: function(suggestion) {
        return suggestion.name;
      }
    }
  }).configure({
    type: 'address',
    countries: ['BE']
  });

  var theMarker = {};

  placesAutoComplete.on('change', function resultSelected(e) {
    document.querySelector('#city').value = e.suggestion.city;
    document.querySelector('#lat').value = e.suggestion.latlng.lat;
    document.querySelector('#lng').value = e.suggestion.latlng.lng;
    document.querySelector('#zip').value = e.suggestion.postcode;

    if (theMarker != undefined) {
          map.removeLayer(theMarker);
    };
    theMarker = L.marker([e.suggestion.latlng.lat,e.suggestion.latlng.lng]).addTo(map);
    map.setView([e.suggestion.latlng.lat, e.suggestion.latlng.lng], 17);
    console.log(e.suggestion);
  });


  map.on('click',function(e){
    lat = e.latlng.lat;
    lon = e.latlng.lng;

    // Set lat en lon to new clicked one
    document.querySelector('#lat').value = lat;
    document.querySelector('#lng').value = lon;

    // Clear existing marker,
    if (theMarker != undefined) {
          map.removeLayer(theMarker);
    };

    // Add a marker to show where you clicked.
     theMarker = L.marker([lat,lon]).addTo(map);
  });

})();
