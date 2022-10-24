<template>
  <div>
    <div class="row">
      <div class="col-md-4">
        <el-button
          :type="column.website ? 'primary' : 'text'"
          class="w:md-3 w:w-full w:border setting-button"
          @click="toggleColumn('website')"
          >ウェブサイト</el-button
        >
        <el-button
          :type="column.username ? 'primary' : 'text'"
          class="w:md-3 w:w-full w:border setting-button"
          @click="toggleColumn('username')"
          >ユーザー名</el-button
        >
        <el-button
          :type="column.password ? 'primary' : 'text'"
          class="w:md-3 w:w-full w:border setting-button"
          @click="toggleColumn('password')"
          >パスワード</el-button
        >
        <el-button
          :type="column.siteName ? 'primary' : 'text'"
          class="w:md-3 w:w-full w:border setting-button"
          @click="toggleColumn('siteName')"
          >サイト名</el-button
        >
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <el-button
          :type="column.email ? 'primary' : 'text'"
          class="w:md-3 w:w-full w:border setting-button"
          @click="toggleColumn('email')"
          >Email</el-button
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
        column: (state) => state.passwordManageListColumn,
      }),
    },
    mounted() {
      console.log(this.column);
    },
    methods: {
      toggleColumn(columnName) {
        this.$store.commit('table/togglePasswordManageListColumn', columnName)
      },
    },
  }
</script>