// Import nuxt configs
import * as config from './configs/nuxt'

// Export the Nuxt configs
export default {
  // Page header configs
  head: config.head,

  // Server configs
  server: config.server,

  // Global CSS
  css: config.css,

  // All plugins
  plugins: config.plugins,

  // Axios configs
  axios: config.axios,

  // Auth configs
  auth: config.auth,

  // Router configs
  router: config.router,

  // Modules
  modules: config.modules,

  // Modules for dev and build
  buildModules: config.buildModules,

  // Internationalization (i18n) configs
  i18n: config.i18n,

  // Page loading indicator
  loading: config.loading,

  // Moment JS
  moment: config.moment,

  // Redirect module
  redirect: config.redirect,

  // Font Awesome config
  fontawesome: config.fontawesome,

  // Auto import components: https://go.nuxtjs.dev/config-components
  // components: true,

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
    transpile: [/^element-ui/],
    postcss: config.postcss, // Add the postCSS config
    ...config.partial, // Build optimization
  },

  // Sitemap config
  sitemap: config.sitemap,

  // Vue screen config
  screen: config.screen,
}
