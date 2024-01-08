<template>
  <div>
    <b-carousel
      id="carousel-visual"
      background="#ababab"
      img-width="1366"
      img-height="400"
      :interval="3000"
    >
      <template v-for="(item, key) of visual">
        <a
          :key="key"
          :href="item.link"
          target="_blank"
          :atl="item.title"
        >
          <b-carousel-slide
            class="carousel-image"
            :img-src="item.attachment"
          />
        </a>
      </template>
    </b-carousel>
  </div>
</template>

<script>
export default {
  props: {
    visual: {
      type: Array,
      required: true,
      default: () => []
    }
  },
  data() {
    return {
      slide: null
    }
  }
}
</script>

<style lang="scss" scoped>
#carousel-visual {
  max-height: 400px;
  .carousel-image, img {
    max-height: 400px;
  }
}
@media (max-width: 767px) {
  #carousel-visual {
    .carousel-image, img {
      height: 160px;
    }
  }
  /deep/ {
    .img-fluid, .img-thumbnail {
      max-width: 100%;
      height: 100%;
    }
  }
}
</style>

