<template>
  <div class="page__wrap page-company-application bg-white">
    <div class="cp-catch d-flex justify-content-center flex-column">
      <b-container class="p-35">
        <div class="cp-catch__wrap">
          <h1>キャッチコピー</h1>
          <div class="btn btn-blue max-w-400 mt-3 mt-md-5">
            出展申請はこちら
          </div>
        </div>
      </b-container>
    </div>
    <div class="cp-feature pt-5 pb-5 mt-md-5">
      <b-container class="p-35">
        <div class="cp-feature__wrap">
          <h2 class="title-block text-center">
            特徴
          </h2>
          <div class="cp-feature__content d-flex flex-column flex-md-row pt-md-4">
            <div class="cp-feature__item mt-4">
              <div class="cp-feature__images">
                <b-img :src="require(`~/assets/images/images-feature.png`)" />
              </div>
              <div class="cp-feature__title mt-3 mt-md-4">
                ポイント03
              </div>
              <div class="cp-feature__text text-overflow-ellipsis mt-2">
                タイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトル
              </div>
            </div>
            <div class="cp-feature__item mt-4">
              <div class="cp-feature__images">
                <b-img :src="require(`~/assets/images/images-feature.png`)" />
              </div>
              <div class="cp-feature__title mt-3 mt-md-4">
                ポイント03
              </div>
              <div class="cp-feature__text text-overflow-ellipsis mt-2">
                タイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトル
              </div>
            </div>
            <div class="cp-feature__item mt-4">
              <div class="cp-feature__images">
                <b-img :src="require(`~/assets/images/images-feature.png`)" />
              </div>
              <div class="cp-feature__title mt-3 mt-md-4">
                ポイント03
              </div>
              <div class="cp-feature__text text-overflow-ellipsis mt-2">
                タイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトル
              </div>
            </div>
          </div>
        </div>
      </b-container>
    </div>
    <div class="cp-flow pt-5 pb-5">
      <b-container class="p-35">
        <div class="cp-flow__wrap">
          <h2 class="title-block text-center">
            出展の流れ
          </h2>
          <div class="cp-flow__content d-flex flex-wrap pt-md-4">
            <div class="cp-flow__item mt-4">
              <div class="cp-flow__images">
                <b-img :src="require(`~/assets/images/images-feature.png`)" />
              </div>
              <div class="cp-flow__title mt-3 mt-md-4">
                お申し込み
              </div>
            </div>
            <div class="cp-flow__item mt-4">
              <div class="cp-flow__images">
                <b-img :src="require(`~/assets/images/images-feature.png`)" />
              </div>
              <div class="cp-flow__title mt-3 mt-md-4">
                審査
              </div>
            </div>
            <div class="cp-flow__item mt-4">
              <div class="cp-flow__images">
                <b-img :src="require(`~/assets/images/images-feature.png`)" />
              </div>
              <div class="cp-flow__title mt-3 mt-md-4">
                通過
              </div>
            </div>
            <div class="cp-flow__item mt-4">
              <div class="cp-flow__images">
                <b-img :src="require(`~/assets/images/images-feature.png`)" />
              </div>
              <div class="cp-flow__title mt-3 mt-md-4">
                出展
              </div>
            </div>
          </div>
          <div class="text-center mt-5">
            <div class="btn btn-blue max-w-400 mt-3">
              出展申請はこちら
            </div>
          </div>
        </div>
      </b-container>
    </div>
    <div class="cp-faq pt-5 pb-5">
      <b-container class="p-35">
        <div class="cp-faq__wrap">
          <h2 class="title-block text-center">
            よくある質問
          </h2>
          <div class="cp-faq__content">
            <div class="cp-faq__item mt-4 mt-md-5">
              <div
                v-b-toggle.collapse-1
                class="cp-faq__question d-flex"
              >
                <span>Q</span>
                <span>テキストテキストテキスト</span>
                <b-icon-chevron-down class="icon-chevron-down" />
              </div>
              <b-collapse
                id="collapse-1"
                class="cp-faq__answer"
              >
                <div class="d-flex">
                  <span>A</span>
                  <span>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</span>
                </div>
              </b-collapse>
            </div>
            <div class="cp-faq__item mt-4 mt-md-5">
              <div
                v-b-toggle.collapse-2
                class="cp-faq__question d-flex"
              >
                <span>Q</span>
                <span>テキストテキストテキスト</span>
                <b-icon-chevron-down class="icon-chevron-down" />
              </div>
              <b-collapse
                id="collapse-2"
                class="cp-faq__answer"
              >
                <div class="d-flex">
                  <span>A</span>
                  <span>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</span>
                </div>
              </b-collapse>
            </div>
            <div class="cp-faq__item mt-4 mt-md-5">
              <div
                v-b-toggle.collapse-3
                class="cp-faq__question d-flex"
              >
                <span>Q</span>
                <span>テキストテキストテキスト</span>
                <b-icon-chevron-down class="icon-chevron-down" />
              </div>
              <b-collapse
                id="collapse-3"
                class="cp-faq__answer"
              >
                <div class="d-flex">
                  <span>A</span>
                  <span>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</span>
                </div>
              </b-collapse>
            </div>
            <div class="cp-faq__item mt-4 mt-md-5">
              <div
                v-b-toggle.collapse-4
                class="cp-faq__question d-flex"
              >
                <span>Q</span>
                <span>テキストテキストテキスト</span>
                <b-icon-chevron-down class="icon-chevron-down" />
              </div>
              <b-collapse
                id="collapse-4"
                class="cp-faq__answer"
              >
                <div class="d-flex">
                  <span>A</span>
                  <span>テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト</span>
                </div>
              </b-collapse>
            </div>
          </div>
        </div>
      </b-container>
    </div>
    <div
      class="cp-contact pt-5 pb-5 mt-md-3"
      id="cp-contact"
    >
      <b-container
        class="p-35"
      >
        <div
          class="cp-contact__wrap position-relative"
        >
          <h2 class="title-block text-center">
            {{ $t('contacts.inquiry') }}
          </h2>
          <div
            ref="contact-form"
            v-loading="loading"
            class="cp-contact__content form-default mt-3 mt-md-5"
          >
            <ValidationObserver
              ref="contactFrom"
              v-slot="{ handleSubmit }"
            >
              <b-form
                id="contact-form"
                @submit.prevent="handleSubmit(onSubmit)"
              >
                <ValidationProvider
                  :name="$t('contacts.name')"
                  rules="required|max:255"
                  v-slot="validationContext"
                >
                  <b-form-group
                    :label="$t('contacts.name')"
                    label-for="name"
                    label-class="label-required-pc"
                  >
                    <b-form-input
                      v-model="contact.name"
                      :state="getValidationState(validationContext)"
                      id="name"
                      :placeholder="$t('common.please_enter')"
                    />
                    <b-form-invalid-feedback id="input-1-live-feedback">
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </ValidationProvider>

                <br />

                <ValidationProvider
                  :name="$t('contacts.contact_type')"
                  rules="required"
                  v-slot="validationContext"
                >
                  <b-form-group
                    :label="$t('contacts.contact_type')"
                    label-for="contact_type"
                    label-class="label-required-pc"
                  >
                    <b-form-radio-group
                      id="contact_type"
                      v-model="contact.contact_type"
                      :options="options_contact_type"
                      :state="getValidationState(validationContext)"
                      name="radio-options"
                    />
                  </b-form-group>
                </ValidationProvider>
                <br />

                <ValidationProvider
                  v-if="contact.contact_type == CONTACT_TYPE_EMAIL"
                  :name="$t('contacts.email')"
                  rules="required|max:255|regexEmail"
                  v-slot="validationContext"
                >
                  <b-form-group
                    :label="$t('contacts.email')"
                    label-for="email"
                    label-class="label-required-pc"
                  >
                    <b-form-input
                      v-model="contact.email"
                      id="email"
                      :state="getValidationState(validationContext)"
                      :placeholder="$t('common.please_enter')"
                    />
                    <b-form-invalid-feedback id="input-1-live-feedback">
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </ValidationProvider>
                <ValidationProvider
                  v-if="contact.contact_type == CONTACT_TYPE_PHONE"
                  :name="$t('contacts.phone')"
                  rules="required|phone|minmax:8,32"
                  v-slot="validationContext"
                >
                  <b-form-group
                    :label="$t('contacts.phone')"
                    label-for="phone"
                    label-class="label-required-pc"
                  >
                    <b-form-input
                      v-model="contact.phone"
                      id="phone"
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
                  :name="$t('contacts.inquiry_type')"
                  rules="required"
                  ref="provider_inquiry_type"
                  v-slot="validationContext"
                >
                  <b-form-group
                    :label="$t('contacts.inquiry_type')"
                    label-for="inquiry_type"
                    label-class="label-required-pc"
                  >
                    <b-form-select
                      v-model="contact.inquiry_type"
                      id="inquiry_type"
                      :state="getValidationState(validationContext)"
                      :options="options_inquiry_type"
                    />
                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </ValidationProvider>
                <br />
                <ValidationProvider
                  :name="$t('contacts.content')"
                  rules="required|max:1000"
                  v-slot="validationContext"
                >
                  <b-form-group
                    :label="$t('contacts.content')"
                    label-for="content"
                    label-class="label-required-pc"
                  >
                    <b-form-textarea
                      id="content"
                      v-model="contact.content"
                      :placeholder="$t('common.please_enter')"
                      :state="getValidationState(validationContext)"
                      rows="4"
                      max-rows="7"
                    />
                    <b-form-invalid-feedback id="input-1-live-feedback">
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </ValidationProvider>
                <br />
                <ValidationProvider
                  name="  "
                  ref="provider_accept"
                  rules="required"
                  v-slot="validationContext"
                >
                  <b-form-group
                    label=" "
                    label-for="accept"
                    class="d-flex justify-content-center pt-3 checkbox-policy"
                  >
                    <b-form-checkbox
                      id="accept"
                      v-model="contact.accept"
                      class="m-0 w-auto"
                      name="accept"
                      :state="getValidationState(validationContext, 'accept', contact.accept)"
                    >
                      <span class="font-weight-normal text-normal">
                        <b-link
                          :href="`/pages/${slug}`"
                          target="_blank"
                          title=""
                          class="text-decoration"
                        >{{ $t('contacts.privacy_policy') }}</b-link>{{ $t('contacts.agree') }}</span>
                    </b-form-checkbox>
                    <b-form-invalid-feedback :state="getValidationState(validationContext, 'accept', contact.accept)">
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </ValidationProvider>
                <b-form-group
                  label=" "
                  label-for="checkbox-1"
                  class="d-flex justify-content-center pt-3"
                >
                  <b-button
                    type="submit"
                    class="btn btn-blue w-272 "
                  >
                    {{ $t('contacts.register') }}
                  </b-button>
                </b-form-group>
              </b-form>
            </ValidationObserver>
          </div>
        </div>
      </b-container>
    </div>
    <div class="cp-request-document bg-grey pt-5 pb-5 pb-md-3">
      <b-container class="p-35">
        <div class="cp-request-document__wrap d-flex flex-column flex-md-row align-items-center justify-content-between">
          <h2 class="title-block text-center mb-0">
            {{ $t('contacts.more_info') }}
          </h2>
          <div
            @click="scrollTo()"
            class="btn btn-blue max-w-400 mt-3 mt-md-0"
          >
            {{ $t('contacts.request_material') }}
          </div>
        </div>
      </b-container>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'

