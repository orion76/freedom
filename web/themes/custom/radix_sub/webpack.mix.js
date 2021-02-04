/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your application. See https://github.com/JeffreyWay/laravel-mix.
 |
 */
const proxy = 'http://freedom.ti-work.ru';
const host = 'freedom.ti-work.ru';
const mix = require('laravel-mix');
const { exec } = require("child_process");
/*
 |--------------------------------------------------------------------------
 | Configuration
 |--------------------------------------------------------------------------
 */
mix
    .setPublicPath('assets')
    .disableNotifications()
    .options({
        processCssUrls: false
    });

if (!mix.inProduction()) {
    mix.webpackConfig({
        devtool: 'inline-source-map'
    }).sourceMaps()
}
/*
 |--------------------------------------------------------------------------
 | Browsersync
 |--------------------------------------------------------------------------
 */
mix.browserSync({
    proxy: proxy,
    // host:host,
    files: [ 
        'assets/js/**/*.js',
        'assets/css/**/*.css',
        // 'templates/**/*.twig'
    ],
    stream: true,
});


/*
 |--------------------------------------------------------------------------
 | SASS
 |--------------------------------------------------------------------------
 */
mix.sass('src/sass/radix_sub.style.scss', 'css');

/*
 |--------------------------------------------------------------------------
 | JS
 |--------------------------------------------------------------------------
 */
mix.js('src/js/radix_sub.script.js', 'js');
