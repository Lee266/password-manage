// This plugin will ensure the i18n works correctly.
// We will get the locale from server and client cookie when available
// Otherwise, the defaultLocale setting will be used.
export default function ({ app }) {
  // Get the stored locale cookie or the defaultLocale setting
  const storedLocale = app.$cookies.get('language')
  const targetLocale = storedLocale ?? app.i18n.defaultLocale

  // Get the current locale
  const currentLocale = app.i18n.localeProperties.code

  // When different, set to the target locale
  if (currentLocale !== targetLocale) {
    app.i18n.setLocale(targetLocale)
  }

  // If stored cookie is not found, store it
  if (!storedLocale) {
    app.$cookies.set('language', currentLocale)
  }

  // After changing to new locale, also store it as cookie
  // This will run each time the locale is changed
  app.i18n.onLanguageSwitched = (oldLocale, newLocale) => {
    app.$cookies.set('language', newLocale)
  }
}
