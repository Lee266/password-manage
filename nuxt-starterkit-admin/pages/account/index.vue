<template>
  <div class="p-4">
    <h1>
      <span v-if="user && user.name">Logged in as: {{ user.name }}</span>
      <span v-else>Not Logged-in</span>
    </h1>

    <NuxtLink to="/logout">
      <el-button type="info">Logout</el-button>
    </NuxtLink>
  </div>
</template>

<script>
  export default {
    async asyncData({ $axios }) {
      try {
        const response = await $axios.$get('/admin/account')
        return { user: response }
      } catch (err) {
        return { user: null }
      }
    },

    created() {
      if (!this.user) this.$router.push('/login')
      console.log(this.user)
    },

    methods: {
      async logout() {
        console.log('logout')
        await this.$axios.$post('/api/logout')
        this.$router.push('/')
      },
    },
  }
</script>
