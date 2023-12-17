const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

 mix.styles([
    'resources/vendor/css/all.min.css',
    'resources/vendor/css/adminlte.min.css',
    'resources/vendor/css/OverlayScrollbars.min.css',
], 'public/css/plantilla.css')
.js('resources/js/app.js', 'public/js')
.vue()
.sass('resources/sass/app.scss', 'public/css')
.scripts([
'resources/vendor/js/adminlte.min.js',
'resources/vendor/js/demo.js',
'resources/vendor/js/jquery.overlayScrollbars.min.js',
], 'public/js/plantilla.js')
.copy('resources/vendor/fontawesome/webfonts', 'public/webfonts');