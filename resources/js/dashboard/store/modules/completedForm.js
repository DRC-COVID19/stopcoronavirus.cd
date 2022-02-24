export default {
  state: {
    completedForms: {} || [],
    completedFormsDetail: [],
    isLoading: false
  },
  mutations: {
    SET_IS_LOADING (state, payload) {
      state.isLoading = payload
    },
    SET_COMPLETED_FORMS (state, payload) {
      state.completedForms = payload
    },
    SET_COMPLETED_FORMS_DETAIL (state, payload) {
      state.completedFormsDetail = payload
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
    },
    completedForm__getByHospitalDetail ({ state, commit }, payload) {
      commit('SET_IS_LOADING', payload.isLoading)
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/dashboard/completed_forms/${payload.completed_form_id}`)
          .then(({ completedForms }) => {
            // const completedForms = data.map(item => ({
            //   id: item.id,
            //   name: item.form_field.name,
            //   default_value: item.value,
            //   last_update: item.completed_form.last_update,
            //   created_manager_name: item.completed_form.created_manager_name,
            //   form_step_id: item.form_field.form_step_id,
            //   form_step_title: item.form_field.form_step_title,
            //   form_field_type: { name: item.form_field_type }
            // }))
            commit('SET_COMPLETED_FORMS_DETAIL', completedForms)
            commit('SET_IS_LOADING', false)
            resolve(true)
          })
          .catch(response => {
            reject(response)
          })
          .finally(() => {
            commit('SET_IS_LOADING', false)
          })
      })
    }
  }
}
