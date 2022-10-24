<template>
  <Page :title="$t('admin.activity.logList')" :breadcrumbs="breadcrumbs">
    <FormContainerCollapse title="検索条件">
      <Filters v-bind="$props" :resources="resources" />
    </FormContainerCollapse>

    <TableSetting
      :total="result.total"
      :range="resultFrom + '~' + resultTo"
      @changeDisplay="changeDisplay($event)"
    >
      <template #settingOptions>
        <Switching v-bind="$props" @changeColumn="changeColumn($event)" />
      </template>
    </TableSetting>

    <Result :data="result.data" :loading="$nuxt.$loading.show" />

    <Pagination
      v-if="result"
      class="w:mt-8"
      :perpage="result.per_page"
      :total="result.total"
      :page="result.current_page"
      @change="navigatePage"
    />
  </Page>
</template>

<router>
  { props: (route) => ({ ...route.query, ...route.params })}
</router>

<script>
  import { trim } from 'lodash'

  import Result from './-components/result'
  import Filters from './-components/filters'
  import Switching from './-components/switching'
  import Pagination from '@/components/table/pagination'
  import Page from '@/layouts/admin'
  import FormContainerCollapse from '@/components/form/container/container-collapse'
  import TableSetting from '@/components/table/setting'

  export default {
    auth: true,

    // Role based restriction
    // Read more in /middleware/README.md
    // meta: {
    //   restrict: 'admin',
    //   allow: 'super_admin',
    // },

    components: {
      Page,
      Result,
      Filters,
      Pagination,
      FormContainerCollapse,
      TableSetting,
      Switching,
    },

    props: {
      page: { type: [String, Number], default: 1 },
      search: { type: String, default: null },
      order: { type: String, default: null },
      direction: { type: String, default: null },
      role: { type: [String, Number], default: null },
      company: { type: [String, Number], default: null },
    },

    async asyncData({ $axios, route }) {
      const params = { ...route.params, ...route.query }
      const [result, resources] = await Promise.all([
        $axios.get('/admin/activity/list/filter', { params }),
        $axios.get('/admin/activity/list/resources'),
      ])

      return {
        result: result.data ?? [],
        resources: resources.data ?? null,
      }
    },

    data: () => ({
      loading: false,
      breadcrumbs: [
        { to: '/dashboard', label: 'Dashboard' },
        { to: '/admin/list', label: 'Admin' },
      ],
    }),

    computed: {
      paginationLayout() {
        let layout = 'prev, next'
        if (this.$screen.sm) layout = 'prev, pager, next'
        return layout
      },
      resultFrom() {
        return this.result.from ?? 0
      },
      resultTo() {
        return this.result.to ?? 0
      },
    },

    // Watch all query changes
    watchQuery: true,

    created() {
      this.$nuxt.$on('changeDisplay', ($event) => {
        const display = trim($event) ? $event : undefined
        const query = { ...this.$route.query, display }
        this.$router.push({ name: this.$route.name, query })
      })
    },

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
