export default {
    state: {
        fluxGeoGranularity: null,
        mapStyle: 1,
    },
    mutations: {
        setFluxGeoGranularity(state, payload) {
            state.fluxGeoGranularity = payload
        },
        setMapStyle(state, payload) {
            state.mapStyle = payload;
        }
    }

}