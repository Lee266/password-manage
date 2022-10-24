<template>
  <el-card v-loading="isLoading" class="card-reset-password sm:w:px-3">
    <!-- Reset password title - Start -->
    <div v-if="!isSuccess">
      <h1 class="w:text-2xl sm:w:text-3xl w:text-center w:mb-4">
        {{ $t('auth.reset_password.page.title') }}
      </h1>
      <div class="sm:w:text-sm w:text-center w:mb-4 mt-0">
        {{ $t('auth.reset_password.page.text') }}
      </div>
    </div>
    <!-- Reset password title - End -->

    <!-- Send Mail Reset Password successfully - Start -->
    <div v-if="isSuccess">
      <h1 class="w:text-2xl sm:w:text-xl w:text-center w:mb-4">
        {{ $t('auth.reset_password.page.success') }}
      </h1>
    </div>
    <!-- Send Mail Reset Password successfully - End -->

    <!-- Reset password form - Start -->
    <el-form
      v-else
      ref="resetPasswordForm"
      :model="form"
      :rules="rules"
      label-width="120px"
      label-position="top"
      @submit.native.prevent="submit('resetPasswordForm')"
    >
      <!-- Email input - Start -->
      <el-form-item :label="$t('auth.reset_password.page.email')" prop="email">
        <el-input
          v-model="form.email"
          prefix-icon="el-icon-user"
          :placeholder="$t('auth.reset_password.page.email')"
        ></el-input>
      </el-form-item>
      <!-- Email input - End -->

      <div class="w:mb-3 w:items-center">
        <div class="row">
          <!-- Submit button - Start -->
          <div
            class="w:items-center"
          >
            <el-button
              type="primary"
              class="w:w-full"
              @click="submit('resetPasswordForm')"
              >{{ $t('auth.reset_password.page.submit') }}</el-button
            >
          </div>
          <!-- Submit button - End -->
        </div>
      </div>
    </el-form>
    <!-- Reset password form - End -->
  </el-card>
</template>
<script>
  import { Email } from '@/presets/validation/rules'

  export default {
    name: 'Reset',
    auth: false,
    layout: 'auth',
    data() {
      return {
        isLoading: false,
        isSuccess: false,
        form: {
          email: ''
        },
        rules: {
          email: Email(this, { required: true }),
        }
      }
    },
    methods: {
      // On form submit
      submit(form) {
        this.$refs[form].validate(async (valid) => {
          if (valid) await this.resetPassword()
        })
      },

      async resetPassword() {
        this.isLoading = true
        try {
          const payload = { ...this.form }

          const response = await this.$axios
            .$post('/admin/password/forgot-password', payload)
            .catch((err) => {
              if (err.response) {
                const message = err.response.data.message
                if (message.length > 0) {
                  this.$notify.error({
                    title: 'エラー',
                    message: this.$t('validation.email.invalid'),
                  })
                }
              }
            })

          if (response.status === 200) {
            this.form.email = ''
            this.isSuccess = true
          } else {
            this.$notify.error({
              title: 'error',
              message: response.message,
            })
          }
        } catch (err) {
          console.log(err)
        }
        this.isLoading = false
      }
    },
  }
</script>

<style scoped lang="scss">
  .el-form-item {
    margin-bottom: rem(24px);
  }
</style>
