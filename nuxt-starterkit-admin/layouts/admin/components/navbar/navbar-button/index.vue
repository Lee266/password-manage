<template>
  <el-button
    plain
    class="navbar-button"
    v-bind="$attrs"
    :style="buttonStyle"
    v-on="$listeners"
  >
    <slot />
  </el-button>
</template>

<script>
  export default {
    computed: {
      buttonStyle() {
        let padding = '0.5rem 0.5rem'
        if (this.$screen.lg) padding = '0.5rem 1rem'
        return {
          '--ns-navbar-button-padding': padding,
        }
      },
    },
  }
</script>

<style scoped lang="scss">
  .navbar-button {
    border: 0;
    font-size: inherit;
    font-weight: 400;
    padding: var(--ns-navbar-button-padding);
  }
</style>
