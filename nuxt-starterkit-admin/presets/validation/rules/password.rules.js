import { isBoolean } from 'lodash'

// Password minimum length
const minLength = 6

// Password validation rules
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
      message: vm.$t('validation.password.required'),
      trigger: 'change',

      // Overrides should be last
      ...overrides,
    },
    {
      required: true,
      min: minLength,
      message: vm
        .$t('validation.password.minLength')
        .replace('{:min}', minLength),
      trigger: 'change',

      // Overrides should be last
      ...overrides,
    },
  ]
}
