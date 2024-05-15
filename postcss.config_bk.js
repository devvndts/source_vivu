module.exports = {
    plugins: {
      'postcss-import': {},
      'tailwindcss/nesting': {},
      'postcss-simple-vars': {},
      'postcss-functions': {},
      'postcss-extend': {},
      'postcss-mixins': {},
      'postcss-conditionals': {},
      'postcss-easy-import': { prefix: '_', extensions: ['.css', '.scss'] },
      'postcss-percentage': {
        precision: 9,
        trimTrailingZero: true,
        floor: true
      },
      tailwindcss: {},
      autoprefixer: {},
    }
  }