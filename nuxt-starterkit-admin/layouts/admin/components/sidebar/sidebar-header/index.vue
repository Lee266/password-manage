<template>
  <div class="sidebar-header" :style="headerStyle">
    <!-- The sidebar header icon - Start -->
    <div class="sidebar-header-icon" :style="headerIconStyle">
      <IconContainer>
        <template v-if="icon">{{ icon }}</template>
        <slot v-else-if="$slots.icon" name="icon" />
        <template v-else>{{ titleAbbr }}</template>
      </IconContainer>
    </div>
    <!-- The sidebar header icon - End -->

    <div class="sidebar-header-content" :style="headerContentStyle">
      <!-- App title - Start -->
      <div v-if="title || $slots.default" class="sidebar-header-title">
        <template v-if="title">{{ title }}</template>
        <slot v-else-if="$slots.default" name="default" />

        <!-- Sidebar toggle button - Start -->
        <SidebarButton
          class="sidebar-button w:hidden lg:w:block"
          @click="toggleCollapsed"
        >
          <ChevronsRightIcon v-if="isCollapsed" size="28" />
          <MenuIcon v-else size="28" />
        </SidebarButton>
        <!-- Sidebar toggle button - End -->
      </div>
      <!-- App title - End -->

      <!-- Navigation links - Start -->
      <div v-if="$slots.links" class="sidebar-header-links">
        <slot name="links" />
      </div>
      <!-- Navigation links - End -->
    </div>
  </div>
</template>

<script>
  import { trim } from 'lodash'
  import { mapState, mapMutations } from 'vuex'
  import { MenuIcon, ChevronsRightIcon } from 'vue-feather-icons'
  import IconContainer from './../icon-container'
  import { NavbarButton as SidebarButton } from '@/layouts/admin/components/navbar'

  import { rem, getStringAbbr } from '@/helpers'

  export default {
    components: {
      IconContainer,
      MenuIcon,
      ChevronsRightIcon,
      SidebarButton,
    },
    props: {
      icon: { type: String, default: null },
      title: { type: String, default: null },
    },
    computed: {
      // Map sidebar states
      ...mapState('sidebar', [
        'width',
        'collapsedWidth',
        'isCollapsed',
        'isRevealed',
      ]),

      // The header style
      headerStyle() {
        return {
          '--ns-sidebar-width': `${rem(this.width)}rem`,
          '--ns-sidebar-collapsed-width': `${rem(this.collapsedWidth)}rem`,
        }
      },

      headerIconStyle() {
        const remWidth = rem(this.collapsedWidth)
        return { width: `${remWidth}rem` }
      },

      headerContentStyle() {
        const remWidth = rem(this.width)
        return { width: `${remWidth}rem` }
      },

      titleAbbr() {
        if (!this.icon) {
          let title = this.title
          if (!title && this.$slots.title && this.$slots.title.length) {
            title = trim(this.$slots.title[0].text)
          }
          if (title) {
            const abbr = getStringAbbr(title)
            if (abbr) return abbr
          }
        }
        return null
      },
    },

    methods: {
      // Map the sidebar toggle mutations
      ...mapMutations('sidebar', ['toggleCollapsed']),
    },
  }
</script>

<style scoped lang="scss">
  .sidebar-header {
    display: flex;
    margin-top: rem(10px);
    margin-bottom: rem(8px);
    transform: translateX(calc(var(--ns-sidebar-collapsed-width) * -1));
    width: calc(var(--ns-sidebar-width) + var(--ns-sidebar-collapsed-width));
  }

  .sidebar-button {
    color: inherit;
    padding: rem(4px 8px);
    background-color: transparent;

    &:hover,
    &:focus {
      color: inherit;
      background-color: transparent;
    }
  }

  .sidebar-header-icon {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .sidebar-header-content {
    display: flex;
    align-items: flex-start;
    justify-content: center;
    flex-direction: column;
    padding: rem(0 8px 0 16px);

    .sidebar-header-title {
      font-size: rem(26px);
      line-height: 1.35;
      text-align: center;
      color: #fff;
      font-size: rem(18px);
      font-weight: bold;

      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .sidebar-header-links {
      display: flex;
      margin-top: rem(12px);
    }
  }
</style>
