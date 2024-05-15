const mix = require('laravel-mix');
mix.disableNotifications();
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

// mix.styles([
//     'css/all.min.css',
//     'plugins/sweetalert2/sweetalert2.min.css',
//     'css/jquery.fancybox.min.css',
//     'css/bootstrap.min.css',
//     'css/fonts.css',
//     'css/style.css',
//     'css/responsive.css',
//     'css/owl.carousel.min.css',
//     'css/owl.theme.default.min.css',
//     'css/cart.css'
// ], 'css/minify.css');

// mix.scripts([
//      'plugins/jquery/jquery.min.js',
//      'plugins/sweetalert2/sweetalert2.all.min.js',
//      'js/jquery.fancybox.min.js',
//      'js/owl.carousel.min.js',
//      'js/function.js',
//      'js/app.js',
//      'js/addon.js'
// ], 'js/minify.js');
// mix.options({
    // Don't perform any css url rewriting by default
//     processCssUrls: false,
// })
// mix.sass('development/sass/main.scss', 'css', {
//     sassOptions: {
//         processCssUrls: false,
//     }
// }).postCss("src/tailwind.css", "css", [
// require("tailwindcss"),
// require("autoprefixer")({
//     grid: true,
// }),
// ]);
mix.options({
    // Don't perform any css url rewriting by default
    processCssUrls: false,
});
mix.postCss("src/tailwind.css", "css", [
    require("tailwindcss"),
    require("autoprefixer")({
        grid: true,
    }),
]);
mix.browserSync({
    proxy: 'localhost:8000',
    "files": ["resources/views/components/**","resources/views/desktop/**","public/**"],
});
/*mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
]);*/
