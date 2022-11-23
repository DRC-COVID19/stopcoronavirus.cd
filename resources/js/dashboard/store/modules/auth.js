import moment from 'moment';
import { event } from 'vue-gtag';

export default {
  state: {
    user: {},
    isAuthenticating: false,
    isAuthenticated: !!localStorage.getItem('dashboard_access_token'),
    userRole: localStorage.getItem('dashboard_access_role')?.split(',') ?? [],
    authError: false,
    lastAuthCheck: null,
    isLogout: false,
  },
  mutations: {
    loginSuccess(state, payload) {
      state.isAuthenticated = true;
      state.isAuthenticating = false;
      state.user = payload.user;
      state.authElocalStoragerror = false;
      state.lastAuthCheck = moment(new Date()).toISOString();

      payload.user.roles.forEach((element) => {
        state.userRole.push(element.name);
      });

      localStorage.setItem('dashboard_access_role', state.userRole);
      if (payload.token) {
        localStorage.setItem('dashboard_access_token', payload.token);
        window.axios.defaults.headers.common['Authorization'] =
          'Bearer ' + payload.token;
      }

      event('login', {
        event_category: 'user_authentification',
        event_label: 'login_sucess',
      });
    },
    loginFail(state) {
      state.isAuthenticating = false;
      state.authError = true;
      event('login', {
        event_category: 'user_authentification',
        event_label: 'login_failed',
      });
    },
    authenticating(state) {
      state.isAuthenticating = true;
      state.authError = false;
    },
    logoutSuccess(state) {
      state.isAuthenticated = false;
      state.userRole = [];
      state.user = null;
      localStorage.removeItem('dashboard_access_token');
      localStorage.removeItem('dashboard_access_role');

      event('logout', {
        event_category: 'user_authentification',
        event_label: 'logout_sucess',
      });
    },
  },
  actions: {
    logUserIn({ commit, rootState }, payload) {
      commit('authenticating');
      return new Promise((resolve, reject) => {
        axios
          .post('/api/dashboard/auth/login', {
            email: payload.email,
            password: payload.password,
          })
          .then(({ data }) => {
            commit('loginSuccess', data);
            resolve(data);
          })
          .catch((error) => {
            commit('loginFail', error.response);
            reject(error.response);
          });
      });
    },
    userMe({ commit, state }) {
      return new Promise((resolve, reject) => {
        axios
          .post('/api/dashboard/auth/me', {})
          .then(({ data }) => {
            state.user = data;
            data.roles.forEach((element) => {
              state.userRole.push(element.name);
            });
            localStorage.setItem('dashboard_access_role', state.userRole);
            resolve(data);
          })
          .catch((error) => {
            reject(error);
          });
      });
    },
    logout({ commit, state }) {
      state.isLogout = true;

      event('logout', {
        event_category: 'user_authentification',
        event_label: 'logout_send',
      });

      return new Promise((resolve, reject) => {
        axios
          .post('/api/dashboard/auth/logout', {})
          .then(() => {
            commit('logoutSuccess');
            resolve();
            commit('setHospitalManagerName', null, { root: true });
          })
          .finally(() => {
            state.isLogout = false;
          });
      });
    },
  },
  getters: {
    getUser: (state) => {
      return state.user;
    },
  },
};
