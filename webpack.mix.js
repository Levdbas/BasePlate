const mix = require('laravel-mix').mix;
let ImageminPlugin = require( 'imagemin-webpack-plugin' ).default;
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
const themePath = 'app';
const assetsPath = `${themePath}/dist`;

mix.setPublicPath(assetsPath);
mix.setResourceRoot('./');

mix.webpackConfig( {
    plugins: [
        new ImageminPlugin( {
//            disable: process.env.NODE_ENV !== 'production', // Disable during development
            pngquant: {
                quality: '95-100',
            },
            test: /\.(jpe?g|png|gif|svg)$/i,
        } ),
    ],
} );

mix.browserSync({
    proxy: 'testenviroment.dev',
    files: [
        `${themePath}/**/*.php`,
        `${assetsPath}/**/*.js`,
        `${assetsPath}/**/*.css`
    ]
});

mix.js(`${resources}/scripts/app.js`, `scripts`);

mix.sass(`${resources}/styles/app.scss`, `styles`, {
    includePaths: ['node_modules']
});
mix.copyDirectory(`${resources}/images`, `${assetsPath}/images`);
// Hash and version files in production.
if (mix.config.inProduction) {
    mix.version();
}
