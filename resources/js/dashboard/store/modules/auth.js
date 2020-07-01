import moment from 'moment';
import { data } from 'jquery';
import { ADMIN_DASHBOARD, AGENT_HOSPITAL } from '../../config/env';

export default {
    state: {
        user: {},
        isAuthenticating: false,
        isAuthenticated: !!localStorage.getItem('dashboard_access_token'),
        userRole: localStorage.getItem('dashboard_access_role'),
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
            if (dashboardRole) {
                localStorage.setItem('dashboard_access_role', ADMIN_DASHBOARD);
                state.userRole = ADMIN_DASHBOARD;
            }
            else if (hospitalRole) {
                localStorage.setItem('dashboard_access_role', AGENT_HOSPITAL);
                state.userRole = AGENT_HOSPITAL;
            }
            if (payload.token) {
                localStorage.setItem('dashboard_access_token', payload.token);
                window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + payload.token;
            }
        },
        loginFail(state) {
            state.isAuthenticating = false;
            state.authError = true;
        },
        authenticating(state) {
            state.isAuthenticating = true;
            state.authError = false;
        },
        logoutSuccess(state) {
            state.isAuthenticated = false;
            state.userRole = null;
            state.user = null;
            localStorage.removeItem('dashboard_access_token');
            localStorage.removeItem('dashboard_access_role');
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
                        if (dashboardRole) {
                            localStorage.setItem('dashboard_access_role', ADMIN_DASHBOARD);
                            state.userRole = ADMIN_DASHBOARD;
                        }
                        else if (hospitalRole) {
                            localStorage.setItem('dashboard_access_role', AGENT_HOSPITAL);
                            state.userRole = AGENT_HOSPITAL;
                        }
                        resolve(data);
                    });
            });
        },
        logout({ commit, state }) {
            state.isLogout = true;
            return new Promise((resolve, reject) => {
                axios.post('/api/dashboard/auth/logout', {}).then(() => {
                    commit('logoutSuccess');
                    resolve();
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