export default {
  state: {
    notifications: [],
    isLoading: false
  },
  mutations: {
    SET_NOTIFICATIONS (state, payload) {
      state.notifications = payload
    }
  },
  actions: {
    notificationHospital ({ commit }, payload) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/dashboard/notifications/${payload.id}`)
          .then(({ data }) => {
            commit('SET_NOTIFICATIONS', data)
            resolve(data)
          })
          .catch((error) => {
            reject(error)
          })
      })
    }
  }
}
