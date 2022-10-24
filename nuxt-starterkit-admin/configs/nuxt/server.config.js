// Nuxt server configs
export default {
  port: process.env.NUXT_CLIENT_PORT ?? 3000,
  host: process.env.NUXT_CLIENT_HOST ?? 'localhost',
}
