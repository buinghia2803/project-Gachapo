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
                    <b-form-group label="通知" label-for="status_notifice" label-class="pb-2 label-required-pc" class="mb-0">
                      <b-form-radio-group
                        id="status_notifice"
                        v-model="selected_notifice"
                        :options="options_notifice"
                        name="status_notifice"
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
        selected_notifice: 1,
        options_notifice: [
          { text: '通知する', value: '1' },
          { text: '未設定', value: '0' },
        ]
      }
    },
  }
</script>

<style scoped>

</style>
