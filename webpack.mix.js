const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/mainmap.js', 'public/js')
    .js('resources/js/accountcomplete.js', 'public/js')
    .js('resources/js/accountEditPrinter.js', 'public/js')
    .js('resources/js/accountEditNonPrinter.js', 'public/js')
    .js('resources/js/fileUpload.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .copy('resources/css/leaflet.css', 'public/css')
    .copy('resources/css/MarkerCluster.css', 'public/css')
    .copy('resources/css/MarkerCluster.Default.css', 'public/css');
