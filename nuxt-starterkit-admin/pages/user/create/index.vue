<template>
  <Page
    title="User Create"
    subtitle="User create page"
    :breadcrumbs="breadcrumbs"
  >
    <div style="height: 1400px">Form to create user</div>
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
      breadcrumbs: [
        { to: '/dashboard', label: 'Dashboard' },
        { to: '/users/create', label: 'User Create' },
      ],
    }),
  }
</script>
