import Vue from 'vue'
import Vuex from 'vuex'
import auth from './modules/auth'
import flux from './modules/flux'
import hospital from './modules/hospital'
import nav from './modules/nav'
import epidemic from './modules/epidemic'
import indicator from './modules/indicator'
import app from './modules/app'
import changeLog from './modules/changeLog'
import form from './modules/form'
import formFieldType from './modules/formFieldType'
import formField from './modules/formField'
import formStep from './modules/formStep'
import hospitalSituation from './modules/hospitalSituation'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {},
  mutations: {},
  modules: {
    app,
    auth,
    flux,
    hospital,
    nav,
    epidemic,
    indicator,
    changeLog,
    form,
    formFieldType,
    formField,
    formStep,
    hospitalSituation
  }
})
