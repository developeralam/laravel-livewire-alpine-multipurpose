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

<<<<<<< HEAD
mix.js('resources/js/app.js', 'public/js')
mix.js('resources/js/admin.js', 'public/js')
.postCss('resources/css/app.css', 'public/css', [
        //
    ]);
=======
mix.js('resources/js/admin.js', 'public/js')
>>>>>>> f09b6a47968621c9c8b11abf3b9d7e9861cd0efb