const CONTACT_TYPE_EMAIL = 2
const CONTACT_TYPE_PHONE = 1

export default {
  data() {
    return {
      CONTACT_TYPE_EMAIL,
      CONTACT_TYPE_PHONE,
      slug: '',
      registered_copy_attachment: null,
      contact: {
        accept: false,
        name: '',
        contact_type: 2,
        email: '',
        phone: '',
        inquiry_type: null,
        content: ''
      },
      options_contact_type: [
        {value: 1, text: '電話で折り返してほしい'},
        {value: 2, text: 'メールで折り返してほしい'}
      ],
      selected_inquiry_type: '',
      options_inquiry_type: [
        {value: null, text: '選択して下さい'},
        {value: 1, text: '出展について'},
        {value: 2, text: '資料請求'},
        {value: 3, text: 'ガチャポについて'},
        {value: 4, text: 'その他について'}
      ]
    }
  },

  computed: {
    ...mapState({
      loading: 'loading'
    }),
  },

  async mounted() {
    this.checkValidateSelect()
    const res = await this.$relipa.getPageWithType({id: 1})
    if(res && res.data) {
      this.slug = res.data.slug
    }
  },

  methods: {
    scrollTo() {
      document.getElementById('cp-contact').scrollIntoView({
        behavior: "smooth"
      });
    },

    /**
     * Check validate for select
     */
    checkValidateSelect() {
      const self = this
      document.querySelector('#inquiry_type').addEventListener("focusout", function () {
        self.$refs.provider_inquiry_type.validate()
      });
    },

    /**
     * Get validation state of form.
     */
    getValidationState(context, field = null, value = null) {
      const { dirty, validated, valid = null } = context
      this.accept = value
      if((dirty || validated) && field && !value) {
        return value;
      }

      return validated ? valid : null;
    },

    /**
     * Call api register contact.
     */
    onSubmit() {
      this.$refs.provider_accept.validate()
      if(this.contact.accept) {
        this.$store.dispatch('setLoading', true)
        this.$relipa.registerContact(this.contact).then(res => {
          if(res) {
            this.$bvToast.toast('お問い合わせを受け付けました。\nなお、お返事までしばらくお時間をいただく場合がございます。', {
              title: 'お問い合わせ',
              variant: 'success',
              autoHideDelay: 2000,
            })
            this.contact = {}
            this.$refs.contactFrom.reset()
            this.$store.dispatch('setLoading', false)
          }
        }).catch(err => {
          this.$store.dispatch('setLoading', false)
          this.$bvToast.toast(this.$('messages.error.failed_to_register_contact'), {
              title: this.$t('companies.title_head'),
              variant: 'danger',
              autoHideDelay: 2000,
            })
        })
      }
    }
  }
}
</script>

<style lang="scss" scoped>
@media (min-width: 1024px) {
  #contact-form {
    min-width: 800px;
  }
}
.text-dark {
  color: #707F89 !important;
}
 .checkbox-policy {
  /deep/ {
    .custom-checkbox {
      .custom-control-label::after, .custom-control-label::before {
        top: 2px;
      }
    }
  }
 }
</style>
