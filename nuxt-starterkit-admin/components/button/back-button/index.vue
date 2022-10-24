<template>
  <el-button icon="el-icon-back" type="danger" @click="$router.go(-1)"
    >Go Back</el-button
  >
</template>

<script>
  export default {
    name: 'BackButtonComponent',
  }
</script>
