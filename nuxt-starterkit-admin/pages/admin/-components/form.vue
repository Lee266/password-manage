<template>
  <Page
    :title="pageTitle"
    :subtitle="pageSubtitle"
    :breadcrumbs="breadcrumbs"
    :container="1200"
  >
    <FormContainer :title="$t('admin.page.title')" :is-loading="isLoading">
      <el-form
        ref="adminForm"
        :model="form"
        :rules="rules"
        hide-required-asterisk
        status-icon
        label-width="180px"
        label-position="left"
        @submit.native.prevent="submit('adminForm')"
      >
        <FormItem
          :name="$t('admin.input.name')"
          prop="name"
          required
          labelleft="true"
        >
          <template #input>
            <el-input v-model="form.name"></el-input>
          </template>
        </FormItem>
        <FormItem :name="$t('admin.input.email')" prop="email" required>
          <template #input>
            <el-input v-model="form.email"></el-input>
          </template>
        </FormItem>
        <FormItem
          :name="$t('admin.input.password')"
          prop="password"
          :required="passwordRequired"
        >
          <template #input>
            <el-col v-if="showPasswordInput" :span="11">
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
        <el-form-item>
          <el-button type="primary" @click="onSubmit('adminForm')">{{
            $t('admin.page.submit')
          }}</el-button>
          <el-button @click="resetForm('adminForm')">{{
            $t('admin.page.reset')
          }}</el-button>
        </el-form-item>
      </el-form>
    </FormContainer>
  </Page>
</template>

<script>
  import Page from '@/layouts/admin'
  import FormContainer from '@/components/form/container'
  import FormItem from '@/components/form/item'
  import { Email, Password, Textbox } from '@/presets/validation/rules'
  import { SuccessMsg, ErrorMsg } from '@/presets/notification/pages/form'

  export default {
    components: {
      Page,
      FormContainer,
      FormItem,
    },
    async asyncData({ $axios, params }) {
      if (params.id === undefined) {
        const defaultData = {
          pageType: 'create',
        }
        // Return as props
        return {
          defaultData,
        }
      } else {
        const defaultData = await $axios.$get(`/admin/admin/${params.id}`)

        defaultData.pageType = 'edit'
        // Return as props
        return {
          defaultData,
        }
      }
    },
    data() {
      const uniqueEmail = (rule, value, callback) => {
        if (value !== null && value !== '') {
          ;(async () => {
            const dataEmail = await this.checkEmail(value)
            if (dataEmail === true || dataEmail === 'true') {
              callback()
            } else {
              callback(new Error(this.$t('validation.email.exist')))
            }
          })()
        } else {
          callback()
        }
      }

      return {
        defaultData: false,
        isLoading: false,
        showPasswordInput: true,
        passwordRequired: true,
        isCreate: true,
        submitUrl: '/admin/admin/create',
        form: {
          name: null,
          email: null,
          password: null,
        },
        // -------------------------------------------------------------------
        // rules params ruleName(this, input name) if input is required
        // rules params ruleName(this, false, input name) if input is not required
        // rules params ruleName(this, { your custom value }, input name) if input have custom validation
        // for check default value, See on each rules.js
        // -------------------------------------------------------------------
        rules: {
          name: Textbox(this, { max: 50 }, this.$t('admin.input.name')),
          email: [...Email(this), { validator: uniqueEmail, trigger: 'blur' }],
          password: Password(this),
        },
        breadcrumbs: [
          { to: '/dashboard', label: 'Dashboard' },
          { to: '/admin/list', label: 'Admin' },
          { to: '', label: 'Create New' },
        ],
      }
    },

    computed: {
      pageType() {
        return this.defaultData.pageType
      },

      pageTitle() {
        let title = 'Create Admin'
        if (this.pageType === 'edit') title = 'Edit Admin'
        return title
      },

      pageSubtitle() {
        let subtitle = 'Create new admin account'
        if (this.pageType === 'edit') subtitle = 'Edit admin account'
        return subtitle
      },
    },

    async created() {
      console.log(this.pageType)
      this.isLoading = true
      try {
        if (this.defaultData.pageType === 'edit') {
          this.form.name = await this.defaultData.data.name
          this.form.email = await this.defaultData.data.email
          this.showPasswordInput = false
          this.passwordRequired = false
          this.rules.password = Password(this, false)
          this.submitUrl = '/admin/admin/update/' + this.defaultData.data.id
          this.breadcrumbs[1].label = 'Admin Edit'
        }
      } catch (e) {
        // console.log(e)
      }
      this.isLoading = false
    },
    methods: {
      onSubmit(form) {
        this.$refs[form].validate(async (valid) => {
          if (valid) await this.save()
        })
      },

      async checkEmail(email) {
        const url = '/admin/admin/uniqueEmail'
        let adminID = null
        if (this.defaultData !== false) {
          if (this.defaultData.pageType === 'edit') {
            adminID = this.defaultData.data.id
          }
        }
        const postData = { email, adminID }
        const response = await this.$axios
          .$post(url, {
            data: postData,
          })
          .catch((err) => {
            console.log(err)
          })

        const notExist = response.status === 200
        return notExist.toString()
      },

      resetForm(form) {
        this.$refs[form].resetFields()
        this.showPasswordInput = false
      },

      async save() {
        this.isLoading = true
        try {
          const Data = { ...this.form }

          const response = await this.$axios
            .$post(this.submitUrl, {
              data: Data,
            })
            .catch((err) => {
              console.log(err)
            })

          const isSuccess = response.status === 200
          // On success
          if (isSuccess) {
            // Move to admin list page
            // this.$router.push('/admins')
            // Display a notification
            this.$notify(SuccessMsg(this))
          } else {
            this.$notify.error(ErrorMsg(this))
          }
        } catch (err) {
          console.log(err)
        }
        this.isLoading = false
      },
    },
  }
</script>
