export default {
  state: {
    geoGranularity: null,
    geoOptions: [],
    formErrors: {}
  },
  mutations: {
    setIndicatorGeoGranularity(state, payload) {
      state.geoGranularity = payload
    },
    setIndicatorGeoOptions(state, payload) {
      state.geoOptions = payload;
    },
  },
  actions: {
    submitFilters({ state }, form) {
      
    }
  }
}