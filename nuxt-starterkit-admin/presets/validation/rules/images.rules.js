import { isBoolean } from 'lodash'

// Images validation rules
export default (vm, overrides) => {
  // If boolean given as override,
  // treat it as required value
  if (isBoolean(overrides)) {
    overrides = { required: overrides }
  }

  // Return the rules
  return [
    {
      required: true,
      message: vm.$t('validation.email.required'),
      trigger: 'change',

      // Overrides should be last
      ...overrides,
    }
  ]
}
