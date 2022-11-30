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
mix.sass('resources/scss/dsv.scss','public/css')
    .styles([
        'node_modules/bootstrap/dist/css/bootstrap.min.css',
        'resources/css/su.css',
        'resources/css/upload.css',
        'resources/css/faq.css',
        'node_modules/bootstrap-select/dist/css/bootstrap-select.min.css',
        'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
        'node_modules/@fortawesome/fontawesome-free/css/all.css',
        'node_modules/daterangepicker/daterangepicker.css'
    ], 'public/css/all.css')
    .combine(['public/css/dsv.css', 'public/css/all.css'], 'public/css/dsvplay.css')

mix.copy('node_modules/@fortawesome/fontawesome-free/webfonts/*', 'public/webfonts/');
mix.scripts([
    //'resources/js/app.js',
    'node_modules/jquery/dist/jquery.min.js',
    //'node_modules/@popperjs/core/dist/umd/popper.min.js',
    'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
    'resources/js/su.js',
    'node_modules/corejs-typeahead/dist/typeahead.bundle.js',
    'node_modules/bootstrap-select/dist/js/bootstrap-select.min.js',
    'node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
    'resources/js/spinner.js',
    'node_modules/daterangepicker/moment.min.js',
    'node_modules/daterangepicker/daterangepicker.js',
    'resources/js/download.js',
    'node_modules/echarts/dist/echarts.min.js',
    'node_modules/@chartisan/echarts/dist/chartisan_echarts.js'
], 'public/js/dsvplay.js');
