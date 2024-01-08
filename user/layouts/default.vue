<template>
  <div
    class="wrap"
  >
    <div class="__header">
      <TheHeader />
    </div>
    <div class="__wrapper">
      <transition :duration="550">
        <Nuxt />
      </transition>
    </div>
    <div class="__footer">
      <TheFooterTop v-if="!$auth.loggedIn" />
      <TheFooter />
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import TheFooterTop from '~/components/organisms/TheFooterTop'
import TheFooter from '~/components/organisms/TheFooter'
import TheHeader from '~/components/organisms/TheHeader'
export default {
//   middleware: ['auth'],
  components: {
    TheFooterTop,
    TheFooter,
    TheHeader
  },

  data() {
    return {

    }
  },

  computed: {
    ...mapState({
      loading: 'loading'
    })
  }

}
</script>

<style lang="scss" scoped>
.layout__content {
  height: 100vh;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
.parallax {
  position: fixed;
  min-height: 1070px;
  z-index: 0;
  width: 100%;
  background-position: center !important;
  background-repeat: no-repeat !important;
  background-size: cover !important;
}
@page {
  size: auto;
}
</style>
