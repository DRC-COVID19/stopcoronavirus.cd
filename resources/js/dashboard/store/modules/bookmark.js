export default {
  state: {
    bookmarks: [],
    isLoading: false,
    isCreating: false
  },
  mutations: {
    SET_BOOK_MARK(state, payload) {
      state.bookmarks = payload;
    },
    SET_IS_LOADING(state, payload) {
      state.isLoading = payload;
    },
    SET_IS_CREATING(state, payload) {
      state.isCreating = payload;
    }
  },
  actions: {
    createBookmark({ state, commit, dispatch }, payload = {}) {
      commit("SET_IS_CREATING", true);
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .post("api/dashboard/bookmarks", payload)
          .then(({ data }) => {
            resolve(true);
          })
          .catch((response) => {
            console.log(response);
            reject(response);
          })
          .finally(() => {
            commit("SET_IS_CREATING", false);
          });
      });
    },
    getBookmarks({ state, commit }, payload = {}) {
      commit("SET_IS_LOADING", true);
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .get('api/dashboard/bookmarks')
          .then(({ data }) => {
            commit("SET_BOOK_MARK", data);
            commit("SET_IS_LOADING", false);
            resolve(true);
          })
          .catch((response) => {
            console.log(response);
            reject(response);
          });
      });
    },
    
  }
}