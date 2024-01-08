<template>
  <div v-loading="loading">
    <b-card
      class="w-100 h-100"
    >
      <div class="call_back-inner-form text-center">
        <svg
          v-if="status && !loading"
          version="1.1"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 130.2 130.2"
        >
          <circle
            class="path circle"
            fill="none"
            stroke="#73AF55"
            stroke-width="6"
            stroke-miterlimit="10"
            cx="65.1"
            cy="65.1"
            r="62.1"
          />
          <polyline
            class="path check"
            fill="none"
            stroke="#73AF55"
            stroke-width="6"
            stroke-linecap="round"
            stroke-miterlimit="10"
            points="100.2,40.2 51.5,88.8 29.8,67.5 "
          />
        </svg>
        <!-- cancel -->
        <svg
          v-if="!status && !loading"
          version="1.1"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 130.2 130.2"
        >
          <circle
            class="path circle"
            fill="none"
            stroke="#D06079"
            stroke-width="6"
            stroke-miterlimit="10"
            cx="65.1"
            cy="65.1"
            r="62.1"
          />
          <line
            class="path line"
            fill="none"
            stroke="#D06079"
            stroke-width="6"
            stroke-linecap="round"
            stroke-miterlimit="10"
            x1="34.4"
            y1="37.9"
            x2="95.8"
            y2="92.3"
          />
          <line
            class="path line"
            fill="none"
            stroke="#D06079"
            stroke-width="6"
            stroke-linecap="round"
            stroke-miterlimit="10"
            x1="95.8"
            y1="38"
            x2="34.4"
            y2="92.2"
          />
        </svg>
        <div v-if="!loading">
          <span class="font-20">{{ status ? 'アカウント検証に成功しました' : '確認リンクの有効期限が切れています。 アカウントを再登録してください。' }}</span>
        </div>
      </div>
      <div class="mt-4 w-100 d-flex justify-content-center">
        <b-button
          class="btn btn-user-login btn-white"
        >
          <b-link
            href="/login"
          >
            {{ $t('common.login') }}
          </b-link>
        </b-button>
      </div>
    </b-card>
  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
  data() {
    return {
      status: false
    }
  },

  computed: {
    ...mapState({
      loading: 'loading'
    })
  },

  mounted() {
    this.fetch()
  },

  methods: {
    /**
     * Call API register completed.
    */
    async fetch() {
      this.$store.dispatch('setLoading', true)
      if(this.$route.query && this.$route.query.email && this.$route.query.code) {
        const response = await this.$relipa.verifyAccount({
          email: this.$route.query.email,
          code: this.$route.query.code
        })
        if (response && response.data && response.data.status) {
          this.status = response.data.status
        } else {
          this.status = false
        }
        this.$store.dispatch('setLoading', false)
      }else {
         this.status = false
         this.$store.dispatch('setLoading', false)
      }
    }
  }
}
</script>

<style lang="scss" scoped>
.btn-user-login {
  a {
    color:#F00000;
  }
}
.font-20 {
  font-size: 20px;
}
.border-none {
  border: none;
}
.height-50px {
  height: 200px;
}
svg {
  width: 60px;
  display: block;
  margin: 40px auto 10px;
}

.path {
  stroke-dasharray: 1000;
  stroke-dashoffset: 0;
  &.circle {
    -webkit-animation: dash .9s ease-in-out;
    animation: dash .9s ease-in-out;
  }
  &.line {
    stroke-dashoffset: 1000;
    -webkit-animation: dash .9s .35s ease-in-out forwards;
    animation: dash .9s .35s ease-in-out forwards;
  }
  &.check {
    stroke-dashoffset: -100;
    -webkit-animation: dash-check .9s .35s ease-in-out forwards;
    animation: dash-check .9s .35s ease-in-out forwards;
  }
}

p {
  text-align: center;
  margin: 20px 0 60px;
  font-size: 1.25em;
  &.success {
    color: #73AF55;
  }
  &.error {
    color: #D06079;
  }
}

@-webkit-keyframes dash {
  0% {
    stroke-dashoffset: 1000;
  }
  100% {
    stroke-dashoffset: 0;
  }
}

@keyframes dash {
  0% {
    stroke-dashoffset: 1000;
  }
  100% {
    stroke-dashoffset: 0;
  }
}

@-webkit-keyframes dash-check {
  0% {
    stroke-dashoffset: -100;
  }
  100% {
    stroke-dashoffset: 900;
  }
}

@keyframes dash-check {
  0% {
    stroke-dashoffset: -100;
  }
  100% {
    stroke-dashoffset: 900;
  }
}

.call_back {
  /deep/ {
    .call_back-inner-form {
      .list-group-item {
        min-height: 220px;
        font-size: 1.6rem;
        padding: 5rem 1rem;
      }
    }
  }
}
</style>