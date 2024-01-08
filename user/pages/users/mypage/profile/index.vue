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
                <div class="m-profile__item d-flex align-items-center">
                  <div>ユーザー情報</div>
                  <div/>
                  <b-link href="profile/update" title="" class="btn btn-blue ml-auto">変更</b-link>
                </div>
                <div class="m-profile__item d-flex align-items-center justify-content-between">
                  <div>パスワード</div>
                  <div>*************</div>
                  <b-link href="profile/update/password" title="" class="btn btn-blue ml-auto">変更</b-link>
                </div>
                <div class="m-profile__item d-flex align-items-center justify-content-between">
                  <div>2段階認証</div>
                  <div>設定済み</div>
                  <b-link href="profile/update/setting-two-step-verification" title="" class="btn btn-blue ml-auto">変更</b-link>
                </div>
                <div class="m-profile__item d-flex align-items-center justify-content-between">
                  <div>通知</div>
                  <div>通知する</div>
                  <b-link href="profile/update/setting-notify" title="" class="btn btn-blue ml-auto">変更</b-link>
                </div>
                <div class="m-profile__item d-flex align-items-center justify-content-between">
                  <div>クレジットカード情報</div>
                  <div/>
                  <b-link href="profile/update/credit-card" title="" class="btn btn-blue ml-auto">変更</b-link>
                </div>
              </div>
              <div class="mt-5 position-relative m-profile__withdraw">
                <h2 class="mypage__sub-title title-block-line">退会について</h2>
                <b-link href="profile/withdraw" title="" class="btn btn-blue">退会</b-link>
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
    name: "profile",
    components: {
      Sidebar
    },
  }
</script>

<style scoped>

</style>
