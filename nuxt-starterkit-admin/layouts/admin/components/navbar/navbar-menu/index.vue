<template>
  <NuxtLink v-if="$attrs.to" v-slot="{ href, navigate }" custom v-bind="$attrs">
    <a
      :href="href"
      class="navbar-menu"
      v-bind="$attrs"
      v-on="$listeners"
      @click="navigate"
    >
      <div class="w:flex w:-mx-1">
        <div v-if="icon || $slots.icon" class="w:px-1 navbar-menu-icon">
          <template v-if="icon">{{ icon }}</template>
          <slot v-else-if="$slots.icon" name="icon" />
        </div>
        <div class="w:px-1 navbar-menu-label">
          <template v-if="label">{{ label }}</template>
          <slot v-else />
        </div>
      </div>
    </a>
  </NuxtLink>
  <div v-else class="navbar-menu" v-bind="$attrs" v-on="$listeners">
    <div class="w:flex w:-mx-1">
      <div v-if="icon || $slots.icon" class="w:px-1 navbar-menu-icon">
        <template v-if="icon">{{ icon }}</template>
        <slot v-else-if="$slots.icon" name="icon" />
      </div>
      <div class="w:px-1 navbar-menu-label">
        <template v-if="label">{{ label }}</template>
        <slot v-else />
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      icon: { type: String, default: null },
      label: { type: String, default: null },
    },
  }
</script>

<style scoped lang="scss">
  @import './assets/scss/import';

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
    @include breakpoint-up(md) {
      font-size: inherit;
    }
  }

  .navbar-menu-label {
    display: none;
    @include breakpoint-up(md) {
      display: block;
    }
  }
</style>
