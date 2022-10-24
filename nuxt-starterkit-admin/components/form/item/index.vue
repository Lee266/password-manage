<template>
  <el-form-item class="el-form-item--label-top" :prop="prop">
    <span slot="label">
      <span>{{ name }}</span>
      <el-tag v-if="required" type="danger" size="mini">{{
        $t('label.required')
      }}</el-tag>
    </span>
    <slot name="input"></slot>
  </el-form-item>
</template>

<script>
  export default {
    props: {
      name: {
        type: String,
        required: false,
        default: null,
      },
      required: {
        type: Boolean,
        required: false,
        default: false,
      },
      prop: {
        type: String,
        required: true,
      },
    },
  }
</script>
