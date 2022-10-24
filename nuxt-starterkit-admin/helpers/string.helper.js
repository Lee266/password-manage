import { capitalize } from 'lodash'

// Get abbreviation from a string
// Used as the default sidebar menu icon when no icon is supplied
export const getStringAbbr = (string, maxLetter = 2) => {
  if (typeof string === 'string') {
    const consonants = string.match(/[^aeiou]/gi)
    if (consonants) {
      const slice = consonants.length >= 3 ? maxLetter : 1
      return capitalize(consonants.join('')).slice(0, slice)
    }
    return null
  }
}
