<template>
  <div loading="isLoading" class="box-card">
    <div class="row md:w:mt-4">
      <div class="col-md">
        <slot name="column-1"></slot>
      </div>
      <div class="col-md">
        <slot name="column-2"></slot>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      isLoading: {
        type: Boolean,
        required: false,
        default: false,
      },
    },
  }
</script>
