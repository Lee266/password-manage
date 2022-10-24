export const Success = (vm) => {
  return {
    type: 'success',
    title: vm.$t('auth.login.success.title'),
    message: vm.$t('auth.login.success.message'),
  }
}

export const Error = (vm) => {
  return {
    title: vm.$t('auth.login.error.title'),
    message: vm.$t('auth.login.error.message'),
  }
}

export const Invalid = (vm) => {
  return {
    title: vm.$t('auth.login.invalid.title'),
    message: vm.$t('auth.login.invalid.message'),
  }
}
