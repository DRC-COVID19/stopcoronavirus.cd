import Vue from 'vue';
import Meta from 'vue-meta';
import BootstrapVue from 'bootstrap-vue'
import store from './store';
import router from './config/router';
import commont from './mixins/common';
import VueLazyLoad from 'vue-lazyload';
import vSelect from 'vue-select';
import App from "./App.vue";

require('./helper');

Vue.use(BootstrapVue);
Vue.use(Meta);
Vue.use(VueLazyLoad);
Vue.component('v-select', vSelect);
Vue.mixin(commont);

router.beforeEach((to, from, next) => {
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.auth.isAuthenticated) {
        next({name: 'login'});
        return
    }
    // if logged in redirect to dashboard
    if (to.name === 'login' && store.state.auth.isAuthenticated) {
        next({name: 'home'});
        return
    }
    
    next()
});

const app=new Vue({
    el: '#app',
    render:h=>h( App ),
    store,
    router
});
export default app;