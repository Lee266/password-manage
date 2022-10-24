<template>
  <div class="menu-arrow" :class="{ expanded }">
    <i class="arrow el-icon-arrow-down"></i>
  </div>
</template>

<script>
  export default {
    props: {
      expanded: { type: Boolean, default: false },
    },
  }
</script>

<style scoped lang="scss">
  .menu-arrow {
    position: absolute;
    right: rem(72px);
    top: rem(8px);
    font-size: rem(14px);

    width: rem(20px);
    height: rem(20px);

    display: flex;
    align-items: center;
    justify-content: center;

    .arrow {
      color: rgba(#fff, 0.8);
      transition: transform 0.4s easeOutExpo;
    }

    &.expanded {
      .arrow {
        transform: rotate(180deg);
      }
    }
  }
</style>
