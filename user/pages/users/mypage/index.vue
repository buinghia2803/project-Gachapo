<template>
  <div
    class="page__wrap mypage mypage-dashboard bg-white pb-4"
    v-loading="loading"
  >
    <b-container class="p-0">
      <div class="page__content">
        <Sidebar
          :title="`ダッシュボード`"
          :class-active="`dashboard`"
        />
        <div class="mypage__right p-35 mt-4">
          <div class="mypage__content">
            <div class="mypage__info">
              {{ $auth.loggedIn ? $auth.user.name : '' }}
            </div>
            <div class="mypage__history mt-4">
              <h1
                class="mypage__sub-title"
              >
                閲覧履歴
              </h1>
              <div class="mypage__history-content">
                <b-carousel
                  ref="myCarousel"
                  id="carousel-history-gacha"
                  controls
                  :interval="4000"
                  @sliding-start="onSlideStart"
                >
                  <b-carousel-slide
                    v-for="item,key in listGachaHistory"
                    :key="key"
                  >
                    <template #img>
                      <div
                        v-for="el,index in item"
                        :key="index"
                      >
                        <ItemGacha :gacha="el" />
                      </div>
                    </template>
                  </b-carousel-slide>
                </b-carousel>
              </div>
            </div>
            <div class="mypage__notify mt-4">
              <div class="mypage__sub-title">
                お知らせ
              </div>
              <div class="mypage__notify-content">
                <div
                  class="mypage__notify-item"
                  v-for="item, key in listNotification"
                  :key="key"
                >
                  <div class="mypage__notify-date">
                    {{ item.start_time | formatShortDate }} ~ {{ item.end_time | formatShortDate }}
                  </div>
                  <div class="mypage__notify-title text-overflow-ellipsis ml-4">
                    {{ item.title }}
                  </div>
                </div>
                <div class="text-center mt-3">
                  <div
                    class="btn btn-blue"
                    @click="goToNotiPage()"
                  >
                    お知らせ一覧
                  </div>
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
import _ from 'lodash'
import {mapState} from 'vuex'
import Sidebar from '~/components/organisms/mypage/sidebar'
import ItemGacha from '~/components/organisms/ItemGacha'

import {
  SORT_TYPE,
  LIMIT_HISTORY_GACHA
} from '~/constants'

const groupBy = (x, f) => x.reduce((a, b) => ((a[f(b)] ||= []).push(b), a), {});

export default {
  layout: 'blank',
  name: "Index",

  components: {
    Sidebar,
    ItemGacha
  },

  data() {
    return {
      listNotification: [],
      listGachaHistory: [],
      controls: false
    }
  },

  computed: {
    ...mapState({
      loading: 'loading'
    }),
  },

  mounted() {
    this.getNotification()
    this.getGachaHistory()
  },

  methods: {
    /**
     * on slide start
     *
     * @param Integer slide
     */
    onSlideStart(slide) {
      // disable prev button
      if(slide === 0){
          document.querySelector('#carousel-history-gacha .carousel-control-prev').style.display = 'none'

          document.querySelector('#carousel-history-gacha .carousel-control-next').style.display = 'flex'

        }else if(slide === Object.keys(this.listGachaHistory).length - 1) { // disable next button
          document.querySelector('#carousel-history-gacha .carousel-control-next').style.display = 'none'

          document.querySelector('#carousel-history-gacha .carousel-control-prev').style.display = 'flex'

        }else if(slide < Object.keys(this.listGachaHistory).length - 1) {

           document.querySelector('#carousel-history-gacha .carousel-control-next').style.display = 'flex'

        }
    },

    /**
     * get notification
     */
    getNotification() {
      this.$store.dispatch('setLoading', true)
      const params = {limit: LIMIT_HISTORY_GACHA, sort_field: 'created_at', sort_type: SORT_TYPE.DESC}
      // call api notification
      this.$relipa.getNotification(params).then(({data}) => {
        this.listNotification = data
      }).finally(() => {
        this.$store.dispatch('setLoading', false)
      })
    },

    /**
     * get list history gacha user
     */
    getGachaHistory() {
      this.$store.dispatch('setLoading', true)
      // call api list gacha
        this.$relipa.getBrowsingHistoryGacha().then(({data}) => {
        const listGacha = data.map((item,key) => {
          // group 2 item
          item.group = key < 2 ? 1 : key < 4 ? 2 : 3
          return item
        })
        this.listGachaHistory = groupBy(listGacha, item => item.group)
      }).finally(() => {
        this.$store.dispatch('setLoading', false)
      })
    },

    /**
     * go to notification page
     */
    goToNotiPage() {
      this.$router.push('/users/mypage/notify')
    }
  }
}
</script>

<style scoped>

</style>
