<template>
  <div
    class="page__wrap mypage mypage-history bg-white pb-5"
    v-loading="loading"
  >
    <b-container class="p-0">
      <div class="page__content">
        <Sidebar
          :title="`購入履歴`"
          :class-active="`list-order`"
        />
        <div class="mypage__right p-35 mt-4">
          <div class="mypage__content">
            <div class="mypage__breadcrumb hidden-sp">
              購入履歴
            </div>
            <div class="mypage__history mt-4">
              <h1 class="mypage__sub-title title-block-line">
                購入履歴
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
                  :type="`list-order`"
                  v-for="item,key in listOrder"
                  :key="key"
                  :item="item.gacha"
                  :class-name="getClassName(item)"
                  :status-deliver="item.status_deliver"
                />
                <nodata v-if="!listOrder.length" />
              </div>
              <pagination
                v-if="listOrder.length"
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
import Nodata from '~/components/organisms/NoData.vue'
import Pagination from '~/components/organisms/Pagination.vue'

import { LIMIT_LIST_ORDER } from '~/constants'

export default {
  layout: 'blank',
  
  name: "ListOrder",

  components: {
    Sidebar,
    MyPageItemGacha,
    Pagination,
    Nodata
  },

  data() {
    return {
      listOrder: [],
      totalPage: 1
    }
  },

  computed: {
    ...mapState({loading: 'loading'})
  },

  mounted() {
    this.getListOrder()
  },

  methods: {
    /**
     * link generate
     * 
     * @param Integer pageNum
     */
    linkGen(pageNum) {
      return pageNum === 1 ? '?' : `?page=${pageNum}`
    },

    /**
     * change page
     * 
     * @param Integer page
     */
    changePage(page){
      this.getListOrder(page)
    },

    /**
     * get list order
     * 
     * @param Integer currentPage
     */
    getListOrder(currentPage = 1) {
      this.$store.dispatch('setLoading', true)

      const params = { limit: LIMIT_LIST_ORDER ,page: currentPage}

      // call api list gacha
      this.$relipa.indexOrder({params}).then(({data}) => {
        this.listOrder = data.data.map(item => {
          item.gacha.order_id = item.id
          return item
        })
        this.totalPage = data.meta.last_page
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
      if(!item.gacha || !item.gacha.products.length) {
        return 'data__item-deactive'
      }

      const now = this.$dayjs().unix()
      const period_start = this.$dayjs(item.gacha.period_start).unix()
      const period_end = this.$dayjs(item.gacha.period_end).unix()

      // check time start end gacha and quantity gacha
      if(period_start <= now && now <= period_end && item.quantity > 0){
        return ''
      }

      return 'data__item-deactive'
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
