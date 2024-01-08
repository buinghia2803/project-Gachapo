<template>
  <div class="page__wrap mypage mypage-profile bg-white pb-4">
    <b-container class="p-0">
      <div class="page__content">
        <Sidebar :title="`登録内容変更`" :classActive="`profile`"/>
        <div class="mypage__right p-35 mt-4">
          <div class="mypage__content">
            <div class="mypage__breadcrumb hidden-sp">登録内容変更</div>
            <div class="mypage__profile mt-4">
              <h1 class="mypage__sub-title title-block-line">登録内容変更</h1>
              <div class="m-profile__content pt-md-3">
                <div class="form-default">
                  <b-form>
                    <div class="m-profile__info-card form-group pt-2 d-flex flex-column">
                      <legend class="m-profile__info-card-title d-flex justify-content-md-between full mb-0">
                        <span>登録中のクレジットカード</span>
                        <span class="hidden-sp">有効期限</span>
                      </legend>
                      <div class="m-profile__info-card-content d-flex align-items-start mt-3 full">
                        <b-img :src="require(`~/assets/images/payment-visa.png`)" alt="" />
                        <div class="d-md-flex full"><span>Visa</span><span>末尾</span><span>000</span><br class="hidden-pc"/><span class="hidden-pc">有効期限</span><span class="ml-md-auto">06/2025</span></div>
                      </div>
                    </div>
                    <br/>
                    <b-form-group label="クレジットカード情報登録" class="box-credit-card">
                      <b-form-group label="ご利用可能なカード一覧" label-class="normal">
                        <b-img :src="require(`~/assets/images/list-payment.png`)" alt="" />
                      </b-form-group>
                      <br class="hidden-sp"/>
                      <b-form-group label="カード番号" label-for="card_number" label-class="label-required-pc">
                        <b-form-input id="card_number" placeholder="入力してください" />
                      </b-form-group>
                      <br class="hidden-sp"/>
                      <b-form-group label="セキュリティーコード" label-for="security_code" label-class="label-required-pc">
                        <b-form-input id="security_code" placeholder="入力してください" />
                      </b-form-group>
                      <br class="hidden-sp"/>
                      <b-form-group label="カード名義" label-for="card_name" label-class="label-required-pc">
                        <b-form-input id="card_name" placeholder="入力してください" />
                      </b-form-group>
                      <br class="hidden-sp"/>
                      <b-form-group label="有効期限" label-for="date_of_expiry" label-class="label-required-pc">
                        <b-form-select class="date_of_expiry_month mr-4" v-model="selected_month" :options="options_month" />
                        <b-form-select class="date_of_expiry_year" v-model="selected_year" :options="options_year" />
                      </b-form-group>
                    </b-form-group><br/>
                    <b-form-group class="d-flex justify-content-center">
                      <b-button type="submit" class="btn btn-blue btn-submit w-272">
                        変更
                      </b-button>
                    </b-form-group>
                  </b-form>
                </div>
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
  export default {
    layout: 'blank',
    components: {
      Sidebar
    },
    data() {
      return {
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
    },
    computed: {}
  }
</script>

<style scoped>

</style>
