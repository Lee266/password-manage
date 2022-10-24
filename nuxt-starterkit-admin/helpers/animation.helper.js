import $ from 'jquery/dist/jquery.slim'

// Get an element height when fully visible
export const getElementHeight = (element) => {
  const $element = $(element)

  // Make the element visible and fullheight
  $element.css({
    height: 'auto',
    display: 'block',
  })

  // Get the element height
  const height = $element.height()

  // Reset the element to its previous state
  $element.css({
    height: '',
    display: '',
  })

  // Return the height
  return height
}

// Animate slide-up an element
export const slideUp = (element, $anime, options = {}) => {
  const $element = $(element)
  const targetHeight = getElementHeight($element)

  $element.css('display', 'block')

  $anime({
    duration: 500,
    easing: 'easeOutExpo',
    height: [targetHeight, 0],
    targets: $element.get(),
    ...options,
  })
}

// Animate slide-down an element
export const slideDown = (element, $anime, options = {}) => {
  const $element = $(element)
  const targetHeight = getElementHeight($element)

  $element.css({
    height: 0,
    display: 'block',
  })

  $anime({
    duration: 500,
    easing: 'easeOutExpo',
    height: [0, targetHeight],
    targets: $element.get(),
    ...options,
  })
}
