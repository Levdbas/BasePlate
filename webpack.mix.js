const mix = require('laravel-mix').mix;
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

const resources = 'assets';
const assetsPath = `app/dist`;

mix.setPublicPath(assetsPath);
mix.setResourceRoot('../');

mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery'],
    tether: ['window.Tether', 'Tether']
});

mix.browserSync({
    proxy: 'yoursite.dev',
    files: [
        `${themePath}/**/*.php`,
        `${assetsPath}/**/*.js`,
        `${assetsPath}/**/*.css`
    ]
});

mix.js(`${resources}/scripts/app.js`, `scripts`, {
    includePaths: ['node_modules']
});
mix.sass(`${resources}/styles/app.scss`, `styles`, {
    includePaths: ['node_modules'],
}).options({
    processCssUrls: false
 });
mix.copyDirectory(`${resources}/images`, `${assetsPath}/images`);
// Hash and version files in production.
if (mix.config.inProduction) {
    mix.version();
}
