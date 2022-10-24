<template>
  <MenuLink
    ref="link"
    v-slot="slotProps"
    custom
    :has-submenu="hasSubmenu"
    v-bind="$attrs"
    v-on="$listeners"
  >
    <li
      class="sidebar-menu"
      :class="{
        'menu-active': slotProps.isActive,
        'menu-exact-active': slotProps.isExactActive,
      }"
    >
      <a
        ref="anchor"
        class="menu-anchor"
        :href="slotProps.href"
        v-bind="$attrs"
        :class="{
          'menu-active': slotProps.isActive,
          'menu-exact-active': slotProps.isExactActive,
        }"
        @click="anchorClick($event, slotProps)"
        v-on="$listeners"
      >
        <el-tooltip effect="dark" :content="tooltipContent" placement="right">
          <div class="icon-column icon-collapsed">
            <IconContainer>
              <template v-if="icon">{{ menuIcon }}</template>
              <template v-else-if="$slots.icon"><slot name="icon" /></template>
              <template v-else>{{ menuAbbr }}</template>
            </IconContainer>
          </div>
        </el-tooltip>

        <div class="icon-column">
          <IconContainer>
            <template v-if="icon">{{ menuIcon }}</template>
            <template v-else-if="$slots.icon"><slot name="icon" /></template>
            <template v-else>{{ menuAbbr }}</template>
          </IconContainer>
        </div>

        <div class="label-column" :class="{ active: slotProps.isActive }">
          <div class="label-container">
            <!-- Menu label - Start -->
            <Label :value="label">
              <slot name="default" />
            </Label>
            <!-- Menu label - End -->

            <!-- Badge - Start -->
            <Badge :value="badge">
              <slot name="badge" />
            </Badge>
            <!-- Badge - End -->
          </div>

          <!-- Menu description - Start -->
          <Description :value="description">
            <slot name="description" />
          </Description>
          <!-- Menu description - End -->

          <!-- Submenu arrow - Start -->
          <Arrow v-if="hasSubmenu" :expanded="isSubmenuExpanded" />
          <!-- Submenu arrow - End -->
        </div>
      </a>

      <!-- Submenu - Start -->
      <div
        v-if="$slots.submenu"
        ref="submenu"
        class="sidebar-submenu"
        :class="{ 'submenu-expanded': isSubmenuExpanded }"
      >
        <ul class="submenu-container">
          <slot name="submenu" />
        </ul>
      </div>
      <!-- Submenu - End -->
    </li>
  </MenuLink>
</template>

