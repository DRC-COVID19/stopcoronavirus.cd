export default {
  state: {
    completedForms: {} || [],
    isLoading: false
  },
  mutations: {
    SET_IS_LOADING (state, payload) {
      state.isLoading = payload
    },
    SET_COMPLETED_FORMS (state, payload) {
      state.completedForms = payload
    }
  },
  actions: {
    completedForm__store (_, payload) {
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .post('/api/dashboard/completed_forms', payload)
          .then(({ data }) => {
            resolve(data)
          })
          .catch(error => {
            reject(error)
          })
      })
    },
    completedForm__update (_, payload) {
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .put(`/api/dashboard/completed_forms/${payload.id}`, payload)
          .then(({ data }) => {
            resolve(data)
          })
          .catch(error => {
            reject(error)
          })
      })
    },
    completedForm__getByHospital ({ state, commit }, payload = {}) {
      commit('SET_IS_LOADING', payload.isLoading)
      return new Promise((resolve, reject) => {
        axios
          .get(
            `/api/dashboard/completed_forms/by-hospital/${payload.hospital_id}`,
            {
              params: { page: payload.page }
            }
          )
          .then(({ data }) => {
            commit('SET_COMPLETED_FORMS', data)
            resolve(true)
            commit('SET_IS_LOADING', false)
          })
          .catch(response => {
            console.log(response)
            reject(response)
          })
      })
    }
  }
}
