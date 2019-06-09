process.env.BABEL_ENV = 'development';
process.env.NODE_ENV = 'development';
global.watch = true;

const webpack = require('webpack');
const browserSync = require('browser-sync').create();
const path = require('path');
const fs = require('fs-extra');
const webpackDevMiddleware = require('webpack-dev-middleware');
const webpackHotMiddleware = require('webpack-hot-middleware');
const formatMessages = require('webpack-format-messages');
const webpackConfig = require('../webpack.config');
const chalk = require('chalk');
const htmlInjector = require('bs-html-injector');
const compiler = webpack(webpackConfig);
const config = require('../config');
const fileSize = require('../helpers/fileSize');

/*
compiler.watch({}, (err, stats) => {
    const messages = formatMessages(stats);
    const my_stats = stats.toJson('verbose');
    const assets = my_stats.assets;
    var totalSize = 0;
    console.log(`\n${chalk.dim('Let\'s build and compile the files...')}`);
    if (!messages.errors.length && !messages.warnings.length) {
        console.log('\n✅ ', chalk.black.bgGreen(' Compiled successfully! \n'));
        console.log();
    }

    if (messages.errors.length) {
        console.log('\n❌ ', chalk.black.bgRed(' Failed to compile build. \n'));
        console.log('\n👉 ', messages.errors.join('\n\n'));
        return;
    }

    if (messages.warnings.length) {
        console.log('\n❌ ', chalk.yellow(' Compiled with warnings. \n'));
        console.log('\n👉 ', messages.warnings.join('\n\n'));
    }
});
 */

const bsOptions = {
    files: [
        {
            // js changes are managed by webpack
            match: [config.path.theme + '/**/*.php', config.path.theme + '/**/**/*.php', config.path.theme + '/**/*.twig'],
            // manually sync everything else
            fn: synchronize,
        },
    ],
    proxy: {
        target: config.browserSyncURL,
        middleware: [
            webpackDevMiddleware(compiler, {
                publicPath: webpackConfig.output.publicPath,
                noInfo: true,
            }),
            webpackHotMiddleware(compiler),
        ],
    },
};
console.log(webpackConfig.output.publicPath);
browserSync.use(htmlInjector, { restrictions: ['#page'] });

function synchronize(event, file) {
    console.log(file);
    if (file.endsWith('php')) {
        htmlInjector();
    }
}

(async () => {
    //await fs.emptyDir(config.publicPath + '/' + path.basename(config.path.dist));
    //await utils.addMainCss();
    browserSync.init(bsOptions);
})();
