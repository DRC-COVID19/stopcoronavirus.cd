import Vue from 'vue';
import Meta from 'vue-meta';
import VueRouter from 'vue-router'
import BootstrapVue from 'bootstrap-vue'
import VueLazyLoad from 'vue-lazyload';
import vSelect from 'vue-select';
import App from "./App.vue";
import router from './config/router';
import store from './store';
import commont from './mixins/common';

require('./helper');

Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(Meta);
Vue.use(VueLazyLoad);
Vue.component('v-select', vSelect);
Vue.mixin(commont);

const app=new Vue({
    el: '#app',
    render:h=>h( App ),
    store,
    router
});
export default app;