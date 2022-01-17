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

mix.sass('resources/assets/sass/portal/app.scss', 'public/assets/portal/css')
    .js('resources/assets/js/portal/app.js', 'public/assets/portal/js')
    .version();

mix.autoload({
    jquery: ['$', 'jQuery', 'window.jQuery', 'window.$'],
    tether: ['Tether', 'window.Tether']
});
