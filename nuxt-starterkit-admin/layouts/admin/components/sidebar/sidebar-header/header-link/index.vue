<template>
  <NuxtLink v-bind="$attrs" class="sidebar-link" v-on="$listeners">
    <slot />
  </NuxtLink>
</template>

<script>
  export default {
    props: {
      hasSubmenu: { type: Boolean, default: false },
    },
  }
</script>

<style scoped lang="scss">
  .sidebar-link {
    position: relative;
    padding: rem(6px 10px);
    font-size: rem(12px);
    text-transform: uppercase;

    transition: 0.5s easeOutQuint;
    transition-property: transform, color;

    &:before {
      content: '';
      height: 1px;
      bottom: rem(-2px);
      left: rem(20px);
      right: rem(20px);
      opacity: 0.6;
      position: absolute;
      background-color: #949dab;
      transform: scaleX(0);
      transform-origin: center;
      transition: transform 0.5s easeOutQuint;
    }

    &:hover {
      color: lighten(#949dab, 15%);
      transform: translateY(rem(-2px));

      &:before {
        transform: scaleX(100%);
      }
    }
  }
</style>
