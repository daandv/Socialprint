/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/accountcomplete.js":
/*!*****************************************!*\
  !*** ./resources/js/accountcomplete.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

//MINIMAP ---------------------------------------------------------
var map = L.map('minimap', {
  maxBounds: [[-90, -180], [90, 180]]
}).locate({
  setView: true,
  maxZoom: 16
});

function onLocationFound(e) {}

map.on('locationfound', onLocationFound);

function onLocationError(e) {
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
var pinkIcon = L.icon({
  iconUrl: './images/marker_pink.png',
  iconSize: [28, 34.5],
  iconAnchor: [10, 45],
  popupAnchor: [0, -60]
}); //ALGOLIA SEARCH ---------------------------------------------------

(function () {
  var placesAutoComplete = places({
    appId: 'plL558Q5UN5X',
    apiKey: 'b5ab61c4e307a747f2dd28a70860d19a',
    container: document.querySelector('#address'),
    templates: {
      value: function value(suggestion) {
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
    }

    ;
    theMarker = L.marker([e.suggestion.latlng.lat, e.suggestion.latlng.lng], {
      icon: pinkIcon
    }).addTo(map);
    map.setView([e.suggestion.latlng.lat, e.suggestion.latlng.lng], 17);
    console.log(e.suggestion);
  });
  map.on('click', function (e) {
    lat = e.latlng.lat;
    lon = e.latlng.lng; // Set lat en lon to new clicked one

    document.querySelector('#lat').value = lat;
    document.querySelector('#lng').value = lon; // Clear existing marker,

    if (theMarker != undefined) {
      map.removeLayer(theMarker);
    }

    ; // Add a marker to show where you clicked.

    theMarker = L.marker([lat, lon], {
      icon: pinkIcon
    }).addTo(map);
    map.setView([lat, lon], 17);
  });
})();

/***/ }),

/***/ 2:
/*!***********************************************!*\
  !*** multi ./resources/js/accountcomplete.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\Daan\Documents\XamppHosting\Socialprint\resources\js\accountcomplete.js */"./resources/js/accountcomplete.js");


/***/ })

/******/ });