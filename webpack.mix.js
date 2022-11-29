const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/assets/js/app.js");
mix.combine(
    [
        "resources/css/bootstrap.css",
        "resources/css/icons.css",
        "resources/css/app.css",
    ],
    "public/assets/css/app.css"
);

mix.copyDirectory("resources/fonts", "public/assets/fonts")
    .copyDirectory("resources/images", "public/assets/images")
    .copyDirectory("resources/js/bootstrap", "public/assets/js/bootstrap")
    .copyDirectory("resources/js/jquery", "public/assets/js/jquery")
    .copyDirectory("resources/js/metismenu", "public/assets/js/metismenu")
    .copyDirectory("resources/js/node-waves", "public/assets/js/node-waves")
    .copyDirectory("resources/js/simplebar", "public/assets/js/simplebar")
    .copyDirectory("resources/js/sweetalert2", "public/assets/js/sweetalert2")
    .copyDirectory("resources/js/datatables", "public/assets/js/datatables")
    .copyDirectory("resources/js/select2", "public/assets/js/select2")
    .copyDirectory(
        "resources/js/full-calendar",
        "public/assets/js/full-calendar"
    )
    .copyDirectory("resources/js/fancybox", "public/assets/js/fancybox")
    .copyDirectory("resources/js/page-modules", "public/assets/js/page-modules");