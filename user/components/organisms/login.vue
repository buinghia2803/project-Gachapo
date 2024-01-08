<template>
  <div v-loading="loading">
    <h2 class="title-block title-block-line-pc text-center text-md-left">
      {{ this.title }}
    </h2>
    <div class="form-login form-default">
      <ValidationObserver
        ref="observer"
        v-slot="{ handleSubmit }"
      >
        <b-form @submit.prevent="handleSubmit(onSubmit)">
          <ValidationProvider
            :name="$t('companies.email')"
            ref="provider_email"
            rules="required|regexEmail|max:255"
            v-slot="validationContext"
          >
            <b-form-group
              id="email"
              :label="$t('companies.email')"
              label-for="email"
              class="mt-5"
            >
              <b-form-input
                id="input-1"
                v-model="form.email"
                type="email"
                :state="getValidationState(validationContext)"
                :placeholder="$t('common.please_enter')"
                @keyup.enter="handleSubmit(onSubmit)"
              />
              <b-form-invalid-feedback id="input-1-live-feedback">
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </ValidationProvider>
          <br />
          <ValidationProvider
            :name="$t('companies.password')"
            ref="provider_password"
            rules="required|password"
            v-slot="validationContext"
          >
            <b-form-group
              class="password"
              :label="$t('companies.password')"
              label-for="password"
            >
              <b-form-input
                id="password"
                v-model="form.password"
                :state="getValidationState(validationContext)"
                type="password"
                :placeholder="$t('common.please_enter')"
                required
                @keyup.enter="handleSubmit(onSubmit)"
              />
              <b-form-invalid-feedback id="input-1-live-feedback">
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </ValidationProvider>
          <br />
          <ValidationProvider
            v-if="show"
            :name="$t('common.secret_key')"
            ref="provider_secret_key"
            rules="required"
            v-slot="validationContext"
          >
            <b-form-group
              class="secret_key"
              :label="$t('common.secret_key')"
              label-for="secret_key"
            >
              <b-form-input
                id="secret_key"
                v-model="form.secret_key"
                type="text"
                :placeholder="$t('common.please_enter')"
                required
                :state="getValidationState(validationContext)"
                @keyup.enter="handleSubmit(onSubmit)"
              />
              <b-form-invalid-feedback id="input-1-live-feedback">
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </ValidationProvider>
          <div class="d-flex justify-content-center pt-4">
            <button
              type="button"
              @click="handleSubmit(onSubmit)"
              class="btn btn-blue btn-login max-w-272"
            >
              {{ $t('common.login') }}
            </button>
          </div>
          <b-form-group class="d-flex justify-content-center text-center pt-4 font-16">
            <b-link
              href="/forgot-password"
              title=""
            >
              {{ $t('common.forgot_password') }}
            </b-link>
          </b-form-group>
        </b-form>
      </ValidationObserver>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
  name:'Login',
  props: {
    title: {
      type: String,
      required: true,
      default: 'ログイン'
    },
  },

  data() {
    return {
      previousRoute: this.$route.query.pre || '/',
      form: {
        email: '',
        secret_key:'',
        password: ''
      },
      show: false
    }
  },

  computed: {
    ...mapState({
      loading: 'loading'
    })
  },

  methods: {
    /**
     * Get validation state of form.
     */
    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },

    /**
     * Event on submit
     */
    async onSubmit() {
      this.$relipa.userLogin(this.form).then(res => {
        if(res && res.code == '2nd_factor') {
            this.$bvToast.toast(this.$t('messages.information.' + res.code), {
              title: this.$t('common.login'),
              variant: 'success',
              autoHideDelay: 2000,
            })
          this.$router.push('/verification-2nd-factor')
          const encode = btoa(encodeURIComponent(JSON.stringify({email: this.form.email, password: this.form.password })));
          this.$store.dispatch('setLoading', false)
          this.$forceUpdate()
          this.$router.push({ path: '/verification-2nd-factor', query: { q:encode } })
          return
        }else {
          this.$auth.setUser(res)
          this.$auth.setUserToken(res.access_token, '')
          if (res.refresh_token) {
            this.$cookies.set(REFRESH_TOKEN, res.refresh_token, { maxAge: REFRESH_TOKEN_MAX_AGE, path: '/' })
          }
          this.$bvToast.toast(this.$t('messages.information.login'), {
            title: this.$t('common.login'),
            variant: 'success',
            autoHideDelay: 2000,
          })
          this.$store.dispatch('setLoading', false)
          this.$router.push(this.previousRoute)
        }
      }).catch(error => {
        if(error && error.response && error.response.data && error.response.data.code) {
          const resError = error.response.data
          if(resError && !resError.status &&  resError.code =='expired') {
            this.$refs.provider_secret_key.applyResult({
              errors:  [resError.message],
              valid: false,
              failedRules: {}
            })
            this.$store.dispatch('setLoading', false)
            return
          }else if(resError && !resError.status && resError.code =='not_exist_code') {
            this.$refs.provider_secret_key.applyResult({
              errors:  [resError.message],
              valid: false,
              failedRules: {}
            })
            this.$store.dispatch('setLoading', false)

            return
          }
            this.form.password = ''
            this.$refs.provider_email.applyResult({
              errors:  [this.$t('messages.error.' + resError.code)],
              valid: false,
              failedRules: {}
            })
            this.$refs.provider_password.reset()
        }else {
          console.error(error);
        }
        this.$store.dispatch('setLoading', false)
      })
    }
  }
}
</script>
<style lang="scss" scoped>
#secret_key {
  height: 50px;
}
.font-16 {
  font-size: 1rem;
}
  /deep/ {
    @media (min-width: 768px) {
      .modal-dialog {
        width: 35%;
      }
    }
  }
</style>
