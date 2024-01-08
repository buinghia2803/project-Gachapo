'use strict' // 厳格モード

/**
 *
 * @param dataEmail
 * @return {boolean|RegExpMatchArray}
 */
export const validEmail = function (dataEmail) {
  const email = `${dataEmail}`.trim();
  if (!email.length) {
    return false
  }

  return String(email)
    .toLowerCase()
    .match(
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
}

/**
 *
 * @param cardNumber
 * @return {boolean}
 */
export const validCardNumber = function (cardNumber = '') {
  // Not has space
  const number = `${cardNumber}`.trim().replace(/[^\d]/g, "")
  if (number.length === 0) {
    return false
  }
  const regex = {
    visa: /^4[0-9]{12}(?:[0-9]{3})?$/,
    mastercard: /^5[1-5][0-9]{14}$/,
    amex: /^3[47][0-9]{13}$/,
    diners: /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/,
    discover: /^6(?:011|5[0-9]{2})[0-9]{12}$/,
    jcb: /^(?:2131|1800|35\d{3})\d{11}$/
  };

  if (regex.visa.test(number)) {
    return true
  } else if (regex.mastercard.test(number)) {
    return true
  } else if (regex.amex.test(number)) {
    return true
  } else if (regex.discover.test(number)) {
    return true
  } else if (regex.diners.test(number)) {
    return true
  } else if (regex.jcb.test(number)) {
    return true
  }

  return false
}

/**
 *
 * @param date
 * @return {boolean}
 */
export const validBirthday = function (date = '') {
  if (!date) {
    return false
  }
  try {
    const d = new Date(date);
    const dNew = new Date();
    if (Object.prototype.toString.call(d) === "[object Date]") {
      // It is a date
      if (isNaN(d)) { // d.getTime() or d.valueOf() will also work
        // date object is not valid
        return false
      } else {
        // date object is valid
        if (d.getFullYear() >= dNew.getFullYear() || ((dNew.getFullYear() - d.getFullYear()) > 120)) {
          return false
        }
        return true
      }
    } else {
      // not a date object
      return false
    }
  } catch (e) {
    return false
  }
}

/**
 *
 * @param val
 * @return {string}
 */
export const formatNumberByRegex = function (val) {
  return `${val}`.replace(/[^\d]/g, "")
}
