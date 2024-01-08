<template>
  <div
    class="page__wrap page-gacha-review pt-5 pb-5"
    v-loading="loading"
  >
    <b-container class="p-35">
      <div class="page__content">
        <div class="gr-review__rating-total box-rating">
          <!-- <b-form-rating
            v-model="avgRating"
            class="box-rating__icon"
            precision="3"
          /> -->
          <RatingStars
            :config="ratingConfig"
            :rating="avgRating"
            :rating-number="totalReview"
          />
        </div>
        <div class="gr-review__list">
          <div
            class="gr-review__item mt-5"
            v-for="item,key in dataReview"
            :key="key"
          >
            <div class="gr-review__user d-flex flex-column flex-md-row">
              <div class="gr-review__rating box-rating mb-4">
                <b-form-rating
                  v-model="item.rating"
                  readonly
                  class="box-rating__icon"
                />
                <span class="box-rating__number">({{ getRating(item.rating) }})</span>
              </div>
              <div class="gr-review__content">
                {{ item.content }}
              </div>
            </div>
            <div class="gr-review__company">
              <div class="gr-review__company-name mb-3">
                {{ item.company_name }}
              </div>
              <div class="gr-review__company-content">
                {{ item.content_reply }}
              </div>
            </div>
          </div>
        </div>
        <div
          class="g-view-more text-right text-md-left mt-4"
          v-if="isShowMore"
          @click="showMoreReview"
        >
          <span>もっと見る＞</span>
        </div>
        <div class="text-center mt-5">
          <div
            class="btn btn-red btn-back max-w-300"
            @click="gotoDetailGacha()"
          >
            ガチャに戻る
          </div>
        </div>
      </div>
    </b-container>
  </div>
</template>

<script>
import { mapState } from 'vuex'

const RatingStars = () => import('~/components/molecules/RatingStars')

const LIMIT_SHOW_COMMENT = 2
export default {
    components: {
      RatingStars
    },

  data(){
    return {
      value: 3,
      dataReview: {},
      avgRating: 0,
      isShowMore: false,
      limit: LIMIT_SHOW_COMMENT,
      totalReview: 0,
      ratingConfig: {
        style: {
          fullStarColor: 'black',
          emptyStarColor: '#cccaca',
          starWidth: 50,
          starHeight: 50
        }
      }
    }
  },

  computed: {
    ...mapState({
      loading: 'loading'
    })
  },

  mounted() {
    this.getReview()
  },

  methods: {
    /**
     * get list review gacha
     */
    getReview(){
      this.$store.dispatch('setLoading', true)
      const id = +this.$route.query.gachaId || 0
      const params = {id, limit: this.limit}
      // call api get list review gacha
      this.$relipa.getReview(params).then(res => {
        if(res){
          this.avgRating = res.avg_rating
          this.dataReview = res.data && res.data.data ? res.data.data : []
          this.isShowMore = res.data.total !== this.dataReview.length
          this.totalReview = res.data.total
        }
      }).finally(() => {
        this.$store.dispatch('setLoading', false)
      })
    },

    /**
     * show more review gacha
     */
    showMoreReview(){
      this.limit += LIMIT_SHOW_COMMENT
      this.getReview()
    },

    /**
     * get rating gacha
     * 
     * @param Float rating
     * @return Float rating after format
     */
    getRating(rating) {
      return Number(rating).toFixed(2)
    },

    /**
     * go page detail gacha
     */
    gotoDetailGacha(){
      this.$router.push('/gacha/detail')
    }
  }
}
</script>

<style scoped lang="scss">
/deep/{
  .gr-review__rating{
    width: 335px;
  }
  .gr-review__content{
    width: calc(100% - 430px);
  }
  @media only screen and (max-width: 767px) {
    .gr-review__content {
        width: calc(100% - 180px);
    }
  }
}
</style>
