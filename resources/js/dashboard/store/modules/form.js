export default {
  state: {
    forms: [],
    recentForms: [],
    formsRecurrences: [],
    isLoading: false,
    isUpdating: false,
    isUpdateFormTitle: null
  },
  mutations: {
    SET_FORMS (state, payload) {
      state.forms = payload
    },
    SET_IS_UPDATE_FORM_TITLE (state, payload) {
      state.isUpdateFormTitle = payload
    },
    SET_RECENT_FORMS (state, payload) {
      state.recentForms = payload
    },
    SET_FORMS_RECURRENCES (state, payload) {
      state.formsRecurrences = payload
    },
    SET_IS_LOADING (state, payload) {
      state.isLoading = payload
    },
    SET_IS_UPDATING (state, payload) {
      state.isUpdating = payload
    }
  },
  actions: {
    formShow (_, payload) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/dashboard/forms/${payload.id}`)
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
        axios
          .get('api/dashboard/forms', {
            params: { page: payload.page || 1 }
          })
          .then(({ data }) => {
            commit('SET_FORMS', data)
            commit('SET_IS_LOADING', false)
            resolve(data)
          })
          .catch((response) => {
            reject(response)
          })
      })
    },
    getFormsRecurrences ({ state, commit }, payload = {}) {
      commit('SET_IS_LOADING', true)
      return new Promise((resolve, reject) => {
        axios
          .get('/api/dashboard/form-recurrences')
          .then(({ data }) => {
            commit('SET_FORMS_RECURRENCES', data)
            commit('SET_IS_LOADING', false)
            resolve(true)
          })
          .catch((response) => {
            reject(response)
          })
      })
    },
    getRecentForms ({ state, commit }, payload = {}) {
      commit('SET_IS_LOADING', true)
      return new Promise((resolve, reject) => {
        axios
          .get('api/dashboard/forms/recent-form')
          .then(({ data }) => {
            commit('SET_RECENT_FORMS', data)
            commit('SET_IS_LOADING', false)
            resolve(data)
          })
          .catch((response) => {
            reject(response)
          })
      })
    },

    getFormFiltered ({ state, commit }, payload = {}) {
      console.log('payload', payload)
      commit('SET_IS_LOADING', true)
      return new Promise((resolve, reject) => {
        axios
          .get(`api/dashboard/forms/get-form-filtered?page=${payload.page}`, {
            params: {
              form_date: payload.form_date,
              published_form: payload.published_form,
              unpublished_form: payload.unpublished_form,
              recurrence_form: payload.recurrence_form,
              paginate: payload.paginate
            }
          })
          .then(({ data }) => {
            resolve(data)
            console.log('data--->', data)
            commit('SET_IS_LOADING', false)
          })
          .catch((response) => {
            reject(response)
          })
      })
    },

    updateFormTitle ({ commit }, payload) {
      return new Promise((resolve, reject) => {
        axios
          .put('/api/dashboard/forms/' + payload.id, payload)
          .then(() => {
            commit('SET_IS_UPDATE_FORM_TITLE', true)
          })

          .catch(({ response }) => {
            commit('SET_IS_UPDATE_FORM_TITLE', false)
          })
      })
    },
    changeStatusForm ({ commit }, payload = {}) {
      commit('SET_IS_UPDATING', true)
      return new Promise((resolve, reject) => {
        axios
          .put(`/api/dashboard/forms/${payload.form_id}`, payload)
          .then(({ data }) => {
            commit('SET_IS_LOADING', false)
            resolve(true)
          })
          .catch((response) => {
            reject(response)
          })
          .finally(() => {
            commit('SET_IS_UPDATING', false)
          })
      })
    },
    form__filterByWords ({ commit }, payload = {}) {
      commit('SET_IS_LOADING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .get('api/dashboard/forms/filter?key_words=' + payload.filter)
          .then(({ data }) => {
            commit('SET_IS_LOADING', false)
            resolve(data)
          })
          .catch(({ response }) => {
            commit('SET_IS_LOADING', false)
          })
          .finally(() => {
            commit('SET_IS_LOADING', false)
          })
      })
    }
  }
}
