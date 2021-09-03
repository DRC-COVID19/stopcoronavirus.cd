export default{
  state: {
    formSteps:[],
    currentPage: 1,
    selectedFormStep: null,
    isLoading: false,
    isCreating: false,
  },
  mutations:{
    SET_FORM_STEP(state,payload){
      state.formSteps = payload
    },
    SET_SELECTED_FORM_STEP(state, payload) {
      state.selectedFormStep = payload;
    },
    SET_IS_LOADING(state, payload) {
      state.isLoading = payload;
    },
    SET_IS_CREATING(state, payload) {
      state.isCreating = payload;
    }
  },
  actions:{
    createFormStep({ state, commit, dispatch }, payload = {}) {
      commit("SET_IS_CREATING", true);
      return new Promise((resolve, reject) => {
        axios.post('api/dashboard/form-steps', payload)
          .then(({ data }) => {
            dispatch('getFormSteps');
            resolve(true)
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
    updateFormStep({ state, commit, dispatch }, payload = {}) {
      commit("SET_IS_CREATING", true);
      return new Promise((resolve, reject) => {
        axios.put(`api/dashboard/form-steps/${payload.id}`, payload)
          .then(({ data }) => {
            dispatch('getFormSteps');
            resolve(true)
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
    removeFormStep({ state, commit, dispatch }, payload = {}) {
      commit("SET_IS_CREATING", true);
      return new Promise((resolve, reject) => {
        axios.delete(`api/dashboard/form-steps/${payload}`)
          .then(({ data }) => {
            dispatch('getFormSteps');
            resolve(true)
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
    searchFormStep ({ state, commit, dispatch }, payload = null) {
      return new Promise((resolve, reject) => {
        if (payload) {
          axios
            .get('api/dashboard/form-steps/filter?date='+payload)
              .then(({ data }) => {
                commit('SET_FORM_STEP', data);
                resolve(true);
              }) 
              .catch(({ response }) => {
                console.log(response);
                reject(response);
              });
        } else {
          dispatch('getFormSteps',{id});
          resolve(true);
        }
      })
    },
    getFormSteps({ state, commit }, payload = {}) {
      commit("SET_IS_LOADING", true);
      return new Promise((resolve, reject) => {
        axios.get(`api/dashboard/form-steps/step-form/${payload.id}`, {
          params: { page: payload.page || 1 }
        })
          .then(({ data }) => {
            commit('SET_FORM_STEP', data);
            commit("SET_IS_LOADING", false);
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