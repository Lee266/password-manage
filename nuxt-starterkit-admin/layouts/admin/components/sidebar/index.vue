<template>
  <nav
    ref="sidebar"
    class="sidebar-container"
    :class="containerClasses"
    :style="containerStyle"
  >
    <div class="sidebar-innerset scrollbar" :style="innersetStyle">
      <!-- Close button - Start -->
      <el-button
        type="text"
        class="sidebar-close-btn"
        @click="setRevealed(false)"
      >
        <i class="el-icon-close"></i>
      </el-button>
      <!-- Close button - End -->

      <slot name="header" />
      <div class="sidebar-translate" :style="translateStyle">
        <div class="sidebar-group-container">
          <slot />
        </div>

        <!-- Copyright - Start -->
        <div v-if="$slots.copyright" class="sidebar-copyright">
          <slot name="copyright" />
        </div>
        <!-- Copyright - End -->
      </div>
    </div>
  </nav>
</template>

<script>
  import $ from 'jquery/dist/jquery.slim'
  import { mapState, mapMutations } from 'vuex'
  import { rem } from '@/helpers'

  export const Sidebar = {
    data: () => ({
      isExpanded: false,
    }),

    computed: {
      // Map Vuex sidebar states
      ...mapState('sidebar', [
        'width',
        'isRevealed',
        'isCollapsed',
        'collapsedWidth',
        'iconContainerSize',
      ]),

      // Should the sidebar collapse or not
      shouldCollapse() {
        return this.isCollapsed && this.$screen.lg
      },

      // Should the sidebar reveal or not
      shouldReveal() {
        return this.isRevealed && !this.$screen.lg
      },

      // Sidebar container classes
      containerClasses() {
        const classes = []
        this.shouldReveal && classes.push('revealed')
        this.shouldCollapse && classes.push('collapsed')
        return classes.join(' ')
      },

      // Sidebar container styles
      containerStyle() {
        // Calculate width based on collapsed state and screen size
        const width = rem(
          this.shouldCollapse ? this.collapsedWidth : this.width
        )

        // Return the styles
        return { width: `${width}rem` }
      },

      // Innerset translate value
      innersetTranslate() {
        return this.width - this.collapsedWidth
      },

      // Innerset styles
      innersetStyle() {
        const width = rem(this.width)
        const translate = rem(this.shouldCollapse ? this.innersetTranslate : 0)
        return {
          width: `${width}rem`,
          transform: `translateX(-${translate}rem)`,
        }
      },

      // Translate style
      translateStyle() {
        if (this.shouldCollapse) {
          let translateX = this.collapsedWidth * -1
          if (this.isExpanded) translateX = 0
          return { transform: `translateX(${rem(translateX)}rem)` }
        }
      },
    },

    methods: {
      ...mapMutations('sidebar', ['setRevealed']),
    },

    watch: {
      isRevealed() {
        // When sidebar is revealed
        // Animate all children element with staggered animation
        if (this.isRevealed && !this.$screen.lg) {
          // List children element
          const children = [
            '.group-title',
            '.sidebar-menu',
            '.sidebar-link',
            '.sidebar-header-title',
          ]

          // Get all visible children element to animate
          const $visibleSidebarMenus = $(this.$refs.sidebar)
            .find(children.join(', '))
            .filter(':visible')

          // Animate the submenu items with staggered delay
          this.$anime({
            duration: 500,
            easing: 'easeOutExpo',
            delay: this.$anime.stagger(50),
            opacity: [0, 1],
            translateX: ['-1rem', 0],
            targets: $visibleSidebarMenus.get(),
            complete: () => {
              // Remove the inline styles
              $visibleSidebarMenus.css({
                opacity: '',
                transform: '',
              })
            },
          })
        }
      },
    },
  }

  // Export sub components
  export { default as SidebarHeader } from './sidebar-header'
  export { default as SidebarHeaderLink } from './sidebar-header/header-link'

  export { default as SidebarGroup } from './sidebar-group'
  export { default as SidebarMenu } from './sidebar-menu'

  // Export the sidebar as default
  export default Sidebar
</script>

<style scoped lang="scss">
  @import './assets/scss/import';

  .sidebar-container {
    top: 0;
    left: 0;
    bottom: 0;
    z-index: 990;
    position: fixed;
    color: #fff;
    font-size: rem(15px);

    transform: translateX(-100%);
    transition: transform 0.4s easeOutExpo;

    flex: 0 0 auto;
    width: auto;

    @include breakpoint-up(lg) {
      position: static;
      transform: translateX(0);
    }

    &.revealed {
      transform: translateX(0);
    }
  }

  .sidebar-innerset {
    top: 0;
    position: sticky;
    width: inherit;
    height: 100vh;
    background-color: #000958;
    transition: transform 0.4s easeOutExpo;
    overflow-y: auto;
    overflow-x: hidden;

    display: flex;
    flex-direction: column;
  }

  .sidebar-translate {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    transition: transform 0.6s easeOutExpo;
  }

  .sidebar-group-container {
    flex-grow: 1;
  }

  .sidebar-close-btn {
    color: inherit;
    font-size: rem(22px);
    width: rem(36px);
    height: rem(36px);
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    top: rem(12px);
    right: rem(12px);
    opacity: 0.5;
    z-index: 99;
    transition: opacity 0.6s easeOutExpo;

    &:hover {
      opacity: 1;
    }

    @include breakpoint-up(lg) {
      display: none;
    }
  }

  .sidebar-copyright {
    font-size: rem(10px);
    padding: rem(10px 16px);
    transition: opacity 0.3s easeOutExpo;
  }

  div.scrollbar {
    &::-webkit-scrollbar {
      width: rem(6px);
    }
    &::-webkit-scrollbar-track {
      background-color: rgba(#000, 0.1);
    }
    &::-webkit-scrollbar-thumb {
      border-radius: rem(6px);
      background-color: rgba(#8b83a3, 0.2);
    }

    &:hover {
      &::-webkit-scrollbar-thumb {
        border-radius: rem(6px);
        background-color: rgba(#8b83a3, 0.6);
      }
    }
  }
</style>
