export default {
  state: {
    completedForms: {} || [],
    completedFormsDetail: {} || [],
    completedFormsByLastUpdate: [],
    isLoading: false
  },
  mutations: {
    SET_IS_LOADING (state, payload) {
      state.isLoading = payload
    },
    SET_COMPLETED_FORMS (state, payload) {
      state.completedForms = payload
    },
    SET_COMPLETED_FORMS_BY_LAST_UPDATE (state, payload) {
      state.completedFormsByLastUpdate = payload
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
        console.log('update data:', payload)
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
          .then(({ data }) => {
            commit('SET_COMPLETED_FORMS_DETAIL', data)
            commit('SET_IS_LOADING', false)
            resolve(data)
          })
          .catch(response => {
            reject(response)
          })
          .finally(() => {
            commit('SET_IS_LOADING', false)
          })
      })
    },
    completedForm__getAllByLastUpdate ({ state, commit }) {
      commit('SET_IS_CREATING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .get('/api/dashboard/completed_forms/agent-last-update')
          .then(({ data }) => {
            const completedForms = data.map(completedForm => ({
              diff_date: completedForm.diff_date,
              last_update: completedForm.last_update,
              name: completedForm.form_id ? completedForm.hospital.name : completedForm.name,
              created_manager_name: completedForm.created_manager_name,
              hospital_id: completedForm.hospital_id
            }))
            commit('SET_IS_LOADING', false)
            resolve(completedForms)
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
