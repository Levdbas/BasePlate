/**
* Assets Config file
*/
process.noDeprecation = true;
const env = process.env.NODE_ENV;
const devMode = process.env.NODE_ENV !== 'production'
const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CleanWebpackPlugin = require('clean-webpack-plugin');
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ImageminPlugin = require('imagemin-webpack-plugin').default
const ManifestPlugin = require('webpack-manifest-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const rootPath = process.cwd();
var configFile = require(path.resolve(__dirname,rootPath)+'/assets/config.json');
const variables = {
  browserSyncURL: configFile['browserSyncURL'],
  browserSyncPort: configFile['browserSyncPort'],
  themePath: path.join(rootPath, configFile['themePath']), // from root folder path/to/theme
  distPath:   path.join(rootPath, configFile['themePath'], 'dist'), // from root folder path/to/theme
  assetsPath: path.join(rootPath, configFile['assetsPath']), // from root folder path/to/assets
};
if (process.env.NODE_ENV === undefined) {
  process.env.NODE_ENV = isProduction ? 'production' : 'development';
}

const config = {
  context: variables.assetsPath,
  entry: {
    app: ['./scripts/app.js', './styles/app.scss']
  },
  devtool: 'source-map',
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader"
        }
      },
      {
        test: /\.scss$/,
        use:  [
          {
            loader: devMode ? 'style-loader' : MiniCssExtractPlugin.loader,
          },
          {
            loader: 'css-loader',
            options: {
              sourceMap: true,
            },
          },
          {
            loader: 'postcss-loader', options: {
              config:{
                path: __dirname,
              },
              options: {
                sourceMap: true,
              },
            },
          },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: true,
            },
          }
        ],
      },
      {
        test: /\.(ttf|eot|woff2?|png|jpe?g|gif|svg|ico)$/,
        include: variables.assetsPath,
        loader: 'url-loader',
        options: {
          limit: 4096,
          name: devMode  ? '[path][name].[ext]' : '[path][name].[hash].[ext]',
        },
      },
    ]
  },
  output: {
    filename: devMode ? 'scripts/[name].js' : 'scripts/[name].[hash].js',
    path: path.resolve(__dirname, variables.distPath)
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: devMode ? 'styles/[name].css' : 'styles/[name].[contenthash].css',
    }),
    new webpack.ProvidePlugin({
      $: 'jquery/dist/jquery.slim.js',
      jQuery: 'jquery/dist/jquery.slim.js',
      Popper: 'popper.js/dist/umd/popper.js'
    }),
    new BrowserSyncPlugin({
      host: 'localhost',
      proxy: variables.browserSyncURL,
      delay: 500,
      watch: true,
      watchOptions: {
        aggregateTimeout: 300,
        poll: 1000,
        ignored: /node_modules/,
      },
      files: [
        variables.themePath+'/**/*.php'
      ],
    }),
    new CopyWebpackPlugin([
      {
        context: variables.assetsPath+'/images',
        from: '**/*',
        to: devMode ? 'images/[name].[ext]' : 'images/[name].[hash].[ext]',
      }
    ],{
      ignore: [
        '.gitkeep'
      ],
      copyUnmodified: true,
    }
  ),
  new ManifestPlugin({
    map: (file) => {
      if (process.env.NODE_ENV === 'production') {
        // Remove hash in manifest key
        file.name = file.name.replace(/(\.[a-f0-9]{32})(\..*)$/, '$2');
      }
      return file;
    },
  })
],
optimization: {
    minimizer: [
      new UglifyJsPlugin({
        cache: true,
        parallel: true,
        sourceMap: true // set to true if you want JS source maps
      }),
      new OptimizeCSSAssetsPlugin({}),
      new ImageminPlugin({
        disable: process.env.NODE_ENV !== 'production',
        test: /\.(jpe?g|png|gif|svg)$/i
      }),
    ]
  }
};
if (process.env.NODE_ENV === 'production') {
  config.plugins.push(
    new CleanWebpackPlugin(variables.distPath,{
      root: rootPath,
      verbose: false,
    })
  );
}
module.exports = config
