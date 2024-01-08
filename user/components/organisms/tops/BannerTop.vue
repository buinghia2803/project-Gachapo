<template>
  <div class="bg-white banner-top">
    <div class="p-0 p-35">
      <div class="banner-top__wrap d-flex flex-column flex-md-row">
        <template v-for="(item, key) of banner">
          <div
            :key="key"
            class="banner-top__item"
          >
            <a
              :key="key"
              :href="item.link"
              target="_blank"
              :atl="item.title"
            >
              <b-img
                :src="item.attachment"
                :alt="item.title"
              />
            </a>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    banner: {
      type: Array,
      required: true,
      default: () => []
    }
  },
}
</script>

<style lang="scss" scoped>
@media (max-width: 767px) {
  .banner-top__wrap  {
    .banner-top__item {
      img {
        max-height: 70px;
      }
    }
  }
}
</style>
