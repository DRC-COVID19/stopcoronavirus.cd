import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import flux from './modules/flux';
import hospital from './modules/hospital';
import nav from './modules/nav';
import epidemic from './modules/epidemic';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {

    },
    mutations: {

    },
    modules: {
        auth,
        flux,
        hospital,
        nav,
        epidemic
    }
});