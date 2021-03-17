import axios from "axios";

export default {
  state: {
    listPandemics: {},
    currentPage: 1,
    selectedPandemics: null,
    isLoading: false,
    isUpdating: false,
    isCreating: false,
    isDeleted: false
  },
  mutations: {
    setListPandemics (state, payload) {
      state.listPandemics = payload;
    },
    setSelectedPandemics (state, payload) {
      state.selectedPandemics = payload;
    },
    setIsLoading (state, payload) {
      state.isLoading = payload;
    },
    setIsCreating (state, payload) {
      state.isCreating = payload;
    },
    setIsUpdating (state, payload) {
      state.isUpdating = payload;
    }
  },
  actions: {
    createPandemics ({state, commit, dispatch}, payload = {}) {
      commit("setIsLoading", true);
      return new Promise((resolve, reject) => {
        axios.post('/api/dashboard/pandemy', payload)
          .then(({ data }) => {
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
    getListPandemics () {
      
    },
    searchPandemics () {
      
    }
  },

}