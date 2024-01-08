<template>
  <div class="page-search pt-5 pb-5">
    <b-container class="p-35">
      <div class="page-content">
        <div class="s-sidebar">
          <b-button
            v-b-toggle.collapse-1
            class="full s-sidebar__title"
          >
            検索
            <b-icon-chevron-down class="icon-chevron-down" />
          </b-button>
          <b-collapse
            id="collapse-1"
            class="m-0 box-filter"
          >
            <b-form-checkbox
              id="checkbox-all"
              name="checkbox-all"
              class="mb-2"
            >
              <b>すべて</b>
            </b-form-checkbox>
            <b-form-group
              class="mb-0"
              label="カテゴリ別"
              v-slot="{ ariaDescribedby }"
            >
              <b-form-checkbox-group
                id="checkbox-group-category"
                :aria-describedby="ariaDescribedby"
                name="flavour-1"
              >
                <b-form-checkbox value="キャラクター・コンテンツ">
                  キャラクター・コンテンツ
                </b-form-checkbox>
                <b-form-checkbox value="ミュージシャン">
                  ミュージシャン
                </b-form-checkbox>
                <b-form-checkbox value="アイドル">
                  アイドル
                </b-form-checkbox>
                <b-form-checkbox value="タレント">
                  タレント
                </b-form-checkbox>
                <b-form-checkbox value="アニメ">
                  アニメ
                </b-form-checkbox>
                <b-form-checkbox value="ホビー">
                  ホビー
                </b-form-checkbox>
                <b-form-checkbox value="その他">
                  その他
                </b-form-checkbox>
              </b-form-checkbox-group>
            </b-form-group>
            <b-form-group
              label="価格別"
              v-slot="{ ariaDescribedby }"
            >
              <b-form-checkbox-group
                id="checkbox-group-price"
                :aria-describedby="ariaDescribedby"
                name="flavour-1"
              >
                <b-form-checkbox value="0~1000">
                  0~1000円
                </b-form-checkbox>
                <b-form-checkbox value="1001~2500">
                  1001~2500円
                </b-form-checkbox>
                <b-form-checkbox value="2501~5000">
                  2501円~5000円
                </b-form-checkbox>
                <b-form-checkbox value="5001~10000">
                  5001~10000円
                </b-form-checkbox>
                <b-form-checkbox value="10001~">
                  10001円~
                </b-form-checkbox>
              </b-form-checkbox-group>
            </b-form-group>
            <b-button class="btn btn-search btn-white border-grey text-black small">
              検索
            </b-button>
          </b-collapse>
        </div>
        <div class="s-content bg-white">
          <h2 class="title-block">
            ○○○○○の検索結果
          </h2>
          <div class="gacha__list">
            <ItemGacha />
            <ItemGacha />
            <ItemGacha />
            <ItemGacha />
            <ItemGacha />
            <ItemGacha />
            <ItemGacha />
            <ItemGacha />
            <ItemGacha />
            <ItemGacha />
          </div>
        </div>
      </div>
    </b-container>
  </div>
</template>
<script>
  import ItemGacha from '~/components/organisms/ItemGacha'
  // import BoxFilter from '~/components/organisms/BoxFilter'
  export default {
    components: {
      ItemGacha,
      // BoxFilter
    },
  }
</script>

<style lang="scss" scoped>
</style>
