export default {
  state: {
    epidemicExtValues: { min: 0, max: 100 },
    legendEpidHover: null, // null ou {'de' : interger , 'a' : integer} ou {'de' : null, 'a' : null}
  },
  mutations: {
    setEpidemicExtValues(state, payload) {
      state.epidemicExtValues = payload;
    },
    setLegendEpidHover(state, sectionHover) {
      state.legendEpidHover = sectionHover;
    },
  },
};
