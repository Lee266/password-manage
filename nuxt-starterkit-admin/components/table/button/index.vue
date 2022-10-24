<template>
  <!-- Edit button - Start -->
  <el-button
    v-if="editButton"
    :size="size"
    class="table-button primary-plain-button"
    v-bind="$attrs"
    type="primary"
    plain
    v-on="$listeners"
  >
    <Icon v-if="icon" :icon="icon" default="el-icon-edit" class="fs12" />
    <Label
      v-if="label"
      :label="label"
      :default="$t('button.edit')"
      class="fs12"
    />
  </el-button>
  <!-- Edit button - End -->

  <!-- View button - Start -->
  <el-button
    v-else-if="viewButton"
    :size="size"
    class="table-button"
    v-bind="$attrs"
    v-on="$listeners"
  >
    <Icon v-if="icon" :icon="icon" default="el-icon-view" class="fs12" />
    <Label
      v-if="label"
      :label="label"
      :default="$t('button.view')"
      class="fs12"
    />
  </el-button>
  <!-- View button - End -->

  <!-- Delete button - Start -->
  <el-button
    v-else-if="deleteButton"
    :size="size"
    class="table-button danger-plain-button"
    v-bind="$attrs"
    type="danger"
    plain
    v-on="$listeners"
  >
    <Icon v-if="icon" :icon="icon" default="el-icon-delete" class="fs12" />
    <Label
      v-if="label"
      :label="label"
      :default="$t('button.delete')"
      class="fs12"
    />
  </el-button>
  <!-- Delete button - End -->
</template>

<script>
  import { lowerCase } from 'lodash'
  import Icon from './-icon.vue'
  import Label from './-label.vue'

  export default {
    components: {
      Icon,
      Label,
    },
    props: {
      preset: { type: String, default: 'edit' },
      size: { type: String, default: 'mini' },
      icon: { type: [Boolean, String], default: true },
      label: { type: [Boolean, String], default: false },
    },
    computed: {
      editButton() {
        return lowerCase(this.preset) === 'edit'
      },
      viewButton() {
        return lowerCase(this.preset) === 'view'
      },
      deleteButton() {
        return lowerCase(this.preset) === 'delete'
      },
    },
  }
</script>

<style lang="scss" scoped>
  .table-button {
    padding: rem(0 3px);
    border-radius: 3px;
    opacity: 1;
  }
  .fs12 {
    font-size: 12px !important;
  }
</style>
