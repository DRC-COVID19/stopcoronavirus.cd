import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import flux from './modules/flux';
import hospital from './modules/hospital';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {

    },
    mutations: {

    },
    modules: {
        auth,
        flux,
        hospital
    }
});