<template>
  <div class="position-relative">
    <div class="container">
      <b-navbar
        toggleable="lg"
        type="dark"
        variant="white"
        class="d-flex flex-column flex-md-row p-0 header__top"
      >
        <b-navbar-brand
          variant="light"
          href="#"
          @click="$router.push('/')"
          class="mr-auto header__logo p-0"
        >
          Online Gacha
        </b-navbar-brand>
        <!-- Right aligned nav items -->
        <b-navbar-nav class="search-nar-bar mr-0 mr-md-3 ml-0 ml-md-3 pt-1 pt-md-0">
          <b-nav-form class="form-search">
            <b-input-group class="position-relative">
              <b-form-input
                v-model="keyword"
                :placeholder="$t('headers.search_header')"
                type="text"
                class="form-control__search"
              />
              <b-button
                variant="outline-secondary"
                class="header__btn-search position-absolute"
                @click="generateFilter"
              >
                {{ $t('common.search') }}
              </b-button>
            </b-input-group>
          </b-nav-form>
        </b-navbar-nav>
        <b-navbar-nav class="ml-0 hidden-sp">
          <div
            v-if="!$auth.loggedIn"
            class="m-0 login-footer__action d-flex align-items-center"
          >
            <b-link
              to="/login"
              class="mr-2 mr-md-3 btn btn-user-login btn-white"
            >
              {{ $t('common.login') }}
            </b-link>
            <b-link
              to="/registers/user"
              class="btn btn-user-register btn-red"
            >
              {{ $t('headers.sign_up') }}
            </b-link>
          </div>
          <div
            class="d-flex align-items-center ml-3"
            v-else
          >
            <div class="header__user-name">
              <b-link
                href="/users/mypage"
                class="text-dark "
              >
                {{ user && user.name ? user.name : '' }}
              </b-link>
            </div>
            <b-link
              href="/users/mypage/notify"
              title=""
              class="btn btn-white ml-3 w-148"
            >
              {{ $t('headers.notify') }}
            </b-link>
          </div>
        </b-navbar-nav>
      </b-navbar>

      <div class="__filters pt-2 pt-md-4 box-filter">
        <b-row>
          <b-col>
            <div class="d-flex">
              <div
                class="d-flex align-items-center"
                @click="openFilter"
              >
                <svg
                  class="pt-1"
                  xmlns="http://www.w3.org/2000/svg"
                  width="22.154"
                  height="18"
                  viewBox="0 0 22.154 18"
                >
                  <path
                    id="list-solid"
                    d="M3.462,61.846H.692A.692.692,0,0,0,0,62.538v2.769A.692.692,0,0,0,.692,66H3.462a.692.692,0,0,0,.692-.692V62.538A.692.692,0,0,0,3.462,61.846ZM3.462,48H.692A.692.692,0,0,0,0,48.692v2.769a.692.692,0,0,0,.692.692H3.462a.692.692,0,0,0,.692-.692V48.692A.692.692,0,0,0,3.462,48Zm0,6.923H.692A.692.692,0,0,0,0,55.615v2.769a.692.692,0,0,0,.692.692H3.462a.692.692,0,0,0,.692-.692V55.615A.692.692,0,0,0,3.462,54.923Zm18,7.615H7.615a.692.692,0,0,0-.692.692v1.385a.692.692,0,0,0,.692.692H21.462a.692.692,0,0,0,.692-.692V63.231A.692.692,0,0,0,21.462,62.538Zm0-13.846H7.615a.692.692,0,0,0-.692.692v1.385a.692.692,0,0,0,.692.692H21.462a.692.692,0,0,0,.692-.692V49.385A.692.692,0,0,0,21.462,48.692Zm0,6.923H7.615a.692.692,0,0,0-.692.692v1.385a.692.692,0,0,0,.692.692H21.462a.692.692,0,0,0,.692-.692V56.308A.692.692,0,0,0,21.462,55.615Z"
                    transform="translate(0 -48)"
                    fill="#f00000"
                  />
                </svg>
                <b-nav-item-dropdown
                  text="すべて"
                  ref="filter_condition"
                  class="pl-1 filter__text"
                >
                  <BoxFilter @filter="generateFilter" />
                </b-nav-item-dropdown>
              </div>
              <div
                class="d-flex align-items-center pl-4"
                @click="searchByFirstCategory"
              >
                <svg
                  class="pt-1"
                  xmlns="http://www.w3.org/2000/svg"
                  width="18"
                  height="18"
                  viewBox="0 0 18 18"
                >
                  <path
                    id="layer-group-solid"
                    d="M.434,5.2,8.623,8.911a.9.9,0,0,0,.748,0L17.561,5.2a.785.785,0,0,0,0-1.407L9.372.074a.9.9,0,0,0-.748,0L.434,3.789A.786.786,0,0,0,.434,5.2ZM17.561,8.3l-2.042-.926L9.836,9.95a2.026,2.026,0,0,1-1.678,0L2.476,7.374.434,8.3a.785.785,0,0,0,0,1.406l8.189,3.712a.9.9,0,0,0,.748,0l8.19-3.712a.785.785,0,0,0,0-1.406Zm0,4.493-2.034-.922L9.836,14.45a2.026,2.026,0,0,1-1.678,0l-5.69-2.579-2.035.922a.785.785,0,0,0,0,1.406l8.189,3.712a.9.9,0,0,0,.748,0l8.19-3.712A.785.785,0,0,0,17.561,12.793Z"
                    transform="translate(0.003 0.007)"
                    fill="#f00000"
                  />
                </svg>
                <div class="pl-1 filter__text">
                  {{ $t('headers.by_category') }}
                </div>
              </div>
            </div>
          </b-col>
          <b-col class="link-register-company">
            <div
              class="d-flex align-items-center justify-content-end"
            >
              <svg
                class="pr-1"
                xmlns="http://www.w3.org/2000/svg"
                width="16.756"
                height="18"
                viewBox="0 0 16.756 18"
              >
                <path
                  id="Path_1"
                  data-name="Path 1"
                  d="M871.378,80,863,89l8.378,9h8.378l-8.378-9,8.378-9Z"
                  transform="translate(-863 -80)"
                  fill="#0089ff"
                />
              </svg>
              <b-link
                class="to-company"
                to="/registers/company"
              >
                {{ $t('headers.register_company') }}
              </b-link>
            </div>
          </b-col>
        </b-row>
      </div>
    </div>
  </div>
