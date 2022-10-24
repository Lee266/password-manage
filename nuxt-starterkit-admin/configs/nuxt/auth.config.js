export default {
  // Where the user will get redirected
  redirect: {
    login: '/login',
    logout: '/login',
    callback: '/login',
    home: '/dashboard',
  },

  // Authentication strategies
  strategies: {
    laravelSanctum: {
      // Sanctum provider
      provider: 'laravel/sanctum',

      // Server base URL
      url: process.env.NUXT_SERVER_URL,

      // Server endpoints
      endpoints: {
        login: { url: '/api/admin/login', method: 'post' },
        logout: { url: '/api/admin/logout', method: 'post' },
        user: { url: '/api/admin/account', method: 'get' },
      },

      // No tokens
      tokenRequired: false,
      tokenType: false,
    },
  },

  // Disable local storage
  localStorage: false,
}
