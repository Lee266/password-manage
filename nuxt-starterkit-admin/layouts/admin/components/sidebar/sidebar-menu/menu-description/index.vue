<template>
  <div v-if="value || $slots.default" class="menu-description">
    <template v-if="value">{{ value }}</template>
    <slot v-else />
  </div>
</template>

<script>
  export default {
    props: {
      value: { type: String, default: null },
    },
  }
</script>

<style scoped lang="scss">
  .menu-description {
    font-size: 12px;
    color: #5d6673;
    margin-top: rem(4px);
  }
</style>
