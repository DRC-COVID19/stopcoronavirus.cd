export default {
  state: {
    townships: [],
    townshipsCompletedForm: [],
    isLoading: false

  },
  mutations: {
    SET_IS_LOADING (state, payload) {
      state.isLoading = payload
    },

    SET_TOWNSHIPS (state, payload) {
      state.townships = payload
    },

    SET_TOWNSHIPS_COMPLETED_FORM (state, payload) {
      state.townshipsCompletedForm = payload
    }
  },
  actions: {
    townships__getAll ({ state, commit }) {
      commit('SET_IS_LOADING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .get('/api/dashboard/townships')
          .then(({ data }) => {
            commit('SET_TOWNSHIPS', data)
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
    getTownshipData ({ state, commit, dispatch }, payload = {}) {
      commit('SET_IS_LOADING', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .post('api/dashboard/townships/completed-forms', payload)
          .then(({ data }) => {
            commit('SET_TOWNSHIPS_COMPLETED_FORM', data)
            resolve(true)
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
