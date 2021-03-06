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
import { GOOGLE_ANALYTICS_ID } from './config/env';
import GlobalComponents from './globalComponents'
import { ADMIN_DASHBOARD, AGENT_HOSPITAL, ADMIN_HOSPITAL } from './config/env';
import "chartjs-plugin-crosshair";
import fullscreen from 'vue-fullscreen';
import VueEllipseProgress from "vue-ellipse-progress";
// import VueSkeletonLoading from 'vue-skeleton-loading';
import VueGtag from "vue-gtag";
import VueMq from 'vue-mq';
import VueTimeline from "@growthbunker/vuetimeline";
import Notifications from 'vue-notification';

import './directive';
require('./helper');

Vue.use(BootstrapVue);
Vue.use(Meta);
Vue.use(VueLazyLoad);
Vue.component('v-select', vSelect);
Vue.mixin(commont);
Vue.use(GlobalComponents);
Vue.use(onlyInt);
Vue.use(fullscreen);
Vue.use(VueEllipseProgress);
// Vue.use(VueSkeletonLoading);
Vue.use(Notifications);

Vue.use(VueTimeline, {
  theme: "light",
});

Vue.use(VueMq, {
  breakpoints: {
    sm: 768,
    md: 1024,
    lg: Infinity
  }
});


if (store.state.auth.isAuthenticated) {
  store.dispatch('userMe').catch(error => {

  });
}

store.dispatch('loadSource');

router.beforeEach((to, from, next) => {
  if (to.matched.some(route => route.meta.requiresAuth) && (!store.state.auth.isAuthenticated || !store.state.auth.userRole)) {
    next({ name: 'login' });
    return
  }

  // if logged in redirect to dashboard
  if (to.name === 'login' && store.state.auth.isAuthenticated && store.state.auth.userRole) {
    next({ name: 'landing' });
    return
  }
  if (to.meta.role && !to.meta.role.some(x => store.state.auth.userRole.includes(x)) && to.name != "acces.denied") {
    next({ name: 'acces.denied' });
    return
  }

  next()
});

Vue.use(VueGtag, {
  config: {
    id: GOOGLE_ANALYTICS_ID,
    pageTrackerScreenviewEnabled: true
  }
}, router);

const app = new Vue({
  el: '#app',
  render: h => h(App),
  store,
  router
});
export default app;
