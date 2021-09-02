export default{
  state: {
    forms:[],
    isLoading: false
  },
  mutations:{
    SET_FORM(state,payload){
      state.forms = payload
    },  
    setIsLoading(state, payload) {
      state.isLoading = payload;
    }
  },
  actions:{
    showForm (_, payload) {
      return new Promise((resolve, reject) => {
        axios.get(`/api/dashboard/forms/${payload.id}`)
          .then(({ data }) => {
            resolve(data)
          })
          .catch((error) => {
            reject(error)
          })
      })
    },

    getForms({ state, commit }, payload = {}) {
      commit("setIsLoading", true);
      return new Promise((resolve, reject) => {
        axios.get('api/dashboard/forms', {
          params: { page: payload.page || 1 }
        })
          .then(({ data }) => {
            commit('SET_FORM', data);
            commit("setIsLoading", false);
            resolve(true);
          })
          .catch((response) => {
            console.log(response);
            reject(response);
          })
      })
    },
  }
}
