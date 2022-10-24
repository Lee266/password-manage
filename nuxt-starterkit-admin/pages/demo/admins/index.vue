<template>
  <div class="container">
    <h1>Admin List Page</h1>

    <h2>
      <NuxtLink to="/demo/admins/super-admin">Detail Super Admin</NuxtLink>
    </h2>
    <h2>
      <NuxtLink to="/demo/admins/office-admin">Detail Office Admin</NuxtLink>
    </h2>

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
