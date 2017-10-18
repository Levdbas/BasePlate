/**
* Assets Config file
*/

process.noDeprecation = true;

const localServer = {
  path: 'testenviroment.dev',
  port: 3000
};

const env = process.env.NODE_ENV;
const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const CleanWebpackPlugin = require('clean-webpack-plugin');
const UglifyJSPlugin = require('webpack-uglifyes-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ImageminPlugin = require('imagemin-webpack-plugin').default
const WebpackAssetsManifest = require('webpack-assets-manifest');

const ExtractNormalCSS  = new ExtractTextPlugin(process.env.NODE_ENV === 'production' ? 'styles/[name].[chunkhash].css' : 'styles/[name].css');
const ExtractCriticalCSS  = new ExtractTextPlugin('styles/critical.php');

const config = {
  entry: {
    app: ['./assets/scripts/app.js', './assets/styles/critical.scss', './assets/styles/app.scss']
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'buble-loader', options: { objectAssign: 'Object.assign' }
        }
      },
      {
        test: /\.scss$/,
        exclude: /critical.scss$/,
        use: ExtractNormalCSS.extract([ 'css-loader', 'sass-loader' ])
      },
      {
        test: /critical.scss$/,
        use: ExtractCriticalCSS.extract([ 'css-loader', 'sass-loader' ])
      },
      {
        test: /\.(eot|svg|ttf|woff|woff2)$/,
        use: [
          {
            loader: 'url-loader',
            options: {name: process.env.NODE_ENV === 'production' ? 'fonts/[name].[hash:6].[ext]' : 'fonts/[name].[ext]', publicPath: '../', limit: 8192}
          }
        ]
      }
    ]
  },
  output: {
    filename: process.env.NODE_ENV === 'production' ? 'scripts/[name].[chunkhash].js' : 'scripts/[name].js',
    path: path.resolve(__dirname, 'app/dist')
  },
  plugins: [
    ExtractNormalCSS,
    ExtractCriticalCSS,
    new webpack.ProvidePlugin({
      $: 'jquery/dist/jquery.slim.js',
      jQuery: 'jquery/dist/jquery.slim.js',
      Popper: 'popper.js/dist/umd/popper.js'
    }),
    new CopyWebpackPlugin([{
      from: 'assets/images/',
      to: process.env.NODE_ENV === 'production' ? 'images/[name].[hash].[ext]' : 'images/[name].[ext]'

    }],{
      ignore: [
        '.gitkeep'
      ]
    }
  ),
  new WebpackAssetsManifest()
]
};

if (process.env.NODE_ENV === 'production') {
  config.plugins.push(
    new UglifyJSPlugin(),
    new OptimizeCssAssetsPlugin({
      assetNameRegExp: /(critical.php|\.css)$/i,
    }),
    new ImageminPlugin({
      disable: process.env.NODE_ENV !== 'production',
      test: /\.(jpe?g|png|gif|svg)$/i
    }),
    new CleanWebpackPlugin('app/dist/')
  );
}
if (process.env.NODE_ENV === 'development') {
  config.plugins.push(
    new BrowserSyncPlugin({
      proxy: localServer.path,
      port: localServer.port,
      files: [
        'app/**/*.php',
        'app/dist/**/*.js',
        'app/dist/**/*.css'
      ],
      injectChanges: true,
      logFileChanges: true,
      logLevel: 'debug',
      logPrefix: 'wepback',
      notify: true,
      open: "local",
      reloadDelay: 0
    })
  )
}

module.exports = config
