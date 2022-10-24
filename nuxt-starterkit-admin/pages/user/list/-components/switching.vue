<template>
  <div class="row">
    <div class="col-md-4">
      <el-button
        :type="column.username ? 'primary' : 'text'"
        class="w:mb-3 w:w-full w:border setting-button"
        @click="toggleColumn('username')"
        >{{ $t('admin.input.username') }}</el-button
      >
    </div>
    <div class="col-md-4">
      <el-button
        :type="column.email ? 'primary' : 'text'"
        class="w:mb-3 w:w-full w:border setting-button"
        @click="toggleColumn('email')"
        >{{ $t('admin.input.email') }}</el-button
      >
    </div>
    <div class="col-md-4">
      <el-button
        :type="column.createdAt ? 'primary' : 'text'"
        class="w:mb-3 w:w-full w:border setting-button"
        @click="toggleColumn('createdAt')"
        >{{ $t('admin.input.createdAt') }}</el-button
      >
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  export default {
    computed: {
      ...mapState('table', {
        column: (state) => state.userListColumn,
      }),
    },

    mounted() {
      console.log(this.column)
    },

    methods: {
      toggleColumn(columnName) {
        this.$store.commit('table/toggleUserListColumn', columnName)
      },
    },
  }
</script>
