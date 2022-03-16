/* eslint-disable comma-spacing */
import axios from "axios";
import { event } from "vue-gtag";

export default {
  state: {
    hospitalData: null,
    hospitalCount: null,
    isLoading: false,
    selectedHospital: null,
    detailHospital: null,
    situationHospital: [],
    hospitalSituations: {},
    situationHospitalLoading: false,
    hospitalTotalData: null,
    hospitalManagerName: null,
    hospitalManagerFirstName: null,
    observation_end: null,
    observation_start: null,
    township: null,
  },
  mutations: {
    selectHospital(state, payload) {
      state.selectedHospital = payload;
    },
    setDetailHospital(state, payload) {
      state.detailHospital = payload;
    },
    setHospitalManagerName(state, payload) {
      state.hospitalManagerName = payload.name;
      state.hospitalManagerFirstName = payload.firstName;
    },
    SET_HOSPITAL(state, payload) {
      state.hospitalData = payload;
    },
    SET_IS_LOADING(state, payload) {
      state.isLoading = payload;
    },
    SET_HOSPITAL_SITUATIONS(state, payload) {
      state.hospitalSituations = payload;
    },
  },
  actions: {
    getHospitalsData({ state }, payload) {
      state.isLoading = payload.isLoading;
      if (payload) {
        if (payload.observation_end) {
          state.observation_end = payload.observation_end;
        }
        if (payload.observation_start) {
          state.observation_start = payload.observation_start;
        }
        state.township = payload.township;

        event("fetch_Infrastructures_data_request", {
          event_category: "fetch_Infrastructures_data",
          event_label: "hospitals_data_req_send",
        });

        axios
          .get("/api/dashboard/hospitals", {
            params: {
              observation_end: payload.observation_end || null,
              observation_start: payload.observation_start || null,
              township: payload.township,
            },
          })
          .then(({ data }) => {
            const Features = data.map((value) => {
              return {
                type: "Feature",
                geometry: {
                  type: "Point",
                  coordinates: [value.longitude, value.latitude],
                },
                properties: {
                  name: value.name ? value.name : "Hopital",
                  id: value.id,
                  address: value.address,
                  foam_beds: value.foam_beds,
                  respirators: value.respirators ?? 0,
                  resuscitation_beds: value.resuscitation_beds ?? 0,
                  doctors: value.doctors ?? 0,
                  nurses: value.nurses ?? 0,
                  para_medicals: value.para_medicals ?? 0,

                  last_update: value.last_update ?? "",
                  completed_forms: JSON.stringify(value.completed_forms ?? []),
                  aggregated: JSON.stringify(value.aggregated ?? []),
                  color: "#ED5F68",
                },
              };
            });
            state.hospitalData = {
              type: "geojson",
              data: {
                type: "FeatureCollection",
                features: Features,
              },
            };
            state.hospitalCount = data.length;
            state.isLoading = false;

            event("fetch_Infrastructures_data_request", {
              event_category: "fetch_Infrastructures_data",
              event_label: "hospitals",
            });
          })
          .catch(({ response }) => {
            state.isLoading = false;
            // eslint-disable-next-line no-undef
            exception(response);
          });

        event("fetch_Infrastructures_data_response", {
          event_category: "fetch_Infrastructures_data",
          event_label: "hospital_totaux_req_send",
        });
        axios
          .get("/api/dashboard/hospitals/totaux", {
            params: {
              observation_end: payload.observation_end || null,
              observation_start: payload.observation_start || null,
              township: payload.township,
            },
          })
          .then(({ data }) => {
            state.hospitalTotalData = data;
            event("fetch_Infrastructures_data_response", {
              event_category: "fetch_Infrastructures_data",
              event_label: "hospital_totaux",
            });
          })
          .catch(({ response }) => {
            // eslint-disable-next-line no-undef
            exception(response);
          });
      } else {
        state.hospitalData = null;
        state.hospitalCount = null;
        state.isLoading = false;
        state.selectedHospital = null;
        state.hospitalTotalData = null;
      }
    },
    getSituationHospital({ state }, payload) {
      const selectedHospital = payload || "";
      state.situationHospitalLoading = true;
      const params = {
        observation_end: state.observation_end,
        observation_start: state.observation_start,
        township: state.township,
      };

      event("fetch_Infrastructures_data_request", {
        event_category: "fetch_Infrastructures_data",
        event_label: "fetch_Infrastructures_evolution_data_req_send",
      });
      const url = `/api/dashboard/hospitals/evolution${
        selectedHospital ? `/${selectedHospital}` : ""
      }`;
      axios
        .get(url, {
          params,
        })
        .then(({ data }) => {
          state.situationHospital = data;
          state.situationHospitalLoading = false;

          event("fetch_Infrastructures_data_response", {
            event_category: "fetch_Infrastructures_data",
            event_label: "Infrastructures_evolution",
          });
        })
        .catch(({ response }) => {
          // eslint-disable-next-line no-undef
          exception(response);
        });
    },
    getHospitals({ state, commit }, payload = {}) {
      commit("SET_IS_LOADING", true);

      return new Promise((resolve, reject) => {
        axios
          .get("/api/dashboard/hospitals-data/by-paginate", {
            params: payload.page,
          })
          .then(({ data }) => {
            commit("SET_HOSPITAL", data);
            resolve(data);
            commit("SET_IS_LOADING", false);
          })
          .catch((response) => {
            reject(response);
          })
          .finally(() => {
            commit("SET_IS_LOADING", false);
          });
      });
    },
    getHospital({ state, commit }, payload = {}) {
      commit("SET_IS_LOADING", true);

      return new Promise((resolve, reject) => {
        axios
          .get(`/api/dashboard/hospitals-data/${payload.hospital_id}`)
          .then(({ data }) => {
            commit("SET_HOSPITAL", data);
            resolve(true);
            commit("SET_IS_LOADING", false);
          })
          .catch((response) => {
            reject(response);
          })
          .finally(() => {
            commit("SET_IS_LOADING", false);
          });
      });
    },
    getHospitalSituations({ state, commit }, payload = {}) {
      commit("SET_IS_LOADING", payload.isLoading);
      return new Promise((resolve, reject) => {
        axios
          .get(
            `/api/dashboard/completed_forms/by-hospital/${payload.hospital_id}`,
            {
              params: { page: payload.page },
            }
          )
          .then(({ data }) => {
            commit("SET_HOSPITAL_SITUATIONS", data);
            resolve(true);
            commit("SET_IS_LOADING", false);
          })
          .catch((response) => {
            console.log(response);
            reject(response);
          });
      });
    },

    hospital__remove({ state, commit }, payload = {}) {
      commit("SET_IS_LOADING", true);
      return new Promise((resolve, reject) => {
        axios
          .patch(`/api/dashboard/hospitals-data/${payload.id}/reject-agent`)
          .then(({ data }) => {
            commit("SET_HOSPITAL", data);
            resolve(true);
            commit("SET_IS_LOADING", false);
          })
          .catch((response) => {
            console.log(response);
            reject(response);
          });
      });
    },
    hospital__store({ state, commit }, payload = {}) {
      commit("SET_IS_LOADING", true);
      return new Promise((resolve, reject) => {
        axios
          .post("/api/dashboard/hospitals-data", {
            name: payload.name,
            latitude: payload.latitude,
            longitude: payload.longitude,
            agent_id: payload.agent_id,
            township_id: payload.township_id,
          })
          .then(({ data }) => {
            commit("SET_HOSPITAL", data);
            resolve(true);
            commit("SET_IS_LOADING", false);
          })
          .catch((response) => {
            console.log(response);
            reject(response);
          });
      });
    },
    hospital__update({ state, commit }, payload = {}) {
      commit("SET_IS_LOADING", true);
      return new Promise((resolve, reject) => {
        axios
          .patch(
            `/api/dashboard/hospitals-data/update-by-admin/${payload.id}`,
            {
              id: payload.id,
              name: payload.name,
              latitude: payload.latitude,
              longitude: payload.longitude,
              agent_id: payload.agent_id,
              township_id: payload.township_id,
            }
          )
          .then(({ data }) => {
            commit("SET_HOSPITAL", data);
            resolve(true);
            commit("SET_IS_LOADING", false);
          })
          .catch((response) => {
            console.log(response);
            reject(response);
          });
      });
    },
    hospital__filter({ state, commit }, payload = {}) {
      commit("SET_IS_LOADING", true);
      return new Promise((resolve, reject) => {
        axios
          .get(`/api/dashboard/hospitals-data/filter/key_words=${payload}`)
          .then(({ data }) => {
            commit("SET_HOSPITAL", data);
            resolve(data);
            commit("SET_IS_LOADING", false);
          })
          .catch((response) => {
            console.log(response);
            reject(response);
          });
      });
    },
  },
};
