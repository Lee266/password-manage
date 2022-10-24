<template>
  <div>
    <el-button
      type="primary"
      class="primary-plain-button"
      size="small"
      @click="showDialog"
      >{{ $t('sample.input.openDialog') }}
      <i class="el-icon-edit-outline"></i>
    </el-button>

    <el-dialog
      :title="$t('sample.input.favoriteFood')"
      :visible.sync="openDialog"
      :append-to-body="true"
      width="52%"
      class="options-list"
    >
      <div class="row w:mt-n4">
        <el-checkbox-group v-model="checkBoxSelected">
          <el-checkbox
            v-for="data in resources.data"
            :key="data.id"
            :label="data.id"
            class="col-md-3 w:mt-4"
            >{{ data.label }}</el-checkbox
          >
        </el-checkbox-group>
      </div>
      <div slot="footer" class="dialog-footer w:text-center">
        <el-button type="primary" @click="confirmCheckBox">{{
          $t('sample.input.confirm')
        }}</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
  export default {
    props: {
      value: {
        default: null,
        type: Array,
      },
      resources: { type: [Array, Object], default: () => {} },
    },
    data() {
      return {
        openDialog: false,
        checkBoxSelected: [],
      }
    },
    methods: {
      showDialog() {
        console.log(this.value)
        this.checkBoxSelected = this.value
        this.openDialog = true
      },
      confirmCheckBox() {
        this.$emit('confirm', this.checkBoxSelected)
        this.openDialog = false
      },
    },
  }
</script>
