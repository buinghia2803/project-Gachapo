<template>
  <div :class="[`data__item data__content`]">
    <div class="dt-td-images" />
    <div class="dt-td-name">
      <div :class="`text-overflow-ellipsis row-2`">
        <h5>
          <b-icon
            icon="exclamation-circle-fill"
            variant="dark"
          />{{ $t('common.no_data') }}
        </h5>
      </div>
    </div>
    <div
      class="dt-td-status hidden-sp"
    />
    <div
      class="dt-td-action hidden-sp d-md-flex flex-column justify-content-center"
    />
  </div>
</template>
<style scoped lang="scss">
.text-overflow-ellipsis{
  text-align: center !important;
}
</style>