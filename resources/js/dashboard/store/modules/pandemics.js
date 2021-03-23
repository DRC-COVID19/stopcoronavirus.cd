export default {
  state: {
    listPandemics: {},
    currentPage: 1,
    listHealthZones: {},
    selectedPandemics: null,
    isLoading: false,
    isUpdating: false,
    isCreating: false,
    isDeleted: false,
    selectedHealthZone: null,
    selectedHealthZoneFilter: null
  },
  mutations: {
    setListPandemics(state, payload) {
      state.listPandemics = payload;
    },
    setSelectedHealthZone(state, payload) {
      state.selectedHealthZone = payload;
    },
    setSelectedHealthZoneFilter(state, payload) {
      state.selectedHealthZoneFilter = payload;
    },
    setListHealthZones(state, payload) {
      state.listHealthZones = payload;
    },
    setSelectedPandemics(state, payload) {
      state.selectedPandemics = payload;
    },
    setIsLoading(state, payload) {
      state.isLoading = payload;
    },
    setIsCreating(state, payload) {
      state.isCreating = payload;
    },
    setIsUpdating(state, payload) {
      state.isUpdating = payload;
    }
  },
  actions: {
    createPandemics({
      state,
      commit,
      dispatch
    }, payload = {}) {
      commit("setIsLoading", true);
      return new Promise((resolve, reject) => {
        axios.post('/api/dashboard/pandemy', payload)
          .then(({
            data
          }) => {
            dispatch("getListPandemics");
            resolve(true);
          })
          .catch((response) => {
            console.log(response);
            reject(response);
          })
          .finally(() => {
            commit("setIsLoading", false)
          })
      })
    },
    updatePandemics({
      state,
      commit,
      dispatch
    }, payload = {}) {
      commit("isLoading", true);
      commit("isUpdating", true);
      return new Promise((resolve, reject) => {
        axios.put('/api/dashboard/' + payload)
          .then(({
            data
          }) => {
            dispatch("getListPandemics");
            resolve(true);
          })
          .catch(response => {
            console.log(response);
            reject(response);
          })
          .finally(() => {
            commit('setIsLoading', false);
          })
      })
    },
    getListHealthZones({
      state,
      commit
    }, payload = {}) {
      commit("setIsLoading", true);
      return new Promise((resolve, reject) => {
        axios.get("/api/health_zones", {
          params: payload.page || 1
        })
          .then(({
            data
          }) => {
            commit("setListHealthZones", data);
            commit("isLoading", false);
            resolve(true);
          })
          .catch(response => {
            console.log(response);
            reject(resolve);
          })
      })
    },
    getListPandemics({
      state,
      commit
    }, payload = {}) {
      commit("setIsLoading", true);
      return new Promise((resolve, reject) => {
        axios.get('/api/pandemy', {
            params: {
              page: payload.page || 1
            }
          })
          .then(({
            data
          }) => {
            commit('setListPandemics', data);
            commit('setIsLoading', false);
            resolve(true);
          })
          .catch(response => {
            console.log(response);
            reject(response);
          })
      })
    },
    searchPandemics({
      state,
      commit
    }, payload = null) {
      commit('setIsLoading', true)
      return new Promise((resolve, reject) => {
        if (payload) {
          axios.get('api/dashboard/pandemy/filter/health_zone?date=' + payload.last_update + '&health_zone_id' + payload.health_zone_id)
            .then(({
              data
            }) => {
              commit("setListPandemics", data);
              resolve(true);
            })
            .catch(response => {
              reject(response);
              commit("setIsLoading", false);
              console.log(response);
            })
            .finally(() => {
              commit("setIsLoading", false);
            })
        }
      })
    }
  },
  getters: {
    // TO be add logs
  }
}
