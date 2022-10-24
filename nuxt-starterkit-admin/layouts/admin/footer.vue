<template>
  <footer
    class="footer w:mt-5"
    :class="{ 'footer-sticky': fixed }"
    :style="footerStyle"
  >
    <template v-if="label">{{ label }}</template>
    <slot v-if="$slots.default" />
  </footer>
</template>

<script>
  import { footer as footerConfig } from '@/configs/layout'
  import { rem } from '@/helpers'

  export default {
    props: {
      label: { type: String, default: null },
    },
    data: () => ({
      ...footerConfig,
    }),
    computed: {
      footerStyle() {
        return {
          '--ns-footer-height': `${rem(this.height)}rem`,
        }
      },
    },
  }
</script>

<style scoped lang="scss">
  .footer {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #e2e7f3;
    font-size: rem(15px);
    color: var(--bs-gray-600);
    height: var(--ns-footer-height);

    &.footer-sticky {
      position: sticky;
      bottom: 0;
    }
  }
</style>
