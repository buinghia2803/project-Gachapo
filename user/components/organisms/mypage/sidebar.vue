<template>
  <div class="mypage__left">
    <b-button
      v-b-toggle.collapse-menu
      class="mypage__left-title text-center"
    >
      <b-icon-chevron-left />{{ title }}
    </b-button>
    <b-collapse
      id="collapse-menu"
      class="m-0"
    >
      <div class="mypage__left-label text-center">
        通知
      </div>
      <ul class="mypage__left-nav">
        <li :class="classActive == 'dashboard' ? 'active' : ''">
          <b-link
            href="/users/mypage"
            title=""
          >
            ダッシュボード<b-icon-caret-right-fill class="hidden-pc" />
          </b-link>
        </li>
        <li :class="classActive == 'notify' ? 'active' : ''">
          <b-link
            href="/users/mypage/notify"
            title=""
          >
            お知らせ<b-icon-caret-right-fill class="hidden-pc" />
          </b-link>
        </li>
        <li :class="classActive == 'history' ? 'active' : ''">
          <b-link
            href="/users/mypage/history"
            title=""
          >
            閲覧履歴<b-icon-caret-right-fill class="hidden-pc" />
          </b-link>
        </li>
        <li :class="classActive == 'list-order' ? 'active' : ''">
          <b-link
            href="/users/mypage/list-order"
            title=""
          >
            購入履歴・レビューを書く<b-icon-caret-right-fill class="hidden-pc" />
          </b-link>
        </li>
        <li>
          <b-link
            href="#"
            title=""
          >
            発送状況確認<b-icon-caret-right-fill class="hidden-pc" />
          </b-link>
        </li>
        <li :class="classActive == 'profile' ? 'active' : ''">
          <b-link
            href="/users/mypage/profile"
            title=""
          >
            登録内容変更<b-icon-caret-right-fill class="hidden-pc" />
          </b-link>
        </li>
        <li :class="classActive == 'favorites' ? 'active' : ''">
          <b-link
            href="/users/mypage/favorites"
            title=""
          >
            お気に入りリスト<b-icon-caret-right-fill class="hidden-pc" />
          </b-link>
        </li>
        <li>
          <div @click="logout()">
            ログアウト<b-icon-caret-right-fill class="hidden-pc" />
          </div>
        </li>
      </ul>
    </b-collapse>
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {
  name: "Sidebar",

  props: {
    title: {
      type: String,
      required: false,
      default: ''
    },

    classActive: {
      type: String,
      required: false,
      default: ''
    },
  },

  computed: {
    ...mapState({loading: 'loading'})
  },

  methods: {
    /**
     * logout user
     */
    async logout(){
      this.$store.dispatch('setLoading', true)
      await this.$auth.logout()
      this.$cookies.remove('refresh_token')
      this.$store.dispatch('setLoading', false)
      this.$router.push('/login')
    }
  }
}
</script>

<style scoped>

</style>
