const path = require('path');
const rootPath = process.cwd();
const { merge } = require('webpack-merge');
const watchMode = global.watch || false;
var userConfig = require(path.resolve(__dirname, rootPath) + '/resources/assets/config.json');
var themePath = '/';

/**
 * Check if root to theme path is set.
 * Sets up proper publicPath and removes extra slashes from the url.
 */
if (userConfig['rootToThemePath']) {
	var publicPath = 'http://localhost:3000/' + userConfig['rootToThemePath'] + '/dist/';
	publicPath = publicPath.replace(/([^:])(\/\/+)/g, '$1/');
} else {
	console.log('\n❌ ', chalk.black.bgRed('Variable rootToThemePath not set in config.json'));
	console.log('This is probably /app/themes/YOURTHEMENAME/ or /wp-content/themes/YOURTHEMENAME/ \n');
	process.exit(1);
}

/**
 * If the /assets/config.json file has a themePath option
 * we overwrite the themePath var with this new path.
 */
if (userConfig['themePath']) {
	themePath = userConfig['themePath'];
}

var config = merge(
    {
        path: {
            theme: path.join(rootPath, themePath), // from root folder path/to/theme
			dist: path.join(rootPath, themePath + '/dist/'), // from root folder path/to/theme
			assets: path.join(rootPath, userConfig['assetsPath']), // from folder containing the package.json to the theme folder.
            public: publicPath, // Used for webpack.output.publicpath - Had to be set this way to overcome middleware issues with dynamic path.
        },
    },
    userConfig,
);

if (watchMode) {
    config.entry.app.push('webpack-hot-middleware/client');
}
config.entry.app.unshift('./build/publicpath_entry.js');

module.exports = config;
