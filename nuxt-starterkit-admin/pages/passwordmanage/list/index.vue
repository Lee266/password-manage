<template>
  <Page
    title="パスワード一覧"
    subtitle="Password manage page"
    :breadcrumbs="breadcrumbs"
  >
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

    <Result 
      :data="result.data"
      class="w:hidden md:w:block"
      :loading="$nuxt.$loading.show"
    />

    <List
      :data="result.data"
      class="w:block md:w:hidden"
      v-bind="$props"
      :loading="$nuxt.$loading.show"
      :resources="resources"
    />
    
    <Pagination
      v-if="result"
      class="w:mt-5"
      :perpage="result.per_page"
      :total="result.total"
      :page="result.current_page"
      @change="navigatePage"
    />

    <!-- <el-button type="danger" @click="test()">Danger</el-button> -->
  </Page>
</template>

<router>
  {props: (route) => ({ ...route.query, ...route.params})}
</router>

<script>
  import { trim } from 'lodash'

  import Result from './-components/result'
  import List from './-components/list'
  import Switching from './-components/switching'
  import Filters from './-components/filters'
  import Pagination from '@/components/table/pagination'
  import Page from '@/layouts/admin'
  import FormContainerCollapse from '@/components/form/container/container-collapse'
  import TableSetting from '@/components/table/setting'

  export default {
    auth: true,
    components: {
      Page,
      Result,
      Filters,
      Pagination,
      FormContainerCollapse,
      TableSetting,
      List,
      Switching,
    },

    props: {
      page: { type: [String, Number], default: 1 },
      search: { type: String, default: null },
      order: { type: String, default: null },
      website: { type: String, default: null },
      username: { type: String, default: null },
      password: { type: String, default: null },
      siteName: { type: String, default: null },
      email: { type: String, default: null },
    },

    async asyncData({$axios, route}) {

      const params = { ...route.params, ...route.query }
      const [result, resources] = await Promise.all([
        $axios.get('/password/manage/filter', { params }),
        $axios.get('/password/manage/resources'),
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
          { to: '/dashboard', label: 'ダッシュボード' },
          { to: '/passwordmanage/list', label: 'パスワード一覧' },
        ],
      }
    },

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

    watchQuery: true,

    created() {
      this.$nuxt.$on('changeDisplay', ($event) => {
        const display = trim($event) ? $event : undefined
        const query = { ...this.$route.query, display}
        this.$router.push({ name: this.$route.name, query })
      })
    },

    methods: {
      parseInt,
      test() {
        console.log('ok');
        console.log(this.result);
      },

      navigatePage(value) {
        const page = parseInt(value)
        const query = {...this.$route.query, page }
        this.$router.push({ name: this.$route.name, query})
      }
    },
  }
</script>