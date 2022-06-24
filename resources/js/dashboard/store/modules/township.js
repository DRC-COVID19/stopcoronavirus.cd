export default {
  state: {
    townships: [],
    isLoading: false,
    townshipsByForm: [],
    isLoadingTownshipsByForm: false
  },
  mutations: {
    SET_IS_LOADING (state, payload) {
      state.isLoading = payload
    },
    SET_IS_LOADING_TOWNSHIPS_BY_FORM (state, payload) {
      state.isLoadingTownshipsByForm = payload
    },
    SET_TOWNSHIPS (state, payload) {
      state.townships = payload
    },
    SET_TOWNSHIPS_BY_FORM (state, payload) {
      state.townshipsByForm = payload
    }
  },
  actions: {
    // getTownshipsByForm
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
    townships__byForm ({ state, commit }, payload) {
      commit('SET_IS_LOADING_TOWNSHIPS_BY_FORM', true)
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .get('/api/dashboard/townships/', {
            params: { form_id: payload.form_id }
          })
          .then(({ data }) => {
            commit('SET_TOWNSHIPS_BY_FORM', data)
            commit('SET_IS_LOADING_TOWNSHIPS_BY_FORM', false)
            resolve(data)
          })
          .catch((response) => {
            reject(response)
          })
          .finally(() => {
            commit('SET_IS_LOADING_TOWNSHIPS_BY_FORM', false)
          })
      })
    }
  }
}
