export default {
    state: {
        fluxGeoGranularity: null,
        mapStyle: 1,
        fluxType: 1,
        fluxGeoOptions: [],
        fluxEnabled: false,
    },
    mutations: {
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
        }
    },
    actions: {
        resetState({ state }) {
            state.fluxGeoGranularity = null;
            state.mapStyle = 1;
            state.fluxType = 1;
            state.fluxGeoOptions = [];
            state.fluxEnabled = false;
        }
    }

}