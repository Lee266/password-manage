<template>
  <div>
    <div class="row">
      <div class="col-md-4">
        <el-button
          :type="column.id ? 'primary' : 'text'"
          class="w:mb-3 w:w-full w:border setting-button"
          @click="toggleColumn('id')"
          >ID</el-button
        >
      </div>
      <div class="col-md-4">
        <el-button
          :type="column.name ? 'primary' : 'text'"
          class="w:mb-3 w:w-full w:border setting-button"
          @click="toggleColumn('name')"
          >{{ $t('admin.activity.name') }}</el-button
        >
      </div>
      <div class="col-md-4">
        <el-button
          :type="column.email ? 'primary' : 'text'"
          class="w:mb-3 w:w-full w:border setting-button"
          @click="toggleColumn('email')"
          >{{ $t('admin.activity.email') }}</el-button
        >
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <el-button
          :type="column.activity ? 'primary' : 'text'"
          class="w:mb-3 w:w-full w:border setting-button"
          @click="toggleColumn('activity')"
          >{{ $t('admin.activity.activity') }}</el-button
        >
      </div>
      <div class="col-md-4">
        <el-button
          :type="column.detail ? 'primary' : 'text'"
          class="w:mb-3 w:w-full w:border setting-button"
          @click="toggleColumn('detail')"
          >{{ $t('admin.activity.detail') }}</el-button
        >
      </div>
      <div class="col-md-4">
        <el-button
          :type="column.ipaddress ? 'primary' : 'text'"
          class="w:mb-3 w:w-full w:border setting-button"
          @click="toggleColumn('ipaddress')"
          >{{ $t('admin.activity.ipaddress') }}</el-button
        >
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <el-button
          :type="column.accessTime ? 'primary' : 'text'"
          class="w:mb-3 w:w-full w:border setting-button"
          @click="toggleColumn('accessTime')"
          >{{ $t('admin.activity.accessTime') }}</el-button
        >
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  export default {
    computed: {
      ...mapState('table', {
        column: (state) => state.logListColumn,
      }),
    },
    mounted() {
      console.log(this.column)
    },
    methods: {
      toggleColumn(columnName) {
        this.$store.commit('table/toggleLogListColumn', columnName)
      },
    },
  }
</script>
