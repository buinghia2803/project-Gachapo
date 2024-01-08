import { SET_LOADING, SET_IS_PC, SET_IS_ACTIVE_SIDEBAR } from '~/constants/mutation-types'

export const state = () => ({
  loading: false,
  isPC: true,
  isActiveSidebar: true
})

export const mutations = {
  [SET_LOADING]: (state, payload) => {
    state.loading = payload
  },
  [SET_IS_PC]: (state, payload) => {
    state.isPC = payload
  },
  [SET_IS_ACTIVE_SIDEBAR]: (state, payload) => {
    state.isActiveSidebar = payload
  }
}
export const getters = {
  loading: state => state.loading,
  isPC: state => state.isPC,
  isActiveSidebar: state => state.isActiveSidebar
}

export const actions = {
  /**
   * Set loading global
   *
   * @param {Function} commit
   * @param {Boolean} payload
   */
  setLoading({ commit }, payload) {
    commit(SET_LOADING, payload)
  },

  /**
   * Set loading global
   *
   * @param {Function} commit
   * @param {Boolean} payload
   */
  setActiveSidebar({ commit }, payload) {
    commit(SET_IS_ACTIVE_SIDEBAR, payload)
  }
}
