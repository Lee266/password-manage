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
            <el-form-item :label="$t('password.list.website')">
              <el-input
                v-model="websiteInput"
                placeholder="ウェブサイトのURLを入力"
                clearable
                @change="filterWebsite"
              ></el-input>
            </el-form-item>
          </div>
          <div class="col-md-4">
            <el-form-item :label="$t('password.list.email')">
              <el-input
                v-model="emailInput"
                placeholder="メールアドレスを入力"
                clearable
                @change="filterEmail"
              ></el-input>
            </el-form-item>
          </div>
          <div class="col-md-4">
            <el-form-item :label="$t('password.list.site_name')">
              <el-input
                v-model="siteNameInput"
                placeholder="サイト名を入力"
                clearable
                @change="filterSiteName"
              ></el-input>
            </el-form-item>
          </div>
          <div class="col-md-4">
            <el-form-item :label="$t('password.list.username')">
              <el-input
                v-model="usernameInput"
                placeholder="ユーザー名を入力"
                clearable
                @change="filterUsername"
              ></el-input>
            </el-form-item>
          </div>

        </div>
      </div>
      <div class="col-md-auto w:mb-3">
        <el-button class="reset-button" size="small" @click="resetFilters">{{
          $t('password.page.reset')
        }}</el-button>
      </div>
    </div>
  </el-form>
</template>

<script>
  import { trim } from 'lodash'

  export default {
    props: {
      page: { type: [String, Number], default: 1},
      search: { type: String, default: null },
      website: { type: String, default: null },
      email: {type: String, default: null},
      username: { type: String, default: null },
      siteName: { type: String, default: null },
      resources: { type: Object, default: () => {} },
    },

    data() {
      return {
        websiteInput: this.$props.website,
        emailInput: this.$props.email,
        usernameInput: this.$props.username,
        siteNameInput: this.$props.siteName,
      }
    },
    computed: {
      routeName() {
        return this.$route.name
      },
      routeQuery() {
        return this.$route.query
      },
      passwordManages() {
        return this.resources?.password_manages ?? []
      },
    },

    methods: {
      resetFilters() {
        this.websiteInput = null
        this.emailInput = null
        this.usernameInput = null
        this.siteNameInput = null
        this.$router.push({name: this.routeName})
      },

      filterWebsite(value){
        const website = trim(value) ? value : undefined
        const query = { ...this.routeQuery, ...{website, page: 1 } }
        this.$router.push({ name: this.routeName, query })
      },
      filterEmail(value) {
        const email = trim(value) ? value : undefined
        const query = { ...this.routeQuery, ...{ email, page: 1 } }
        this.$router.push({ name: this.routeName, query })
      },
      filterSiteName(value) {
        const siteName = trim(value) ? value : undefined
        const query = { ...this.routeQuery, ...{ siteName, page: 1 } }
        this.$router.push({ name: this.routeName, query })
      },
      filterUsername(value) {
        const username = trim(value) ? value : undefined
        const query = { ...this.routeQuery, ...{ username, page: 1 } }
        this.$router.push({ name: this.routeName, query })
      },

    }
  }
</script>