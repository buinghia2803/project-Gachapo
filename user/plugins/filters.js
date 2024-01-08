import Vue from 'vue'

const LIMIT_TITLE = 45

/**
 * price format
 * @param {Number} num
 * @return {String} formatted number
 */
const price = num => {
  return parent.$nuxt.$n(num, 'currency')
}

/**
 * price format
 * @param {Number} num
 * @return {Number} formatted number
 */
const numbersFloatOrInt = num => {
  return parent.$nuxt.$n(num, 'currency')
}

/**
 * date format
 * @param {Date} date
 * @param {String} format
 * @return {String} formatted date
 */
const date = (date, format = 'YYYY年MM月DD日 HH:mm:ss') => {
  const dateObj = parent.$nuxt.$dayjs(date)

  return dateObj.isValid() ? dateObj.format(format) : ''
}

/**
 * Format date in localization long format
 *
 * @param {Date|Timestamp} date Date value
 */
const localizeDateLong = date => {
  const dateObj = parent.$nuxt.$dayjs(date)

  return date && dateObj.isValid() ? parent.$nuxt.$d(date, 'long') : ''
}

/**
 * Format date in localization short format
 *
 * @param {Date|Timestamp} date Date value
 */
const localizeDateShort = date => {
  const dateObj = parent.$nuxt.$dayjs(date)

  return date && dateObj.isValid() ? parent.$nuxt.$d(date, 'short') : ''
}


/**
 * Show a partial title
 *
 * @return {String} formatted long text to short text
 */
const partialTitle = (text, isShorten = true, length) => {
  if (!isShorten) {
    return text
  }
  let textLenght = 0
  if (length) {
    textLenght = length
  } else {
    textLenght = LIMIT_TITLE
  }

  return text && text.length >= textLenght ? text.slice(0, textLenght) + '...' : text
}

const formatShortDate = (date, format = 'YYYY/MM/DD') => {
  const dateObj = parent.$nuxt.$dayjs(date)

  return dateObj.isValid() ? dateObj.format(format) : ''
}

const filters = {
  price,
  numbersFloatOrInt,
  date,
  localizeDateLong,
  localizeDateShort,
  partialTitle,
  formatShortDate
}

for (const propName of Object.getOwnPropertyNames(filters)) {
  if (filters[propName] instanceof Function) {
    Vue.filter(propName, filters[propName])
  }
}

