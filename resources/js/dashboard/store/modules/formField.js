export default {
  state: {
    formFields: [],
    currentPage: 1,
    isLoading: false,
    isUpdating: false
  },

  mutations: {
    SET_FORM_FIELD (state, payload) {
      state.formFields = payload
    },
    SET_IS_LOADING (state, payload) {
      state.isLoading = payload
    },
    SET_IS_UPDATING (state, payload) {
      state.isUpdating = payload
    }
  },
  actions: {
    formFieldStore (_, payload) {
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .post('/api/dashboard/form-fields', payload)
          .then(({ data }) => {
            resolve(data)
          })
          .catch(error => {
            reject(error)
          })
      })
    },
    getFormFields ({ state, commit }, payload = {}) {
      commit('SET_IS_LOADING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .get('api/dashboard/form-fields/get-form', {
            params: {
              form_id: payload.form_id,
              step_id: payload.step_id
            }
          })
          .then(({ data }) => {
            commit('SET_FORM_FIELD', data)
            commit('SET_IS_LOADING', false)
            resolve(data)
          })
          .catch(response => {
            console.log(response)
            reject(response)
          })
      })
    },
    removeFormField ({ state, commit, dispatch }, payload = {}) {
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .delete(`api/dashboard/form-fields/${payload}`)
          .then(({ data }) => {
            resolve(true)
          })
          .catch(response => {
            reject(response)
          })
      })
    },
    updateFormField ({ state, commit, dispatch }, payload = {}) {
      commit('SET_IS_UPDATING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .put(`api/dashboard/form-fields/${payload.id}`, payload)
          .then(({ data }) => {
            resolve(true)
          })
          .catch(response => {
            reject(response)
          })
          .finally(() => {
            commit('SET_IS_UPDATING', false)
          })
      })
    }
  }
}
