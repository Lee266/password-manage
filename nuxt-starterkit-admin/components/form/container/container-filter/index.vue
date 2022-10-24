<template>
  <div loading="isLoading">
    <div class="row">
      <div class="col-md">
        <div class="row">
          <div class="col-md"><slot name="column-1"></slot></div>
          <div class="col-md"><slot name="column-2"></slot></div>
          <div class="col-md"><slot name="column-3"></slot></div>
        </div>
      </div>
      <div class="col-md-auto">
        <slot name="reset"></slot>
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
