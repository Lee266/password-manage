<template>
  <div>
    <div class="row">
      <div class="col-md-4">
        <el-button
          :type="column.name ? 'primary' : 'text'"
          class="w:mb-3 w:w-full w:border setting-button"
          @click="toggleColumn('name')"
          >管理者名</el-button
        >
      </div>
      <div class="col-md-4">
        <el-button
          :type="column.role ? 'primary' : 'text'"
          class="w:mb-3 w:w-full w:border setting-button"
          @click="toggleColumn('role')"
          >管理者権限</el-button
        >
      </div>
      <div class="col-md-4">
        <el-button
          :type="column.email ? 'primary' : 'text'"
          class="w:mb-3 w:w-full w:border setting-button"
          @click="toggleColumn('email')"
          >メールアドレス</el-button
        >
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <el-button
          :type="column.company ? 'primary' : 'text'"
          class="w:mb-3 w:w-full w:border setting-button"
          @click="toggleColumn('company')"
          >会社名</el-button
        >
      </div>
      <div class="col-md-4">
        <el-button
          :type="column.telpNumber ? 'primary' : 'text'"
          class="w:mb-3 w:w-full w:border setting-button"
          @click="toggleColumn('telpNumber')"
          >電話番号</el-button
        >
      </div>
      <div class="col-md-4">
        <el-button
          :type="column.residence ? 'primary' : 'text'"
          class="w:mb-3 w:w-full w:border setting-button"
          @click="toggleColumn('residence')"
          >住所</el-button
        >
      </div>
      <div class="col-md-4">
        <el-button
          :type="column.registrationDate ? 'primary' : 'text'"
          class="w:mb-3 w:w-full w:border setting-button"
          @click="toggleColumn('registrationDate')"
          >登録日</el-button
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
        column: (state) => state.adminListColumn,
      }),
    },
    mounted() {
      console.log(this.column)
    },
    methods: {
      toggleColumn(columnName) {
        this.$store.commit('table/toggleAdminListColumn', columnName)
      },
    },
  }
</script>
