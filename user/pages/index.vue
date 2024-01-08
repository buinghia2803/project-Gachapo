<template>
  <div>
    <SliderTop :visual="main_visual" />
    <BannerTop :banner="banner" />
    <AboutTop />
    <FlowTop />

    <ListGachaNew
      v-if="Array.isArray(new_arrivals) && new_arrivals.length"
      :new-arrivals="new_arrivals"
    />

    <ListGachaPopular
      v-if="Array.isArray(favorites) && favorites.length"
      :favorites="favorites"
    />

    <ListGachaRecommend
      v-if="Array.isArray(recommends) && recommends.length"
      :recommends="recommends"
    />
  </div>
</template>

<script>
import { mapState } from 'vuex'

const SliderTop = () => import('~/components/organisms/tops/SliderTop')
const BannerTop = () => import('~/components/organisms/tops/BannerTop')
const AboutTop = () => import('~/components/organisms/tops/AboutTop')
const FlowTop = () => import('~/components/organisms/tops/FlowTop')
const ListGachaNew = () => import('~/components/organisms/tops/ListGachaNew')
const ListGachaPopular = () => import('~/components/organisms/tops/ListGachaPopular')
const ListGachaRecommend = () => import('~/components/organisms/tops/ListGachaRecommend')

export default {
  components: {
    SliderTop,
    BannerTop,
    AboutTop,
    FlowTop,
    ListGachaNew,
    ListGachaPopular,
    ListGachaRecommend
  },

  async asyncData({ $relipa, store }) {
    let response = []
    let pages = []

    const res = await $relipa.getInfoHomePage()
    if(res && res.data) {
      response = res.data
    }

    const resPage = await $relipa.getPageList()
    if(resPage && resPage.data) {
      pages = resPage.data
      store.dispatch('home/setStaticPage', pages)
    }

    return { response, pages }
  },

  data() {
    return {
      banner: [],
      favorites: [],
      new_arrivals: [],
      recommends: [],
      main_visual: []
    }
  },

  computed: {
    ...mapState({
      loading: 'loading'
    })
  },

  created() {
    this.prepareData()
  },

  methods: {
    /**
     * Call api get data for home
     */
    async prepareData() {
      if(this.response) {
        this.banner = this.response.banner
        this.favorites = this.chunkArr(this.response.favorites, 2)
        this.new_arrivals = this.chunkArr(this.response.new_arrivals, 2)
        this.recommends = this.chunkArr(this.response.recommends, 2)
        this.main_visual = this.response.visual
      }
    },

    /**
     * Chunk Array.
     */
    chunkArr(array, chunkSize) {
      var R = [];
      for (var i = 0; i < array.length; i += chunkSize)
        R.push(array.slice(i, i + chunkSize));
      return R;
    }
  }
}
</script>
<style lang="scss" src="assets/scss/home.scss" />
