import moment from 'moment';

export default {
    state: {
        user: {},
        isAuthenticating: false,
        isAuthenticated: !!localStorage.getItem('dashboard_access_token'),
        authError: false,
        lastAuthCheck: null
    },
    mutations: {
        loginSuccess(state, payload) {
            state.isAuthenticated = true;
            state.isAuthenticating = false;
            state.user = payload.user;
            state.authElocalStoragerror = false;
            state.lastAuthCheck = moment(new Date()).toISOString();
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
            state.user = null;
            localStorage.removeItem('dashboard_access_token');
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
                    resolve();
                }).catch(error => {
                    commit('loginFail', error);
                });
            });
        },
        userMe({ commit, state }) {
            return new Promise((resolve, reject) => {
                axios.post('/api/dashboard/auth/me', {})
                    .then((data) => {
                        state.user = data.user;
                        resolve();
                    });
            });
        },
        logout({ commit }) {
            return new Promise((resolve, reject) => {
                axios.post('/api/dashboard/auth/logout', {}).then(() => {
                    commit('logoutSuccess');
                    resolve();
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