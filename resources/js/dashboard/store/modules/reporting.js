export default {
  state: {
    linesSelected: [],
    columnsSelected: [],
  },
  mutations: {
    SET_LINES(state, payload) {
      state.linesSelected = payload;
    },
    SET_COLUMNS(state, payload) {
      state.columnsSelected = payload;
    },
    SET_RESET(state, payload) {
      state.linesSelected = [];
      state.columnsSelected = [];
    },
  },
  actions: {
    reporting__editLines({ state, commit, dispatch }, payload = []) {
      commit('SET_LINES', payload);
    },
    reporting__editColumns({ state, commit, dispatch }, payload = []) {
      commit('SET_COLUMNS', payload);
    },
    reporting__reset({ commit }) {
      commit('SET_RESET');
    },
  },
};
