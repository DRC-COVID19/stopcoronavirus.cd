import moment from 'moment';
import { data } from 'jquery';
import { ADMIN_DASHBOARD, AGENT_HOSPITAL, ADMIN_HOSPITAL } from '../../config/env';
import {event} from 'vue-analytics';

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
      let dashboardRole = payload.user.roles.find(x => x.name == ADMIN_DASHBOARD);
      let hospitalRole = payload.user.roles.find(x => x.name == AGENT_HOSPITAL);
      let adminHospitalRole = payload.user.roles.find(x => x.name == ADMIN_HOSPITAL);
      if (dashboardRole) {
        state.userRole.push(ADMIN_DASHBOARD);
      }
      if (hospitalRole) {
        state.userRole.push(AGENT_HOSPITAL);
      }
      if (adminHospitalRole) {
        state.userRole.push(ADMIN_HOSPITAL);
      }
      localStorage.setItem('dashboard_access_role', state.userRole);
      if (payload.token) {
        localStorage.setItem('dashboard_access_token', payload.token);
        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + payload.token;
      }
      event('User', 'login', 'state request', "login success");
    },
    loginFail(state) {
      state.isAuthenticating = false;
      state.authError = true;
      event('User', 'login', 'state request', "login failed");
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
      event('User', 'logout', 'state request', "logout success");
    }
  },
  actions: {
    logUserIn({ commit, rootState }, payload) {
      commit('authenticating');
      return new Promise((resolve, reject) => {
        axios.post('/api/dashboard/auth/login', {
          email: payload.email,
          password: payload.password
        }).then(({ data }) => {
          commit('loginSuccess', data);
          resolve(data);
        }).catch((error) => {
          commit('loginFail', error.response);
          reject(error.response)
        });
      });
    },
    userMe({ commit, state }) {
      return new Promise((resolve, reject) => {
        axios.post('/api/dashboard/auth/me', {})
          .then(({ data }) => {
            state.user = data;
            let dashboardRole = data.roles.find(x => x.name == ADMIN_DASHBOARD);
            let hospitalRole = data.roles.find(x => x.name == AGENT_HOSPITAL);
            let adminHospitalRole = data.roles.find(x => x.name == ADMIN_HOSPITAL);
            if (dashboardRole) {
              state.userRole.push(ADMIN_DASHBOARD);
            }
            if (hospitalRole) {
              state.userRole.push(AGENT_HOSPITAL);
            }
            if (adminHospitalRole) {
              state.userRole.push(ADMIN_HOSPITAL);
            }
            localStorage.setItem('dashboard_access_role', state.userRole);
            resolve(data);
          })
          .catch(error => {
            reject(error);
          });
      });
    },
    logout({ commit, state }) {
      state.isLogout = true;
      event('User', 'logout', 'state request', "send");

      return new Promise((resolve, reject) => {
        axios.post('/api/dashboard/auth/logout', {}).then(() => {
          commit('logoutSuccess');
          resolve();
          commit('setHospitalManagerName', null, { root: true })
        }).finally(() => {
          state.isLogout = false;
        })
      });
    }
  },
  getters: {
    getUser: state => {
      return state.user;
    },
  }
};
