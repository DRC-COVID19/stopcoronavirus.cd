export default {
  state: {
    listChangeLogs: {},
    currentPage: 1,
    selectedChangeLog: null,
    isLoading: false,
    isCreating: false,
  },
  mutations: {
    setListChangeLogs(state, payload) {
      state.listChangeLogs = payload;
    },
    setSelectedChangeLog(state, payload) {
      state.selectedChangeLog = payload;
    },
    setIsLoading(state, payload) {
      state.isLoading = payload;
    },
    setIsCreating(state, payload) {
      state.isCreating = payload;
    }
  },
  actions: {
    createChangeLog({ state, commit, dispatch }, payload = {}) {
      commit("setIsCreating", true);
      return new Promise((resolve, reject) => {
        axios.post('/api/dashboard/change-log', payload)
          .then(({ data }) => {
            dispatch('getListChangedLogs');
            resolve(true)
          })
          .catch((response) => {
            console.log(response);
            reject(response);
          })
          .finally(() => {
            commit("setIsCreating", false);
          });
      });
    },
    updateChangeLog({ state, commit, dispatch }, payload = {}) {
      commit("setIsCreating", true);
      return new Promise((resolve, reject) => {
        axios.put(`/api/dashboard/change-log/${payload.id}`, payload)
          .then(({ data }) => {
            dispatch('getListChangedLogs');
            resolve(true)
          })
          .catch((response) => {
            console.log(response);
            reject(response);
          })
          .finally(() => {
            commit("setIsCreating", false);
          });
      });
    },
    removeChangeLog({ state, commit, dispatch }, payload = {}) {
      commit("setIsCreating", true);
      return new Promise((resolve, reject) => {
        axios.delete(`/api/dashboard/change-log/${payload.id}`, payload)
          .then(({ data }) => {
            dispatch('getListChangedLogs');
            resolve(true)
          })
          .catch((response) => {
            console.log(response);
            reject(response);
          })
          .finally(() => {
            commit("setIsCreating", false);
          });
      });
    },
    getListChangedLogs({ state, commit }, payload = {}) {

      commit("setIsLoading", true);
      return new Promise((resolve, reject) => {
        axios.get('/api/dashboard/change-log', {
          params: { page: payload.page || 1 }
        })
          .then(({ data }) => {
            commit('setListChangeLogs', data);
            commit("setIsLoading", false);
            resolve(true)
          })
          .catch((response) => {
            console.log(response);
            reject(response);
          })


      })
    },
    setChangeLogsRead({ state, dispatch }) {
      return new Promise((resolve, reject) => {
        state.listChangeLogs.data.map(item => {
          item.notRead = false;
        });
        axios.post('/api/dashboard/change-log/read').then(({ data }) => {
          dispatch('getListChangedLogs');
          resolve(true);
        })
          .catch(response => {
            console.log(response);
            reject(response);
          })
      })

    }
  },
  getters: {
    getChangeLogNotRead(state) {
      if (!state.listChangeLogs.data) {
        return []
      }
      return state.listChangeLogs.data.filter((x) => x.notRead)/*.sort((a, b) => {
        return new Date(a.from) < new Date(b.from) ? 1 : -1;
      })*/;
    }
  }
}
