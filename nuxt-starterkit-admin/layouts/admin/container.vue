<template>
  <div v-if="!value" class="w:mx-auto">
    <slot />
  </div>
  <div
    v-else
    class="content-container w:container w:mx-auto"
    :style="containerStyle"
  >
    <slot />
  </div>
</template>

<script>
  import { rem } from '@/helpers'
  export default {
    props: {
      value: { type: [Boolean, Number, String], default: false },
    },

    computed: {
      containerStyle() {
        let maxWidth = 'none'

        if (typeof this.value === 'string') maxWidth = this.value
        else if (typeof this.value === 'number') {
          maxWidth = `${rem(this.value)}rem`
        }

        return {
          '--ns-admin-container-max-width': maxWidth,
        }
      },
    },
  }
</script>

<style scoped lang="scss">
  .content-container {
    max-width: var(--ns-admin-container-max-width);
  }
</style>
