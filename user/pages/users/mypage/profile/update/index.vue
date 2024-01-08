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
                <div class="form-default  ">
                  <b-form>
                    <b-form-group label="お名前" label-for="name" label-class="label-required-pc">
                      <b-form-input v-model="name" :state="validation" id="name" placeholder="入力してください" />
                      <b-form-invalid-feedback :state="validation">
                        Your user ID must be 5-12 characters long.
                      </b-form-invalid-feedback>
                      <b-form-valid-feedback :state="validation">
                        Looks Good.
                      </b-form-valid-feedback>
                    </b-form-group><br/>
                    <b-form-group label="フリガナ" label-for="name_furigana" label-class="label-required-pc">
                      <b-form-input id="name_furigana" placeholder="入力してください" />
                    </b-form-group><br/>
                    <b-form-group label="Eメール" label-for="email" label-class="label-required-pc">
                      <b-form-input id="email" placeholder="入力してください" />
                    </b-form-group><br/>
                    <b-form-group label="生年月日" label-for="birthday" label-class="label-required-pc">
                      <b-form-input id="birthday" placeholder="入力してください" type="date" />
                    </b-form-group><br/>
                    <b-form-group label="性別" label-for="gender" label-class="label-required-pc">
                      <b-form-select v-model="selected_gender" :options="options_gender" />
                    </b-form-group><br/>
                    <b-form-group label="職業" label-for="profession" label-class="label-required-pc">
                      <b-form-input id="profession" placeholder="入力してください" />
                    </b-form-group><br/>
                    <b-form-group label="住所" label-class="label-required-pc" class="box-address">
                      <b-form-group label="住所1" label-for="address_first">
                        <b-form-input id="address_first" placeholder="入力してください" />
                      </b-form-group>
                      <b-form-group label="住所2" label-for="address_second">
                        <b-form-input id="address_second" placeholder="入力してください" />
                      </b-form-group>
                      <b-form-group label="基本設定" label-for="address_type">
                        <b-form-select v-model="selected_address" :options="options_address" />
                      </b-form-group>
                    </b-form-group><br/>
                    <b-form-group label="電話番号" label-for="phone" label-class="label-required-pc">
                      <b-form-input id="phone" placeholder="入力してください" />
                    </b-form-group><br/>
                    <b-form-group label="興味のあるカテゴリー" label-for="category_id" label-class="pb-2 label-required-pc" class="mb-0">
                      <b-form-radio-group
                        id="radio-group-1"
                        v-model="selected_category"
                        :options="options_category"
                        name="category_id"
                        class="form-group__category_id"
                      />
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
        name: '',
        selected_gender: 1,
        options_gender: [
          { value: '1', text: '男性' },
          { value: '2', text: '女性' },
          { value: '3', text: 'その他' }
        ],
        selected_address: 1,
        options_address: [
          { value: '1', text: '住所1に届ける ' },
          { value: '2', text: '住所2に届ける ' }
        ],
        selected_category: 1,
        options_category: [
          { text: 'キャラクター・コンテンツ', value: '1' },
          { text: 'ミュージシャン', value: '2' },
          { text: 'アイドル', value: '3' },
          { text: 'タレント', value: '4' },
          { text: 'アニメ', value: '5' },
          { text: 'ホビー', value: '6' },
          { text: 'それ以外', value: '7' },
        ]
      }
    },
    computed: {
      validation() {
        return this.name.length > 4 && this.name.length < 13
      }
    }
  }
</script>

<style scoped>

</style>
