import mock from '../../mock';

export default {
  state: {
    isLoading: false,
    predictedData: [],
    predictionFilter: {},
  },
  mutations: {
    SET_PREDICTED_DATA(state, payload) {
      state.predictedData = payload;
    },

    SET_PREDICTION_FILTER(state, payload) {
      state.predictionFilter = payload;
    },

    SET_IS_LOADING(state, payload) {
      state.isLoading = payload;
    },
  },
  getters: {},
  actions: {
    prediction__GetPredictedData({ state, commit }, payload = {}) {
      commit('SET_IS_LOADING', true);
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        mock
          .fetchPredictions()
          .then(({ data }) => {
            commit('SET_PREDICTED_DATA', data);
            console.log('PREDICTED_DATA', data);
            console.log('PREDICTION_FILTER', payload);
            commit('SET_PREDICTION_FILTER', payload);
            commit('SET_IS_LOADING', false);
            resolve(data);
          })
          .catch((response) => {
            reject(response);
          });
      });
    },
  },
};
