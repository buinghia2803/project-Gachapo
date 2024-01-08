import Vue from 'vue'

const isServer = Vue.prototype.$isServer

// eslint-disable-next-line no-useless-escape
const SPECIAL_CHARS_REGEXP = /([\:\-\_]+(.))/g
const MOZ_HACK_REGEXP = /^moz([A-Z])/
const ieVersion = isServer ? 0 : Number(document.documentMode)

/**
 * Remove characters from both sides of a string
 *
 * @param {string} string - Class name
 * @return {string} Class name
 */
const trim = function (string) {
  return (string || '').replace(/^[\s\uFEFF]+|[\s\uFEFF]+$/g, '')
}

/**
 * Convert name to camelCase
 *
 * @param {string} name - Style name
 * @return {string} Style name
 */
const camelCase = function (name) {
  return name
    .replace(SPECIAL_CHARS_REGEXP, function (_, separator, letter, offset) {
      return offset ? letter.toUpperCase() : letter
    })
    .replace(MOZ_HACK_REGEXP, 'Moz$1')
}

/**
 * Determine whether any of the matched elements are assigned the given class.
 *
 * @param {object} el - Element object
 * @param {string} cls - Class name
 * @return {boolean} Style name
 */
export function hasClass(el, cls) {
  if (!el || !cls) { return false }
  if (cls.includes(' ')) { throw new Error('className should not contain space.') }
  if (el.classList) {
    return el.classList.contains(cls)
  } else {
    return (' ' + el.className + ' ').includes(' ' + cls + ' ')
  }
}

/**
 * Adds the specified class to each element in the set of matched elements.
 *
 * @param {object} el - Element object
 * @param {string} cls - Class name
 */
export function addClass(el, cls) {
  if (!el) { return }
  let curClass = el.className
  const classes = (cls || '').split(' ')

  for (let i = 0, j = classes.length; i < j; i++) {
    const clsName = classes[i]
    if (!clsName) { continue }

    if (el.classList) {
      el.classList.add(clsName)
    } else if (!hasClass(el, clsName)) {
      curClass += ' ' + clsName
    }
  }
  if (!el.classList) {
    el.className = curClass
  }
}

/**
 * Remove a single class from each element in the set of matched elements.
 *
 * @param {object} el - Element object
 * @param {string} cls - Class name
 */
export function removeClass(el, cls) {
  if (!el || !cls) { return }
  const classes = cls.split(' ')
  let curClass = ' ' + el.className + ' '

  for (let i = 0, j = classes.length; i < j; i++) {
    const clsName = classes[i]
    if (!clsName) { continue }

    if (el.classList) {
      el.classList.remove(clsName)
    } else if (hasClass(el, clsName)) {
      curClass = curClass.replace(' ' + clsName + ' ', ' ')
    }
  }
  if (!el.classList) {
    el.className = trim(curClass)
  }
}

/**
 * Get style value of element
 *
 * @param {object} element - Element object
 * @param {string} styleName - Style name
 * @return {string} Style value
 */
export const getStyle =
  ieVersion < 9
    ? function (element, styleName) {
      if (isServer) { return }
      if (!element || !styleName) { return null }
      styleName = camelCase(styleName)
      if (styleName === 'float') {
        styleName = 'styleFloat'
      }
      try {
        switch (styleName) {
          case 'opacity':
            try {
              return element.filters.item('alpha').opacity / 100
            } catch (e) {
              return 1.0
            }
          default:
            return element.style[styleName] || element.currentStyle
              ? element.currentStyle[styleName]
              : null
        }
      } catch (e) {
        return element.style[styleName]
      }
    }
    : function (element, styleName) {
      if (isServer) { return }
      if (!element || !styleName) { return null }
      styleName = camelCase(styleName)
      if (styleName === 'float') {
        styleName = 'cssFloat'
      }
      try {
        const computed = document.defaultView.getComputedStyle(element, '')
        return element.style[styleName] || computed
          ? computed[styleName]
          : null
      } catch (e) {
        return element.style[styleName]
      }
    }

/**
 * Set style value of element
 *
 * @param {object} element - Element object
 * @param {string} styleName - Style name
 * @param {string} value - Style value
 */
export function setStyle(element, styleName, value) {
  if (!element || !styleName) { return }

  if (typeof styleName === 'object') {
    Object.keys(styleName).forEach(key => {
      if (Object.prototype.hasOwnProperty.call(styleName, key)) {
        setStyle(element, key, styleName[key])
      }
    })
  } else {
    styleName = camelCase(styleName)
    if (styleName === 'opacity' && ieVersion < 9) {
      element.style.filter = isNaN(value)
        ? ''
        : 'alpha(opacity=' + value * 100 + ')'
    } else {
      element.style[styleName] = value
    }
  }
}

/**
 * The default action of the event will not be triggered
 */
export function preventDefault(e) {
  e = e || window.event
  if (e.preventDefault) {
    e.preventDefault()
  }
}

/**
 * Add style overflow to html tag, for disable scroll on mobile
 */
export function addOverflowToHtmlTag(e) {
  preventDefault(e)
  document.documentElement.style.overflow = 'hidden'
}

/**
 * Remove overflow style to html tag, for enable scroll on mobile
 */
export function removeOverflowFromHtmlTag() {
  document.documentElement.style.overflow = null
}

/**
 * Disable scroll of the browser when loading overlay is shown and fullscreen
 */
export function disableScroll() {
  document.addEventListener('wheel', preventDefault, { passive: false })
  if (window.addEventListener) {
    window.addEventListener('DOMMouseScroll', preventDefault, false)
  }
  window.onmousewheel = document.onmousewheel = preventDefault
  window.ontouchstart = preventDefault
  window.ontouchmove = preventDefault
  document.ontouchmove = preventDefault
  document.ontouchmove = event => {
    event.preventDefault()
  }
  window.ontouchend = preventDefault
  window.addEventListener('touchstart', addOverflowToHtmlTag, false)
  window.addEventListener('touchmove', addOverflowToHtmlTag, false)
  window.addEventListener('touchend', addOverflowToHtmlTag, false)
}

/**
 * Enable scroll of the browser when loading overlay is hidden
 */
export function enableScroll() {
  document.removeEventListener('wheel', preventDefault, { passive: false })
  if (window.removeEventListener) {
    window.removeEventListener('DOMMouseScroll', preventDefault, false)
  }
  window.onmousewheel = document.onmousewheel = null
  window.ontouchstart = null
  window.ontouchmove = null
  document.ontouchmove = null
  window.ontouchend = null
  window.removeEventListener('touchstart', addOverflowToHtmlTag, false)
  window.removeEventListener('touchmove', addOverflowToHtmlTag, false)
  window.removeEventListener('touchend', addOverflowToHtmlTag, false)
  removeOverflowFromHtmlTag()
}