<script>
  import $ from 'jquery/dist/jquery.slim'
  import { mapState } from 'vuex'
  import { trim, filter, startCase } from 'lodash'

  import Arrow from './menu-arrow'
  import Label from './menu-label'
  import Badge from './menu-badge'
  import MenuLink from './menu-link'
  import Description from './menu-description'
  import IconContainer from './../icon-container'

  import { getStringAbbr, slideDown, slideUp } from '@/helpers'

  export default {
    components: {
      Arrow,
      Label,
      Badge,
      MenuLink,
      Description,
      IconContainer,
    },

    inheritAttrs: false,

    props: {
      icon: { type: String, default: null },
      label: { type: String, default: null },
      badge: { type: [String, Number], default: null },
      description: { type: String, default: null },
      tooltip: { type: String, default: null },
    },

    data: () => ({
      isSubmenuExpanded: false,
    }),

    computed: {
      ...mapState('sidebar', ['distinctMenu']),

      hasSubmenu() {
        return !!this.$slots.submenu
      },

      menuIcon() {
        return this.icon && startCase(this.icon)
      },

      menuAbbr() {
        if (!this.icon) {
          let label = this.label
          if (!label && this.$slots.default && this.$slots.default.length) {
            label = trim(this.$slots.default[0].text)
          }
          if (label) {
            const abbr = getStringAbbr(label)
            if (abbr) return startCase(abbr)
          }
        }
        return null
      },

      tooltipContent() {
        // When tooltip prop is supplied, use it
        if (this.$props.tooltip) return this.$props.tooltip
        // Otherwise if label prop is supplied, use the label instead
        else if (this.$props.label) return this.$props.label
        // If nothing is there, then parse and use the slot content as last option
        else {
          const slotLabel = this.$slots.default
          if (slotLabel && slotLabel.length) {
            const whitespaces = /^\s+|\s+$|\s+(?=\s)/g
            return slotLabel[0].text.replace(whitespaces, '')
          }
          return null
        }
      },
    },

    mounted() {
      const anchor = this.$refs.anchor
      if (anchor) {
        const anchorClass = anchor.classList
        if (anchorClass.contains('menu-active')) {
          this.isSubmenuExpanded = true
        }
      }
    },

    methods: {
      // On anchor click
      anchorClick($event, slotProps) {
        if (this.hasSubmenu) this.toggleSubmenu()
        else slotProps.navigate($event)
      },

      // Dinstinctive mode. Close other submenus
      // Only one menu can be opened at a time
      closeSiblings() {
        // Find expanded siblings
        const $siblings = this.$parent.$children
        const $expandedSiblings = filter($siblings, 'isSubmenuExpanded')

        // Close all expanded siblings
        $expandedSiblings.forEach(function ($sibling) {
          $sibling.toggleSubmenu()
        })
      },

      // Toggle visibility of the submenu
      toggleSubmenu() {
        if (this.hasSubmenu) {
          if (this.isSubmenuExpanded) {
            const $submenu = this.$refs.submenu

            // If the submenu is expanded, collapse it
            slideUp($submenu, this.$anime, {
              complete: () => {
                $submenu.style.height = null
                $submenu.style.display = null
              },
            })
          } else {
            // Find the submenu
            const $submenu = $(this.$refs.submenu)

            // Temporarily expand the submenu (make it visible)
            // And find all visible submenu items
            $submenu.css('display', 'block')
            const $submenuItems = $submenu.find('.sidebar-menu:visible')
            $submenu.css('display', '')

            // On distinct menu mode, close all other submenus
            if (this.distinctMenu) this.closeSiblings()

            // Expand the submenu
            slideDown($submenu, this.$anime, {
              complete: () => {
                $submenu.css('height', '')
              },
            })

            // Animate the submenu items with staggered delay
            this.$anime({
              duration: 500,
              easing: 'easeOutExpo',
              opacity: [0, 1],
              translateX: ['1.5rem', 0],
              delay: this.$anime.stagger(50),
              targets: $submenuItems.get(),
            })
          }

          // Toggle the main flag
          this.isSubmenuExpanded = !this.isSubmenuExpanded
        }
      },
    },
  }
</script>

<style scoped lang="scss">
  $menu-padding-left: 24px;

  .sidebar-menu {
    margin: rem(0 -24px);

    .menu-anchor {
      display: flex;
      padding: rem(6px 0 6px 8px);
      margin-top: inherit;
      margin-bottom: inherit;
      position: relative;

      &:before {
        content: '';
        left: 0;
        top: 0;
        bottom: 0;
        width: rem(4px);
        position: absolute;
        background-color: transparent;
        transition: background-color 0.5s easeOutExpo;
      }
      &:after {
        content: '';
        left: auto;
        top: 0;
        right: rem(55px);
        width: rem(4px);
        height: rem(48px);
        position: absolute;
      }

      &.menu-exact-active {
        $active-color: #1c78d7;
        &:before {
          background-color: $active-color;
          box-shadow: rem(0 0 16px 8px) rgba($active-color, 0.1);
        }
        &:after {
          background-color: $active-color;
          box-shadow: rem(0 0 16px 8px) rgba($active-color, 0.1);
        }

        .icon-column {
          color: #1f82e9;
        }
      }

      .label-column {
        flex: 1 0 0%;
        display: flex;
        position: relative;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;

        .label-container {
          display: flex;
        }
      }

      .icon-column {
        flex: 0 0 auto;
        width: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.5s easeOutExpo;

        &.icon-collapsed {
          right: 0;
          z-index: 90;
          position: absolute;
          padding: rem(0 11px);
        }
      }
    }
  }

  .sidebar-submenu {
    $submenu-indent: 0;

    display: none;
    overflow: hidden;
    padding: rem(0 24px);
    background-color: rgba(#000, 0.2);

    &.submenu-expanded {
      display: block;
    }

    .submenu-container {
      padding: 0;
      list-style-type: none;
    }

    .menu-anchor {
      padding-left: rem($menu-padding-left + ($submenu-indent * 1));
      .icon-column-collapse {
        margin-right: 15px !important;
      }
    }

    .sidebar-submenu {
      background-color: rgba(#000, 0.175);
      .menu-anchor {
        padding-left: rem($menu-padding-left + ($submenu-indent * 2));
      }
    }
  }
</style>

<style lang="scss">
  .sidebar-container.collapsed {
    .sidebar-menu {
      .label-column {
        opacity: 0;
        transition: opacity 0.4s;
      }
    }
    &:hover {
      .sidebar-menu {
        .label-column {
          opacity: 1;
        }
      }
    }
  }
</style>