</template>

<script>
import BoxFilter from '~/components/organisms/BoxFilter'
import { mapGetters } from 'vuex'
export default {
  components: {
    BoxFilter
  },

  data() {
    return {
      user: this.$auth.user,
      keyword: '',
    }
  },

  computed: {
    ...mapGetters({
      categories: 'home/getCategories'
    })
  },

  watch: {
    '$auth.user': {
      handler(val) {
        this.user = val
      }
    }
  },

  created() {
    this.prepareData()
  },

  methods: {
    /**
     * Preparse data
     */
    async prepareData() {
      if(!this.categories || (Array.isArray(this.categories) && !this.categories.length)) {
        await this.$store.dispatch('home/getCategories')
      }
    },

    /**
     * Generate filter for search
     */
    generateFilter(conds) {
      if(conds instanceof Event) {
        conds = {}
      }
      conds.keyword = this.keyword
      this.$store.dispatch('home/setConditions', conds)
      const query = this.buildPathConds(conds)
      this.$refs.filter_condition.hide()
      this.$router.push('/search' + query)
    },

    /**
     * Search with first category.
     */
    searchByFirstCategory() {
      if(Array.isArray(this.categories) && this.categories.length) {
        const firstCate = this.categories[0]
        this.$router.push('/search?categogry_ids=['+ firstCate.id +']')
      }
    },

    /**
     * Open option filter.
     */
    openFilter() {
       this.$refs.filter_condition.show()
    },

    /**
     * Build param with conditions.
     * @param {Object} conds
     */
    buildPathConds(conds) {
      let path = '?'
      for (const key in conds) {
        if (Object.hasOwnProperty.call(conds, key)) {
          if(Array.isArray(conds[key]) && conds[key].length) {
            path += key + '=' + JSON.stringify(conds[key] || '') + '&'
          } else {
            path += key + '=' +(conds[key]|| '' )+ '&'
          }
        }
      }

      return path
    },
  }
}
</script>

<style lang="scss" scoped>
.search-nar-bar {
  width: 70%;
}
.to-company {
  color: black;
}
.font-30 {
  font-size: 30px;
}
.text-dark {
  color: black;
}
/deep/ {
  .filter__text {
    .dropdown-menu {
      box-shadow: -2px 4px 13px 2px rgba(128, 128, 128, 0.452);
      // width: 75vw;
    }
  }
  .form-search {
    form {
      &.form-inline {
        width: 100%;
      }
    }
  }
}
</style>
