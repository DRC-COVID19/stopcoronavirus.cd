export default {
  state: {
    completedFormHistories: [],
    NotificationcompletedFormHistories: [],
    countConflict: 0,
    isLoading: false
  },

  mutations: {
    SET_IS_LOADING (state, payload) {
      state.isLoading = payload
    },
    SET_COMPLETED_FORMS_HISTORIES (state, payload) {
      state.completedFormHistories = payload
    },
    SET_NOTIFICATION_COMPLETED_FORM_HISTORIES (state, payload) {
      state.NotificationcompletedFormHistories = payload
    },
    SET_COUNT_CONFLICT (state, payload) {
      state.countConflict = payload
    }
  },
  actions: {
    completedFormHistoryIndex ({ commit }, payload) {
      commit('SET_IS_LOADING', true)
      return new Promise((resolve, reject) => {
        axios
          .get('/api/dashboard/completed-form-histories/get-completed-form-by-conflict', {
            params: payload
          })
          .then(({ data }) => {
            commit('SET_COMPLETED_FORMS_HISTORIES', data)
            commit('SET_IS_LOADING', false)
            resolve(data)
          })
          .catch((response) => {
            reject(response)
          })
          .finally(() => {
            commit('SET_IS_LOADING', false)
          })
      })
    },
    getNotificationCompletedFormHistories ({ commit }, payload) {
      commit('SET_IS_LOADING', true)
      return new Promise((resolve, reject) => {
        axios
          .get('/api/dashboard/completed-form-histories/get-notification-conflict')
          .then(({ data }) => {
            commit('SET_NOTIFICATION_COMPLETED_FORM_HISTORIES', data)
            commit('SET_IS_LOADING', false)
            resolve(data)
          })
          .catch((response) => {
            reject(response)
          })
          .finally(() => {
            commit('SET_IS_LOADING', false)
          })
      })
    },
    completedFormHistoryStore (_, payload) {
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .post('/api/dashboard/completed-form-histories/store-completed-form-history', payload)
          .then(({ data }) => {
            resolve(data)
          })
          .catch((error) => {
            reject(error)
          })
      })
    }
  }
}