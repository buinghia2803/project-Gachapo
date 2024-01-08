const SET_CATEGORY = 'SET_CATEGORY'
const SET_CONDITION = 'SET_CONDITION'
const SET_STATIC_PAGE = 'SET_STATIC_PAGE'


export const state = () => ({
    categories: [],
    conditions: {},
    staticPage: []
  })

export const getters = {
  /**
   * Get state category
   * @param {Function} state
   * @returns {Array} selected items
   */
  getCategories: state => {
    return state.categories
  },

  /**
   * Get state category
   * @param {Function} state
   * @returns {Array} selected items
   */
  getConditions: state => {
    return state.conditions
  },
  /**
   * Get state category
   * @param {Function} state
   * @returns {Array} selected items
   */
  getStaticPage: state => {
    return state.staticPage
  },
}

export const actions = {
  async getCategories({ commit }, payload) {
    let result = []
    const res = await this.$relipa.getListOfSearchTerms()
    if(res && res.data) {
      result = res.data
    }

    commit(SET_CATEGORY, result)

    return result || []
  },

  /**
   * Set conditions
   * @param {Function} commit
   * @param {object} payload
   */
  setConditions({ commit }, payload) {
    commit(SET_CONDITION, payload)
  },

  /**
   * Set static pages
   * @param {Function} commit
   * @param {object} payload
   */
  setStaticPage({ commit }, payload) {
    commit(SET_STATIC_PAGE, payload)
  }
}

export const mutations = {
  [SET_CATEGORY]: (state, payload) => {
    state.categories = payload
  },

  [SET_CONDITION]: (state, payload) => {
    state.conditions = payload
  },

  [SET_STATIC_PAGE]: (state, payload) => {
    state.staticPage = payload
  },
}
