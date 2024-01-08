<template>
  <div>
    <b-form-checkbox
      name="checkbox-all"
      class="mb-2"
      @change="toggleAllCategory"
    >
      <b>すべて</b>
    </b-form-checkbox>
    <b-form-group
      class="mb-0"
      label="カテゴリ別"
    >
      <b-form-checkbox-group
        name="checkbox-group-category"
      >
        <b-form-checkbox-group
          v-model="selectedCategory"
          :key="JSON.stringify(selectedCategory)"
          value-field="id"
          text-field="name"
          :options="categories"
          class="__option_category"
          name="radio-options"
        />
      </b-form-checkbox-group>
    </b-form-group>
    <b-form-group label="価格別">
      <b-form-checkbox-group
        v-model="selectedPrice"
        value-field="value"
        text-field="name"
        :options="PRICE_TYPES"
        class="__option_price"
        name="radio-options"
      />
    </b-form-group>
    <b-button
      @click="doSearch"
      class="btn btn-search btn-white border-grey text-black small"
    >
      {{ $t('common.search') }}
    </b-button>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
const PRICE_TYPES = [
  { id: 1, name: "0~1000円" , value: 1},
  { id: 2, name: "1001~2500円" , value: 2},
  { id: 3, name: "2501円~5000円" , value: 3},
  { id: 4, name: "5001~10000円" , value: 4},
  { id: 5, name: "10001円~" , value: 5},
]
const EVENT_FILTER = 'filter'

export default {
  name: "BoxFilter",

  data() {
    return {
      PRICE_TYPES,
      selectedCategory: [],
      selectedPrice: []
    }
  },

  computed: {
    ...mapGetters({
      categories: 'home/getCategories'
    })
  },

  methods: {
    /**
     * Checking all category
     */
    toggleAllCategory(checked) {
      for (const item of this.categories) {
        item.disabled = checked
      }
      this.selectedCategory = checked ? this.categories.map(item => item.id) : []
    },

    /**
     * Do search
     */
    doSearch() {
      this.$emit(EVENT_FILTER, { category_ids: this.selectedCategory, price_types: this.selectedPrice })
    }
  }
}
</script>

<style lang="scss" scoped>
.__option_price {
  font-weight: 700;
}
.__option_category {
  .custom-control-label {
    span {
      font-weight: 100;
    }
  }
}
</style>
