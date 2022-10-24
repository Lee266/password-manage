<template>
  <el-card v-loading="isLoading" class="card-auth sm:w:px-3">
    <!-- Login title - Start -->
    <h1 class="w:text-center w:mb-0 w:mt-2 login-title">Nuxt Starterkit</h1>
    <p class="sm:w:text-sm w:text-center mt-0 login-sub-title">
      {{ $t('auth.login.page.title') }}
    </p>
    <!-- Login title - End -->

    <!-- Error handler - Start -->
    <div v-if="error.length >= 1" class="row w:mb-4">
      <div class="col-md-12">
        <el-alert :title="error[0].title" type="error">
          <span class="error-message"> {{ error[0].message }} <br /> </span>
        </el-alert>
      </div>
    </div>
    <!-- Error handler - End -->

    <!-- Login form - Start -->
    <el-form
      ref="loginForm"
      :model="form"
      :rules="rules"
      label-width="120px"
      label-position="top"
      hide-required-asterisk
      @submit.native.prevent="submit('loginForm')"
    >
      <!-- Email input - Start -->
      <el-form-item :label="$t('auth.login.field.email')" prop="email">
        <el-input
          v-model="form.email"
          prefix-icon="el-icon-user"
          :placeholder="$t('auth.login.field.email')"
        ></el-input>
      </el-form-item>
      <!-- Email input - End -->

      <!-- Password input - Start -->
      <el-form-item :label="$t('auth.login.field.password')" prop="password">
        <el-input
          v-model="form.password"
          type="password"
          autocomplete="off"
          prefix-icon="el-icon-unlock"
          :placeholder="$t('auth.login.field.password')"
        ></el-input>
      </el-form-item>
      <!-- Password input - End -->

      <div class="w:mb-3 w:items-center">
        <div class="row">
          <!-- Remember me checkbox - Start -->
          <div
            class="col-sm w:flex-grow w:flex w:items-center w:justify-center"
          >
            <el-form-item class="mb-0">
              <el-checkbox
                v-model="form.remember"
                :label="$t('auth.login.field.remember')"
              >
              </el-checkbox>
            </el-form-item>
          </div>
          <!-- Remember me checkbox - End -->

          <!-- Submit button - Start -->
          <div class="w:items-center">
            <el-button
              type="primary"
              class="w:w-full mt-2 login-submit"
              @click="submit('loginForm')"
              >{{ $t('auth.login.page.submit') }}</el-button
            >
          </div>
          <!-- Submit button - End -->
          <!--
          <a class="w:flex w:justify-end" :href="forgotPasswordUrl">
            <div class="w:text-blue-500 w:font-small w:mt-4">
              {{ $t('auth.login.page.forgotPassword') }}
            </div>
          </a>
          -->
        </div>
      </div>
    </el-form>
    <!-- Login form - End -->
  </el-card>
</template>
<script>
  // Import components
  import { Error, Invalid } from '@/presets/notification/auth/login'
  import { Email, Password } from '@/presets/validation/rules'

  export default {
    auth: false,
    layout: 'auth',
    data() {
      return {
        isLoading: false,
        forgotPasswordUrl: '/password/reset',
        form: {
          email: 'admin@admin.com',
          password: '12345678',
          remember: true,
        },
        rules: {
          email: Email(this, { required: true }),
          password: Password(this, { required: true }),
        },
        error: [],
      }
    },
    methods: {
      // On form submit
      submit(form) {
        this.$refs[form].validate(async (valid) => {
          if (valid) await this.login()
        })
      },

      // Perform login attempt
      // CSRF cookie is fetched automatically beforehand
      async login() {
        this.isLoading = true

        try {
          // Append the current locale into the login credentials
          const locale = this.$i18n.localeProperties.code ?? 'ja'
          const loginData = { ...this.form, ...{ locale } }

          // Do the login attempt
          const response = await this.$auth.loginWith('laravelSanctum', {
            data: loginData,
          })

          const isSuccess = response.status === 200
          const isAuthenticated = response.data.authenticated

          // On success
          if (isSuccess && isAuthenticated) {
            // Move to the default protected route
            this.$router.push('/dashboard')
            return
          }

          // Otherwise, desiplay an error message
          this.$notify.error(Error(this))
        } catch (err) {
          // On exception, display an invalid login message
          const errMsg = []
          errMsg.push({
            message: Invalid(this).message,
            title: Invalid(this).title,
          })
          this.error = errMsg
        }

        this.isLoading = false
      },
    },
  }
</script>

<style scoped lang="scss">
  .el-form-item {
    margin-bottom: rem(24px);
  }

  .login-title {
    font-size: rem(22px);
  }

  .login-sub-title {
    font-weight: bold;
    color: #676767;
  }

  .login-submit {
    box-shadow: 3px 3px 1px #00000029;
  }
</style>
