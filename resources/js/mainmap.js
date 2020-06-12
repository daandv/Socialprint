
//LEAFLET MAP ------------------------------------------------------
var map = L.map('mymap',
{
    maxBounds: [[-90,-180],   [90,180]],
    keyboard: false,
    zoomControl: false,
    zoomSnap: 0.1,
    wheelPxPerZoomLevel: 100
}).locate({setView: true, maxZoom: 16});

function onLocationFound(e) {
  console.log("Locatie gevonden")
    // var radius = e.accuracy;
    //
    // L.marker(e.latlng).addTo(map)
    //     .bindPopup("You are within " + radius + " meters from this point").openPopup();
    //
    // L.circle(e.latlng, radius).addTo(map);
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
            noWrap: true,
        }).addTo(map);

L.control.zoom({
    position: 'bottomright',
}).addTo(map);

var greenIcon = L.icon({
    iconUrl: './images/marker_pink.png',
    // shadowUrl: 'leaf-shadow.png',

    iconSize:     [28, 34.5], // size of the icon
    // shadowSize:   [50, 64], // size of the shadow
    iconAnchor:   [10, 45], // point of the icon which will correspond to marker's location
    // shadowAnchor: [4, 62],  // the same for the shadow
    popupAnchor:  [0, -60] // point from which the popup should open relative to the iconAnchor
});

// Load api data
fetch("./printers")
  .then(response => response.json())
  .then(data => {
    var printers = data.data;
    // console.log(printers);
    //cluster
    var markerClusters = L.markerClusterGroup({
      showCoverageOnHover:false,
      maxClusterRadius:30,
    });

    for ( var i = 0; i < printers.length; ++i )
    {
      var popup = '<div class="leafletHeader"><img class="leafletProfilePicture" src="' + printers[i].profile_picture_url +'" alt="Profielfoto"><div class="leafletFavoriteTitle"><span class="leafletFavoriteName">' +
      printers[i].name + '</span><br><span class="leafletFavoriteAddress">' +
      printers[i].streetAndNr + ', ' + printers[i].busNr + printers[i].city + '</span></div></div><div class="leafletPrice"> €' + printers[i].price + ' per pagina</div>' +
      '<div class="leafletPrinterTags"><span>' + printers[i].format +'</span> <span>' + printers[i].color + '</span></div>' +
      '<a href="./print_at/' + printers[i].printer_id + '" class="button-primary leafletButton">Print bij mij</a><a href="./profile/' + printers[i].id + '" class="leafletGreyLink">Of bekijk profiel</a>';

      var m = L.marker( [printers[i].lat, printers[i].lng], {title:printers[i].name, icon:greenIcon} )
                      .bindPopup( popup );

      markerClusters.addLayer( m );
    }
    map.addLayer( markerClusters );

    //ZICHTBARE MARKERS
    map.on('moveend', function() {
      var notclusteredmarkers = []
      markerClusters.eachLayer(function(feature) {
          if (map.hasLayer(feature)) {
              notclusteredmarkers.push(feature)
          }
      });
                    console.log(notclusteredmarkers);
    });


  })
  .catch(function(error) {
    console.log(error);
  });






  //ALGOLIA SEARCH ---------------------------------------------------
  (function() {
    var placesAutoComplete = places({
      appId: 'plL558Q5UN5X',
      apiKey: 'b5ab61c4e307a747f2dd28a70860d19a',
      container: document.querySelector('#adress'),
      templates: {
        value: function(suggestion) {
          return suggestion.name;
        }
      }
    }).configure({
      type: 'city',
      countries: ['BE']
    });

    placesAutoComplete.on('change', function resultSelected(e) {
      console.log(e.suggestion);
      map.setView([e.suggestion.latlng.lat, e.suggestion.latlng.lng], 13);


    });
  })();
