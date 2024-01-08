<template>
  <div :class="[`data__item data__content`, className]">
    <div class="dt-td-images">
      <b-img
        :src="getImageGacha().length ? getImageGacha() : require(`~/assets/images/flow-1.png`)"
      />
    </div>
    <div class="dt-td-name">
      <div :class="`text-overflow-ellipsis row-2 ${type==='review' ? 'review' : ''}`">
        {{ item && item.name ? item.name : '' }}
      </div>
    </div>
    <div
      class="dt-td-status hidden-sp"
      v-if="type !== `review`"
    >
      {{ getStatus() }}
    </div>
    <div
      class="dt-td-action hidden-sp d-md-flex flex-column justify-content-center"
      v-if="type !== `review`"
    >
      <b-button
        @click="goToGachaDetail"
        title=""
        class="btn btn-blue"
        :disabled="isDetailPage"
      >
        再購入
      </b-button>
      <button
        class="btn btn-review mt-2"
        :disabled="isReviewPage"
        v-if="type == `list-order`"
        @click="goToReviewPage()"
      >
        レビューを書く
      </button>
    </div>
  </div>
</template>

<script>
import { 
  LIST_STATUS_GACHA,
  STATUS_DELIVERED,
  LIST_STATUS_FAVORITE_GACHA,
  LIST_STATUS_ORDER_HISTORY
} from '~/constants'
export default {
  name: "ItemGacha",

  data() {
    return {
      class: ''
    }
  },

  props: {
    className: {
      type: String,
      required: false,
      default: ''
    },

    type: {
      type: String,
      required: false,
      default: ''
    },

    item: {
      type: Object,
      required: false,
      default: () => {}
    },

    statusDeliver: {
      type: Number,
      required: false,
      default: 0
    }
  },

  computed: {
    /**
     * check disable button go to detail gacha
     * 
     * @return Boolean
     */
    isDetailPage() {
      return this.className === 'data__item-deactive' ? true : false
    },

    /**
     * check disable button go to review gacha
     * 
     * @return Boolean
     */
    isReviewPage() {
      return this.className === 'data__item-deactive' || this.statusDeliver !== STATUS_DELIVERED ? true : false
    }
  },

  methods: {
    /**
     * get gacha image
     */
    getImageGacha() {
      if(!this.item) {
        return ''
      }
      if(!this.type) {
        return this.item.images && this.item.images.length ? this.item.images[0].attachment : ''
      }

      return this.item.image_url
    },

    /**
     * get status
     * 
     * @return String Status name
     */
    getStatus(){
      if(!this.item){
        return ''
      }
      let status = ''
      if(this.type === 'list-order'){
        status = this.getStatusOrder(LIST_STATUS_ORDER_HISTORY)
      }else{
        const listStatus = this.type === 'favorite' ? LIST_STATUS_FAVORITE_GACHA : LIST_STATUS_GACHA
        status = this.getStatusGacha(listStatus)
      }

      return status
    },

    /**
     * get status gacha
     * 
     * @param Array listStatusGacha
     * @return String gachaStatusName
     */
    getStatusGacha(listStatusGacha){
      const now = this.$dayjs().unix()
      const period_start = this.$dayjs(this.item.period_start).unix()
      const period_end = this.$dayjs(this.item.period_end).unix()

      if (now <= period_start || period_end <= now) {
        return '販売終了'
      }

      const gacha = listStatusGacha.find(item => item.id === this.item.status_operation)
      return gacha && gacha.name ? gacha.name : ''
    },

    /**
     * get status order
     * 
     * @param Array listStatusOrder
     * @return String OrderStatusName
     */
    getStatusOrder(listStatusOrder) {
      const order = listStatusOrder.find(item => item.id === this.item.status)
      return order && order.name ? order.name : ''
    },

    /**
     * go to detail gacha
     */
    goToGachaDetail() {
      this.$router.push('/gachas/detail')
    },

    /**
     * go to review gacha page
     */
    goToReviewPage() {
      this.$router.push({path: '/users/mypage/review', query: {order_id: this.item.order_id}})
    }
  },
}
</script>

<style scoped lang="scss">
.review{
  text-align: center !important;
}
</style>
