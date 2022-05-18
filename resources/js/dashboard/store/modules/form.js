export default {
  state: {
    forms: [],
    form: {},
    recentForms: [],
    formsRecurrences: [],
    isLoading: false,
    isUpdating: false,
    isUpdateFormTitle: null,
    isUpdateForm: false,
    isDeleteForm: false
  },
  mutations: {
    SET_FORMS (state, payload) {
      state.forms = payload
    },
    SET_FORM (state, payload) {
      state.form = payload
    },
    SET_IS_UPDATE_FORM_TITLE (state, payload) {
      state.isUpdateFormTitle = payload
    },
    SET_IS_UPDATE_FORM (state, payload) {
      state.isUpdateForm = payload
    },
    SET_IS_DELETE_FORM (state, payload) {
      state.isDeleteForm = payload
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
  getters: {
    form__publishedForms: state => state.forms.filter(form => form.publish)
  },
  actions: {
    formShow ({ commit }, payload) {
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/dashboard/forms/${payload.id}`)
          .then(({ data }) => {
            commit('SET_FORM', data)
            resolve(data)
          })
          .catch((error) => {
            reject(error)
          })
      })
    },
    form__UpdateFormVisibility ({ commit }, payload) {
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .put('/api/dashboard/forms/update-form-visibility' + payload.id, payload.form)
          .then(() => {
            resolve(true)
            commit('SET_IS_UPDATE_FORM', true)
          })

          .catch(({ response }) => {
            reject(response)
            commit('SET_IS_UPDATE_FORM', false)
          })
      })
    },
    form__Update ({ commit }, payload) {
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .put('/api/dashboard/forms/' + payload.id, payload.form)
          .then(() => {
            resolve(true)
            commit('SET_IS_UPDATE_FORM', true)
          })

          .catch(({ response }) => {
            reject(response)
            commit('SET_IS_UPDATE_FORM', false)
          })
      })
    },
    form__Delete ({ commit }, formId) {
      return new Promise((resolve, reject) => {
        axios
          .delete(`/api/dashboard/forms/${formId}`)
          .then(({ data }) => {
            commit('SET_IS_DELETE_FORM', true)
            resolve(true)
          })
          .catch(({ response }) => {
            commit('SET_IS_DELETE_FORM', false)
            reject(response)
          })
      })
    },
    getForms ({ state, commit }, payload = {}) {
      commit('SET_IS_LOADING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
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
