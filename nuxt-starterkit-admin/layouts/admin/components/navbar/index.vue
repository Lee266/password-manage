<template>
  <nav class="navbar" :style="navbarStyle" :class="{ 'navbar-sticky': fixed }">
    <div class="navbar-innerset">
      <div v-if="$slots.toolbar" class="navbar-group-toolbar">
        <slot name="toolbar" />
      </div>
      <div v-if="$slots.default" class="navbar-group-menu">
        <slot name="default" />
      </div>
    </div>
  </nav>
</template>

<script>
  import { mapState } from 'vuex'
  import { rem } from '@/helpers'

  export const Navbar = {
    computed: {
      ...mapState('navbar', ['height', 'fixed']),

      navbarStyle() {
        return {
          '--ns-navbar-height': `${rem(this.height)}rem`,
        }
      },
    },
  }

  // Export components
  export { default as NavbarButton } from './navbar-button'
  export { default as NavbarMenu } from './navbar-menu'
  export { default as NavbarDropdown } from './navbar-dropdown'
  export { default as NavbarDropdownItem } from './navbar-dropdown/dropdown-item'

  // Also export Navbar as default
  export default Navbar
</script>

<style scoped lang="scss">
  .navbar {
    display: flex;
    font-size: rem(15px);
    background-color: #fff;
    height: var(--ns-navbar-height);
    box-shadow: rem(0 0 12px 0) rgb(#000, 0.05);
    z-index: 980;

    &.navbar-sticky {
      top: 0;
      position: sticky;
      height: rem(50px);
    }
  }

  .navbar-innerset {
    flex-grow: 1;
    display: flex;
    height: rem(50px);
  }

  .navbar-group-menu,
  .navbar-group-toolbar {
    padding: rem(0 16px);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .navbar-group-toolbar {
    flex: 0 0 auto;
    width: auto;
  }

  .navbar-group-menu {
    flex-grow: 1;
    justify-content: flex-end;
  }
</style>
