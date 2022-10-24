<template>
  <div class="menu-label">
    <template v-if="value">{{ value }}</template>
    <slot v-else name="default" />
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
  .menu-label {
    width: auto;
    flex: 0 0 auto;
    padding: rem(0 2px);
    transition: 0.5s easeOutExpo;
    transition-property: transform, color;
    font-weight: bold;
    font-size: rem(16px);
  }
</style>

<style lang="scss">
  .sidebar-container {
    .menu-anchor {
      &:hover {
        & > .label-column > .label-container > .menu-label {
          color: lighten(#ffffff, 25%);
          transform: translateX(rem(2px));
        }
      }

      &.menu-active {
        background-color: rgba(255, 255, 255, 0.1);
        & > .label-column > .label-container > .menu-label {
          color: lighten(#ffffff, 25%);
        }
      }
    }
    .sidebar-submenu {
      .menu-anchor {
        &.menu-active {
          background-color: rgba(255, 255, 255, 0.05);
        }
      }
    }
  }
</style>
