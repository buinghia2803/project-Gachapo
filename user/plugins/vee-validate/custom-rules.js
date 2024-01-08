/*
|--------------------------------------------------------------------------
| Validator custom.
|--------------------------------------------------------------------------
|
| Here is where you can create rule and override rule or where can
| override message of the rule.
|
*/
import {
  required,
  email,
  numeric
} from 'vee-validate/dist/rules'

const CustomRules = {
  /**
   * Validate email
   */
  email: {
    ...email,
    message: () => {
      return parent.$nuxt.$t('messages.error.regex_email')
    }
  },

  /**
   * Validate required
   */
  required: {
    ...required,
    message: name => {
      return parent.$nuxt.$t('messages.error.required', { name })
    }
  },

  /**
   * Validate regex
   */
  regex: {
    // ...regex,
    validate(value, { target }) {
      var regex = _a.regex;
      if (Array.isArray(value)) {
          return value.every(function (val) { return validate$4(val, { regex: regex }); });
      }
      return regex.test(String(value));
    },
    message: () => {
      return parent.$nuxt.$t('messages.error.invalid_format')
    }
  },

  /**
   * Validate numeric
   */
  numeric: {
    ...numeric,
    message: () => {
      return parent.$nuxt.$t('messages.error.numeric')
    }
  },

  /**
   * Validate decimals
   */
  decimals: {
    validate(value, { target }) {
      const regex = /^\d+(\.\d{1,6})?$/gim
      return regex.test(value)
    },
    message: name => {
      return parent.$nuxt.$t('messages.error.decimal', { name })
    }
  },

  /**
   * Validate integer
   */
  integer: {
    validate(value, { target }) {
      const regex = /^\d+?$/gim
      return regex.test(value)
    },
    message: () => {
      return parent.$nuxt.$t('messages.error.integer')
    }
  },

  /**
   * Validate image
   */
  image: {
    validate(value) {
      if (value && value.length && value[0].type.match(/(jpg|jpeg|png|gif)$/)) {
        return true
      }
      return false
    },
    message: name => {
      return parent.$nuxt.$t('messages.error.invalid_image')
    }
  },

  /**
   * Validate file csv
   */
  csv: {
    validate(value) {
      console.log(value)

      if (value && value.length && (value[0].type === 'application/vnd.ms-excel' || 'text/csv')) {
        return true
      }
      return false
    },
    message: name => {
      return parent.$nuxt.$t('messages.error.invalid_csv')
    }
  },

  /**
   * More than validator.
   */
  moreThan: {
    params: ['target', 'name'],
    validate: (value, target) => {
      return +value >= +target
    },
    messages: (name, { target }) => {
      return parent.$nuxt.$t('messages.error.more_than', { name, target })
    }
  },

  /**
   * Less than validator.
   */
  lessThan: {
    params: ['target', 'name'],
    validate(value, { target }) {
      return +value <= +target
    },
    message: (name, { target }) => {
      return parent.$nuxt.$t('messages.error.less_than', { name, target })
    }
  },

  /**
   * Validate dateRange
   */
  dateRange: {
    params: ['target'],
    validate(value, { target }) {
      return target && value ? (target >= value) : true
    },
    message: (name, { target }) => {
      return parent.$nuxt.$t('messages.error.date_before', { name, target })
    }
  },

  /**
   * Check date from
   */
  dateFromTo: {
    params: ['target'],
    validate(value, { target }) {
      return target && value ? (target <= value) : true
    },
    message: (name, { target }) => {
      return parent.$nuxt.$t('messages.error.date_after', { name, target })
    }
  },

  /**
   * Validate range of number
   */
  fieldRange: {
    params: ['range'],
    validate(value, { range }) {
      if (value.length && range) {
        if (range > value.trim().length || range < value.trim().length) {
          return false
        } else {
          return true
        }
      }
    },

    message: (name, { range }) => {
      return parent.$nuxt.$t('messages.error.invalid_range', { name, range })
    }
  },

  /**
   * Validate image
   */
  image: {
    validate(value) {
      if (value && value.length && value[0].type.match(/(jpg|jpeg|png|gif)$/)) {
        return true
      }
      return false
    },
    message: name => {
      return parent.$nuxt.$t('messages.error.invalid_image')
    }
  },

  /**
   * Validate phone
   */
  phone: {
    validate(value, {min,max}) {
      var regex = /^\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,20}$/

      return regex.test(String(value));
    },
    message: name => {
      return parent.$nuxt.$t('messages.error.invalid_phone', { name })
    }
  },

  /**
   * Validate phone
   */
  password: {
    validate(value) {
      const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/

      return regex.test(String(value));
    },
    message: name => {
      return parent.$nuxt.$t('messages.error.invalid_password')
    }
  },

  /**
   * Validate password
   */
  'password-format': {
    validate(value) {
      const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/

      return regex.test(String(value));
    },
    message: name => {
      return parent.$nuxt.$t('messages.error.reset_password', { name })
    }
  },

  /**
   * Validate max min
   */
  minmax: {
    validate(value, { min, max }) {
      if (value) {
        return value.trim().length >= min && value.trim().length <= max
      } else {
        return false
      }
    },
    message: (name, { min, max }) => {
      return parent.$nuxt.$t('messages.error.min_max', { name, min, max })
    },
    params: ['min', 'max']
  },

  /**
   * Validate min
   */
  min: {
    validate(value, { min }) {
      return value.length >= min
    },
    message: (name, { min }) => {
      return parent.$nuxt.$t('messages.error.min', { name, min })
    },
    params: ['min']
  },

  /**
   * Validate min
   */
  max: {
    validate(value, { max }) {
      return value.length <= max
    },
    message: (name, { max }) => {
      return parent.$nuxt.$t('messages.error.max', { name, max })
    },
    params: ['max']
  },

  /**
   * Validate color hex code
   */
  'color-hex': {
    validate(value, { target }) {
      const regex = /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/gim
      return regex.test(value.trim())
    },
    message: () => {
      return parent.$nuxt.$t('messages.error.color_hex')
    }
  },

  /**
   * Confirm-password validator.
   */
  'confirm-password': {
    params: ['target'],
    validate(value, { target }) {
      return value === target
    },
    message: () => {
      return parent.$nuxt.$t('messages.error.unmatch_password')
    }
  },

  /**
   * validate special characters in email
   */
  regexEmail: {
    validate(value){
      const regex = /^\w+([\+.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/

      return regex.test(String(value))
    },
    message: () => {
      return parent.$nuxt.$t('messages.error.regex_email')
    }
  },
}

export { CustomRules }
