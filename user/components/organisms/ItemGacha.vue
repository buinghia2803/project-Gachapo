<template>
  <div :class="[`gacha__box`, className]">
    <div
      class="gacha__reward-type"
      v-if="isShowReward"
    >
      A賞
    </div>
    <div class="gacha__item bg-white box-shadow">
      <div class="gacha__quality text-left">
        残/{{ getTotalProduct() }}個
      </div>
      <div class="gacha__images mt-2">
        <b-img :src="gacha && gacha.image_url ? gacha.image_url : require(`~/assets/images/flow-1.png`)" />
      </div>
      <div class="gacha__name text-overflow-ellipsis mt-2 text-left">
        {{ gacha ? gacha.name: "" }}
      </div>
    </div>
  </div>
</template>

<script>
const REWORD_PERCENTAGE_MANAGEMENT = 1

export default {
  name: "ItemGacha",

  props: {
    isShowReward: {
      type: Boolean,
      required: false
    },
    className: {
      type: String,
      default: '',
      required: false,
    },
    gacha: {
      type: Object,
      default: () => {},
      required: false,
    },
  },

  methods: {
    /**
     * get total product
     */
    getTotalProduct() {
      if(this.gacha && this.gacha.reward_status === REWORD_PERCENTAGE_MANAGEMENT) {
        return '∞'
      }else {
        return this.gacha && this.gacha.quantity ? this.gacha.quantity : 0
      }
    }
  }
}
</script>

<style scoped>

</style>
