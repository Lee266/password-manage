<template>
  <el-form
    ref="form"
    label-width="120px"
    label-position="top"
    @submit.native.prevent
    @keydown.enter.prevent
  >
    <div class="row">
      <div class="col-md">
        <div class="row">
          <div class="col-md-4">
            <el-form-item :label="$t('admin.list.name')">
              <el-input
                v-model="usernameInput"
                placeholder="ユーザ名を入力"
                clearable
                @change="filterName"
              ></el-input>
            </el-form-item>
          </div>

          <div class="col-md-4">
            <el-form-item :label="$t('admin.list.email')">
              <el-input
                v-model="emailInput"
                placeholder="メールアドレスを入力"
                clearable
                @change="filterEmail"
              ></el-input>
            </el-form-item>
          </div>

          <div class="col-md-4">
            <el-form-item :label="$t('admin.list.companyName')">
              <el-input
                v-model="companyInput"
                placeholder="キーワードを入力"
                clearable
                @change="filterCompany"
              ></el-input>
            </el-form-item>
          </div>

          <div class="col-md-4">
            <el-form-item :label="$t('admin.list.residence')">
              <el-input
                v-model="addressInput"
                placeholder="住所を入力"
                clearable
                @change="filterAddress"
              ></el-input>
            </el-form-item>
          </div>

          <div class="col-md-4">
            <el-form-item :label="$t('admin.input.keyword')">
              <el-input
                v-model="searchInput"
                placeholder="キーワードを入力"
                clearable
                @change="filterSearch"
              ></el-input>
            </el-form-item>
          </div>

          <div class="col-md-4">
            <el-form-item :label="$t('admin.list.authority')">
              <el-select
                v-model="roleInput"
                class="w:w-half"
                placeholder="管理者権限を選択"
                clearable
                @change="filterRole"
              >
                <el-option
                  v-for="item in roles"
                  :key="item.id"
                  :label="$t(`auth.role.${camelCase(item.name)}`)"
                  :value="item.id"
                />
              </el-select>
            </el-form-item>
          </div>
        </div>
      </div>
      <div class="col-md-auto w:mb-3">
        <el-button class="reset-button" size="small" @click="resetFilters">{{
          $t('admin.page.reset')
        }}</el-button>
      </div>
    </div>
  </el-form>
</template>

<script>
  import { trim, camelCase } from 'lodash'

  export default {
    props: {
      page: { type: [String, Number], default: 1 },
      search: { type: String, default: null },
      role: { type: [String, Number], default: null },
      company: { type: String, default: null },
      resources: { type: Object, default: () => {} },
      name: { type: String, default: null },
      email: { type: String, default: null },
      address: { type: String, default: null },
    },

    data() {
      return {
        usernameInput: this.$props.name,
        emailInput: this.$props.email,
        searchInput: this.$props.search,
        roleInput: this.$props.role ? parseInt(this.$props.role) : null,
        companyInput: this.$props.company,
        addressInput: this.$props.address,
      }
    },
    computed: {
      routeName() {
        return this.$route.name
      },
      routeQuery() {
        return this.$route.query
      },

      roles() {
        return this.resources?.roles ?? []
      },
      companies() {
        return this.resources?.companies ?? []
      },

      orderOptions() {
        return [
          { name: 'name', label: 'Name' },
          { name: 'role', label: 'Role Name' },
          { name: 'email', label: 'Email Address' },
          { name: 'company', label: 'Company Name' },
          { name: 'created', label: 'Created Date' },
        ]
      },
    },

    methods: {
      camelCase,

      resetFilters() {
        this.searchInput = null
        this.roleInput = null
        this.companyInput = null
        this.emailInput = null
        this.usernameInput = null
        this.addressInput = null
        this.$router.push({ name: this.routeName })
      },

      filterSearch(value) {
        const search = trim(value) ? value : undefined
        const query = { ...this.routeQuery, ...{ search, page: 1 } }
        this.$router.push({ name: this.routeName, query })
      },

      filterRole(value) {
        const role = value ? parseInt(value) : undefined
        const query = { ...this.routeQuery, ...{ role, page: 1 } }
        this.$router.push({ name: this.routeName, query })
      },

      filterCompany(value) {
        const company = trim(value) ? value : undefined
        const query = { ...this.routeQuery, ...{ company, page: 1 } }
        this.$router.push({ name: this.routeName, query })
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

      filterAddress(value) {
        const address = trim(value) ? value : undefined
        const query = { ...this.routeQuery, ...{ address, page: 1 } }
        this.$router.push({ name: this.routeName, query })
      },
    },
  }
</script>
