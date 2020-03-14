const path = require('path');
const rootPath = process.cwd();
const merge = require('webpack-merge');
const watchMode = global.watch || false;
var userConfig = require(path.resolve(__dirname, rootPath) + '/resources/assets/config.json');

var themeURLPath = userConfig['themePath'].replace('/web/', '');
var config = merge(
    {
        path: {
            themeURI: userConfig['themePath'],
            theme: path.join(rootPath, userConfig['themePath']), // from root folder path/to/theme
            dist: path.join(rootPath, userConfig['themePath'] + '/dist/'), // from root folder path/to/theme
            assets: path.join(rootPath, userConfig['assetsPath']), // from root folder path/to/assets
            public: 'http://localhost:3000/' + themeURLPath + '/dist/', // Used for webpack.output.publicpath - Had to be set this way to overcome middleware issues with dynamic path.
        },
    },
    userConfig,
);

if (watchMode) {
    config.entry.app.push('webpack-hot-middleware/client');
}
config.entry.app.unshift('./build/publicpath_entry.js');

module.exports = config;
