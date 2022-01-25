import axios from "axios";

export default {
  state: {
    hospitalsList: [],
    hospitalSituation: [],
    isLoading: false,
    isCreating: false,
    hospitalSituationAll: [],
    observation_start: null,
    observation_end: null,
    hospitalSituationSelected: [],
  },

  mutations: {
    SET_HOSPITAL_SITUATION(state, payload) {
      state.hospitalSituation = payload;
    },
    SET_IS_LOADING(state, payload) {
      state.isLoading = payload;
    },
    SET_IS_CREATING(state, payload) {
      state.isCreating = payload;
    },
    SET_ALL_HOSPITAL_SITUATION(state, payload) {
      state.hospitalSituationAll = payload;
    },
    SET_HOSPITALS(state, payload) {
      state.hospitalsList = payload;
    },
    SET_SITUATION(state, payload) {
      state.hospitalSituationSelected = payload;
    },
  },
  actions: {
    createHospitalSituation({ state, commit, dispatch }, payload = {}) {
      commit("SET_IS_CREATING", true);
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        console.log("store:", payload);
        axios
          .post("api/dashboard/hospital-situations-new", payload)
          .then(({ data }) => {
            commit("SET_HOSPITAL_SITUATION", data);
            commit("SET_IS_LOADING", false);
            resolve(true);
          })
          .catch((response) => {
            reject(response);
          })
          .finally(() => {
            commit("SET_IS_CREATING", false);
          });
      });
    },
    getHospitalSituations({ state, commit }, { payload }) {
      commit("SET_IS_CREATING", true);
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .get("api/dashboard/hospital-situations-new")
          .then(({ data }) => {
            commit("SET_HOSPITAL_SITUATION", data);
            commit("SET_IS_LOADING", false);
            resolve(true);
          })
          .catch((response) => {
            reject(response);
          })
          .finally(() => {
            commit("SET_IS_CREATING", false);
          });
      });
    },
    getHospitalSituationsAll({ state, commit }) {
      commit("SET_IS_CREATING", true);
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .get("api/dashboard/get-hospital-situations-all")
          .then(({ data }) => {
            commit("SET_ALL_HOSPITAL_SITUATION", data);
            commit("SET_IS_LOADING", false);
            resolve(true);
          })
          .catch((response) => {
            reject(response);
          })
          .finally(() => {
            commit("SET_IS_LOADING", false);
          });
      });
    },
    getHospitals({ state, commit }) {
      commit("SET_IS_LOADING", true);
      return new Promise((resolve, reject) => {
        axios
          .get("api/dashboard/hospitals-data")
          .then(({ data }) => {
            commit("SET_HOSPITALS", data);
            commit("SET_IS_LOADING", false);
            resolve(true);
          })
          .catch((response) => {
            reject(response);
          })
          .finally(() => {
            commit("SET_IS_LOADING", false);
          });
      });
    },
    gethospitalsFiltered({ state, commit }, payload) {
      commit("SET_IS_LOADING", payload.isLoading);
      return new Promise((resolve, reject) => {
        axios
          .post("http://127.0.0.1:8000/api/dashboard/get-situations", payload)
          .then(({ data }) => {
            commit("SET_SITUATION", data);
            commit("SET_IS_LOADING", false);
            resolve(true);
            console.log("hospital filter", data);
          })
          .catch((response) => {
            reject(response);
          })
          .finally(() => {
            commit("SET_IS_LOADING", false);
          });
      });
    },
  },
};
