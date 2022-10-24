export const SuccessMsg = (vm) => {
  return {
    type: 'success',
    title: vm.$t('general.success_save.title'),
    message: vm.$t('general.success_save.message'),
  }
}

export const ErrorMsg = (vm) => {
  return {
    title: vm.$t('general.error_save.title'),
    message: vm.$t('general.error_save.message'),
  }
}
