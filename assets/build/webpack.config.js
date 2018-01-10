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
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ImageminPlugin = require('imagemin-webpack-plugin').default
const ManifestPlugin = require('webpack-manifest-plugin');

const rootPath = process.cwd();
const variables = {
  browserSyncURL: 'testenviroment.dev',
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
        test: /\.(ttf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
        include: variables.assetsPath,
        loader: 'url-loader',
        options: {
          limit: 4096,
          name: process.env.NODE_ENV === 'production' ? '[path][name].[hash:6].[ext]' : '[path][name].[ext]',
        },
      },
    ]
  },
  output: {
    filename: process.env.NODE_ENV === 'production' ? 'scripts/[name].[chunkhash].js' : 'scripts/[name].js',
    path: path.resolve(__dirname, variables.distPath)
  },
  plugins: [
    ExtractNormalCSS,
    ExtractCriticalCSS,
    new BrowserSyncPlugin({
      proxy: variables.browserSyncURL,
      port: variables.browserSyncPort,
      delay: 500,
      watch: true,
      watchOptions: {
        aggregateTimeout: 300,
        poll: 1000,
        ignored: /node_modules/,
      },
      files: [
        variables.publicPath+'/**/*.php'
      ],
    }),
    new ConcatPlugin({
      uglify: process.env.NODE_ENV === 'production' ? true : false,
      sourceMap: false,
      name: 'app',
      outputPath: 'scripts/',
      fileName: process.env.NODE_ENV === 'production' ? '[name].[chunkhash].js' : '[name].js',
      filesToConcat: ['jquery', 'bootstrap', 'popper.js/dist/umd/popper.js', './scripts/**']
    }),
    new CopyWebpackPlugin([
      {
        context: variables.assetsPath+'/images',
        from: '**/*',
        to: process.env.NODE_ENV === 'production' ? 'images/[name].[hash].[ext]' : 'images/[name].[ext]',
      }
    ],{
      ignore: [
        '.gitkeep'
      ],
      debug: 'debug',
      copyUnmodified: true,
    },
  ),
  new ManifestPlugin()
]
};

if (process.env.NODE_ENV === 'production') {
  config.plugins.push(
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
module.exports = config
