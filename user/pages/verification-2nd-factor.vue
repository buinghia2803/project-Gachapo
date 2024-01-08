<template>
  <div v-loading="loading">
    <b-container class="mt-4 mb-4">
      <div>
        <h2 class="title-block title-block-line-pc text-center text-md-left">
          {{ $t('common.login') }}
        </h2>
        <div class="form-login form-default">
          <ValidationObserver
            ref="observer"
            v-slot="{ handleSubmit }"
          >
            <b-form @submit.prevent="handleSubmit(onSubmit)">
              <ValidationProvider
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
            </b-form>
          </ValidationObserver>
        </div>
      </div>
    </b-container>
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
  data() {
    return{
      previousRoute: this.$route.query.pre || '/',
      form: {
        secret_key: ''
      }
    }
  },

  computed: {
    ...mapState({
      loading: 'loading'
    })
  },

  created() {
    if(this.$route.query.q) {
      this.form = {...JSON.parse(decodeURIComponent(atob(this.$route.query.q || "{}"))), ...this.form}
    }
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
      this.$store.dispatch('setLoading', true)
      this.$relipa.userLogin(this.form).then(res => {
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

<style>

</style>