<template>
  <div class="page__wrap page-register-user bg-pc-white pt-5 pb-4">
    <b-container class="p-35">
      <div class="page__content">
        <h2 class="title-block title-block-line-pc text-center text-md-left">
          {{ $t('register_user.title') }}
        </h2>
        <div
          v-loading="loading"
          class="form-default form-register-user"
        >
          <ValidationObserver
            ref="form_user_obs"
            class="form-default-observer"
            v-slot="{ handleSubmit }"
          >
            <b-form
              class="__register_user"
              @submit.prevent="handleSubmit(onSubmit)"
            >
              <ValidationProvider
                :name="$t('register_user.name')"
                rules="required|max:100"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('register_user.name')"
                  label-for="name"
                  label-class="label-required-pc"
                >
                  <b-form-input
                    id="name"
                    v-model="form.name"
                    :state="getValidationState(validationContext)"
                    data-error="name"
                    :placeholder="$t('common.please_enter')"
                  />
                  <b-form-invalid-feedback id="input-1-live-feedback">
                    {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>
              <br />
              <ValidationProvider
                :name="$t('register_user.name_furigana')"
                rules="required|max:100"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('register_user.name_furigana')"
                  label-for="name_furigana"
                  label-class="label-required-pc"
                >
                  <b-form-input
                    id="name_furigana"
                    v-model="form.name_furigana"
                    data-error="name_furigana"
                    :state="getValidationState(validationContext)"
                    :placeholder="$t('common.please_enter')"
                  />
                  <b-form-invalid-feedback id="input-1-live-feedback">
                    {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>

              <br />

              <ValidationProvider
                ref="provider_email"
                :name="$t('register_user.email')"
                rules="required|max:255|regexEmail"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('register_user.email')"
                  label-for="email"
                  label-class="label-required-pc"
                >
                  <b-form-input
                    id="email"
                    v-model="form.email"
                    data-error="email"
                    :state="getValidationState(validationContext)"
                    :placeholder="$t('common.please_enter')"
                  />
                  <b-form-invalid-feedback id="input-1-live-feedback">
                    {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>

              <br />

              <ValidationProvider
                :name="$t('register_user.password')"
                rules="required|password"
                v-slot="validationContext"
                vid="password"
              >
                <b-form-group
                  :label="$t('register_user.password')"
                  label-for="password"
                  label-class="label-required-pc"
                >
                  <b-form-input
                    id="password"
                    type="password"
                    :state="getValidationState(validationContext)"
                    v-model="form.password"
                    :placeholder="$t('common.please_enter')"
                  />
                  <b-form-invalid-feedback id="input-1-live-feedback">
                    {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>

              <br />

              <ValidationProvider
                :name="$t('register_user.password_confirmation')"
                :rules="'required|confirm-password:' + form.password"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('register_user.password_confirmation')"
                  label-for="password_confirm"
                  label-class="label-required-pc"
                >
                  <b-form-input
                    id="password_confirm"
                    v-model="form.password_confirmation"
                    data-error="c_password"
                    type="password"
                    :state="getValidationState(validationContext)"
                    :placeholder="$t('common.please_enter')"
                  />
                  <b-form-invalid-feedback id="input-1-live-feedback">
                    {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>

              <br />
              <ValidationProvider
                :name="$t('register_user.birthday')"
                rules="required"
                v-slot="{ errors }"
              >
                <b-form-group
                  :label="$t('register_user.birthday')"
                  label-for="birthday"
                  label-class="label-required-pc"
                >
                  <date-picker
                    id="form_birthday"
                    v-model="form.birthday"
                    type="date"
                    value-type="timestamp"
                    placeholder="YYYY年MM月DD日"
                    :disabled-date="disabledRange"
                    :formatter="dayjsFormat"
                    :class="'w-100'"
                    :editable="false"
                    @change="(value) => changeDatepicker('form_birthday', value)"
                  >
                    <template #icon-calendar>
                      <b-icon-calendar2-event />
                    </template>
                  </date-picker>
                  <div class="d-block invalid-feedback">
                    {{ errors && errors[0] ? appendCSSValid('form_birthday') : '' }}
                    {{ errors[0] }}
                  </div>
                </b-form-group>
              </ValidationProvider>

              <br />

              <ValidationProvider
                :name="$t('register_user.gender')"
                rules="required"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('register_user.gender')"
                  label-for="gender"
                  label-class="label-required-pc"
                >
                  <b-form-select
                    id="gender"
                    v-model="form.gender"
                    :options="OPTION_GENDER"
                    :state="getValidationState(validationContext)"
                    data-error="gender"
                    :placeholder="$t('common.option_please_select')"
                  />
                  <b-form-invalid-feedback id="input-1-live-feedback">
                    {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>

              <br />

              <ValidationProvider
                :name="$t('register_user.profession')"
                rules="required|max:255"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('register_user.profession')"
                  label-for="profession"
                  label-class="label-required-pc"
                >
                  <b-form-input
                    id="profession"
                    v-model="form.profession"
                    data-error="profession"
                    :state="getValidationState(validationContext)"
                    :placeholder="$t('common.please_enter')"
                  />
                  <b-form-invalid-feedback id="input-1-live-feedback">
                    {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>
              <br />

              <b-form-group
                :label="$t('register_user.address')"
                label-class="label-required-pc"
                class="box-address"
              >
                <ValidationProvider
                  :name="$t('register_user.address_first')"
                  :rules="(form.address_type !== ADDRESS_TYPE_SECOND ? 'required|max:255': '')"
                  v-slot="validationContext"
                >
                  <b-form-group
                    :label="$t('register_user.address_first')"
                    label-for="address_first"
                  >
                    <b-form-input
                      id="address_first"
                      v-model="form.address_first"
                      data-error="address"
                      :state="getValidationState(validationContext)"
                      :placeholder="$t('common.please_enter')"
                    />
                    <b-form-invalid-feedback id="input-1-live-feedback">
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </ValidationProvider>
                <!--  -->
                <ValidationProvider
                  :name="$t('register_user.address_second')"
                  :rules="(form.address_type == ADDRESS_TYPE_SECOND ? 'required|max:255': '')"
                  v-slot="validationContext"
                >
                  <b-form-group
                    :label="$t('register_user.address_second')"
                    label-for="address_second"
                    class="mt-2"
                  >
                    <b-form-input
                      id="address_second"
                      v-model="form.address_second"
                      data-error="address_second"
                      :state="getValidationState(validationContext)"
                      :placeholder="$t('common.please_enter')"
                    />
                    <b-form-invalid-feedback id="input-1-live-feedback">
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </ValidationProvider>

                <ValidationProvider
                  :name="$t('register_user.address_type')"
                  rules="required"
                  v-slot="validationContext"
                >
                  <b-form-group
                    :label="$t('register_user.address_type')"
                    label-for="address_type"
                    class="mt-2"
                  >
                    <b-form-select
                      id="address_type"
                      data-error="address_type"
                      v-model="form.address_type"
                      :state="getValidationState(validationContext)"
                      :options="OPTION_ADDRESS_TYPES"
                    />
                    <b-form-invalid-feedback id="input-1-live-feedback">
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </ValidationProvider>
              </b-form-group>
              <br />
              <ValidationProvider
                ref="provider_phone"
                :name="$t('register_user.phone')"
                rules="required|phone"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('register_user.phone')"
                  label-for="phone"
                  label-class="label-required-pc"
                >
                  <b-form-input
                    id="phone"
                    v-model="form.phone"
                    :state="getValidationState(validationContext)"
                    :placeholder="$t('common.please_enter')"
                  />
                  <b-form-invalid-feedback id="input-1-live-feedback">
                    {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>
              <br />

              <ValidationProvider
                :name="$t('register_user.category')"
                ref="radio_group_1"
                rules="required"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('register_user.category')"
                  label-for="category_id"
                  label-class="pb-2 label-required-pc"
                  class="mb-0"
                >
                  <b-form-radio-group
                    id="radio-group-1"
                    value-field="id"
                    text-field="name"
                    v-model="form.category_id"
                    :options="categories"
                    :state="getValidationState(validationContext, 'category_id')"
                    name="category_id"
                    class="form-group__category_id"
                  />
                  <b-form-invalid-feedback :state="getValidationState(validationContext, 'category_id')">
                    {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>

              <br />

              <b-form-group
                :label="$t('register_user.card_info')"
                class="box-credit-card"
                label-class="title-block-line-pc"
              >
                <b-form-group :label="$t('register_user.card_list')">
                  <b-img :src="require(`~/assets/images/list-payment.png`)" />
                </b-form-group>

                <br class="hidden-sp" />

                <ValidationProvider
                  :name="$t('register_user.card_number')"
                  rules="required|max:50"
                  v-slot="validationContext"
                >
                  <b-form-group
                    :label="$t('register_user.card_number')"
                    label-for="card_number"
                    label-class="label-required-pc"
                  >
                    <b-form-input
                      id="card_number"
                      v-model="form.card_number"
                      data-error="card_number"
                      :state="getValidationState(validationContext)"
                      :formatter="regexCardNumber"
                      :placeholder="$t('common.please_enter')"
                    />
                    <b-form-invalid-feedback id="input-1-live-feedback">
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </ValidationProvider>
                <br class="hidden-sp" />

                <ValidationProvider
                  :name="$t('register_user.security_code')"
                  rules="required|max:50"
                  v-slot="validationContext"
                >
                  <b-form-group
                    :label="$t('register_user.security_code')"
                    label-for="security_code"
                    label-class="label-required-pc"
                  >
                    <b-form-input
                      id="security_code"
                      v-model="form.security_code"
                      data-error="security_code"
                      :state="getValidationState(validationContext)"
                      :formatter="formatNumber"
                      max="4"
                      min="3"
                      :placeholder="$t('common.please_enter')"
                    />
                    <b-form-invalid-feedback id="input-1-live-feedback">
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </ValidationProvider>

                <br class="hidden-sp" />

                <ValidationProvider
                  :name="$t('register_user.card_name')"
                  rules="required|max:255"
                  v-slot="validationContext"
                >
                  <b-form-group
                    :label="$t('register_user.card_name')"
                    label-for="card_name"
                    label-class="label-required-pc"
                  >
                    <b-form-input
                      id="card_name"
                      style="text-transform:uppercase"
                      v-model="form.card_name"
                      data-error="card_name"
                      :state="getValidationState(validationContext)"
                      :formatter="regexCardHoldName"
                      :placeholder="$t('common.please_enter')"
                    />
                    <b-form-invalid-feedback id="input-1-live-feedback">
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </ValidationProvider>

                <br class="hidden-sp" />

                <b-form-group
                  :label="$t('register_user.date_of_expiry')"
                  label-for="date_of_expiry"
                  label-class="label-required-pc"
                >
                  <ValidationProvider
                    :name="$t('register_user.date_of_expiry')"
                    rules="required"
                    ref="dateExpired"
                    v-slot="validationContext"
                  >
                    <b-form-select
                      class="date_of_expiry_month mr-4"
                      id="date_of_expiry_month"
                      v-model="month_expired"
                      :options="OPTIONS_MONTHS"
                      data-error="date_of_expiry"
                      placeholder="MM"
                      :state="getValidationState(validationContext, 'month_expired', month_expired)"
                      @change="(value) => onChangeDateExpired(value, years_expired)"
                    />

                    <b-form-select
                      class="date_of_expiry_year"
                      id="date_of_expiry_year"
                      v-model="years_expired"
                      :options="OPTIONS_YEARS"
                      data-error="date_of_expiry"
                      placeholder="YYYY"
                      :state="getValidationState(validationContext, 'years_expired', years_expired)"
                      @change="(value) => onChangeDateExpired(value, form.month_expired)"
                    />
                    <b-form-invalid-feedback id="input-1-live-feedback">
                      {{ customErrors[0] }}
                    </b-form-invalid-feedback>
                  </ValidationProvider>
                </b-form-group>
              </b-form-group>
              <br />
              <b-form-group
                label=" "
                label-for="submit"
                class="d-flex justify-content-center"
              >
                <b-button
                  type="button"
                  @click="handleSubmit(onSubmit)"
                  class="btn btn-blue w-272"
                >
                  {{ $t('common.register') }}
                </b-button>
              </b-form-group>
            </b-form>
          </Validationobserver>
        </div>
      </div>
    </b-container>
  </div>
</template>

<script>
const {formatNumberByRegex} = require('~/utils/utility')

import { mapState, mapGetters } from 'vuex'
import DatePicker from 'vue2-datepicker'
import 'vue2-datepicker/index.css'
import 'vue2-datepicker/locale/ja'
import { OPTION_GENDER,  ADDRESS_TYPE_SECOND, OPTION_ADDRESS_TYPES } from '~/constants'

export default {
  components: {
    DatePicker
  },

  data() {
    return {
      // render const.
      ADDRESS_TYPE_SECOND,
      OPTION_ADDRESS_TYPES,

      // form
      form: {
        name: '',
        name_furigana: '',
        email: '',
        password: '',
        password_confirmation: '',
        birthday: '',
        gender: null,
        address_first: '',
        address_second: '',
        address_type: 1,
        phone: '',
        profession: '',
        category_id: null,
        card_number: '',
        security_code: '',
        card_name: '',
        date_of_expiry: null,
      },
      month_expired: null,
      years_expired: null,
      customErrors: [],

      // config dayjs
      dayjsFormat: {
        stringify: date => {
          return date ? this.$dayjs(date).format('YYYY年MM月DD日') : ''
        },
        parse: value => {
          return value ? this.$dayjs(value, 'YYYY年MM月DD日').toDate() : null
        },
      },
      dayjsFormatYM: {
        stringify: date => {
          return date ? this.$dayjs(date).format('MM月YYYY年') : ''
        },
        parse: value => {
          return value ? this.$dayjs(value, 'YYYY年MM月DD日').toDate() : null
        },
      }
    }
  },

  computed: {
    ...mapGetters({
      categories: 'home/getCategories',
    }),
    ...mapState({
      loading: 'loading'
    }),

    /**
     * Return option Gender from constant.
     */
    OPTION_GENDER() {
      const list = OPTION_GENDER
      list.unshift({ value: null, text: this.$t('common.option_please_select') });

      return list
    },

    /**
     * Return option categories from API.
     */
    OPTION_CATEGORIES() {
      const list = [...this.categories] || []
      list.unshift({ id: null, name: this.$t('common.option_please_select') });

      return list
    },

    /**
     * Option years
     */
    OPTIONS_YEARS() {
      const date = new Date();
      const year = date.getFullYear(); // returns -100
      const list = Array(50).fill(1).map((ele, index) => ({value: (+year + index), text: (+year + index)}))
      list.unshift({ value: null, text: 'YYYY' });

      return list
    },

    /**
     * Option months
     */
    OPTIONS_MONTHS() {
      const theMonths = ["January", "February", "March", "April", "May","June", "July", "August", "September", "October", "November", "December"];
      const list = Array(12).fill(1).map((ele, index) => ({value: (1 + index), text: theMonths[index]}))
      list.unshift({ value: null, text: 'MM' });

      return list
    },
  },

  created() {
    this.prepareData()
  },

  methods: {
    /**
     * Preparse data
     */
    async prepareData() {
      if(!this.categories || (Array.isArray(this.categories) && !this.categories.length)) {
        await this.$store.dispatch('home/callCategories')
      }
    },

    /**
     * Max date for datetime picker
     * @param {Date} date
     */
    disabledRange(date) {
      return date >= this.$dayjs().subtract(1, 'days')
    },

    /**
     * Call api register user.
     */
    onSubmit() {
      this.$store.dispatch('setLoading', true)
      this.form.date_of_expiry =  (this.month_expired < 10 ? '0' : '')+ this.month_expired + '/' + this.years_expired
      this.form.birthday =  this.$dayjs(this.form.birthday).format('YYYY/MM/DD')
      this.$relipa.registerUser(this.form).then(res => {
        this.$bvToast.toast(this.$t('register_user.register_completed'), {
          title: this.$t('register_user.title'),
          variant: 'success',
          autoHideDelay: 4000,
        })
        this.$store.dispatch('setLoading', false)
        this.$router.push('/')
      }).catch(err => {
        this.$store.dispatch('setLoading', false)
            if(err.response && (err.response.data.errors || err.response.data.data)){
              const errList = err.response.data.errors || err.response.data.data.errors
              for (const key in errList) {
                if (Object.hasOwnProperty.call(errList, key)) {
                  this.$refs['provider_' + key].applyResult({
                    errors:  errList[key],
                    valid: false,
                    failedRules: {}
                  });
                }
              }
            }else {
              this.$bvToast.toast(this.$t('companies.server_error'), {
                title: this.$t('companies.title_head'),
                variant: 'danger',
                autoHideDelay: 4000,
              })
            }
      })
    },

    /**
     * Append css valid for datepicker.
     * @param {String} $id
     */
    appendCSSValid(id) {
      if(document && !document.querySelector('#'+ id + ' input').value) {
        document.querySelector('#'+ id + ' input').classList.add("form-control");
        document.querySelector('#'+ id + ' input').classList.add("is-invalid");
      }
    },

    /**
     * Get validation state of form.
     */
    getValidationState({ dirty, validated, valid = null }, field = null, value = null) {
      if((dirty || validated) && field) {
        return !!value;
      }

      return dirty || validated ? valid : null;
    },

    /**
     * Event on change expired date.
     * @param {string} value
     */
    onChangeDateExpired(value, target) {
      if(!value || !target) {
        this.customErrors.push(this.$t('messages.error.required'))
      }else {
        this.customErrors= []
      }
    },

    /**
     * Format number
     * @param {Number} val
     */
    formatNumber(val) {
      return formatNumberByRegex(val)
    },

    /**
     * Format card number
     * @param {Number} val
     */
    regexCardNumber(val) {
      return val.trim().replace(/[^\d]/g, "").replace(/(.{4})/g, '$1 ').trim()
    },

    /**
     * Format card name
     * @param {String} val
     */
    regexCardHoldName(val) {
      return val.replace(/^[0-9-_!@#$%^&*()|\\<>\[\]\{\}+=?'"`/]$/g, "")
    },

    /**
     * Date formater.
     */
    dateFormater(value) {
      return this.$dayjs(value).format('YYYY-MM-DD')
    },

    /**
     * Change color when datepicker is not null.
     * @param {String} id
     * @param {String} value
     */
    changeDatepicker(id, value) {
      if(id && document && value) {
        this.$nextTick(()  => {
          document.querySelector(`#${id} input`).classList.remove('is-invalid');
        })
      }
    }
  }
}
</script>

<style lang="scss" scoped>
/deep/ {
  .mx-input {
    width: 100%;
    height: 50px;
  }
}
.form-control.is-valid {
  background-image: unset;
}
.form-default-observer {
  display: flex;
  justify-content: center;
  @media (min-width: 1024px) {
    .__register_user {
      max-width: 800px
    }
  }
}
@media (max-width: 768px) {
  .__register_user {
    width: 100%;
  }
}
</style>
