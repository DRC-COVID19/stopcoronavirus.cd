export default {
  state: {
    hospitalSituation: [],
    isLoading: false,
    isCreating: false
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
    }
  },
  actions: {
    createHospitalSituation ({ state, commit, dispatch }, payload = {}) {
      commit('SET_IS_CREATING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .post('api/dashboard/hospital-situations-new', payload)
          .then(({ data }) => {
            commit('SET_HOSPITAL_SITUATION', data)
            commit('SET_IS_LOADING', false)
            resolve(true)
          })
          .catch(response => {
            console.log(response)
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
          .post('api/dashboard/hospital-situations-new')
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
    }
  }
}
