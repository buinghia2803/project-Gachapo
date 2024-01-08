<template>
  <div>
    <b-pagination-nav
      class="mt-4"
      :link-gen="linkGen"
      :number-of-pages="total"
      @change="changePage"
      use-router
    />
  </div>
</template>
<script>
export default {
  props: {
    total: {
      type: Number,
      default: 1,
      required: true,
    }
  },

  methods:{
    /**
     * link generate
     * 
     * @param Integer pageNum
     */
    linkGen(pageNum) {
      return pageNum === 1 ? '?' : `?page=${pageNum}`
    },

    /**
     * change page
     * 
     * @param Integer page
     */
    changePage(page){
      this.$emit('change-page', page)
    },

  }
}
</script>