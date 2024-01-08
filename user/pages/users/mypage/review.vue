<template>
  <div class="page__wrap mypage mypage-review bg-white pb-5">
    <b-container class="p-0">
      <div class="page__content">
        <Sidebar
          :title="`購入履歴`"
          :class-active="`list-order`"
        />
        <div class="mypage__right p-35 mt-4">
          <div class="mypage__content">
            <div class="mypage__breadcrumb hidden-sp">
              購入履歴
            </div>
            <div class="mypage__history mt-4">
              <h1 class="mypage__sub-title title-block-line">
                レビューを書く
              </h1>
              <div class="data__list order__list pt-0 pt-md-2 title-block-line">
                <div class="data__item data__title">
                  <div class="dt-th-images">
                    商品画像
                  </div>
                  <div class="dt-th-name">
                    商品名
                  </div>
                </div>
                <MyPageItemGacha
                  :type="`review`"
                  :item="orderReview.gacha"
                />
              </div>
              <div class="form-default form-review">
                <ValidationObserver
                  ref="observer"
                  v-slot="{ handleSubmit }"
                >
                  <b-form @submit.prevent="handleSubmit(submit)">
                    <b-form-group
                      label="総合評価"
                      label-for="rating"
                      class="title-block-line pt-3 mb-1"
                    >
                      <div class="box-rating_review">
                        <b-form-rating
                          variant="warning"
                          id="rating-10"
                          v-model="form.rating"
                        />
                      </div>
                      <p
                        class="text-danger rating"
                        v-if="errorRating"
                      >
                        {{ $t('messages.error.required') }}
                      </p>
                    </b-form-group>
                    <br />
                    <ValidationProvider
                      :name="$t('gacha.content')"
                      rules="required|max:200"
                      v-slot="validationContext"
                    >
                      <b-form-group
                        label="レビュー追加"
                        label-for="content"
                      >
                        <b-form-textarea
                          id="content"
                          placeholder="入力してください"
                          rows="5"
                          max-rows="7"
                          v-model="form.content"
                          :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback id="input-1-live-feedback">
                          {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                      </b-form-group>
                    </ValidationProvider>
                    <br />
                    <b-form-group class="d-flex justify-content-center justify-content-md-end align-items-md-end">
                      <b-button
                        type="submit"
                        class="btn btn-blue btn-submit m-0"
                        :disabled="isReviewGacha"
                      >
                        投稿
                      </b-button>
                    </b-form-group>
                  </b-form>
                </ValidationObserver>
              </div>
            </div>
          </div>
        </div>
      </div>
    </b-container>
  </div>
</template>

<script>
import Sidebar from '~/components/organisms/mypage/sidebar'
import MyPageItemGacha from '~/components/organisms/mypage/ItemGacha'
export default {
  layout: 'blank',

  name: "Review",

  components: {
    Sidebar,
    MyPageItemGacha
  },

  data() {
    return {
      orderReview: {},
      form: {
        rating: 5,
        content: ''
      },
      isReviewGacha: false,
      errorRating: false,
    }
  },

  async mounted() {
    await this.getReviewByUserId()
    const id = +this.$route.query.order_id || 0
    if(id){
      this.getDetailOrder(id)
    }
  },

  methods: {
    /**
     * Get validation state of form.
     */
    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },

    getDetailOrder(id){
      this.$relipa.getDetailOrder({id}).then(({data}) => {
        this.orderReview = data
      })
    },

    /**
     * review gacha
     */
    submit() {
      if(!this.form.rating){
        this.errorRating = true
      }

      this.form.order_id = +this.$route.query.order_id
      this.form.user_id = this.$auth.user.id

      // call api create review
      this.$relipa.reviewOrder(this.form).then(res => {
        if(res) {
          this.isReviewGacha = true
          this.$bvToast.toast(this.$t('messages.information.review_gacha'), {
            title: this.$t('review_gacha.title'),
            variant: 'success',
            autoHideDelay: 2000,
          })
        }
      }).catch(() => {
        this.$bvToast.toast(this.$t('messages.error.review_gacha'), {
            title: this.$t('review_gacha.title'),
            variant: 'success',
            autoHideDelay: 2000,
          })
      })
    },

    /**
     * get review  by user id
     */
    getReviewByUserId() {
      const params = {user_id: this.$auth.user.id}
      this.$relipa.getReviewByUserId(params).then(({data}) => {
        if(data){
          this.form = data
          this.isReviewGacha = true
        }
      })
    }
  },
}
</script>

<style scoped lang="scss">
/deep/{
  .box-rating_review{
    width: 20%;
    .form-control{
    border: none;
    }
  }

  .rating{
    font-size: 1.3em;
  }
}
</style>
