<template>
  <div class="sidebar-group" :style="sidebarGroupStyle">
    <div v-if="title" class="group-title">{{ title }}</div>
    <ul class="group-content">
      <slot />
    </ul>
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  import { rem } from '@/helpers'

  export default {
    props: {
      title: { type: String, default: '' },
    },

    computed: {
      // Map Vuex sidebar states
      ...mapState('sidebar', [
        'width',
        'isRevealed',
        'isCollapsed',
        'collapsedWidth',
        'iconContainerSize',
      ]),

      sidebarGroupStyle() {
        return {
          '--ns-sidebar-group-content-width': `${rem(
            this.width + this.collapsedWidth
          )}rem`,
        }
      },
    },
  }
</script>

<style scoped lang="scss">
  .sidebar-group {
    margin-top: rem(9px);
    transition: transform 0.4s easeOutExpo;

    .group-title {
      color: #5d6673;
      font-size: rem(12px);
      font-weight: 500;
      padding: rem(0 32px);
      padding-left: rem(40px);
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-bottom: rem(8px);
    }

    .group-content {
      margin: 0;
      padding: rem(0 24px);
      list-style: none;
      width: var(--ns-sidebar-group-content-width);
    }
  }
</style>
