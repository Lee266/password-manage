<template>
  <Page
    :title="pageTitle"
    :subtitle="pageSubtitle"
    :breadcrumbs="breadcrumbs"
    :container="1200"
  >
    <FormContainer :title="$t('password.page.title')" :is-loading="isLoading">
      <el-form
        ref="passwordManageForm"
        :model="form"
        :rules="rules"
        hide-required-asterisk
        status-icon
        label-width="180px"
        label-position="left"
        @submit.native.prevent="submit('passwordManageForm')"
        >
        <FormItem
          :name="$t('password.input.website')"
          prop="website"
          required
          labelleft="true">
          <template #input>
            <el-input v-model="form.website"></el-input>
          </template>
        </FormItem>
        <FormItem
          :name="$t('password.input.username')"
          prop="username"
        >
          <template #input>
            <el-input v-model="form.username"></el-input>
          </template>
        </FormItem>
        <FormItem
          :name="$t('password.input.password')"
          prop="password"
          :required="passwordRequired"
        >
          <template #input>
            <el-col v-if="showPasswordInput">
              <el-input
                v-model="form.password"
                type="password"
                autocomplete="off"
                show-password
              ></el-input>
            </el-col>
            <el-button
              v-else
              type="primary"
              @click="showPasswordInput = true"
              >{{ $t('admin.page.changepass') }}</el-button
            >
          </template>
        </FormItem>
        <FormItem
          :name="$t('password.input.site_name')"
          prop="site_name"
        >
          <template #input>
            <el-input v-model="form.site_name"></el-input>
          </template>
        </FormItem>
        <FormItem
          :name="$t('password.input.email')"
          prop="email"
        >
          <template #input>
            <el-input v-model="form.email"></el-input>
          </template>
        </FormItem>
        <el-form-item>
          <el-button type="primary" @click="onSubmit('passwordManageForm')">{{
            $t('admin.page.submit')
          }}</el-button>
          <el-button @click="resetForm('passwordManageForm')">{{
            $t('admin.page.reset')
          }}</el-button>
          <el-button @click="change()">
            パスワードリストへ
          </el-button>
        </el-form-item>
      </el-form>
    </FormContainer> 
  </Page>
</template>

<script>
  import Page from '@/layouts/admin'
  import FormContainer from '@/components/form/container'
  import FormItem from '@/components/form/item'
  import { Email, Password, Textbox} from '~/presets/validation/rules'
  import { SuccessMsg, ErrorMsg } from '~/presets/notification/pages/form'

  export default {
    components: {
      Page,
      FormContainer,
      FormItem,
    },
    async asyncData({ $axios, params} ) {
      if (params.id === undefined) {
        const defaultData = {
          pageType: 'create',
        }

        return {
          defaultData,
        }
      } else {
        const defaultData = await $axios.$get(`/password/manage/${params.id}`)

        defaultData.pageType  = 'edit'
        return {
          defaultData,
        }
      }
    },
    data() {
      return {
        defaultData: false,
        isLoading: false,
        showPasswordInput: true,
        passwordRequired: true,
        isCreate: true,
        submitUrl: '/password/manage/create',
        form: {
          website: null,
          username: null,
          password: null,
          site_name: null,
          email: null,
          note: null,
        },
        rules: {
          website: Textbox(this, {max: 510}, this.$t('password.input.website')),
          username: Textbox(this, {required: false}, this.$t('password.input.username')),
          password: Password(this),
          site_name: Textbox(this, {required: false}, this.$t('password.input.site_name')),
          email: [...Email(this, {required: false})],
        },

        breadcrumbs: [
        { to: '/dashboard', label: 'Dashboard' },
        { to: '/passwordmanage/create', label: 'PasswordManage Create' },
        { to: '', label: 'Create New'},
        ],
      }
    },
    computed: {
      pageType() {
        return this.defaultData.pageType
      },
      pageTitle() {
      let title = 'Create Password'
      if (this.pageType === 'edit') title = 'Edit Password'
        return title
      },

      pageSubtitle() {
        let subtitle = 'Password create page'
        if (this.pageType === 'edit') subtitle = 'Edit password manage'
          return subtitle
      },
    },

    async created() {
      this.isLoading = true
      try {
        if (this.defaultData.pageType === 'edit') {
          this.form.website = await this.defaultData.data.website
          this.form.username = await this.defaultData.data.username
          this.form.site_name = await this.defaultData.data.site_name
          this.form.email = await this.defaultData.data.email
          this.showPasswordInput = false
          this.passwordRequired = false
          this.rules.password = Password(this, false)
          this.submitUrl = '/password/manage/update/' + this.defaultData.data.id
          this.breadcrumbs[1].label = 'Admin Edit'
        }
      } catch (e) {
        console.log(e);
      }
      this.isLoading = false
    },

    methods: {
      onSubmit(form) {
        this.$refs[form].validate(async (valid) => {
          if (valid) await this.save(form)
        })
      },

      change() {
        this.$router.push('/passwordmanage/list')
      },

      resetForm(form) {
        this.$refs[form].resetFields()
        if (this.pageType === 'edit') {
          this.showPasswordInput = false
        }
      },

      async save(form) {
        this.isLoading = true
        try {
          const Data = {...this.form }
          const response = await this.$axios
            .$post(this.submitUrl, {
              data: Data,
            })
            .catch((err) => {
              console.log(err);
            })
          console.log(response);
          const isSuccess = response.status === 200
          if (isSuccess) {
            if (this.pageType === 'create') {
              this.$refs[form].resetFields()
            }
            this.$notify(SuccessMsg(this))
          } else {
            this.$notify.error(ErrorMsg(this))
          }
        } catch (err) {
          this.$notify.error(ErrorMsg(this))
        }
        this.isLoading = false
      },
    },
  }
</script>