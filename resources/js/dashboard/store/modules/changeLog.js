export default {
  state: {
    listChangeLogs: {},
    currentPage: 1,
    selectedChangeLog: null,
    isLoading: false
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
  },
  actions: {
    getListChangedLogs({ state, commit }, payload={}) {

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
