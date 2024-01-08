<template>
  <div
    class="page__wrap mypage mypage-notify bg-white pb-5"
    v-loading="loading"
  >
    <b-container class="p-0">
      <div class="page__content">
        <Sidebar
          :title="`お知らせ`"
          :class-active="`notify`"
        />
        <div class="mypage__right p-35 mt-4">
          <div class="mypage__content">
            <div class="mypage__notify">
              <div class="mypage__notify-header title-block-line">
                {{ notification.title }}
              </div>
              <div class="mypage__notify-text">
                {{ notification.content }}
              </div>
              <div class="text-center mt-4">
                <b-button
                  @click="goToListNoti()"
                  class="btn btn-blue w-180"
                >
                  戻る
                </b-button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </b-container>
  </div>
</template>

<script>
import {mapState} from 'vuex'

import Sidebar from '~/components/organisms/mypage/sidebar'

export default {
  layout: 'blank',

  name: "Detail",
  
  components: {
    Sidebar
  },

  data() {
    return {
      notification: {},
    }
  },

  computed: {
    ...mapState({loading: 'loading'})
  },

  mounted() {
    const id = +this.$route.query.id || 0
    if(id){
      this.getDetailNotification(id)
    }
  },

  methods: {
    /**
     * get detail notification
     * 
     * @param Integer id
     */
    getDetailNotification(id) {
      this.$store.dispatch('setLoading', true)
      this.$relipa.getDetailNotification({id}).then(({data}) => {
        this.notification = data
      }).finally(() => {
        this.$store.dispatch('setLoading', false)
      })
    },

    /**
     * go to list notification page
     */
    goToListNoti() {
      this.$router.push('/users/mypage/notify')
    }
  }
}
</script>

<style scoped>

</style>
