export default {
  state: {},
  mutations: {
    SET_ADMIN_USERS(state, payload) {
      state.adminUsers = payload;
    },
  },
  actions: {
    adminUser__getAgentHospitals() {
      return new Promise((resolve) => {
        axios.get('api/admin_users/agents-hospital').then(({ data }) => {
          resolve(data);
        });
      });
    },
  },
};
