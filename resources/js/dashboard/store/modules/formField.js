export default {
  state: {
    formFields: [],
    currentPage: 1,
    isLoading: false
  },

  mutations: {
    SET_FORM_FIELD (state, payload) {
      state.formFields = payload
    },
    SET_IS_LOADING (state, payload) {
      state.isLoading = payload
    }
  },
  actions: {
    formFieldStore (_, payload) {
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios.post('/api/dashboard/form-fields', payload)
          .then(({ data }) => {
            resolve(data)
          })
          .catch((error) => {
            reject(error)
          })
      })
    },
    getFormFields ({ state, commit }, payload = {}) {
      commit('SET_IS_LOADING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios.get(`api/dashboard/form-fields/get-form/${payload.id}`)
          .then(({ data }) => {
            commit('SET_FORM_FIELD', data)
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
