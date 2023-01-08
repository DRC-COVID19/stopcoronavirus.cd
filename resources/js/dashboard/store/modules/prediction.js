import { PREDICTION_API_URL } from '../../config/env';
import axios2 from 'axios';

export default {
  state: {
    isLoading: false,
    predictedData: [],
    correlationData: null,
    predictionFilter: {},
    error: false,
  },
  mutations: {
    SET_PREDICTED_DATA(state, payload) {
      state.predictedData = payload;
    },

    SET_CORRELATION_DATA(state, payload) {
      state.correlationData = payload;
    },

    SET_PREDICTION_FILTER(state, payload) {
      state.predictionFilter = payload;
    },

    SET_IS_PREDICTION_LOADING(state, payload) {
      state.isLoading = payload;
    },
    SET_ERROR(state, payload) {
      state.error = payload;
    },
  },
  getters: {
    prediction__GetFormattedData: (state) => {
      let formattedData = [];

      /* data = {
      form_field_id: 2,
      form_field_name: "",
      originals: [
        { date: '2022-11-17', value: 10},
        { date: '2022-11-18', value: 10}
      ],
      predicted: [
        { date: '2022-11-20', value: 10},
        { date: '2022-11-22', value: 11},
        { date: '2022-11-23', value: 12}
      ]
    } */
      state.predictedData.forEach((data) => {
        const originals = data.originals.map((d) => ({
          date: d.date,
          [data.form_field_name]: { value: d.value, updated: d.updated },
        }));

        const predicted = data.predicted.map((d) => ({
          date: d.date,
          [data.form_field_name]: { value: d.value, updated: d.updated },
        }));

        [...originals, ...predicted].forEach((d) => {
          const currentData = formattedData.find((f) => f.date === d.date);
          if (!!currentData) {
            formattedData = formattedData.map((f) =>
              f.date === currentData.date ? { ...f, ...d } : f
            );
          } else {
            formattedData.push(d);
          }
        });
      });

      return formattedData;
    },
  },
  actions: {
    prediction__GetPredictedData(action, payload = {}) {
      return requestAction('prediction/', action, payload);
    },
    prediction__RecalculatePredictedData(action, payload = {}) {
      return requestAction('recompute/', action, payload);
    },
  },
};

async function requestAction(url, { state, commit }, payload = {}) {
  return new Promise((resolve, reject) => {
    commit('SET_IS_PREDICTION_LOADING', true);
    commit('SET_ERROR', false);
    axios2
      .post(`${PREDICTION_API_URL}/${url}`, payload, {
        timeout: 300000,
      })
      .then(({ data }) => {
        commit('SET_PREDICTED_DATA', data.response);
        commit('SET_CORRELATION_DATA', data.correlation);
        commit('SET_PREDICTION_FILTER', payload);
        commit('SET_IS_PREDICTION_LOADING', false);
        commit('SET_ERROR', false);
        resolve(data);
      })
      .catch((error) => {
        commit('SET_IS_PREDICTION_LOADING', false);
        console.log('rr', error.response);
        if (error.response?.data?.message) {
          commit('SET_ERROR', error.response?.data?.message);
        } else {
          commit(
            'SET_ERROR',
            "Une erreur est survenu pendant l'opération veuillez ressayer s'il vous plaît."
          );
        }

        reject(error);
      });
  });
}
