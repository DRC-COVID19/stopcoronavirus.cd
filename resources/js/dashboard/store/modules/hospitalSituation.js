import axios from 'axios'

export default {
  state: {
    hospitalsList: [],
    hospitalSituation: [],
    filterdHospitalSituation: [],
    hospitalSituationDetail: {},
    AllhospitalSituationByLastUpdate: [],
    isLoading: false,
    isCreating: false,
    hospitalSituationAll: [],
    observation_start: null,
    observation_end: null,
    hospitalSituationSelected: [],
    hospitalObservationSituation: []
  },

  mutations: {
    SET_HOSPITAL_SITUATION (state, payload) {
      state.hospitalSituation = payload
    },
    SET_IS_LOADING (state, payload) {
      state.isLoading = payload
    },
    SET_IS_CREATING (state, payload) {
      state.isCreating = payload
    },
    SET_ALL_HOSPITAL_SITUATION (state, payload) {
      state.hospitalSituationAll = payload
    },
    SET_ALL_HOSPITAL_SITUATION_BY_LAST_UPDATE (state, payload) {
      state.AllhospitalSituationByLastUpdate = payload
    },
    SET_FILTERED_HOSPITAL_SITUATION (state, payload) {
      state.filterdHospitalSituation = payload
    },
    HOSPITAL_SITUATION_DETAIL (state, payload) {
      state.hospitalSituationDetail = payload
    },
    SET_HOSPITALS (state, payload) {
      state.hospitalsList = payload
    },
    SET_SITUATION (state, payload) {
      state.hospitalSituationSelected = payload
    },
    SET_OBSERVATION (state, payload) {
      state.observation_start = payload.observation_start
      state.observation_end = payload.observation_end
    },
    SET_OBSERVATION_SITUATION_HOSPITALS (state, payload) {
      state.hospitalObservationSituation = payload
    }
  },
  actions: {
    createHospitalSituation ({ state, commit, dispatch }, payload = {}) {
      commit('SET_IS_CREATING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef

        axios
          .post('/api/dashboard/hospital-situations', payload)
          .then(({ data }) => {
            commit('SET_HOSPITAL_SITUATION', data)
            commit('SET_IS_LOADING', false)
            resolve(true)
          })
          .catch(response => {
            reject(response)
          })
          .finally(() => {
            commit('SET_IS_CREATING', false)
          })
      })
    },
    updateHospitalSituation ({ state, commit, dispatch }, payload = {}) {
      commit('SET_IS_CREATING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef

        axios
          .put(
            `/api/dashboard/hospital-situations/${payload.hospital_id}`,
            payload
          )
          .then(({ data }) => {
            commit('SET_IS_LOADING', false)
            resolve(true)
          })
          .catch(response => {
            reject(response)
          })
          .finally(() => {
            commit('SET_IS_CREATING', false)
          })
      })
    },
    // getHospitalSituations ({ state, commit }, { payload }) {
    //   commit('SET_IS_CREATING', true)
    //   return new Promise((resolve, reject) => {
    //     // eslint-disable-next-line no-undef
    //     axios
    //       .get('api/dashboard/hospital-situations-new')
    //       .then(({ data }) => {
    //         commit('SET_HOSPITAL_SITUATION', data)
    //         commit('SET_IS_LOADING', false)
    //         resolve(true)
    //       })
    //       .catch(response => {
    //         reject(response)
    //       })
    //       .finally(() => {
    //         commit('SET_IS_CREATING', false)
    //       })
    //   })
    // },
    getHospitalSituationsAll ({ state, commit }) {
      commit('SET_IS_CREATING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .get('api/dashboard/get-hospital-situations-all')
          .then(({ data }) => {
            commit('SET_ALL_HOSPITAL_SITUATION', data)
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
    },
    getAllHospitalSituationsByLastUpdate ({ state, commit }) {
      commit('SET_IS_CREATING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .get('/api/dashboard/hospital-situations/agent-last-update')
          .then(({ data }) => {
            commit('SET_ALL_HOSPITAL_SITUATION_BY_LAST_UPDATE', data)
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
    },
    getHospitals ({ state, commit }) {
      commit('SET_IS_LOADING', true)
      return new Promise((resolve, reject) => {
        axios
          .get('api/dashboard/hospitals-data')
          .then(({ data }) => {
            commit('SET_HOSPITALS', data)
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
    },
    getHospitalSituationsDetail ({ state, commit }, payload) {
      console.log('mon payload de bon:', payload)
      commit('SET_IS_LOADING', payload.isLoading)
      return new Promise((resolve, reject) => {
        axios
          .get(
            `/api/dashboard/hospital-situations/${payload.update_id}/hospital_id/${payload.hospital_id}`
          )
          .then(({ data }) => {
            const hospitalSituations = data.map(item => ({
              name: item.name,
              order_field: item.order_field,
              default_value: item.default_value,
              last_update: item.last_update,
              created_manager_name: item.created_manager_name,
              updated_manager_name: item.updated_manager_name,
              form_step_id: item.form_step_id,
              form_step_title: item.form_step_title,
              id: item.id,
              form_field_type: { name: item.form_field_type }
            }))
            commit('HOSPITAL_SITUATION_DETAIL', hospitalSituations)
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
    },
    gethospitalsFiltered ({ state, commit }, payload) {
      commit('SET_IS_LOADING', payload.isLoading)

      return new Promise((resolve, reject) => {
        axios
          .post('api/dashboard/get-situations', payload)
          .then(({ data }) => {
            commit('SET_FILTERED_HOSPITAL_SITUATION', data)
            commit('SET_SITUATION', data)
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
    },
    getObservationSituationHospital ({ state, commit }, payload) {
      commit('SET_IS_LOADING', payload.isLoading)
      return new Promise((resolve, reject) => {
        axios
          .post('api/dashboard/get-observation-situation-hospital', payload)
          .then(({ data }) => {
            commit('SET_OBSERVATION_SITUATION_HOSPITALS', data)
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
    },
    async getObservation ({ state, commit }, payload) {
      await commit('SET_OBSERVATION', payload)
    }
  }
}