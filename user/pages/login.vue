<template>
  <div class="page-login pt-5 pb-5 bg-pc-white">
    <b-container class="p-35">
      <Login :title="$t('common.title_login')" />
    </b-container>
  </div>
</template>

<script>
const Login = () => import('~/components/organisms/Login')
export default {
  layout: 'default',
  components: {
    Login,
  },
}
</script>

<style lang="scss" scoped>
</style>
