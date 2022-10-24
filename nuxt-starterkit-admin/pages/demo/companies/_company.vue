<template>
  <div class="container">
    <h1>Company Page</h1>

    <h2>This is {{ company.name }}</h2>

    <BackButton />
  </div>
</template>

<script>
  import BackButton from '@/components/button/back-button'
  export default {
    auth: false,
    components: {
      BackButton,
    },

    // The asyncData for SSR
    asyncData({ params }) {
      // Fetching company data here
      // const company = await fetch(
      //   `https://api.grune.com/company/${params.company}`
      // ).then((res) => res.json())

      // Simulate a company data
      const company = {
        name: `Company ${params.company.toUpperCase()}`,
      }

      // Return as props
      return {
        company,
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
