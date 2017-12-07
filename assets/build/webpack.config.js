/**
* Assets Config file
*/
process.noDeprecation = true;
const env = process.env.NODE_ENV;
const path = require('path');
const ConcatPlugin = require('webpack-concat-plugin');
const webpack = require('webpack');
const ExtractTextPlugin = require("extract-text-webpack-plugin");
const CleanWebpackPlugin = require('clean-webpack-plugin');
const UglifyJSPlugin = require('webpack-uglifyes-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ImageminPlugin = require('imagemin-webpack-plugin').default
const ManifestPlugin = require('webpack-manifest-plugin');

const rootPath = process.cwd();
const variables = {
  browserSyncPath: 'yoururl.dev',
  browserSyncPort: 3000,
  publicPath: path.join(rootPath, 'app'), // from root folder path/to/theme
  distPath:   path.join(rootPath, 'app/dist'), // from root folder path/to/theme
  assetsPath: path.join(rootPath, 'assets'), // from root folder path/to/assets
};



const ExtractNormalCSS  = new ExtractTextPlugin(process.env.NODE_ENV === 'production' ? 'styles/[name].[chunkhash].css' : 'styles/[name].css');
const ExtractCriticalCSS  = new ExtractTextPlugin('styles/critical.php');

if (process.env.NODE_ENV === undefined) {
  process.env.NODE_ENV = isProduction ? 'production' : 'development';
}

const config = {
  context: variables.assetsPath,
  entry: {
    app: ['./scripts/app.js', './styles/critical.scss', './styles/app.scss']
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /(scripts|node_modules)/,
        use: {
          loader: 'buble-loader', options: { objectAssign: 'Object.assign' }
        }
      },
      {
        test: /\.(css|scss|sass)$/,
        include: variables.assetsPath,
        exclude: /critical.scss$/,
        use: ExtractNormalCSS.extract({
          fallback: 'style-loader',
          use: [
            {loader: 'css-loader'},
            {
              loader: 'postcss-loader', options: {
                config:{
                  path: __dirname,
                },
              },
            },
            {loader: 'sass-loader'}
          ],
        }),
      },
      {
        test: /critical.scss$/,
        use: ExtractCriticalCSS.extract([ 'css-loader', 'sass-loader' ]),
        include: variables.assetsPath
      },
      {
        test: /\.(png|jpe?g|gif|svg|ico)$/,
        include: variables.assetsPath,
        use: [
          {
            loader: 'url-loader',
            options: {name: process.env.NODE_ENV === 'production' ? 'images/[name].[hash:6].[ext]' : 'images/[name].[ext]', publicPath: '../', limit: 8192}
          }
        ]
      },
      {
        test: /\.(eot|ttf|woff|woff2)$/,
        include: variables.assetsPath,
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
    path: path.resolve(__dirname, variables.distPath)
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
      from: variables.assetsPath+'/images/',
      to: process.env.NODE_ENV === 'production' ? 'images/[name].[hash].[ext]' : 'images/[name].[ext]'

    }],{
      ignore: [
        '.gitkeep'
      ]
    }
  ),
  new ManifestPlugin()
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
    new CleanWebpackPlugin(variables.distPath,{
      root: rootPath,
      verbose: false,
    })
  );
}
if (process.env.NODE_ENV === 'development') {
  config.plugins.push(
    new BrowserSyncPlugin({
      proxy: variables.browserSyncPath,
      port: variables.browserSyncPort,
      files: [
        variables.publicPath+'/**/*.php',
        variables.distPath+'/**/*.js',
        variables.distPath+'/**/*.css'
      ],
      injectChanges: true,
      logFileChanges: true,
      logLevel: 'info',
      logPrefix: 'wepback',
      notify: true,
      open: "local",
      reloadDelay: 0
    })
  )
}

module.exports = config
