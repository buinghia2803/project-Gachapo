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
          </div>
        </div>
        <div class="gd-info-gacha pt-0 d-flex flex-row">
          <div class="gd-info-gacha__right full p-0 d-flex flex-wrap flex-column flex-md-row align-items-center">
            <b-button
              v-b-modal.modal-success
              class="btn btn-red max-w-272"
            >
              受け取る
            </b-button>
            <b-button class="btn btn-blue-2 max-w-272 mt-3 ml-md-3 mt-md-0">
              もう一度ガチャする
            </b-button>
            <b-button
              v-b-modal.modal-edit-address
              class="btn btn-green max-w-272 mt-3"
            >
              別の住所に送る
            </b-button>
          </div>
        </div>
      </div>
    </b-container>
    <b-modal
      id="modal-success"
      hide-footer
    >
      <h2 class="title-block title-block-line-pc text-center text-md-left">
        ガチャありがとうございました！
      </h2>
      <div class="modal-text">
        <p class="text-center text-md-left pt-3 pt-md-0">
          商品の発送準備に入ります。<br />
          今しばらくお待ちください。
        </p>
      </div>
    </b-modal>
    <b-modal
      id="modal-edit-address"
      hide-footer
    >
      <h2 class="title-block title-block-line-pc text-center text-md-left">
        クレジットカード
      </h2>
      <div class="edit-card__content pt-3 pt-md-0">
        <div class="form-default form-gachas">
          <b-form>
            <b-form-group
              label=""
              class="box-address"
            >
              <b-form-group
                label="住所1"
                label-for="address_first"
                label-class="label-required-pc"
              >
                <b-form-input
                  id="address_first"
                  placeholder="入力してください"
                />
              </b-form-group>
              <b-form-group
                label="住所2"
                label-for="address_second"
                label-class="label-required-pc"
              >
                <b-form-input
                  id="address_second"
                  placeholder="入力してください"
                />
              </b-form-group>
              <b-form-group
                label="メイン"
                label-for="address_type"
                label-class="label-required-pc"
              >
                <b-form-select
                  v-model="selected_address"
                  :options="options_address"
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
  export default {
    components: {},
    data() {
      return {
        value: 4,
        selected_address: 1,
        options_address: [
          { value: '1', text: '住所1に届ける ' },
          { value: '2', text: '住所2に届ける ' }
        ]
      }
    }
  }
</script>

<style scoped>

</style>
