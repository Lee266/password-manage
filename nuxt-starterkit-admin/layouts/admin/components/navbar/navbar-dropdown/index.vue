<template>
  <el-dropdown trigger="click" class="navbar-dropdown-container">
    <div class="el-dropdown-link navbar-menu">
      <div class="w:flex w:-mx-1">
        <!-- Menu icon - Start -->
        <div v-if="$props.icon || $slots.icon" class="navbar-menu-icon w:px-1">
          <template v-if="icon">
            <i :class="icon"></i>
          </template>
          <slot v-else-if="$slots.icon" name="icon" />
        </div>
        <!-- Menu icon - End -->

        <!-- Menu label - Start -->
        <div class="navbar-menu-label w:px-1">
          <slot name="default" />
        </div>
        <!-- Menu label - End -->

        <!-- Dropdown arrow - Start -->
        <div v-if="arrow" class="navbar-menu-icon w:px-1">
          <i class="el-icon-arrow-down"></i>
        </div>
        <!-- Dropdown arrow - End -->
      </div>
    </div>
    <el-dropdown-menu slot="dropdown">
      <slot name="dropdown" />
    </el-dropdown-menu>
  </el-dropdown>
</template>

<script>
  export default {
    props: {
      icon: { type: String, default: null },
      arrow: { type: Boolean, default: false },
    },
  }
</script>

<style scoped lang="scss">
  @import './assets/scss/import';

  .navbar-dropdown-container {
    color: inherit;
    font-size: inherit;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;

    .el-dropdown-link {
      height: 100%;
    }
  }

  .navbar-menu {
    border: 0;
    height: 100%;
    display: flex;
    position: relative;
    align-items: center;
    justify-content: center;
    padding: rem(10px 12px);
    transition: color 0.3s easeOutExpo;
    cursor: pointer;

    &:before {
      content: '';
      left: 50%;
      height: 1px;
      width: rem(16px);
      bottom: rem(14px);
      position: absolute;
      background-color: #409eff;
      transform: scaleX(0) translateX(-50%);
      transform-origin: left;
      transition: 0.6s transform easeOutExpo;

      @include breakpoint-up(md) {
        width: rem(32px);
      }
    }

    &:hover {
      color: #409eff;
      &:before {
        transform: scaleX(100%) translateX(-50%);
      }
    }
  }

  .navbar-menu-icon {
    font-size: rem(18px);
    color: #676767;
    @include breakpoint-up(md) {
      font-size: rem(14px);
    }
  }

  .navbar-menu-label {
    display: none;
    color: #676767;
    font-size: rem(14px);
    @include breakpoint-up(md) {
      display: block;
    }
  }
</style>
