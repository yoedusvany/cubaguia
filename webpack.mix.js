const mix = require('laravel-mix');


mix.react('resources/js/app.js', 'public/js')
    .js('resources/js/app-backend.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');
