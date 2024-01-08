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
            <div class="mypage__breadcrumb hidden-sp">
              お知らせ
            </div>
            <div class="mypage__history mt-4">
              <h1 class="mypage__sub-title title-block-line">
                お知らせ
              </h1>
            </div>
            <div class="mypage__notify mt-4">
              <div class="mypage__notify-content p-0 no-border">
                <div
                  class="mypage__notify-item"
                  v-for="item,key in listNotification"
                  :key="key"
                  @click="goToDetailPage(item.id)"
                >
                  <div class="mypage__notify-date">
                    ({{ item.start_time | formatShortDate }} ~ {{ item.end_time | formatShortDate }})
                  </div>
                  <div class="mypage__notify-title text-overflow-ellipsis ml-4">
                    {{ item.title }}
                  </div>
                </div>
              </div>
              <pagination
                :total="totalPage"
                @change-page="changePage"
              />
            </div>
          </div>
        </div>
      </div>
    </b-container>
  </div>
</template>

<script>
import { mapState } from 'vuex'

import Sidebar from '~/components/organisms/mypage/sidebar'
import Pagination from '~/components/organisms/Pagination.vue'

export default {
  layout: 'blank',

  name: "Notify",

  components: {
    Sidebar,
    Pagination
  },

  data() {
    return {
      totalPage: 1,
      listNotification: []
    }
  },

  computed: {
    ...mapState({loading: 'loading'})
  },

  mounted() {
    this.getListNotification()
  },

  methods: {
    /**
     * change page
     * 
     * @param Integer page
     */
    changePage(page) {
      this.getListNotification(page)
    },

    /**
     * get list notification
     * 
     * @param Integer current page
     */
    getListNotification(currentPage = 1) {
      this.$store.dispatch('setLoading', true)
      const params = { limit: 7, page: currentPage }
      this.$relipa.getNotification(params).then(res => {
        this.listNotification = res.data
        this.totalPage = res.meta.last_page
      }).finally(() => {
        this.$store.dispatch('setLoading', false)
      })
    },

    /**
     * go to detail notification page
     */
    goToDetailPage(id) {
      this.$router.push({path: 'notify/detail', query: {id}})
    }
  }
}
</script>

<style scoped lang="scss">
/deep/ {
  .mypage__notify-date{
    width: 240px;
  }
  .mypage__notify-item{
    cursor: pointer;
  }
  .mypage__notify-item:hover{
    background: rgb(245, 245, 245);
  }
}
</style>
