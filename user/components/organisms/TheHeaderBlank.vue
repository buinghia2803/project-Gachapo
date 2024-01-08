<template>
  <div class="position-relative">
    <b-container>
      <div class="header-blank d-flex justify-content-between align-items-center">
        <div
          class="header-blank__logo"
          @click="goToTopPage()"
        >
          Online Gacha
        </div>
        <div class="header-blank__type">
          ユーザー - 管理画面
        </div>
        <div class="d-flex align-items-center header-blank__info">
          <div class="header__user-name">
            {{ $auth.loggedIn ? $auth.user.name : '' }}
          </div>
          <b-link
            href="/users/mypage/notify"
            title=""
            class="btn btn-white ml-5 w-148"
          >
            通知
          </b-link>
        </div>
      </div>
    </b-container>
  </div>
</template>

<script>
export default {
  methods: {
    /**
     * go to top page - home page
     */
    goToTopPage() {
      this.$router.push('/')
    }
  }
}
</script>

<style lang="scss" scoped>
.header-blank__logo{
  cursor: pointer;
}
</style>
