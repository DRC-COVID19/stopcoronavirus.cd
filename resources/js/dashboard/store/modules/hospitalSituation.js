import axios from 'axios'

export default {
  state: {
    hospitalsList: [],
    hospitalSituation: [],
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
    SET_HOSPITALS (state, payload) {
      state.hospitalsList = payload
    }
  },
  actions: {
    createHospitalSituation ({ state, commit, dispatch }, payload = {}) {
      commit('SET_IS_CREATING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        console.log('store:', payload)
        axios
          .post('api/dashboard/hospital-situations-new', payload)
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
    getHospitalSituations ({ state, commit }, { payload }) {
      commit('SET_IS_CREATING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .get('api/dashboard/hospital-situations-new')
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
    gethospitalsFiltered ({ state, commit }, payload) {
      commit('SET_IS_LOADING', payload.isLoading)
      if (payload) {
        if (payload.observation_end) {
          state.observation_end = payload.observation_end
        }
        if (payload.observation_start) {
          state.observation_start = payload.observation_start
        }
        state.township = payload.township
        return new Promise((resolve, reject) => {
          axios
            .get('api/dashboard/hospitalsFiltered', {
              params: {
                observation_end: payload.observation_end || null,
                observation_start: payload.observation_start || null,
                hospital: payload.hospital
              }
            })
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
      }
    }
  }
}
