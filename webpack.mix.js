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

mix.css('resources/css/app.css', 'public/css')
    .js('resources/js/app.js', 'public/js').react()
    .css('resources/css/dashboard.css', 'public/css')
    .js('resources/js/dashboard.js', 'public/js')
    .js('resources/js/Components/AdminDenyTable.jsx', 'public/js/Components').react()
    .css('resources/css/signup.css', 'public/css')
    .js('resources/js/signup.js', 'public/js')
    .css('resources/css/statistics.css', 'public/css')
    .js('resources/js/statistics.js', 'public/js')
    .css('resources/css/event.css', 'public/css')
    .js('resources/js/event/clock.js', 'public/js/event')
    .js('resources/js/event/main.js', 'public/js/event')
    .copyDirectory('resources/images', 'public/images')
