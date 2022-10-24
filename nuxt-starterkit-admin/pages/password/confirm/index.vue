<template>
  <el-card v-loading="isLoading" class="card-reset-password sm:w:px-3">
    <!-- Confirm reset password title - Start -->
    <div v-if="!isSuccess">
      <h1 class="w:text-2xl sm:w:text-3xl w:text-center w:mb-4">
        {{ $t('auth.confirm_reset_password.page.title') }}
      </h1>
      <div class="sm:w:text-sm w:text-center w:mb-4 mt-0">
        {{ $t('auth.confirm_reset_password.page.text') }}
      </div>
    </div>
    <!-- Confirm reset password title - End -->

    <!-- Reset Password successfully - Start -->
    <div v-if="isSuccess">
      <h1 class="w:text-2xl sm:w:text-3xl w:text-center w:mb-4">
        {{ $t('auth.confirm_reset_password.page.success') }}
      </h1>
      <div class="sm:w:text-sm w:text-center mt-0">
        {{ $t('auth.confirm_reset_password.page.success_text') }}
      </div>
      <a 
        :href="toLoginPage"
      >
        <div class="sm:w:text-sm w:text-center w:text-blue-500 mt-0">
          {{ $t('auth.confirm_reset_password.page.login_here') }}
        </div>
      </a>
    </div>
    <!-- Reset Password successfully - End -->

    <!-- Confirm reset password form - Start -->
    <el-form
      v-else
      ref="confirmResetPasswordForm"
      :model="form"
      :rules="rules"
      label-width="120px"
      label-position="top"
      @submit.native.prevent="submit('confirmResetPasswordForm')"
    >
    <!-- Password input - Start -->
      <el-form-item :label="$t('auth.confirm_reset_password.page.new_password')" prop="password">
        <el-input
          v-model="form.password"
          type="password"
          autocomplete="off"
          prefix-icon="el-icon-unlock"
          :placeholder="$t('auth.confirm_reset_password.page.new_password')"
        ></el-input>
      </el-form-item>
      <!-- Password input - End -->

      <!-- Confirm Password input - Start -->
      <el-form-item :label="$t('auth.confirm_reset_password.page.confirm_password')" prop="confirmPassword">
        <el-input
          v-model="form.confirmPassword"
          type="password"
          autocomplete="off"
          prefix-icon="el-icon-unlock"
          :placeholder="$t('auth.confirm_reset_password.page.confirm_password')"
        ></el-input>
      </el-form-item>
      <!-- Confirm Password input - End -->

      <div class="w:mb-3 w:items-center">
        <div class="row">
          <!-- Submit button - Start -->
          <div
            class="w:items-center"
          >
            <el-button
              type="primary"
              class="w:w-full"
              @click="submit('confirmResetPasswordForm')"
              >{{ $t('auth.confirm_reset_password.page.submit') }}</el-button
            >
          </div>
          <!-- Submit button - End -->
        </div>
      </div>
    </el-form>
    <!-- Confirm reset password form - End -->
  </el-card>
</template>
<script>
  import { Password } from '@/presets/validation/rules'

  export default {
    name: 'Reset',
    auth: false,
    layout: 'auth',
    data() {
      const confirmPassword = (rule, value, callback) => {
        if (value !== this.form.password) {
          callback(new Error(
            this.$t('validation.password.confirmation')
          ))
        } else {
          callback()
        }
      }

      return {
        isLoading: false,
        isSuccess: false,
        toLoginPage:'/login',
        form: {
          token: '',
          email: '',
          password: null,
          confirmPassword: null,
        },
        rules: {
          password: Password(this, { required: true }),
          confirmPassword: [...Password(this, {required: true}), { validator: confirmPassword, trigger: 'blur' }]
        },
      }
    },
    created() {
      const token = this.$route.query.token
      this.checkToken(token)
    },
    methods: {
      // On form submit
      submit(form) {
        this.$refs[form].validate(async (valid) => {
          if (valid) await this.confirmResetPassword()
        })
      },

      async confirmResetPassword() {
        this.isLoading = true
        try {
          const payload = { ...this.form }

          const response = await this.$axios
            .$post('/admin/password/reset', payload)
            .catch((err) => {
              console.log(err)
            })

          if (response.status === 200) {
            this.form.email = ''
            this.isSuccess = true
          }
        } catch (err) {
          console.log(err)
        }
        this.isLoading = false
      },

      async checkToken(token) {
        this.isLoading = true
        const response = await this.$axios
          .$get(`/admin/password/reset/${token}`)
          .catch((err) => {
            console.log(err)
            return this.$router.push('/404')
          })
        
        if (response.data) {
          this.isLoading = false
          this.form.token = token
          this.form.email = response.data.email
        } else {
          return this.$router.push('/404')
        }
      }

    },
  }
</script>

<style scoped lang="scss">
  .el-form-item {
    margin-bottom: rem(24px);
  }
</style>
