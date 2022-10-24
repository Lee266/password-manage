<template>
  <div class="w:mt-3 w:mb-1">
    <div class="row">
      <div class="col-md w:mt-2">
        <span class="number-result">{{ $props.total }}件</span>
        <span class="number-item"
          >（{{ $props.range }}{{ $t('label.show') }}）</span
        >
      </div>
      <div class="col-md-auto w:flex sm:w:mt-2">
        <span class="w:flex w:justify-end display-result w:mr-2"
          >{{ $t('label.result') }}:
        </span>
        <el-select
          v-model="numberSelected"
          class="select-number"
          size="mini"
          :placeholder="numberSelected"
          @change="changeDisplay"
        >
          <el-option
            v-for="item in numberOptions"
            :key="item.name"
            :label="item.label"
            :value="item.name"
          />
        </el-select>
        <el-button
          size="mini"
          class="w:flex w:justify-end w:ml-3 options-button"
          @click="dialogVisible = true"
        >
          <i class="el-icon-s-operation" />
          {{ $t('button.settings') }}</el-button
        >
      </div>
    </div>

    <el-dialog
      :title="$t('label.settingHeader')"
      :visible.sync="dialogVisible"
      :append-to-body="true"
      width="52%"
      class="options-list"
    >
      <slot name="settingOptions"></slot>
    </el-dialog>
  </div>
</template>

<script>
  export default {
    props: {
      total: { type: [String, Number], default: null },
      range: { type: [String, Number], default: null },
    },
    data() {
      return {
        numberSelected: '10',
        dialogVisible: false,
      }
    },
    computed: {
      numberOptions() {
        return [
          { name: '10', label: '10' },
          { name: '25', label: '25' },
          { name: '50', label: '50' },
          { name: '75', label: '75' },
          { name: '100', label: '100' },
          { name: 'All', label: 'All' },
        ]
      },
      routeQuery() {
        return this.$route.query
      },
    },
    mounted() {
      if (this.routeQuery.display) {
        this.numberSelected = this.routeQuery.display
      }
    },
    methods: {
      changeDisplay(selected) {
        this.$nuxt.$emit('changeDisplay', selected)
      },

      
    },
  }
</script>

<style scoped lang="scss">
  .number-result {
    font-weight: bold;
  }
  .number-item {
    font-size: rem(12px);
  }
  .display-result {
    font-size: rem(12px);
    margin-top: rem(8px);
  }
  .el-dialog__title {
    font-size: rem(12px) !important;
    font-weight: bold;
  }
  .select-number {
    width: rem(75px);
    margin-right: rem(10px);
  }
  .options-button {
    box-shadow: rem(2px 2px 1px) #00000029;
  }
</style>
<style lang="scss">
  .el-dialog__title {
    font-weight: bold;
    font-size: rem(14px);
    padding: rem(0 0 5px);
  }
  .el-dialog__header {
    border-bottom: 1px solid #c5c5c5;
  }
  .el-dialog__body {
    padding: rem(24px 28px) !important;
  }
  .options-list {
    .el-dialog__body .row .col-md-4 {
      padding-left: 0 !important;
    }
  }
</style>
