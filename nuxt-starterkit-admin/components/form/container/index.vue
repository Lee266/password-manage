<template>
  <el-card v-loading="isLoading" class="box-card">
    <div slot="header" class="header">
      <span class="header-title">{{ title }}</span>
      <slot name="button"></slot>
    </div>
    <div>
      <slot></slot>
    </div>
  </el-card>
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

<style>
  .header-title {
    font-size: 14px;
    font-weight: 700;
  }

  .header-button {
    float: right;
    margin-left: 5px;
  }

  .hideupload > div {
    display: none !important;
  }
</style>
