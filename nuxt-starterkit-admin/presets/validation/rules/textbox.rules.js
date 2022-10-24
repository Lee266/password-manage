import { isBoolean } from 'lodash'

// default validation
let minLength = 0
let maxLength = 255
let requiredVal = true

// Password validation rules
export default (vm, overrides, attr) => {
  // If boolean given as override,
  // treat it as required value
  if (isBoolean(overrides)) {
    overrides = { required: overrides }
  }

  if (overrides.min !== undefined) minLength = overrides.min
  if (overrides.max !== undefined) maxLength = overrides.max
  if (overrides.required !== undefined) requiredVal = overrides.required

  // Return the rules
  return [
    {
      required: requiredVal,
      message: vm.$t('validation.required').replace(':attribute', attr),
      trigger: 'change',
    },
    {
      required: requiredVal,
      min: minLength,
      message: vm
        .$t('validation.min.string')
        .replace(':attribute', attr)
        .replace(':min', minLength),
      trigger: 'change',
    },
    {
      required: requiredVal,
      max: maxLength,
      message: vm
        .$t('validation.max.string')
        .replace(':attribute', attr)
        .replace(':max', maxLength),
      trigger: 'change',
    },
  ]
}
