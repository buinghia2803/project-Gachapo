<template>
  <div
    class="page__wrap page-forgot-password-reset pt-5 pb-5"
    v-loading="loading"
  >
    <b-container class="p-35">
      <div class="page__content">
        <h2 class="title-block title-block-line-pc text-center text-md-left">
          パスワード再設定
        </h2>
        <h3 class="title-block-sub text-center">
          新しいパスワードをご入力ください
        </h3>
        <div class="form-default form-forgot-password-reset mt-5">
          <ValidationObserver
            ref="validateForm"
            v-slot="{ handleSubmit }"
          >
            <b-form @submit.prevent="handleSubmit(onSubmit)">
              <ValidationProvider
                :name="$t('password_resets.password')"
                rules="required|password-format"
                v-slot="validationContext"
              >
                <b-form-group
                  label="パスワード"
                  label-for="password"
                  label-class="label-required-pc"
                  :state="getValidationState(validationContext)"
                  vid="password"
                >
                  <b-form-input
                    type="password"
                    v-model="form.password"
                    id="password"
                    :state="getValidationState(validationContext)"
                    placeholder="入力してください"
                  />
                  <b-form-invalid-feedback
                    id="input-1-live-feedback"
                  >
                    {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>
              <br />
              <ValidationProvider
                :name="$t('password_resets.password_confirmation')"
                :rules="'required|confirm-password:' + form.password"
                v-slot="validationContext"
              >
                <b-form-group
                  label="パスワードの確認"
                  label-for="password_confirm"
                  label-class="label-required-pc"
                  :state="getValidationState(validationContext)"
                >
                  <b-form-input
                    type="password"
                    v-model="form.password_confirmation"
                    id="password_confirm"
                    :state="getValidationState(validationContext)"
                    placeholder="入力してください"
                  />
                  <b-form-invalid-feedback
                    id="input-1-live-feedback"
                  >
                    {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>
              <br />
              <br />
              <b-form-group class="d-flex justify-content-center">
                <b-button
                  type="submit"
                  class="btn btn-blue btn-submit w-272 mr-md-5"
                >
                  変更する
                </b-button>
              </b-form-group>
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
    return {
      form: {}
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
     * on submit form
     */
    async onSubmit(){
      this.$store.dispatch('setLoading', true)
      const params = {secret_key: this.$route.query.sk, email:this.$route.query.email}

      // call api check time secret key
      const resCheck = await this.$relipa.checkSecretKey(params)
      // case expired secret key
      if(!resCheck.status) {
          this.$bvToast.toast(this.$t('messages.error.forgot_password'), {
            title: this.$t('password_resets.title'),
            variant: 'danger',
            autoHideDelay: 2000,
          })
      }else{
        const paramResetPassword = {...this.form, secret_key: this.$route.query.sk}
        // call api reset password
        const res = await this.$relipa.resetPassword(paramResetPassword)
        if(res) {
          this.$bvToast.toast(this.$t('messages.confirmation.reset_password'), {
            title: this.$t('password_resets.title'),
            variant: 'success',
            autoHideDelay: 2000,
          })
          this.$store.dispatch('setLoading', false)
          setTimeout(() => {
            this.$router.push('/login')
          }, 1000)
        }else {
          this.$store.dispatch('setLoading', false)
          this.$bvToast.toast(this.$t('messages.error.reset_password'), {
            title: this.$t('password_resets.title'),
            variant: 'danger',
            autoHideDelay: 2000,
          })
        }
      }
      this.$store.dispatch('setLoading', false)
    }
  }
}
</script>

<style scoped>

</style>
