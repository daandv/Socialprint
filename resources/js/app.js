require('./bootstrap');
require('./leaflet.js');
require('./leaflet.markercluster.js');
import tippy from 'tippy.js';

// Tippy
tippy('[data-tippy-content]');

// Navbar
$('.main-nav').click(function(e) {
      $(this).find( "a" ).addClass("lighter");
});
$('.main-nav').find("a").click(function(e) {
    $(this).addClass("brighter");
})
