export default {
  state: {
    completedForms: {} || [],
    completedFormsDetail: {} || [],
    completedFormsByLastUpdate: [],
    completedFormsAggregated: {},
    completedFormsData: {},
    filterData: {},
    isLoading: false,
    iscompletedFormsAggregatedLoading: false,
    isLoadingFile: false
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
            `/api/dashboard/completed_forms/check-last_update/${payload.hospital_id}/${payload.last_update}`
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
          .catch((response) => {
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
          .get('/api/dashboard/completed_forms/get-latest-hospital-update')
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
            commit('SET_COMPLETED_FORMS_AGGREGATED', data)
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
    }
  }
}
