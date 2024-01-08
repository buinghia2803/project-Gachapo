import {
  SET_MODEL,
  SET_LIST,
  SET_CHECKED,
  SET_CHECKED_ALL
} from '~/constants/mutation-types'

import { PAGE_SIZES, SORT_TYPE } from '~/constants'

export default class {
  constructor(modelType) {
    this.state = {
      model: {},
      list: [],
      selected: []
    }

    this.mutations = {
      [SET_LIST]: (state, payload) => {
        state.list = payload
      },
      [SET_MODEL]: (state, payload) => {
        state.model = payload
      },
      [SET_CHECKED]: (state, payload) => {
        const newData = state.list.map(item => {
          if (item.id === payload.item.id) {
            item.isSelected = payload.state
          }

          return item
        })

        state.selected = newData.filter(item => item.isSelected)
      },

      [SET_CHECKED_ALL]: (state, payload) => {
        state.list.forEach(item => {
          item.isSelected = payload.state
        })

        const selectedItems = state.list.filter(item => item.isSelected)
        state.selected = selectedItems
      }
    }

    this.getters = {
      /**
       * Get state selected
       * @param {Function} state
       * @returns {Array} selected items
       */
      getSelected: state => {
        return state.selected
      },

      /**
       * Get state selected
       * @param {Function} state
       * @returns {Array} selected items
       */
      getList: state => {
        return state.list
      },

      /**
       * Is selected all items
       * @param {Function} state
       * @returns {Boolean}
       */
      isSelectedAll: state => {
        if (state.selected && !state.selected.length) {
          return false
        }
        return state.selected.length === state.list.length
      }
    }

    this.actions = {
      /**
       * Get list model
       *
       * @param {Function} commit
       * @param {Array} payload
       * @return {Array} model list
       */
      async getList({ commit }, payload) {
        let params = {}
        if (payload && payload.params) {
          params = {
            ...payload.params,
            limit: payload.params.limit || PAGE_SIZES[2],
            page: payload.params.page || 1,
            sort: payload.params.sort || null,
            sortType: payload.params.sortType || SORT_TYPE.DESC
          }
        }
        const { data: { result } } = await this.$relipa[`index${modelType}`]({ params })

        const initials = result.data

        commit(SET_LIST, initials)

        return result || []
      },

      /**
       * Get model detail
       *
       * @param {Function} commit
       * @param {Object} payload
       * @return {Object} model detail
       */
      async getModel({ commit }, { id }) {
        let model = {}

        if (id && +id != 0) {
          const { data: { result } } = await this.$relipa[`show${modelType}`]({ id })

          model = result.data
        }

        commit(SET_MODEL, model)
        return model
      },

      /**
       * Create/Update model
       *
       * @param {Function} commit
       * @param {Object} payload
       * @return {Object} model detail
       */
      async saveModel({ commit }, payload) {
        try {
          let properties = []

          // if (payload instanceof User) {
          properties = Object.keys(payload)
          // }

          // Prepair form data
          const form = this.$util.getFormData(payload, properties)

          const { data: { result: { data: model } } } = payload.id ? await this.$relipa[`update${modelType}`](form) : await this.$relipa[`store${modelType}`](form)

          commit(SET_MODEL, model)

          return model
        } catch (err) {
          console.error(err)
          throw err
        }
      },

      /**
       * Set checked each item in table
       * @param {Function} commit
       * @param {*} payload
       */
      setChecked({ commit }, payload) {
        commit(SET_CHECKED, payload)
      },

      /**
       * Set checked all item in table
       * @param {Function} commit
       * @param {*} payload
       */
      setCheckedAll({ commit }, payload) {
        commit(SET_CHECKED_ALL, payload)
      }
    }
  }
}
