// https://i18n.nuxtjs.org/basic-usage
export default {
  // We render each page with the locale
  // and we do not generate new URL for each locale.
  strategy: 'no_prefix', // Keep this as "no_prefix"

  // All supported locales
  locales: [
    { code: 'en', iso: 'en-US', name: 'English', file: 'en/index.js' },
    { code: 'ja', iso: 'ja-JP', name: 'Japanese', file: 'ja/index.js' },
  ],

  // Default locale is Japanese
  defaultLocale: 'ja',

  // Lazy load the translation files
  lazy: true,

  // Translation folder
  langDir: 'locales/',

  // When set true, this will detect the user's browser language setting
  // and use it as default locale.
  detectBrowserLanguage: false, // Keep this set as false

  // This will let you create per component translation
  // https://i18n.nuxtjs.org/per-component-translations
  vueI18nLoader: true,
}
