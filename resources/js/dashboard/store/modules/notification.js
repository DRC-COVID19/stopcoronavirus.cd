export default {
  state: {
    notifications: [],
    notificationData: [],
    isLoading: false
  },
  mutations: {
    SET_NOTIFICATIONS (state, payload) {
      state.notifications = payload
    },
    SET_NOTIFICATION_DATA (state, payload) {
      state.notificationData = payload
    },
    SET_IS_LOADING (state, payload) {
      state.isLoading = payload
    }
  },
  actions: {
    notificationHospital ({ commit }, payload) {
      commit('SET_IS_LOADING', true)
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/dashboard/notifications/${payload.id}`)
          .then(({ data }) => {
            commit('SET_NOTIFICATIONS', data)
            resolve(data)
            commit('SET_IS_LOADING', false)
          })
          .catch((error) => {
            reject(error)
          })
          .finally(() => {
            commit('SET_IS_LOADING', false)
          })
      })
    },

    getNotificationByPaginate ({ state, commit }, payload = {}) {
      commit('SET_IS_LOADING', true)

      return new Promise((resolve, reject) => {
        axios
          .get(`/api/dashboard/notifications/by-paginate/${payload.id}`, {
            params: { page: payload.page }
          })
          .then(({ data }) => {
            commit('SET_NOTIFICATION_DATA', data)
            resolve(data)
            commit('SET_IS_LOADING', false)
          })
          .catch((response) => {
            reject(response)
          })
          .finally(() => {
            commit('SET_IS_LOADING', false)
          })
      })
    }

  }
}
