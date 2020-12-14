import {event} from 'vue-analytics';

export default {
  state: {
    fluxGeoGranularity: null,
    fluxGeoGranularityTemp: null,
    mapStyle: 1,
    fluxType: 1,
    fluxTimeGranularity: null,
    fluxGeoOptions: [],
    fluxGeoOptionsTmp: [],
    fluxEnabled: true,
    isWatchingfluxGeoOptions: true,
    domaineExtValues: {},
    tendanceChartSelectedValue: null,
    isProvinceStatSeeing: false,
    legendHover: null, // null ou {'de' : interger , 'a' : integer} ou {'de' : null, 'a' : null}
    typePresence: 1,
    afriFluxType: 1,
    selectedSource: 1,
    observationDate: {}
  },
  mutations: {
    setIsWatchingfluxGeoOptions(state, payload) {
      state.isWatchingfluxGeoOptions = payload;
    },
    setFluxGeoGranularity(state, payload) {
      state.fluxGeoGranularity = payload
    },
    setFluxTimeGranularity(state, payload) {
      state.fluxTimeGranularity = payload
    },
    setFluxGeoGranularityTemp(state, payload) {
      state.fluxGeoGranularityTemp = payload
    },
    setMapStyle(state, payload) {
      state.mapStyle = payload;
    },
    setFluxType(state, payload) {
      let fluxType = ""
      if(payload == 1) fluxType = "Entrante"
      else if(payload == 2) fluxType = "Sortante"
      else if(payload == 3) fluxType = "Présences"
      else if(payload == 4) fluxType = "Général"
      event('Mobilité', 'Switch type mobilité', 'Mobilité', fluxType);

      state.fluxType = payload
    },
    setFluxGeoOptions(state, payload) {
      state.fluxGeoOptions = payload;
    },
    setFluxGeoOptionsTmp(state, payload) {
      state.fluxGeoOptionsTmp = payload;
    },
    setFluxEnabled(state, payload) {
      state.fluxEnabled = payload;
    },
    setLegendHover(state, sectionHover) {
      if (sectionHover) {
        let from = null;
        let to = null;
        if (typeof sectionHover.de == "string") {
          from = Number(sectionHover.de.replace("%", ""));
        }
        if (typeof sectionHover.a == "string") {
          to = Number(sectionHover.a.replace("%", "")) + 1;
        }
        sectionHover.de = from;
        sectionHover.a = to;
      }
      state.legendHover = sectionHover
    },
    setDomaineExtValues(state, payload) {
      state.domaineExtValues = payload;
    },
    setTendanceChartSelectedValue(state, payload) {
      state.tendanceChartSelectedValue = payload;
    },
    setIsProvinceStatSeeing(state, payload) {
      if(payload) event('Mobilité', 'Switch type mobilité', 'Mobilité', 'zones');
      state.isProvinceStatSeeing = payload;
    },
    setTypePresence(state, payload) {
      let fluxType = ""
      if(payload == 1) fluxType = "Jour & Nuit"
      else if(payload == 2) fluxType = "Jour"
      else if(payload == 3) fluxType = "Nuit"

      event('Mobilité', 'Switch type presence mobilité', 'Presence', fluxType);
      state.typePresence = payload;
    },
    setAfriFluxType(state, payload) {

      state.afriFluxType = payload;
    },
    setSelectedSource(state, payload) {
      state.selectedSource = payload;
    },
    setObservationDate(state, payload) {
      state.observationDate = payload;
    }
  },
  actions: {
    resetState({ state }) {
      state.fluxGeoGranularity = null;
      state.mapStyle = 1;
      state.fluxType = 1;
      state.fluxGeoOptions = [];
      state.fluxEnabled = false;
      state.legendHover = null;
      state.domaineExtValues = {}
    },
    setLegendHover({ state, commit }, sectionHover) {
      commit('setLegendHover', sectionHover)
    }
  },
  getters: {
    fluxType: state => state.fluxType,
    legendHover: state => state.legendHover
  }
}
