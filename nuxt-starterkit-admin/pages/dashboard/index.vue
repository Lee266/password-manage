<template>
  <Page title="ダッシュボード" :breadcrumbs="breadcrumbs">
    <div style="height: 1400px; margin-top: 42px">Dashboard content</div>
  </Page>
</template>

<script>
  import Page from '@/layouts/admin'
  export default {
    auth: true,
    components: {
      Page,
    },
    data: () => ({
      breadcrumbs: [{ to: '/dashboard', label: 'ダッシュボード' }],
    }),
  }
</script>
