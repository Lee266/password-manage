<template>
  <el-card v-loading="isLoading" class="box-card box-collapse">
    <div slot="header" class="header" @click="toggleCollapsed">
      <i :class="isShow ? 'el-icon-arrow-down' : 'el-icon-arrow-up'"></i>
      <span class="header-title">{{ title }}</span>
      <slot name="button"></slot>
    </div>

    <el-collapse-transition>
      <div v-show="isShow" class="content">
        <slot></slot>
      </div>
    </el-collapse-transition>
  </el-card>
</template>

<script>
  export default {
    props: {
      title: {
        type: String,
        required: false,
        default: null,
      },
      isLoading: {
        type: Boolean,
        required: false,
        default: false,
      },
    },
    data() {
      return {
        isShow: true,
      }
    },
    watch: {
      '$screen.width'() {
        this.changeCollapsed()
      },
    },
    created() {
      this.changeCollapsed()
    },
    methods: {
      toggleCollapsed() {
        this.isShow = !this.isShow
      },
      changeCollapsed() {
        if (process.client) {
          if (this.$screen.lg) {
            this.isShow = true
          } else {
            this.isShow = false
          }
        }
      },
    },
  }
</script>

<style scoped lang="scss">
  .header {
    &:hover {
      color: #3b82f6;
      cursor: pointer;
    }
  }
  .content {
    //margin: rem(-18px 12px);
    padding: rem(16px 24px 2px);
  }
</style>

<style lang="scss">
  .box-collapse {
    .el-card__body {
      padding: 0 !important;
    }
    .el-card__header {
      padding: rem(14px 10px) !important;
    }
  }
</style>
