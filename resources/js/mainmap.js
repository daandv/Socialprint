
//LEAFLET MAP ------------------------------------------------------
var map = L.map('mymap',
{
    maxBounds: [[-90,-180],   [90,180]],
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
            noWrap: true
        }).addTo(map);


// api data inladen (printers) origineel
fetch("./printers")
  .then(response => response.json())
  .then(data => {
    var printers = data.data;
    // console.log(printers);
    //cluster
    var markerClusters = L.markerClusterGroup({
      showCoverageOnHover:false,
      maxClusterRadius:100,
    });

    for ( var i = 0; i < printers.length; ++i )
    {
      // var popup = markers[i].name +
      //             '<br/>' + markers[i].city +
      //             '<br/><b>IATA/FAA:</b> ' + markers[i].iata_faa +
      //             '<br/><b>ICAO:</b> ' + markers[i].icao +
      //             '<br/><b>Altitude:</b> ' + Math.round( markers[i].alt * 0.3048 ) + ' m' +
      //             '<br/><b>Timezone:</b> ' + markers[i].tz;

      var popup = printers[i].name + '<br>' + printers[i].lat + '<br>' + printers[i].lng;

      var m = L.marker( [printers[i].lat, printers[i].lng], {title:printers[i].name} )
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
