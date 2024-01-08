<template>
  <div
    class="page__wrap page-forgot-password pt-5 pb-5"
    v-loading="loading"
  >
    <b-container class="p-35">
      <div class="page__content">
        <h2 class="d-flex justify-content-center mb-5">
          Online Gacha
        </h2>
        <h2 class="title-block title-block-line-pc text-center text-md-left">
          パスワード再発行
        </h2>
        <div class="form-default form-forgot-password mt-5">
          <ValidationObserver
            ref="contactFrom"
            v-slot="{ handleSubmit }"
          >
            <b-form @submit.prevent="handleSubmit(onSubmit)">
              <ValidationProvider
                :name="$t('password_resets.email')"
                rules="required|max:255|regexEmail"
                v-slot="validationContext"
              >
                <b-form-group
                  label="登録メールアドレス"
                  label-for="email"
                  label-class="label-required-pc"
                  :state="getValidationState(validationContext)"
                >
                  <b-form-input
                    v-model="email"
                    :state="getValidationState(validationContext)"
                    id="email"
                    placeholder="入力してください"
                  />
                  <b-form-invalid-feedback
                    id="input-1-live-feedback"
                    v-if="existEmail"
                  >
                    {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
                  <b-form-invalid-feedback
                    :state="existEmail"
                    v-if="!existEmail"
                  >
                    メールが無効です。もう一度お試しください。
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>
              <br />
              <b-form-group class="d-flex justify-content-center">
                <b-button
                  type="submit"
                  class="btn btn-blue btn-submit w-272 mr-md-5"
                >
                  送信
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
import {mapState} from 'vuex'
  export default {
    data() {
      return {
        email: '',
        existEmail: true,
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
      onSubmit() {
        this.$store.dispatch('setLoading', true)
        const params = {email: this.email}
        // call api forgot password
        this.$relipa.forgotPasssword(params).then(({data}) => {
          // case email do not exists
          if(data.status === 0){
            this.existEmail = false
          }else{
            // send mail success
             this.$bvToast.toast(this.$t('messages.confirmation.forgot_password.send_mail'), {
              title: this.$t('password_resets.forgot_password_title'),
              variant: 'success',
              autoHideDelay: 2000,
            })
          }
        }).catch(err => {
          // send mail error
           this.$bvToast.toast(this.$t('messages.error.send_email'), {
              title: this.$t('password_resets.forgot_password_title'),
              variant: 'danger',
              autoHideDelay: 2000,
            })
        }).finally(() => {
          this.$store.dispatch('setLoading', false)
        })
      },
    }
  }
</script>

<style scoped>

</style>
