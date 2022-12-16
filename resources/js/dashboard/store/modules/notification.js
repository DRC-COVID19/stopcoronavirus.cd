export default {
  state: {
    notifications: [],
    notificationData: [],
    notificationNotRead: [],
    notificationRead: {},
    isCreated: false,
    isLoading: false,
  },
  mutations: {
    SET_NOTIFICATIONS(state, payload) {
      state.notifications = payload;
    },
    SET_NOTIFICATION_DATA(state, payload) {
      state.notificationData = payload;
    },
    SET_NOTIFICATION_NOT_READ(state, payload) {
      state.notificationNotRead = payload;
    },
    SET_NOTIFICATION_READ(state, payload) {
      state.notificationRead = payload;
    },
    SET_NOTIFICATION_CREATED(state, payload) {
      state.isCreated = payload;
    },

    SET_IS_LOADING(state, payload) {
      state.isLoading = payload;
    },
  },
  actions: {
    notificationCreated({ commit }) {
      commit('SET_NOTIFICATION_CREATED', true);
    },
    notificationHospital({ commit }, payload) {
      commit('SET_IS_LOADING', true);
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/dashboard/notifications/${payload.id}`)
          .then(({ data }) => {
            commit('SET_NOTIFICATIONS', data);
            resolve(data);
            commit('SET_IS_LOADING', false);
          })
          .catch((error) => {
            reject(error);
          })
          .finally(() => {
            commit('SET_IS_LOADING', false);
          });
      });
    },
    getnotificationNotRead({ commit }, payload) {
      commit('SET_IS_LOADING', true);
      return new Promise((resolve, reject) => {
        axios
          .get(
            `/api/dashboard/notifications/notification-not-read/${payload.id}`
          )
          .then(({ data }) => {
            commit('SET_NOTIFICATION_NOT_READ', data);
            resolve(data);
            commit('SET_IS_LOADING', false);
          })
          .catch((error) => {
            reject(error);
          })
          .finally(() => {
            commit('SET_IS_LOADING', false);
          });
      });
    },
    setNotification({ commit }, payload) {
      commit('SET_IS_LOADING', true);
      return new Promise((resolve, reject) => {
        axios
          .get(
            `/api/dashboard/notifications/set-notification-by-hospital/${payload.id}`
          )
          .then(({ data }) => {
            commit('SET_NOTIFICATION_READ', data);
            resolve(data);
            commit('SET_IS_LOADING', false);
          })
          .catch((error) => {
            reject(error);
          })
          .finally(() => {
            commit('SET_IS_LOADING', false);
          });
      });
    },

    getNotificationByPaginate({ state, commit }, payload = {}) {
      commit('SET_IS_LOADING', true);

      return new Promise((resolve, reject) => {
        axios
          .get(`/api/dashboard/notifications/by-paginate/${payload.id}`, {
            params: { page: payload.page },
          })
          .then(({ data }) => {
            commit('SET_NOTIFICATION_DATA', data);
            resolve(data);
            commit('SET_IS_LOADING', false);
          })
          .catch((response) => {
            reject(response);
          })
          .finally(() => {
            commit('SET_IS_LOADING', false);
          });
      });
    },
  },
};
