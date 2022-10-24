<template>
  <div class="container">
    <h1>Product List Page</h1>

    <h2>
      <NuxtLink to="/demo/products/notebook">Notebook Product Page</NuxtLink>
    </h2>
    <h2>
      <NuxtLink to="/demo/products/macbook">Macbook Product Page</NuxtLink>
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
