<template>
  <div class="layout__blank">
    <div class="__header ___header-blank">
      <TheHeaderBlank />
    </div>
    <div class="__wrapper">
      <Nuxt />
    </div>
    <div class="__footer">
      <TheFooter />
    </div>
  </div>
</template>

<script>
import TheHeaderBlank from '~/components/organisms/TheHeaderBlank'
import TheFooter from '~/components/organisms/TheFooter'
export default {
  components: {
    TheHeaderBlank,
    TheFooter
  },

  middleware: ['auth']
}
</script>
<style lang="scss" scoped>
.layout__container {
  &.ant-layout {
    height: 100vh;
  }
}
</style>
