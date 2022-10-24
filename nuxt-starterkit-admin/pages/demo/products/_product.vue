<template>
  <div class="container">
    <h1>{{ product.name }} store Page</h1>

    <el-button type="primary" @click="buyProduct(product.name)"
      >Buy a {{ product.name }} now
    </el-button>

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
      // Fetching product data here
      // const product = await fetch(
      //   `https://api.grune.com/product/${params.product}`
      // ).then((res) => res.json())

      // Simulate a product data
      const product = {
        name: capitalize(params.product),
      }

      // Return as props
      return {
        product,
      }
    },

    methods: {
      buyProduct(productName) {
        this.$notify({
          title: 'Success',
          message: `You are buying a ${productName}`,
          type: 'success',
        })
      },
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
