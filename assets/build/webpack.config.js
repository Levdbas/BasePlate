/**
 * Assets Config file
 */
process.noDeprecation = true
const env = process.env.NODE_ENV
const devMode = process.env.NODE_ENV !== 'production'
const path = require('path')
const webpack = require('webpack')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin')
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')
const CopyWebpackPlugin = require('copy-webpack-plugin')
const ImageminPlugin = require('imagemin-webpack-plugin').default
const UglifyJsPlugin = require('uglifyjs-webpack-plugin')
const ReplaceInFileWebpackPlugin = require('replace-in-file-webpack-plugin')
const WebpackAutoInject = require('webpack-auto-inject-version')
const rootPath = process.cwd()
var configFile = require(path.resolve(__dirname, rootPath) + '/assets/config.json')

const variables = {
    browserSyncURL: configFile['browserSyncURL'],
    browserSyncPort: configFile['browserSyncPort'],
    sourceMaps: configFile['sourceMaps'],
    themePath: path.join(rootPath, configFile['themePath']), // from root folder path/to/theme
    distPath: path.join(rootPath, configFile['themePath'], 'dist'), // from root folder path/to/theme
    assetsPath: path.join(rootPath, configFile['assetsPath']), // from root folder path/to/assets
}

const config = {
    context: variables.assetsPath,
    entry: {
        app: ['./scripts/app.js', './styles/app.scss'],
        gutenberg: ['./styles/gutenberg.scss'],
    },
    devtool: variables.sourceMaps ? 'cheap-module-eval-source-map' : false,
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        babelrc: false,
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
                    },
                    {
                        loader: 'css-loader',
                        options: {
                            sourceMap: variables.sourceMaps,
                        },
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            config: {
                                path: __dirname + '/postcss.config.js',
                            },
                        },
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: variables.sourceMaps,
                        },
                    },
                ],
            },
            {
                test: /\.(ttf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
                include: variables.assetsPath,
                loader: 'url-loader',
                options: {
                    limit: 4096,
                    name: '[path][name].[ext]',
                },
            },
        ],
    },
    output: {
        filename: 'scripts/[name].js',
        path: path.resolve(__dirname, variables.distPath),
        pathinfo: false,
    },
    plugins: [
        new BrowserSyncPlugin(
            {
                host: 'localhost',
                proxy: variables.browserSyncURL,
                files: [variables.themePath + '/**/*.php'],
            },
            {
                injectCss: true,
            }
        ),
        new WebpackAutoInject({
            // options
            // example:
            components: {
                InjectAsComment: false,
                AutoIncreaseVersion: true,
                InjectByTag: false,
            },
        }),
        new ReplaceInFileWebpackPlugin([
            {
                dir: variables.themePath,
                files: ['style.css'],
                rules: [
                    {
                        search: /(\d+\.)(\d+(.*))/,
                        replace: function(match) {
                            var version = JSON.stringify(require(rootPath + '/package.json').version)
                            var version = version.replace(/['"]+/g, '')
                            return version
                        },
                    },
                ],
            },
        ]),
        new MiniCssExtractPlugin({
            filename: 'styles/[name].css',
        }),
        new webpack.ProvidePlugin({
            $: 'jquery/dist/jquery.slim.js',
            jQuery: 'jquery/dist/jquery.slim.js',
            Popper: 'popper.js/dist/umd/popper.js',
        }),

        new CopyWebpackPlugin(
            [
                {
                    context: variables.assetsPath + '/images',
                    from: '**/*',
                    to: 'images/[name].[ext]',
                },
            ],
            {
                ignore: ['.gitkeep'],
                copyUnmodified: true,
            }
        ),
    ],
    optimization: {
        removeEmptyChunks: false,
        splitChunks: {
            chunks: 'all',
            automaticNameDelimiter: '-',
            name: 'vendor',
        },
        minimizer: [
            new UglifyJsPlugin({
                cache: true,
                sourceMap: variables.sourceMaps,
                uglifyOptions: {
                    compress: true,
                    output: {
                        comments: false,
                    },
                },
            }),
            new OptimizeCSSAssetsPlugin({
                cssProcessorOptions: {
                    map: {
                        inline: false,
                    },
                },
            }),
            new ImageminPlugin({
                disable: process.env.NODE_ENV !== 'production',
                test: /\.(jpe?g|png|gif|svg)$/i,
            }),
        ],
    },
}
module.exports = config
