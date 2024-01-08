<template>
  <div class="flow-top bg-grey">
    <b-container class="p-35">
      <div class="flow-top__wrap">
        <h2 class="title-block text-center">
          遊び方
        </h2>
        <div class="flow-top__content d-flex flex-column flex-md-row justify-content-center">
          <div class="flow-top__item text-center position-relative box-shadow mt-4">
            <span>01</span>
            <b-img :src="require(`~/assets/images/flow-1.png`)" />
          </div>
          <div class="flow-top__item text-center position-relative box-shadow mt-4">
            <span>02</span>
            <b-img :src="require(`~/assets/images/flow-1.png`)" />
          </div>
          <div class="flow-top__item text-center position-relative box-shadow mt-4">
            <span>03</span>
            <b-img :src="require(`~/assets/images/flow-1.png`)" />
          </div>
        </div>
        <br class="hidden-sp" />
        <br class="hidden-sp" />
        <div class="text-center mt-4 mt-md-5">
          <b-link
            href="/search"
            class="btn btn-red btn-go-search max-w-300 btn-medium"
          >
            ガチャする
          </b-link>
        </div>
      </div>
    </b-container>
  </div>
</template>

<script>
  export default {

  }
</script>

<style lang="scss" scoped>
.btn-go-search {
  line-height: 2;
}
</style>
