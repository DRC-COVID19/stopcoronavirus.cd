export default {
    state: {
        fluxGeoGranularity: null,
        mapStyle: 1,
        fluxType: 1,
        fluxGeoOptions: [],
        fluxEnabled: false,
        isWatchingfluxGeoOptions: true,
        legendHover : null // null ou {'de' : interger , 'a' : integer} ou {'de' : null, 'a' : null}
    },
    mutations: {
        setIsWatchingfluxGeoOptions(state, payload) {
            state.isWatchingfluxGeoOptions = payload;
        },
        setFluxGeoGranularity(state, payload) {
            state.fluxGeoGranularity = payload
        },
        setMapStyle(state, payload) {
            state.mapStyle = payload;
        },
        setFluxType(state, payload) {
            state.fluxType = payload
        },
        setFluxGeoOptions(state, payload) {
            state.fluxGeoOptions = payload;
        },
        setFluxEnabled(state, payload) {
            state.fluxEnabled = payload;
        },
        setLegendHover(state, sectionHover) {
            state.legendHover = sectionHover
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
        },
        setLegendHover({state,commit}, sectionHover){
            commit('setLegendHover', sectionHover)
        }
    },
    getters : {
        fluxType : state => state.fluxType,
        legendHover : state => state.legendHover
    }
}