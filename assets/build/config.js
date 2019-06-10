const path = require('path');
const rootPath = process.cwd();
const merge = require('webpack-merge');
const WATCH = global.watch || false;
var userConfig = require(path.resolve(__dirname, rootPath) + '/assets/config.json');

var config = merge(
    {
        path: {
            theme: path.join(rootPath, userConfig['themePath']), // from root folder path/to/theme
            dist: path.join(rootPath, userConfig['themePath'] + '/dist/'), // from root folder path/to/theme
            assets: path.join(rootPath, userConfig['assetsPath']), // from root folder path/to/assets
        },
    },
    userConfig,
);

if (WATCH) {
    config.entry.app.push('webpack-hot-middleware/client');
}

module.exports = config;
