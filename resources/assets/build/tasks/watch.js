process.env.BABEL_ENV = 'development';
process.env.NODE_ENV = 'development';
global.watch = true;

const webpack = require('webpack');
const browserSync = require('browser-sync').create();
const path = require('path');
const middleware = require('webpack-dev-middleware');
const webpackHotMiddleware = require('webpack-hot-middleware');
const formatMessages = require('webpack-format-messages');
const webpackConfig = require('../webpack.config');
const chalk = require('chalk');
const compiler = webpack(webpackConfig);
const config = require('../config');

browserSync.init({
    files: [
        {
            match: [config.path.theme + '/**/*.php', config.path.theme + '/**/**/*.php', config.path.theme + '/**/*.twig'],
        },
    ],
    proxy: {
        target: config.browserSyncURL,
        middleware: [
            middleware(compiler, {
                publicPath: webpackConfig.output.publicPath,
                noInfo: true,
                stats: false,
                writeToDisk: filePath => {
                    return /^(?!.*(hot-update)).*/.test(filePath);
                },
            }),
            webpackHotMiddleware(compiler, {
                log: false,
                logLevel: 'none',
            }),
        ],
    },
});

compiler.hooks.done.tap('test', stats => {
    const messages = formatMessages(stats);
    console.log(`\n${chalk.dim("Let's build and compile the files...")}`);
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
