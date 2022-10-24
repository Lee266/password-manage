<template>
  <div class="icon-container" :style="iconStyle">
    <slot />
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  import { rem } from '@/helpers'

  export default {
    computed: {
      ...mapState('sidebar', ['iconContainerSize']),

      iconStyle() {
        const size = `${rem(this.iconContainerSize)}rem`
        return {
          '--ns-sidebar-icon-width': size,
          '--ns-sidebar-icon-height': size,
        }
      },
    },
  }
</script>

<style scoped lang="scss">
  .icon-container {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: rem(5px);
    color: #fff;
    width: var(--ns-sidebar-icon-width);
    height: var(--ns-sidebar-icon-height);
  }
</style>
