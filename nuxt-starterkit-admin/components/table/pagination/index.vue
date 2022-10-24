<template>
  <div class="w:flex w:items-center w:justify-center">
    <el-pagination
      class="w:block md:w:hidden"
      background
      layout="prev, next"
      :total="$props.total"
      :page-size="$props.perpage"
      :current-page.sync="currentPage"
      @current-change="navigate"
    />
    <el-pagination
      class="w:hidden md:w:block"
      background
      :pager-count="5"
      layout="prev, pager, next"
      :total="$props.total"
      :page-size="$props.perpage"
      :current-page="$props.page"
      @current-change="navigate"
    />
  </div>
</template>

<script>
  export default {
    props: {
      perpage: { type: [Number, String], default: 10 },
      total: { type: [Number, String], default: null },
      page: { type: [Number, String], default: 1 },
    },
    data() {
      return {
        currentPage: this.page,
      }
    },
    methods: {
      navigate(page) {
        this.$emit('change', page)
      },
    },
  }
</script>
