<template>
  <div loading="isLoading" class="box-card">
    <div slot="header">
      <span class="header-title">{{ title }}</span>
      <el-divider class="divider-line"></el-divider>
    </div>
    <div>
      <slot></slot>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      title: {
        type: String,
        required: false,
        default: null,
      },
      isLoading: {
        type: Boolean,
        required: false,
        default: false,
      },
    },
  }
</script>

<style scoped lang="scss">
  .divider-line {
    margin-top: rem(6px);
  }
  .header-title {
    font-size: 14px;
    font-weight: normal;
  }
</style>
