<template>
  <NuxtLink
    v-if="hasSubmenu"
    v-slot="slotProps"
    v-bind="$attrs"
    v-on="$listeners"
    @click.native.prevent="$emit('click')"
    ><slot v-bind="slotProps" />
  </NuxtLink>
  <NuxtLink v-else v-slot="slotProps" v-bind="$attrs" v-on="$listeners">
    <slot v-bind="slotProps" />
  </NuxtLink>
</template>
<script>
  export default {
    props: {
      hasSubmenu: { type: Boolean, default: false },
    },
  }
</script>
