<template>
  <div>
    <div class="main-footer pt-5 pb-3 pb-md-4">
      <b-container class="p-35">
        <div class="footer-title">
          Online Gacha
        </div>
        <b-row class="d-flex flex-column flex-md-row pt-1">
          <template v-for="(items, key) of pages">
            <b-col
              :key="key"
              class="f-footer"
            >
              <template v-for="(item, idx) of items">
                <div :key="idx">
                  <b-link :to="`/pages/` + item.slug">
                    {{ item.title }}
                  </b-link>
                </div>
              </template>
            </b-col>
          </template>
          <b-col class="th-footer mt-4 mt-md-0">
            <div class="info-list d-flex">
              <div class="mr-4">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="50"
                  height="50"
                  viewBox="0 0 50 50"
                >
                  <path
                    id="facebook-square-brands"
                    d="M44.643,32H5.357A5.357,5.357,0,0,0,0,37.357V76.643A5.357,5.357,0,0,0,5.357,82H20.675V65H13.644V57h7.031V50.9c0-6.936,4.129-10.768,10.454-10.768a42.6,42.6,0,0,1,6.2.54v6.808h-3.49c-3.439,0-4.511,2.134-4.511,4.323V57H37l-1.228,8H29.325V82H44.643A5.357,5.357,0,0,0,50,76.643V37.357A5.357,5.357,0,0,0,44.643,32Z"
                    transform="translate(0 -32)"
                    fill="#fff"
                  />
                </svg>
              </div>
              <div class="mr-4">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="50"
                  height="50"
                  viewBox="0 0 50 50"
                >
                  <path
                    id="instagram-square-brands"
                    d="M25,51.047A5.953,5.953,0,1,0,30.955,57,5.953,5.953,0,0,0,25,51.047Zm13.919-4.576a6.027,6.027,0,0,0-3.394-3.394c-2.344-.925-7.924-.718-10.525-.718s-8.175-.215-10.526.718a6.027,6.027,0,0,0-3.394,3.394c-.924,2.344-.718,7.93-.718,10.528s-.206,8.177.722,10.529a6.027,6.027,0,0,0,3.394,3.394c2.344.925,7.924.718,10.526.718s8.174.215,10.525-.718a6.027,6.027,0,0,0,3.394-3.394c.932-2.344.718-7.93.718-10.528s.214-8.176-.718-10.528ZM25,66.152a9.141,9.141,0,1,1,6.475-2.677A9.152,9.152,0,0,1,25,66.152ZM34.529,49.6a2.124,2.124,0,1,1,1.514-.623,2.136,2.136,0,0,1-1.514.623ZM44.643,32H5.357A5.357,5.357,0,0,0,0,37.357V76.643A5.357,5.357,0,0,0,5.357,82H44.643A5.357,5.357,0,0,0,50,76.643V37.357A5.357,5.357,0,0,0,44.643,32ZM42.732,64.366c-.144,2.86-.8,5.4-2.885,7.478s-4.621,2.749-7.478,2.885c-2.948.166-11.785.166-14.732,0-2.86-.144-5.386-.8-7.478-2.885s-2.749-4.623-2.885-7.478c-.166-2.949-.166-11.787,0-14.732.144-2.86.789-5.4,2.885-7.478s4.628-2.741,7.478-2.877c2.948-.166,11.785-.166,14.732,0,2.86.144,5.394.8,7.478,2.885s2.749,4.623,2.885,7.483C42.9,52.585,42.9,61.415,42.732,64.366Z"
                    transform="translate(0 -32)"
                    fill="#fff"
                  />
                </svg>
              </div>
              <div>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="50"
                  height="50"
                  viewBox="0 0 50 50"
                >
                  <path
                    id="twitter-square-brands"
                    d="M44.643,32H5.357A5.359,5.359,0,0,0,0,37.357V76.643A5.359,5.359,0,0,0,5.357,82H44.643A5.359,5.359,0,0,0,50,76.643V37.357A5.359,5.359,0,0,0,44.643,32ZM39.185,49.723c.022.313.022.636.022.949,0,9.676-7.366,20.826-20.826,20.826A20.73,20.73,0,0,1,7.143,68.217a15.421,15.421,0,0,0,1.763.089,14.676,14.676,0,0,0,9.085-3.125A7.329,7.329,0,0,1,11.15,60.1a7.889,7.889,0,0,0,3.3-.134,7.32,7.32,0,0,1-5.859-7.187v-.089a7.315,7.315,0,0,0,3.3.926,7.3,7.3,0,0,1-3.259-6.094,7.228,7.228,0,0,1,.993-3.694,20.784,20.784,0,0,0,15.089,7.656A7.335,7.335,0,0,1,37.21,44.8a14.343,14.343,0,0,0,4.643-1.763,7.3,7.3,0,0,1-3.214,4.029,14.566,14.566,0,0,0,4.219-1.138A15.408,15.408,0,0,1,39.185,49.723Z"
                    transform="translate(0 -32)"
                    fill="#fff"
                  />
                </svg>
              </div>
            </div>
            <div />
            <div />
            <div class="c-footer mt-5">
              © GOGO Enterprise,Inc.
            </div>
          </b-col>
        </b-row>
      </b-container>
    </div>
    <div class="footer-login">
      <b-container class="p-35">
        <div class="d-flex justify-content-center">
          <b-icon-house-door-fill />
          <b-icon-person-fill />
        </div>
      </b-container>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'TheFooter',

  data() {
    return {
      pages: []
    }
  },

  computed: {
    ...mapGetters({
      staticPage: 'home/getStaticPage'
    })
  },

  async created() {
    if(!(Array.isArray(this.staticPage) && this.staticPage.length)) {
      const resPage = await this.$relipa.getPageList()
      if(resPage && resPage.data) {
        this.$store.dispatch('home/setStaticPage', resPage.data)
        this.pages = this.chunkArr(resPage.data, 4)
      }
    }else {
      this.pages = this.chunkArr(this.staticPage, 4)
    }

    this.$forceUpdate()
  },

  methods: {

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

<style lang="scss" scoped>
</style>
