export default {
  state: {
    completedForms: {} || [],
    completedFormsDetail: {} || [],
    completedFormsByLastUpdate: [],
    completedFormsAggregated: {},
    completedFormsData: {},
    completedFormAll: [],
    filterData: {},
    isLoading: false,
    iscompletedFormsAggregatedLoading: false,
    isLoadingFile: false,
    selectedForm: null
  },
  mutations: {
    SET_IS_LOADING (state, payload) {
      state.isLoading = payload
    },
    SET_IS_LOADING_FILE (state, payload) {
      state.isLoadingFile = payload
    },
    SET_COMPLETED_FORMS (state, payload) {
      state.completedForms = payload
    },
    SET_COMPLETED_FORMS_AGGREGATED (state, payload) {
      state.completedFormsAggregated = payload
    },
    SET_IS_COMPLETED_FORMS_AGGREGATED_LOADING (state, payload) {
      state.iscompletedFormsAggregatedLoading = payload
    },
    SET_COMPLETED_FORMS_BY_LAST_UPDATE (state, payload) {
      state.completedFormsByLastUpdate = payload
    },
    SET_COMPLETED_FORMS_DETAIL (state, payload) {
      state.completedFormsDetail = payload
    },
    SET_COMPLETED_FORMS_DATA (state, payload) {
      state.completedFormsData = payload
    },
    SET_FILTER__DATA (state, payload) {
      state.filterData = payload
    },
    SET_SELECTED_FORM (state, payload) {
      state.selectedForm = payload
    },
    SET_COMPLETED_FORM_ALL (state, payload) {
      state.completedFormAll = payload
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
          .catch((error) => {
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
          .catch((error) => {
            reject(error)
          })
      })
    },
    completedForm__delete (_, id) {
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .delete(`/api/dashboard/completed_forms/${id}`)
          .then(({ data }) => {
            resolve(data)
          })
          .catch((error) => {
            reject(error)
          })
      })
    },
    completedForm__getByHospital ({ state, commit }, payload = {}) {
      commit('SET_IS_LOADING', true)
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
            resolve(data)
            commit('SET_IS_LOADING', false)
          })
          .catch((response) => {
            console.log(response)
            reject(response)
          })
      })
    },
    completedForm__checkLastUpdate ({ state, commit }, payload = {}) {
      commit('SET_IS_LOADING', true)
      return new Promise((resolve, reject) => {
        axios
          .get(
            `/api/dashboard/completed_forms/check-last_update/${payload.hospital_id}/${payload.last_update}`,
            {
              params: {
                form_id: payload.form_id
              }
            }
          )
          .then(({ data }) => {
            commit('SET_COMPLETED_FORMS', data)
            resolve(data)
            commit('SET_IS_LOADING', false)
          })
          .catch((response) => {
            console.log(response)
            reject(response)
          })
      })
    },
    completedForm__show ({ state, commit }, payload) {
      commit('SET_IS_LOADING', payload.isLoading)
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/dashboard/completed_forms/${payload.completed_form_id}`)
          .then(({ data }) => {
            commit('SET_COMPLETED_FORMS_DETAIL', data)
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
    completedForm__getAllByLastUpdate ({ state, commit }, payload) {
      commit('SET_IS_CREATING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .get('/api/dashboard/completed_forms/get-latest-hospital-update', {
            params: {
              form_id: payload.form_id
            }
          })
          .then(({ data }) => {
            resolve(data)
          })
          .catch((response) => {
            reject(response)
          })
      })
    },

    completedForm__getAggregatedByHospitals ({ commit }, payload) {
      commit('SET_IS_COMPLETED_FORMS_AGGREGATED_LOADING', true)
      return new Promise((resolve, reject) => {
        axios
          .post(
            '/api/dashboard/completed_forms/get-aggregated-by-hospitals',
            payload
          )
          .then(({ data }) => {
            const aggregatedData = { ...data }
            if (!payload.observation_start) {
              aggregatedData.data = aggregatedData.data.map((hospital) => {
                if (hospital.completed_forms.length > 0) {
                  hospital.completed_forms = [hospital.completed_forms[0]]
                }
                return hospital
              })
            }
            // aggregated data
            commit('SET_COMPLETED_FORMS_AGGREGATED', aggregatedData)
            commit('SET_IS_COMPLETED_FORMS_AGGREGATED_LOADING', false)
          })
          .catch((response) => {
            reject(response)
          })
          .finally(() => {
            commit('SET_IS_COMPLETED_FORMS_AGGREGATED_LOADING', false)
          })
      })
    },
    completedForm__getDataByHospitals ({ commit }, payload) {
      commit('SET_IS_LOADING_FILE', true)

      return new Promise((resolve, reject) => {
        axios
          .post('/api/dashboard/completed_forms/get-data-by-hospitals', payload)
          .then(({ data }) => {
            commit('SET_COMPLETED_FORMS_DATA', data)

            resolve(data)
            commit('SET_IS_LOADING_FILE', false)
          })
          .catch((response) => {
            reject(response)
          })
          .finally(() => {
            commit('SET_IS_LOADING_FILE', false)
          })
      })
    },
    completedForm__setSelectedForm ({ commit }, payload) {
      commit('SET_SELECTED_FORM', payload)
    },
    completedForm__getAllFiltered (_, payload) {
      return new Promise((resolve, reject) => {
        axios
          .get('/api/dashboard/completed_forms/get-all-filtered', {
            params: payload
          })
          .then(({ data }) => {
            resolve(data)
          })
          .catch((response) => {
            reject(response)
          })
      })
    },
    getCompletedFormConflict (_, payload) {
      return new Promise((resolve, reject) => {
        axios
          .get('/api/dashboard/completed-forms/completed-form-conflict', {
            params: {
              form_id: payload.form_id
            }
          })
          .then(({ data }) => {
            resolve(data)
          })
          .catch((response) => {
            reject(response)
          })
      })
    },
    getCompletedFormByHospital (_, payload) {
      return new Promise((resolve, reject) => {
        axios
          .get('/api/dashboard/completed-forms/completed-form-hospital', {
            params: payload
          })
          .then(({ data }) => {
            resolve(data)
          })
          .catch((response) => {
            reject(response)
          })
      })
    },
    completedForm__getAll ({ commit }, payload) {
      commit('SET_IS_LOADING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .get('/api/dashboard/completed_forms', {
            params: {
              form_id: payload.form_id
            }
          })
          .then(({ data }) => {
            console.log('data is there ', data)
            commit('SET_COMPLETED_FORM_ALL', data)
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
    completedForm__getAllAndOptimizeQuery ({ commit }, payload) {
      commit('SET_IS_LOADING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .get('/api/dashboard/completed_forms/get_all_and_optimize_query', {
            params: {
              form_id: payload.form_id
            }
          })
          .then(({ data }) => {
            commit('SET_COMPLETED_FORM_ALL', data)
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
    }
  }
}
