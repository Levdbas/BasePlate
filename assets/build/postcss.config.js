const cssnanoConfig = {
    preset: ['default', { discardComments: { removeAll: true } }],
}

module.exports = {
    plugins: {
        autoprefixer: process.env.NODE_ENV === 'production' ? true : false,
        cssnano: process.env.NODE_ENV === 'production' ? cssnanoConfig : false,
    },
}
