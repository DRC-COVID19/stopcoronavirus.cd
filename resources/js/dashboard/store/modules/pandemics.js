export default {
  state: {
    listPandemics: {},
    currentPage: 1,
    selectedPandemics: null,
    isLoading: false,
    isUpdating: false,
    isDeleted: false
  },
  mutations: {
    setListPandemics (state, payload) {
      state.listPandemics = payload;
    },
    setSelectedPandemics (state, payload) {
      state.selectedPandemics = payload;
    }
  },
  actions: {
    getListPandemics () {

    },
    searchPandemics () {
      
    }
  },

}