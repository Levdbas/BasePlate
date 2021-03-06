module.exports = {
    presets: [
        [
            '@babel/preset-env',

            {
                debug: false,
                targets: {
                    browsers: ['last 2 versions', 'ie >= 11'],
                },
            },
        ],
    ],
    plugins: ['@babel/plugin-syntax-dynamic-import', '@babel/plugin-transform-regenerator'],
};
