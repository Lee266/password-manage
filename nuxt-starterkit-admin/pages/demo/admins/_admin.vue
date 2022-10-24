<template>
  <div class="container">
    <h1>Admin Page</h1>

    <h2>I am {{ admin.name }}</h2>

    <BackButton />
  </div>
</template>

<script>
  import { capitalize } from 'lodash'
  import BackButton from '@/components/button/back-button'

  export default {
    auth: false,
    components: {
      BackButton,
    },

    // The asyncData for SSR
    asyncData({ params }) {
      // Fetching admin data here
      // const admin = await fetch(
      //   `https://api.grune.com/admin/${params.admin}`
      // ).then((res) => res.json())

      // Simulate an admin data
      const admin = {
        name: capitalize(params.admin),
      }

      // Return as props
      return {
        admin,
      }
    },
  }
</script>

<style lang="scss">
  .container {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
  }
</style>
