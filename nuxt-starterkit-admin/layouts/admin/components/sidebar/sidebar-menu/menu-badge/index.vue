<template>
  <div v-if="value || $slots.default" class="menu-badge-container">
    <div v-if="value" class="menu-badge">{{ value }}</div>
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
  .menu-badge-container {
    width: auto;
    flex: 0 0 auto;
    padding: rem(0 8px);
  }

  .menu-badge {
    $badge-color: #1c78d7;

    color: lighten($badge-color, 40%);
    background-color: $badge-color;
    border: 1px solid transparent;
    -webkit-tap-highlight-color: transparent;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    font-size: rem(11px);
    width: auto;
    height: rem(18px);
    line-height: rem(16px);
    text-decoration: none;
    padding: rem(0 8px);
    box-sizing: border-box;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-transform: uppercase;
    border-radius: rem(32px);
    font-weight: 700;
    letter-spacing: 0.25px;
    cursor: default;
    text-overflow: ellipsis;
    overflow: hidden;
  }
</style>
