<template>
  <span v-if="$props.label" class="w:text-sm lg:w:inline-block">
    <template v-if="$props.label && typeof $props.label === 'string'">{{
      $props.label
    }}</template>
    <template v-else>{{ $props.default }}</template>
  </span>
</template>

<script>
  export default {
    props: {
      label: { type: [Boolean, String], default: true },
      default: { type: String, default: null },
    },
  }
</script>
