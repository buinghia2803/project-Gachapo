<template>
  <div>
    <div class="login-footer pt-4 pb-4">
      <b-container class="p-35">
        <div class="login-footer__wrap">
          <h4>{{ $t('footers.above.title') }}</h4>
          <p>{{ $t('footers.above.sub_title_1') }}<br />{{ $t('footers.above.sub_title_2') }}</p>
          <div class="m-0 login-footer__action">
            <p class="hidden-sp">
              Online Gacha
            </p>
            <b-button
              class="mr-4 btn btn-user-login btn-white"
            >
              <b-link
                class="btn-white"
                to="/login"
              >
                {{ $t('common.login') }}
              </b-link>
            </b-button>
            <b-button
              class="btn btn-user-register btn-red"
            >
              <b-link
                class="btn-red"
                to="/registers/user"
                @click="scrollToTop"
              >
                {{ $t('headers.sign_up') }}
              </b-link>
            </b-button>
          </div>
        </div>
      </b-container>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    /**
     * Scroll to top page.
     */
    scrollToTop() {
      window.scrollTo(0,0)
    }
  }
}
</script>
