const cssnanoConfig = {
  preset: ['default', { discardComments: { removeAll: true } }]
};

module.exports = {
    plugins: {
      cssnano: process.env.NODE_ENV === 'production' ? cssnanoConfig : false,
      autoprefixer: process.env.NODE_ENV === 'production' ? true : false,
    },
};
