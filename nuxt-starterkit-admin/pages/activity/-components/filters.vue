<template>
  <el-form
    ref="form"
    label-width="120px"
    label-position="top"
    @submit.native.prevent
    @keydown.enter.prevent
  >
    <FormContainerFilter>
      <template #column-1>
        <el-form-item :label="$t('admin.input.username')">
          <el-input
            v-model="nameInput"
            placeholder="ユーザ名を入力"
            clearable
            @change="filterName"
          ></el-input>
        </el-form-item>
      </template>

      <template #column-2>
        <el-form-item :label="$t('admin.input.email')">
          <el-input
            v-model="emailInput"
            placeholder="メールアドレスを入力"
            clearable
            @change="filterEmail"
          ></el-input>
        </el-form-item>
      </template>
      <!-- Search - Start -->
      <template #column-3>
        <el-form-item :label="$t('admin.input.keyword')">
          <el-input
            v-model="searchInput"
            placeholder="キーワードを入力"
            clearable
            @change="filterSearch"
          ></el-input>
        </el-form-item>
      </template>
      <!-- Search - End -->

      <template #reset>
        <div class="w:mb-3">
          <el-button class="reset-button" size="small" @click="resetFilters">{{
            $t('admin.page.reset')
          }}</el-button>
        </div>
      </template>
    </FormContainerFilter>
  </el-form>
</template>

<script>
  import { trim, camelCase } from 'lodash'
  import FormContainerFilter from '@/components/form/container/container-filter'

  export default {
    components: {
      FormContainerFilter,
    },
    props: {
      page: { type: [String, Number], default: 1 },
      search: { type: String, default: null },
      resources: { type: Object, default: () => {} },
      name: { type: String, default: null },
      email: { type: String, default: null },
    },

    data() {
      return {
        nameInput: this.$props.name,
        emailInput: this.$props.email,
        searchInput: this.$props.search,
      }
    },

    computed: {
      routeName() {
        return this.$route.name
      },
      routeQuery() {
        return this.$route.query
      },

      orderOptions() {
        return [
          { name: 'log_id', label: 'ID' },
          { name: 'name', label: this.$t('admin.activity.name') },
          { name: 'email', label: this.$t('admin.activity.email') },
          { name: 'activity', label: this.$t('admin.activity.activity') },
          { name: 'ip', label: this.$t('admin.activity.ipaddress') },
          { name: 'access_time', label: this.$t('admin.activity.accessTime') },
        ]
      },
    },

    methods: {
      camelCase,

      resetFilters() {
        this.searchInput = null
        this.nameInput = null
        this.emailInput = null
        this.$router.push({ name: this.routeName })
      },
      filterName(value) {
        const name = trim(value) ? value : undefined
        const query = { ...this.routeQuery, ...{ name, page: 1 } }
        this.$router.push({ name: this.routeName, query })
      },

      filterEmail(value) {
        const email = trim(value) ? value : undefined
        const query = { ...this.routeQuery, ...{ email, page: 1 } }
        this.$router.push({ name: this.routeName, query })
      },

      filterSearch(value) {
        const search = trim(value) ? value : undefined
        const query = { ...this.routeQuery, ...{ search, page: 1 } }
        this.$router.push({ name: this.routeName, query })
      },
    },
  }
</script>
