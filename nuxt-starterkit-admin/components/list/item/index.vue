<template>
  <div class="row">
    <div class="col-4 w:mt-4 list-item">{{ column }}</div>
    <div class="col-8 w:mt-4 list-item list-value">{{ value }}</div>
  </div>
</template>

<script>
  export default {
    props: {
      column: { type: String, default: '' },
      value: { type: String, default: '' },
    },
  }
</script>
<style scoped lang="scss">
  .list-item {
    font-size: rem(14px);
    color: #030303;
  }
  .list-value {
    white-space: nowrap; /*disable line breaks*/
    overflow: hidden; /*hide overflowing text*/
    text-overflow: ellipsis; /*display ellipsis "..." to represent clipped text*/
  }
</style>
