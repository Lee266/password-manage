<template>
  <el-card class="card-auth sm:w:px-3">
    <h2 class="w:text-center">{{ $t('auth.logout.page.title') }}</h2>
  </el-card>
</template>
<script>
  export default {
    layout: 'auth',
    created() {
      this.$auth.logout()
    },
  }
</script>
