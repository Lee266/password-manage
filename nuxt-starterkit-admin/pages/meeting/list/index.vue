<template>
  <Page
    :title="$t('meeting.breadcrumb')"
    :subtitle="$t('meeting.breadcrumb')"
    :breadcrumbs="breadcrumbs"
    :container="1200"
  >
    <el-card class="md:w:p-4">
      <Filters v-bind="$props" :resources="resources" />
    </el-card>

    <el-card class="w:mt-4 md:w:p-4">
      <Result :data="result.data" />

      <Pagination
        v-if="result"
        class="w:mt-8"
        :perpage="result.per_page"
        :total="result.total"
        :page="result.current_page"
        @change="navigatePage"
      />
    </el-card>
  </Page>
</template>

<router>
  { props: (route) => ({ ...route.query, ...route.params })}
</router>

<script>
  import Result from './-components/result'
  import Filters from './-components/filters'
  import Pagination from '@/components/table/pagination'
  import Page from '@/layouts/admin'

  export default {
    auth: true,

    components: {
      Page,
      Result,
      Filters,
      Pagination,
    },

    props: {
      page: { type: [String, Number], default: 1 },
      search: { type: String, default: null },
      order: { type: String, default: null },
      direction: { type: String, default: null },
    },

    async asyncData({ $axios, route }) {
      const params = { ...route.params, ...route.query }
      const [result, resources] = await Promise.all([
        $axios.get('/admin/meeting/list/filter', { params }),
        $axios.get('/admin/meeting/list/resources'),
      ])

      return {
        result: result.data ?? [],
        resources: resources.data ?? null,
      }
    },

    data() {
      return {
        loading: false,
        breadcrumbs: [
          { to: '/dashboard', label: this.$t('meeting.breadcrumb') },
          { to: '/meeting/list', label: this.$t('meeting.subBreadcrumb') },
        ],
      }
    },

    computed: {
      paginationLayout() {
        let layout = 'prev, next'
        if (this.$screen.sm) layout = 'prev, pager, next'
        return layout
      },
    },

    // Watch all query changes
    watchQuery: true,

    methods: {
      parseInt,

      navigatePage(value) {
        const page = parseInt(value)
        const query = { ...this.$route.query, page }
        this.$router.push({ name: this.$route.name, query })
      },
    },
  }
</script>
