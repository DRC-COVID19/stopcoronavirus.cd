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
    observation_end: null
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
    }
  },
  actions: {
    createHospitalSituation ({ state, commit, dispatch }, payload = {}) {
      commit('SET_IS_CREATING', true)
      console.log('payload hospital:', payload)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef

        axios
          .post('/api/dashboard/hospital-situations', payload)
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
    getHospitalSituations ({ state, commit }, { payload }) {
      commit('SET_IS_CREATING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .get('api/dashboard/hospital-situations')
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
          .get(`/api/dashboard/hospital-situations/${payload.update_id}`)
          .then(({ data }) => {
            commit('HOSPITAL_SITUATION_DETAIL', data)
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
