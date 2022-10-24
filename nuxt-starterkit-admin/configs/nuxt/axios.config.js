// Axios module configuration: https://go.nuxtjs.dev/config-axios
export default {
  // Set withCredentials true
  credentials: true,

  // The server base URL
  baseURL: process.env.NUXT_SERVER_API ?? 'http://localhost:8086',
}
