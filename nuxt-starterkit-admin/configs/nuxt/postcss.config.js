export default {
  hideNothingWarning: true,
  // All the PostCSS plugins
  plugins: {
    // PostCSS pixel to rem converter
    'postcss-rem': {
      name: 'rem',
      baseline: 16,
    },

    'postcss-import': true,
    'postcss-hexrgba': true,
    'postcss-easings': true,

    // PostCSS Autoprefixer
    autoprefixer: {},
  },
  preset: {},
}
