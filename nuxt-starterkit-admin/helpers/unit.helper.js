import { unit } from '@/consts'

// Convert pixel to rem unit
export const rem = (value) => {
  return value ? value / unit.rem.base : 0
}
