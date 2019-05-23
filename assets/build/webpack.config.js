/**
 * Assets Config file
 */
process.noDeprecation = true;
const env = process.env.NODE_ENV;
const devMode = process.env.NODE_ENV !== 'production';
const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ImageminPlugin = require('imagemin-webpack');
const imageminGifsicle = require('imagemin-gifsicle');
const imageminJpegtran = require('imagemin-jpegtran');
const imageminOptipng = require('imagemin-optipng');
const imageminSvgo = require('imagemin-svgo');
const ManifestPlugin = require('webpack-manifest-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const merge = require('webpack-merge');
const rootPath = process.cwd();

var userConfig = require(path.resolve(__dirname, rootPath) + '/assets/config.json');

const config = merge(
    {
        path: {
            theme: path.join(rootPath, userConfig['themePath']), // from root folder path/to/theme
            dist: path.join(rootPath, userConfig['themePath'], 'dist'), // from root folder path/to/theme
            assets: path.join(rootPath, userConfig['assetsPath']), // from root folder path/to/assets
        },
    },
    userConfig,
);

const webpackConfig = {
    context: config.path.assets,
    entry: config.entry,
    devtool: config.sourceMaps ? 'source-map' : false,
    mode: env,
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        cacheDirectory: true,
                    },
                },
            },
            {
                test: /\.scss$/,
                exclude: /node_modules/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                        options: {
                            publicPath: '../',
                            sourceMap: config.sourceMaps,
                        },
                    },
                    {
                        loader: 'css-loader',
                        options: {
                            sourceMap: config.sourceMaps,
                        },
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            sourceMap: config.sourceMaps,
                            config: {
                                path: __dirname + '/postcss.config.js',
                            },
                        },
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: config.sourceMaps,
                        },
                    },
                ],
            },
            {
                test: /\.(ttf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
                include: config.path.assets,
                loader: 'url-loader',
                options: {
                    limit: 4096,
                    name: devMode ? '[path][name].[ext]' : '[path][name].[hash].[ext]',
                },
            },
        ],
    },
    output: {
        filename: devMode ? 'scripts/[name].js' : 'scripts/[name].[hash].js',
        path: path.resolve(__dirname, config.path.dist),
        pathinfo: false,
    },
    performance: { hints: false },
    plugins: [
        new BrowserSyncPlugin({
            host: 'localhost',
            proxy: config.browserSyncURL,
            files: [config.path.theme + '/**/*.php', config.path.theme + '/**/**/*.php', config.path.theme + '/**/*.twig'],
        }),
        new MiniCssExtractPlugin({
            filename: devMode ? 'styles/[name].css' : 'styles/[name].[contenthash].css',
        }),
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery',
            Popper: 'popper.js/dist/umd/popper.js',
            Alert: 'exports-loader?Alert!bootstrap/js/dist/alert',
            Button: 'exports-loader?Button!bootstrap/js/dist/button.js',
            Carousel: 'exports-loader?Carousel!bootstrap/js/dist/carousel.js',
            Collapse: 'exports-loader?Collapse!bootstrap/js/dist/collapse.js',
            Dropdown: 'exports-loader?Dropdown!bootstrap/js/dist/dropdown.js',
            Modal: 'exports-loader?Modal!bootstrap/js/dist/modal.js',
            Popover: 'exports-loader?Popover!bootstrap/js/dist/popover.js',
            Scrollspy: 'exports-loader?Scrollspy!bootstrap/js/dist/scrollspy.js',
            Tab: 'exports-loader?Tab!bootstrap/js/dist/tab.js',
            Tooltip: 'exports-loader?Tooltip!bootstrap/js/dist/tooltip.js',
            Util: 'exports-loader?Util!bootstrap/js/dist/util.js',
        }),
        new CopyWebpackPlugin(
            [
                {
                    context: config.path.assets + '/images',
                    from: '**/*',
                    to: devMode ? 'images/[path][name].[ext]' : 'images/[path][name].[hash].[ext]',
                },
            ],
            {
                ignore: ['.gitkeep'],
                copyUnmodified: true,
            },
        ),
        new ManifestPlugin({
            map: file => {
                if (process.env.NODE_ENV === 'production') {
                    // Remove hash in manifest key
                    file.name = file.name.replace(/(\.[a-f0-9]{32})(\..*)$/, '$2');
                }
                return file;
            },
        }),
    ],
    optimization: {
        splitChunks: {
            chunks: 'all',
            automaticNameDelimiter: '-',
            name: 'vendor',
        },
        minimizer: [
            new TerserPlugin({
                cache: true,
                parallel: true,
                sourceMap: config.sourceMaps,
            }),
            new ImageminPlugin({
                bail: false, // Ignore errors on corrupted images
                cache: true,
                name: '[path][name].[ext]',
                imageminOptions: {
                    // Lossless optimization with custom option
                    // Feel free to experement with options for better result for you
                    plugins: [
                        imageminGifsicle({
                            interlaced: true,
                        }),
                        imageminJpegtran({
                            progressive: true,
                        }),
                        imageminOptipng({
                            optimizationLevel: 1,
                        }),
                        imageminSvgo({
                            removeViewBox: false,
                        }),
                    ],
                },
            }),
        ],
    },
};
if (process.env.NODE_ENV === 'production') {
    webpackConfig.plugins.push(new CleanWebpackPlugin());
}
module.exports = webpackConfig;
