<template>
  <i
    v-if="$props.icon && typeof $props.icon === 'string'"
    class="w:text-base"
    :class="$props.icon"
  ></i>
  <i v-else class="w:text-base" :class="$props.default"></i>
</template>

<script>
  export default {
    props: {
      icon: { type: [Boolean, String], default: true },
      default: { type: String, default: null },
    },
  }
</script>
