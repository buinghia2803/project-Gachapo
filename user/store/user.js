import BaseStore from './base-store'

export const user = {
  id: null,
  first_name: null,
  last_name: null,
  email: null,
  password: null,
  employee_code: null,
  employee_type: null,
  leader_id: null,
  started_working_at: null,
  allowance: null,
}
const base = new BaseStore('User')

export const state = () => {
  // Inherit from base store
  base.state
}
export const getters = {
  // Inherit from base store
  ...base.getters
}
export const actions = {
  // Inherit from base store
  ...base.actions,
}
export const mutations = {
  // Inherit from base store
  ...base.mutations
}
