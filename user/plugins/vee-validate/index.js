/**
 * Vee-validate
 * https://vee-validate.logaretm.com/v3/overview.html#getting-started
 */
 import Vue from 'vue'
 import { ValidationObserver, ValidationProvider, extend } from 'vee-validate'
//  import * as rules from 'vee-validate/dist/rules'
 import { CustomRules } from './custom-rules'

//  Object.keys(rules).forEach(rule => {
//    extend(rule, {
//      ...rules[rule], // copies rule configuration
//    })
//  })
 Object.keys(CustomRules).forEach(rule => {
  extend(rule, {
     ...CustomRules[rule]
   })
 })


 // Register it globally
 Vue.component('ValidationObserver', ValidationObserver)
 Vue.component('ValidationProvider', ValidationProvider)

 export default (context, inject) => {
   inject('validator', ValidationProvider)
 }
