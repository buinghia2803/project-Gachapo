<template>
  <div
    class="page__wrap mypage mypage-history bg-white pb-5"
    v-loading="loading"
  >
    <b-container class="p-0">
      <div class="page__content">
        <Sidebar
          :title="`閲覧履歴`"
          :class-active="`history`"
        />
        <div class="mypage__right p-35 mt-4">
          <div class="mypage__content">
            <div class="mypage__breadcrumb hidden-sp">
              閲覧履歴
            </div>
            <div class="mypage__history mt-4">
              <h1 class="mypage__sub-title title-block-line">
                閲覧履歴
              </h1>
              <div class="data__list history__list pt-4">
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
                  v-for="(item, index) in listGacha"
                  :key="index"
                  :item="item"
                  :class-name="getClassName(item)"
                />
              </div>
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

import { 
  LIMIT_HISTORY_GACHA 
} from '~/constants'
export default {
  layout: 'blank',

  name: "History",

  components: {
    Sidebar,
    MyPageItemGacha
  },

  data() {
    return {
      listGacha: [],
      className: ''
    }
  },

  computed: {
    ...mapState({loading: 'loading'})
  },

  mounted(){
    this.getGachaHistory()
  },

  methods: {
    /**
     * get list history gacha user
     */
    getGachaHistory() {
      this.$store.dispatch('setLoading', true)
      // call api list gacha
      this.$relipa.getBrowsingHistoryGacha().then(({data}) => {
        this.listGacha = data
      }).finally(() => {
        this.$store.dispatch('setLoading', false)
      })
    },

    /**
     * get class name
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
