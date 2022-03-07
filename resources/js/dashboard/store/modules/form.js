export default {
  state: {
    forms: [],
    isLoading: false
  },
  mutations: {
    SET_FORMS (state, payload) {
      state.forms = payload
    },
    SET_IS_LOADING (state, payload) {
      state.isLoading = payload
    }
  },
  actions: {
    formShow (_, payload) {
      return new Promise((resolve, reject) => {
        axios.get(`/api/dashboard/forms/${payload.id}`)
          .then(({ data }) => {
            resolve(data)
          })
          .catch((error) => {
            reject(error)
          })
      })
    },

    getForms ({ state, commit }, payload = {}) {
      commit('SET_IS_LOADING', true)
      return new Promise((resolve, reject) => {
        axios.get('api/dashboard/forms', {
          params: { page: payload.page || 1 }
        })
          .then(({ data }) => {
            commit('SET_FORMS', data)
            commit('SET_IS_LOADING', false)
            resolve(true)
          })
          .catch((response) => {
            console.log(response)
            reject(response)
          })
      })
    }
  }
}
