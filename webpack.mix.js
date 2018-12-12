/**
 * Note: Using laravel mix for better development experience with CI.
 * 
 * The Javascript src files (uncompiled) are located in the rootdirectory/src folder
 * THe Javascript compiled files are located in the assets/js/dar folder
 */

let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel (In this case CODEIGNITER) application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.disableNotifications();
mix 
    .js('src/assets/js/app.js','assets/js/dar/customapp.js')
    .js('src/assets/js/dashboard.js', 'assets/js/dar')
    .js('src/assets/js/location.js', 'assets/js/dar')
    .js('src/assets/js/surveys.js', 'assets/js/dar')
    .js('src/assets/js/single-survey.js', 'assets/js/dar')
    
; // End of laravel mix