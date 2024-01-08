<template>
  <div class="page__wrap page-gacha-result pt-5 pb-5">
    <b-container class="p-35">
      <div class="page__content bg-white">
        <div class="gd-info-gacha d-flex flex-row">
          <div class="gd-info-gacha__left">
            <b-carousel
              id="main-gacha"
            >
              <b-carousel-slide
                :img-src="require(`~/assets/images/main-visual.png`)"
              />
              <b-carousel-slide
                :img-src="require(`~/assets/images/main-visual.png`)"
              />
              <b-carousel-slide
                :img-src="require(`~/assets/images/main-visual.png`)"
              />
            </b-carousel>
          </div>
          <div class="gd-info-gacha__right">
            <div class="gd-info-gacha__title mt-3 mt-md-0">
              <h1 class="m-0">
                商品名
              </h1>
            </div>
            <div class="gd-info-gacha__description mt-3">
              テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト
              テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト
              テキストテキストテキストテキストテキストテキスト
            </div>
            <div class="gd-info-gacha__rating box-rating mt-3">
              <b-form-rating
                v-model="value"
                readonly
                class="box-rating__icon"
              />
              <span class="box-rating__number">(28)</span>
            </div>
            <div class="gd-info-gacha__stock mt-3">
              残/6個
            </div>
          </div>
        </div>
        <div class="gd-info-gacha pt-0 d-flex flex-row">
          <div class="gd-info-gacha__right full">
            <div class="gd-info-gacha__price mt-0 d-flex align-items-end">
              <span>¥1,000/回</span>
              <b-form-input
                type="number"
                placeholder="01"
                class="ml-2 mr-2"
              />
              <span>回</span>
              <b-icon-heart-fill class="gd-info-gacha__like ml-3 ml-md-5 active" />
            </div>
            <div class="gd-info-gacha__buy mt-4 d-flex flex-wrap">
              <b-button
                v-b-modal.modal-buy-gacha
                class="btn btn-red max-w-300 btn-medium"
              >
                ガチャする
              </b-button>
              <div class="gd-info-gacha__message-login hidden-sp">
                ―――　ログイン or 決済画面へ
              </div>
            </div>
            <br />
            <b-button
              v-b-modal.modal-login
              class="btn btn-red max-w-300 btn-medium"
            >
              ログイン
            </b-button>
            <br />
            <br />
            <b-button
              v-b-modal.modal-payment-error
              class="btn btn-red max-w-300 btn-medium"
            >
              決済エラー
            </b-button>
            <br />
            <br />
            <b-button
              v-b-modal.modal-edit-card
              class="btn btn-red max-w-300 btn-medium"
            >
              ユーザー変更画面へ
            </b-button>
          </div>
        </div>
        <div class="gd-info-product mt-4">
          <h2 class="title-block text-center mb-0">
            ガチャ内容
          </h2>
          <div class="gacha__list">
            <ItemGacha
              :is-show-reward="true"
              :class-name="`full`"
            />
            <ItemGacha
              :is-show-reward="true"
              :class-name="`full`"
            />
            <ItemGacha
              :is-show-reward="true"
              :class-name="`full`"
            />
            <ItemGacha
              :is-show-reward="true"
              :class-name="`full`"
            />
          </div>
        </div>
      </div>
    </b-container>
    <b-modal
      id="modal-login"
      hide-footer
    >
      <login :title="`ログイン`" />
    </b-modal>
    <b-modal
      id="modal-buy-gacha"
      hide-footer
    >
      <b-form
        @submit.prevent="onSubmit"
        @reset="onReset"
      >
        <div class="gd-info-gacha pt-3 pl-0 pr-0 d-flex flex-row">
          <div class="gd-info-gacha__left">
            <b-carousel
              id="main-gacha"
            >
              <b-carousel-slide
                :img-src="require(`~/assets/images/main-visual.png`)"
              />
              <b-carousel-slide
                :img-src="require(`~/assets/images/main-visual.png`)"
              />
              <b-carousel-slide
                :img-src="require(`~/assets/images/main-visual.png`)"
              />
            </b-carousel>
          </div>
          <div class="gd-info-gacha__right">
            <div class="gd-info-gacha__title mt-0 mt-md-0">
              <h1 class="m-0">
                商品名
              </h1>
            </div>
            <div class="gd-info-gacha__description mt-3 text-overflow-ellipsis row-4">
              テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト
              テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト
              テキストテキストテキストテキストテキストテキスト
            </div>
            <div class="gd-info-gacha__stock mt-3">
              残/6個
            </div>
          </div>
        </div>
        <div class="gd-info-gacha full pl-0 pr-0 pt-0 d-flex flex-column flex-md-row">
          <div class="gd-info-gacha__right">
            <div class="gd-info-gacha__price mt-0 d-flex align-items-end">
              <span>¥1,000/回</span>
              <b-form-input
                type="number"
                placeholder="01"
                class="ml-2 mr-2"
              />
              <span>回</span>
            </div>
            <div class="gd-info-gacha__coupon mt-3">
              <b-form-group
                label="クーポンコード"
                label-for="coupon"
                class="mt-0 d-flex align-items-center"
              >
                <b-form-input
                  id="coupon"
                  type="text"
                  placeholder="入力してください"
                />
              </b-form-group>
            </div>
            <div class="gd-info-gacha__total mt-4 d-flex justify-content-between align-items-center">
              <div>小計</div>
              <div>¥1,000</div>
            </div>
            <div class="gd-info-gacha__buy mt-5 text-center">
              <b-button class="btn btn-blue max-w-300">
                決済する
              </b-button>
            </div>
          </div>
        </div>
      </b-form>
    </b-modal>
    <b-modal
      id="modal-payment-error"
      hide-footer
    >
      <h2 class="title-block title-block-line-pc text-center text-md-left">
        決済エラー
      </h2>
      <div class="payment-error__content pt-3 pt-md-0">
        <h3>テキストテキスト</h3>
        <p>
          テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト
          テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト
          テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト
          テキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト
        </p>
      </div>
      <div class="payment-error__action d-flex flex-column flex-md-row align-items-center justify-content-center">
        <div class="btn btn-blue mt-3 max-w-272">
          ガチャに戻る
        </div>
        <div class="btn btn-blue mt-4 max-w-272 ml-md-4">
          ユーザー変更画面へ
        </div>
      </div>
    </b-modal>
    <b-modal
      id="modal-edit-card"
      hide-footer
    >
      <h2 class="title-block title-block-line-pc text-center text-md-left">
        クレジットカード
      </h2>
      <div class="edit-card__content pt-3 pt-md-0">
        <div class="form-default form-gacha-detail">
          <b-form>
            <b-form-group
              label=""
              class="box-credit-card"
              label-class="title-block-line-pc"
            >
              <b-form-group label="ご利用可能なカード一覧">
                <b-img :src="require(`~/assets/images/list-payment.png`)" />
              </b-form-group>
              <br class="hidden-sp" />
              <b-form-group
                label="カード番号"
                label-for="card_number"
                label-class="label-required-pc"
              >
                <b-form-input
                  id="card_number"
                  placeholder="入力してください"
                />
              </b-form-group>
              <br class="hidden-sp" />
              <b-form-group
                label="セキュリティーコード"
                label-for="security_code"
                label-class="label-required-pc"
              >
                <b-form-input
                  id="security_code"
                  placeholder="入力してください"
                />
              </b-form-group>
              <br class="hidden-sp" />
              <b-form-group
                label="カード名義"
                label-for="card_name"
                label-class="label-required-pc"
              >
                <b-form-input
                  id="card_name"
                  placeholder="入力してください"
                />
              </b-form-group>
              <br class="hidden-sp" />
              <b-form-group
                label="有効期限"
                label-for="date_of_expiry"
                label-class="label-required-pc"
              >
                <b-form-select
                  class="date_of_expiry_month mr-4"
                  v-model="selected_month"
                  :options="options_month"
                />
                <b-form-select
                  class="date_of_expiry_year"
                  v-model="selected_year"
                  :options="options_year"
                />
              </b-form-group>
            </b-form-group>
            <br />
            <b-form-group class="d-flex justify-content-center">
              <b-button
                type="submit"
                class="btn btn-blue btn-submit w-272"
              >
                変更
              </b-button>
            </b-form-group>
          </b-form>
        </div>
      </div>
    </b-modal>
  </div>
</template>

<script>
  import ItemGacha from '~/components/organisms/ItemGacha'
  const Login = () => import('~/components/organisms/Login')
  export default {
    components: {
      ItemGacha,
      Login
    },
    data() {
      return {
        value: 4,
        selected_month: null,
        options_month: [
          { value: '1', text: '1' },
          { value: '2', text: '2' },
          { value: '3', text: '3' },
          { value: '4', text: '4' },
          { value: '5', text: '5' },
          { value: '6', text: '6' },
          { value: '7', text: '7' },
          { value: '8', text: '8' },
          { value: '9', text: '9' },
          { value: '10', text: '10' },
          { value: '11', text: '11' },
          { value: '12', text: '12' }
        ],
        selected_year: null,
        options_year: [
          { value: '2022', text: '2022' },
          { value: '2023', text: '2023' },
          { value: '2024', text: '2024' },
          { value: '2025', text: '2025' }
        ]
      }
    }
  }
</script>

<style scoped>

</style>
