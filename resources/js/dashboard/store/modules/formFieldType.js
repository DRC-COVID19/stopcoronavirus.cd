export default {
  state: {
    formFieldTypes: []
  },
  mutations: {
    SET_FORM_FIELD_TYPES: (state, payload) => {
      state.formFieldTypes = payload;
    },
  },
  actions: {
    formFieldTypeIndex ({ commit }) {
      axios.get('/api/dashboard/form-field-types')
        .then(({ data }) => {
          commit('SET_FORM_FIELD_TYPES', data)
        })
        .catch((error) => {
          console.log(error)
        })
    }
  }
}
