import Vue from 'vue';
import Meta from 'vue-meta';
import BootstrapVue from 'bootstrap-vue';
import onlyInt from 'vue-input-only-number';
import store from './store';
import router from './config/router';
import commont from './mixins/common';
import VueLazyLoad from 'vue-lazyload';
import vSelect from 'vue-select';
import App from "./App.vue";
import GlobalComponents from './globalComponents'
import { ADMIN_DASHBOARD, AGENT_HOSPITAL } from './config/env';
import "chartjs-plugin-crosshair";

require('./helper');

Vue.use(BootstrapVue);
Vue.use(Meta);
Vue.use(VueLazyLoad);
Vue.component('v-select', vSelect);
Vue.mixin(commont);
Vue.use(GlobalComponents);
Vue.use(onlyInt);

if (store.state.auth.isAuthenticated ) {
    store.dispatch('userMe');
}

router.beforeEach((to, from, next) => {
    if (to.matched.some(route => route.meta.requiresAuth) && (!store.state.auth.isAuthenticated || !store.state.auth.userRole)) {

        next({ name: 'login' });
        return
    }

    // if logged in redirect to dashboard
    if (to.name === 'login' && store.state.auth.isAuthenticated && store.state.auth.userRole) {
        switch (store.state.auth.userRole) {
            case ADMIN_DASHBOARD:
                next({ name: 'home' });
                break;
            case AGENT_HOSPITAL:
                next({ name: 'hospital.home' });
                break;
            default:
                next({ name: 'acces.denied' });
                break;
        }
        return
    }


    if (to.meta.role  && !to.meta.role.includes(store.state.auth.userRole) && to.name != "acces.denied") {
        next({ name: 'acces.denied' });
        return
    }

    next()
});

const app = new Vue({
    el: '#app',
    render: h => h(App),
    store,
    router
});
export default app;