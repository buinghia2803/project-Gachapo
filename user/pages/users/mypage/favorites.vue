<template>
  <div
    class="page__wrap mypage mypage-history bg-white pb-5"
    v-loading="loading"
  >
    <b-container class="p-0">
      <div class="page__content">
        <Sidebar
          :title="`お気に入りリスト`"
          :class-active="`favorites`"
        />
        <div class="mypage__right p-35 mt-4">
          <div class="mypage__content">
            <div class="mypage__breadcrumb hidden-sp">
              お気に入りリスト
            </div>
            <div class="mypage__history mt-4">
              <h1 class="mypage__sub-title title-block-line">
                お気に入りリスト
              </h1>
              <div class="data__list order__list pt-4">
                <div class="data__item data__title">
                  <div class="dt-th-images">
                    商品画像
                  </div>
                  <div class="dt-th-name">
                    商品名
                  </div>
                  <div class="dt-th-status hidden-sp">
                    稼働状況
                  </div>
                  <div class="dt-th-action hidden-sp" />
                </div>
                <MyPageItemGacha
                  v-for="item,key in listFavorite"
                  :key="key"
                  :item="item"
                  :type="`favorite`"
                  :class-name="getClassName(item)"
                />
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
import MyPageItemGacha from '~/components/organisms/mypage/ItemGacha'
import Pagination from '~/components/organisms/Pagination.vue'

import { LIMIT_LIST_ORDER } from '~/constants'

export default {
  layout: 'blank',

  name: "Favorites",

  components: {
    Sidebar,
    MyPageItemGacha,
    Pagination
  },

  data() {
    return {
      listFavorite: [],
      totalPage: 1
    }
  },

  computed: {
    ...mapState({loading: 'loading'})
  },

  mounted() {
    this.getListFavorite()
  },

  methods: {
    /** 
     * change page
     * 
     * @param Integer page
     */
    changePage(page){
      this.getListFavorite(page)
    },
    
    /**
     * get list favorite
     * 
     * @param Integer currentPage
     */
    getListFavorite(currentPage = 1){
      this.$store.dispatch('setLoading', true)

      const params = { limit: LIMIT_LIST_ORDER ,page: currentPage}

      // call api list favorite
      this.$relipa.getListFavorite(params).then(res => {
        this.listFavorite = res.data
        this.totalPage = res.meta.last_page
      }).finally(() => {
        this.$store.dispatch('setLoading', false)
      })
    },

    /**
     * get class name
     * 
     * @param Object item
     */
    getClassName(item) {
      if(!item || !item.products.length) {
        return 'data__item-deactive'
      }
      
      // check cout product gacha
      const productCount = this.getTotalProduct(item.products)

      const now = this.$dayjs().unix()
      const period_start = this.$dayjs(item.period_start).unix()
      const period_end = this.$dayjs(item.period_end).unix()
      
      // check time start end gacha
      if(period_start <= now && now <= period_end && productCount){
        return ''
      }

      return 'data__item-deactive'
    },

    /**
     * get total product
     * 
     * @param Array item - product
     */
    getTotalProduct(item) {
      let sum = 0
      if(item && Array.isArray(item)){
        if(item.length) {
          item.forEach(element => {
            sum += element.quantity
          });
        }
      }else{
        return 0
      }


      return sum
    }
  }
}
</script>

<style scoped lang="scss">
/deep/{
  .data__item-deactive{
    .btn-blue{
      background: gray;
      border-color: gray;
    }
  }
}
</style>
