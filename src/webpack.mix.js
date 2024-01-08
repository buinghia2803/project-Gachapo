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

mix.copyDirectory('resources/js', 'public/js');
mix.copy('resources/css/bootstrap.min.css', 'public/css');
mix.copy('resources/js/bootstrap-datetimepicker.min.js', 'public/js/bootstrap-datetimepicker.min.js');
mix.copy('resources/js/datepicker.min.js', 'public/js/datepicker.min.js');
mix.copy('resources/css/bootstrap-datetimepicker.min.css', 'public/css');
mix.copy('resources/css/jquery.datetimepicker.min.css', 'public/css');
mix.copy('resources/css/datepicker.css', 'public/css');
mix.copyDirectory('resources/images', 'public/images');
mix.copyDirectory('resources/fonts', 'public/fonts');

mix.js('resources/js/app.js', 'public/js/app.min.js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/admin.scss', 'public/css')
    .sass('resources/sass/preview-gacha.scss', 'public/css')
    .version([
        '**/*.css',
        '**/*.js',
        'images/**/*'
    ]);

mix.sourceMaps();
