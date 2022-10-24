// Email validation rules
import { isBoolean } from 'lodash'
export default (vm, overrides) => {
  // If boolean given as override, treat it as required value
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
    },

    // Valid email pattern rule
    // Referring to https://emailregex.com/
    {
      required: true,
      pattern:
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
      message: vm.$t('validation.email.invalid'),
      trigger: 'change',

      // Overrides should be last
      ...overrides,
    },
  ]
}
