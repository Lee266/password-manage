<template>
  <div class="admin-container">
    <!-- Append the Sidebar - Start -->
    <AppSidebar />
    <!-- Append the Sidebar - End -->

    <div class="content-outset" :style="outsetStyle">
      <!-- Append the Navbar - Start -->
      <AppNavbar :title="title" />
      <!-- Append the Navbar - End -->

      <!-- Main content - Start -->
      <main class="content-innerset">
        <AppContainer :value="container">
          <!-- Content heading - Start -->
          <div
            v-if="hasTitle || hasSubtitle || hasBreadcrumbs"
            class="content-heading row"
          >
            <!-- Breadcrumb - Start -->
            <div v-if="hasBreadcrumbs" class="col-lg-auto page-breadcrumb">
              <el-breadcrumb
                v-if="breadcrumbs && breadcrumbs.length"
                separator-class="el-icon-arrow-right"
              >
                <el-breadcrumb-item
                  v-for="(breadcrumb, index) in breadcrumbs"
                  :key="index"
                  :to="breadcrumb.to"
                  >{{ breadcrumb.label }}</el-breadcrumb-item
                >
              </el-breadcrumb>
              <slot v-else-if="$slots.breadcrumbs" name="breadcrumbs" />
            </div>
            <!-- Breadcrumb - End -->
          </div>
          <!-- Content heading - End -->

          <!-- Content body - Start -->
          <div class="content-body">
            <slot v-if="$slots.default" />
            <Nuxt v-else />
          </div>
          <!-- Content body - End -->
        </AppContainer>
      </main>
      <!-- Main content - End -->
    </div>
  </div>
</template>

<script>
  import { mapMutations, mapState } from 'vuex'

  // Import Navbar and Sidebar components
  import AppNavbar from './admin/navbar'
  import AppSidebar from './admin/sidebar'
  import AppContainer from './admin/container'
  import { rem } from '@/helpers'

  export default {
    components: {
      AppNavbar,
      AppSidebar,
      AppContainer,
    },

    props: {
      title: { type: String, default: null },
      subtitle: { type: String, default: null },
      breadcrumbs: { type: Array, default: () => [] },
      container: { type: [Boolean, Number, String], default: false },
    },

    computed: {
      ...mapState('sidebar', ['isCollapsed', 'width', 'collapsedWidth']),

      // When we have title prop or slot
      hasTitle() {
        return this.title || this.$slots.title
      },

      // When we have subtitle prop or slot
      hasSubtitle() {
        return this.subtitle || this.$slots.subtitle
      },

      // When we have breadcrumbs prop or slot
      hasBreadcrumbs() {
        return (
          (this.breadcrumbs && this.breadcrumbs.length) ||
          this.$slots.breadcrumbs
        )
      },

      outsetStyle() {
        let maxWidth = '100%'
        if (this.$screen.lg) {
          let sidebarWidth = rem(this.width)
          if (this.isCollapsed) sidebarWidth = rem(this.collapsedWidth)
          maxWidth = `calc( 100% - ${sidebarWidth}rem )`
        }
        return { maxWidth }
      },
    },

    methods: {
      // Map the sidebar state toggling mutation
      ...mapMutations('sidebar', ['toggleCollapsed', 'toggleRevealed']),
    },
  }
</script>

<style scoped lang="scss">
  @import './assets/scss/import';

  .admin-container {
    display: flex;
    flex-wrap: wrap;
    flex-grow: 1;
  }

  .content-outset {
    flex: 1 0 0%;
    width: 100%;
    max-width: 100%;

    position: relative;
    z-index: 10;
    display: flex;
    flex-direction: column;
  }

  .content-innerset {
    flex-grow: 1;
    padding: rem(20px 20px);

    @include breakpoint-up(lg) {
      padding: rem(32px 24px);
    }
  }

  .content-heading {
    margin-bottom: rem(16px);
    margin-top: rem(-37px);
    .page-breadcrumb {
      .el-breadcrumb {
        opacity: 0.6;
      }
    }
  }

  @media only screen and (max-width: 991px) {
    .content-heading {
      margin-top: 0px;
    }
  }

  .page-heading {
    order: 2;
    @include breakpoint-up(lg) {
      order: 1;
    }
  }

  .page-breadcrumb {
    order: 1;
    margin-top: rem(8px);
    @include breakpoint-up(lg) {
      order: 2;
      margin-top: rem(16px);
    }
  }

  .page-title {
    margin-top: rem(6px);
    margin-bottom: rem(8px);
  }

  .page-subtitle {
    margin: 0;
    font-size: rem(18px);
    color: var(--bs-gray-600);
  }
</style>
