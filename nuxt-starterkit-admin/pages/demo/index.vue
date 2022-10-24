<template>
  <div class="container">
    <h1>{{ $t('label.topPage') }}</h1>
    <p>This page is only for SSR demo</p>

    <h2>
      <NuxtLink to="/demo/companies">Company List Page</NuxtLink>
    </h2>
    <div class="subnav">
      <h3><NuxtLink to="/demo/companies/a">Detail Company A</NuxtLink></h3>
      <h3><NuxtLink to="/demo/companies/b">Detail Company B</NuxtLink></h3>
    </div>

    <h2>
      <NuxtLink to="/demo/admins">Admin List Page</NuxtLink>
    </h2>
    <div class="subnav">
      <h3>
        <NuxtLink to="/demo/admins/super-admin">Detail Super Admin</NuxtLink>
      </h3>
      <h3>
        <NuxtLink to="/demo/admins/office-admin">Detail Office Admin</NuxtLink>
      </h3>
    </div>

    <h2>
      <NuxtLink to="/demo/products">Product List Page</NuxtLink>
    </h2>
    <div class="subnav">
      <h3>
        <NuxtLink to="/demo/products/notebook">Notebook Product Page</NuxtLink>
      </h3>
      <h3>
        <NuxtLink to="/demo/products/macbook">Macbook Product Page</NuxtLink>
      </h3>
    </div>

    <el-button type="primary" @click="toggleLocale">
      Toggle Language
    </el-button>
  </div>
</template>

<script>
  export default {
    auth: false,
    computed: {
      locale() {
        return this.$i18n.localeProperties.code ?? this.$i18n.defaultLocale
      },
    },
    methods: {
      toggleLocale() {
        const locale = this.locale === 'ja' ? 'en' : 'ja'
        this.$i18n.setLocale(locale)
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
