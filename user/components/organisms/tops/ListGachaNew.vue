<template>
  <div class="list-gacha-new bg-grey pt-5 pt-md-4 pb-3 pb-md-4">
    <b-container class="p-35">
      <div class="list-gacha-new__wrap">
        <h2 class="title-block text-center text-md-left">
          {{ $t('home.gacha_new_arrival') }}
        </h2>
        <div class="scrollbar custom-scroll-bar list-gacha-new__content gacha__scroll mt-4">
          <div class="gacha__list">
            <template v-for="(items, key) of newArrivals">
              <div
                :key="key"
                class="gacha__row d-flex"
              >
                <template v-for="(gacha, idx) of items">
                  <ItemGacha
                    :key="idx"
                    :gacha="gacha"
                  />
                </template>
              </div>
            </template>
          </div>
        </div>
        <div
          v-if="Array.isArray(newArrivals) && newArrivals.length * MULTIPLE_ARRAY_MUNER >= MAX_RECORD_GACHA_HOME"
          class="g-view-more text-center mt-5 mt-md-2"
        >
          <b-link href="/search?type=new">
            {{ $t('home.show_more') }}
          </b-link>
        </div>
      </div>
    </b-container>
  </div>
</template>

<script>
import { MAX_RECORD_GACHA_HOME } from '~/constants'
const ItemGacha  = () => import('~/components/organisms/ItemGacha')

const MULTIPLE_ARRAY_MUNER = 2

export default {
  components: {
    ItemGacha
  },

  props: {
    newArrivals: {
      type: Array,
      required: true,
      default:() => []
    }
  },

  data() {
    return {
      MULTIPLE_ARRAY_MUNER,
      MAX_RECORD_GACHA_HOME
    }
  }
}
</script>

<style scoped>

</style>
