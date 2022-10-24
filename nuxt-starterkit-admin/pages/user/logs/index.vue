<template>
  <Page
    title="User Logs"
    subtitle="The user log page"
    :breadcrumbs="breadcrumbs"
  >
    <div style="height: 1400px">User logs</div>
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
        { to: '/users/log', label: 'User Logs' },
      ],
    }),
  }
</script>
