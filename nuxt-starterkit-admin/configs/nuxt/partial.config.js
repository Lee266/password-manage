// Build optimization with chunk/partial splitting
export default {
  extractCSS: true,
  optimization: {
    splitChunks: {
      chunks: 'all',
      automaticNameDelimiter: '.',
      name: 'partial',
      maxSize: 256000,
    },
  },
}
