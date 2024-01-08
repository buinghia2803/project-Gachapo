<template>
  <div class="page__wrap page-register-user bg-pc-white pt-5 pb-4">
    <b-container class="p-35">
      <div class="page__content">
        <h2 class="title-block title-block-line-pc text-center text-md-left">
          {{ $t('companies.title_head') }}
        </h2>
        <div
          v-loading="loading"
          class="form-default form-register-company"
        >
          <ValidationObserver
            ref="company_observer"
            class="form-default-observer"
            v-slot="{ handleSubmit }"
          >
            <b-form
              class="company-form"
              @submit.prevent="handleSubmit(onSubmit)"
            >
              <ValidationProvider
                :name="$t('companies.company')"
                rules="required|max:100"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('companies.company')"
                  label-for="company"
                  label-class="label-required-pc"
                >
                  <b-form-input
                    v-model="form.company"
                    id="company"
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
                :name="$t('companies.company_furigana')"
                v-slot="validationContext"
                rules="required|max:100"
              >
                <b-form-group
                  :label="$t('companies.company_furigana')"
                  label-for="company_furigana"
                  label-class="label-required-pc"
                >
                  <b-form-input
                    v-model="form.company_furigana"
                    id="company_furigana"
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
                :name="$t('companies.person_manager')"
                rules="required|max:100"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('companies.person_manager')"
                  label-for="person_manager"
                  label-class="label-required-pc"
                >
                  <b-form-input
                    v-model="form.person_manager"
                    id="person_manager"
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
                :name="$t('companies.person_manager_furigana')"
                rules="required|max:100"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('companies.person_manager_furigana')"
                  label-for="person_manager_furigana"
                  label-class="label-required-pc"
                >
                  <b-form-input
                    v-model="form.person_manager_furigana"
                    id="person_manager_furigana"
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
                :name="$t('companies.phone')"
                rules="required|phone|minmax:8,32"
                ref="provider_phone"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('companies.phone')"
                  label-for="phone"
                  label-class="label-required-pc"
                >
                  <b-form-input
                    v-model="form.phone"
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
                :name="$t('companies.email')"
                ref="provider_email"
                rules="required|max:255|regexEmail"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('companies.email')"
                  label-for="email"
                  label-class="label-required-pc"
                >
                  <b-form-input
                    v-model="form.email"
                    id="email"
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
                :name="$t('companies.password')"
                rules="required|password"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('companies.password')"
                  label-for="password"
                  label-class="label-required-pc"
                >
                  <b-form-input
                    v-model="form.password"
                    id="password"
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
                :name="$t('companies.password_confirm')"
                :rules="'required|confirm-password:' + form.password"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('companies.password_confirm')"
                  label-for="password_confirm"
                  label-class="label-required-pc"
                >
                  <b-form-input
                    v-model="form.password_confirm"
                    id="password_confirm"
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
                :name="$t('companies.company_information')"
                rules="required|max:1000"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('companies.company_information')"
                  label-for="company_information"
                  label-class="label-required-pc"
                >
                  <b-form-textarea
                    v-model="form.company_information"
                    id="company_information"
                    :state="getValidationState(validationContext)"
                    :placeholder="$t('common.please_enter')"
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
                :name="$t('companies.site_url')"
                rules="required|max:255"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('companies.site_url')"
                  label-for="site_url"
                  label-class="label-required-pc"
                >
                  <b-form-input
                    v-model="form.site_url"
                    id="site_url"
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
                :name="$t('companies.company_address')"
                rules="required|max:255"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('companies.company_address')"
                  label-for="company_address"
                  label-class="label-required-pc"
                >
                  <b-form-input
                    v-model="form.company_address"
                    id="company_address"
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
                name=" "
                rules="required"
                ref="provider_registered_copy_attachment"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('companies.registered_copy_attachment')"
                  label-for="registered_copy_attachment"
                  label-class="label-required-pc white-space-pre-line"
                  class="align-items-start"
                >
                  <div class="box-input-file position-relative w-180">
                    <b-form-file
                      v-model="form.registered_copy_attachment"
                      id="registered_copy_attachment"
                      class="btn btn-blue m-0"
                      accept=".pdf"
                      size="20MB"
                      :state="getValidationState(validationContext, 'registered_copy_attachment')"
                      plain
                      @change="validateFile"
                    />
                    <p class="btn btn-blue w-180 box-input-file__label">
                      {{ $t('companies.upload') }}
                    </p>
                    <b-form-invalid-feedback id="input-1-live-feedback">
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </div>
                  <b-form-invalid-feedback
                    :state="false"
                    id="input-1-live-feedback"
                    v-if="errorMaxFile"
                  >
                    {{ $t('companies.max_20MB') }}
                  </b-form-invalid-feedback>
                  <b-form-invalid-feedback
                    :state="false"
                    id="input-1-live-feedback"
                    v-else-if="errorMessage"
                  >
                    イメージ画像はPDF形式でアップロードしてください。
                  </b-form-invalid-feedback>
                  <div class="m-0 box-input-file__text">
                    {{ form.registered_copy_attachment ? form.registered_copy_attachment.name : '' }}
                  </div>
                </b-form-group>
              </ValidationProvider>
              <br />
              <ValidationProvider
                :name="$t('companies.consent_document')"
                rules="required"
                v-slot="validationContext"
              >
                <b-form-group
                  :label="$t('companies.consent_document')"
                  label-for="consent_document"
                  label-class="label-required-pc"
                >
                  <b-form-textarea
                    v-model="form.consent_document"
                    id="consent_document"
                    :state="getValidationState(validationContext)"
                    :placeholder="$t('common.please_enter')"
                    rows="7"
                    disabled
                    max-rows="10"
                  />
                  <b-form-invalid-feedback id="input-1-live-feedback">
                    {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>
              <br />
              <ValidationProvider
                rules="required"
                v-slot="validationContext"
              >
                <b-form-group
                  label=" "
                  label-for="accept"
                  class="d-flex justify-content-center pr-md-2"
                >
                  <b-form-checkbox
                    id="accept-1"
                    v-model="accept"
                    :state="getValidationState(validationContext, 'accept', accept)"
                    name="checkbox-1"
                    class="m-0 w-auto mr-md-5"
                  >
                    {{ $t('companies.agree') }}
                  </b-form-checkbox>
                  <b-form-invalid-feedback :state="getValidationState(validationContext, 'accept', accept)">
                    {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </ValidationProvider>
              <b-form-group
                label=" "
                label-for="submit"
                class="d-flex justify-content-center"
              >
                <b-button
                  type="submit"
                  class="btn btn-blue w-272 mr-md-5"
                >
                  {{ $t('common.register') }}
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
const TODOTEXT =  `One of the main reasons I continue to use TurboTax to do my taxes is because the program keeps track of all the information from previous years, which can be downloaded and stored as both .tax and .pdf files. The program is (obviously) kept up to date on all tax laws and rules. In many instances, you can electronically transfer your W-2 information (if supported by your employer). A nice feature that was new to me this year was that you can upload a PDF of a 1099 or W2 form and the program will automatically input the information – much better than having to manually type everything in (as it’s been in years past).

                The online-based software allows access to help files, as well as 24/7 support from specialists and other customers. Before filing, the program runs a review to make sure you’ve completed all the forms you need to. TurboTax offers a “guarantee” that all calculations will be correct and includes audit support if needed.

                There’s also an “audit defense” option available for an additional $60 which comes with identity theft monitoring and restoration. Whether or not you actually need this kind of coverage is debatable. While it certainly provides peace of mind, if you actually did have to go to court over an audit, it doesn’t include legal representation.

                In all my years of filing with TurboTax, I’ve received two “audit” type questions in the form of letters asking for more information and/or clarification. Both were from the state of New York and had to do with real estate in New York City (I own a coop apartment) and were easily resolved by me simply submitting the information requested. In keeping with this, I will say that the one time I did call one of TurboTax’s CPA specialists it was in reference to real estate taxes in the city and they weren’t able to help me. To be fair, NYC real estate pretty much functions in its own wild west as opposed to the rest of the country but Intuit should really ensure they have experts who understand it.

                TurboTax is free if you’re able to file a simple tax form without itemizing deductions.

                The $59 deluxe version allows for itemizing, the $89 premier version adds coverage of rental property income and investments and the $119 self-employed edition (which is what I use) offers guidance for freelancers and business owners. Each of these is often available slightly cheaper on Amazon as a download – or even an old-fashioned disc. Ahead of tax season, all of this software is currently on sale at Amazon.`

export default {
  data() {
    return {
      accept: '',
      errorMessage: false,
      errorMaxFile: false,
      form: {
        company: '',
        company_furigana: '',
        person_manager: '',
        person_manager_furigana: '',
        phone: '',
        email: '',
        password: '',
        password_confirm: '',
        company_information: '',
        site_url: '',
        company_address: '',
        registered_copy_attachment: [],
        consent_document: TODOTEXT,
      },
    }
  },

  computed: {
    ...mapState({
      loading: 'loading'
    }),
  },

  methods: {
    /**
     * check validate file upload
     */
    validateFile(e){
      const file = e.target.files[0]
      if(file && file.size/(1024*1024) > 20) {
        this.errorMaxFile = true
      }else {
        this.errorMaxFile = false
      }
      if(!e.target.value.includes('.pdf')){
        this.errorMessage = true
      }else{
        this.errorMessage = false
      }
    },

    /**
     * Get validation state of form.
     */
    getValidationState({ dirty, validated, valid = null }, field = null, value = null) {
      if( dirty&& field === 'accept') {
        return value;
      }

      return dirty || validated ? valid : null;
    },

    /**
     * Call api register company
     */
    onSubmit() {
        this.$store.dispatch('setLoading', true)
        if(!this.errorMessage && !this.errorMaxFile && this.accept) {
          this.$relipa.registerCompany(this.form).then(res => {
          this.$bvToast.toast(this.$t('companies.register_completed'), {
              title: this.$t('companies.title_head'),
              variant: 'success',
              autoHideDelay: 4000,
          })
          this.accept = null
          this.form = {}
          this.form.consent_document = TODOTEXT
          this.$refs.company_observer.reset()
          this.$store.dispatch('setLoading', false)
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
        }
    }
  }
}
</script>
<style lang="scss" scoped>
.form-default-observer {
  display: flex;
  justify-content: center;
  @media (min-width: 1024px) {
    .company-form {
      min-width: 800px
    }
  }
}
@media (max-width: 768px) {
  .company-form {
    width: 100%;
  }
}

#form_group_company_information
{
  div {
    display: flex;
    flex-direction: column;
  }
}
</style>
