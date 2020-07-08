export default {
    state: {
        fluxGeoGranularity: null,
        mapStyle: 1,
        fluxType: 1,
        fluxGeoOptions: []
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
        }

    }

}