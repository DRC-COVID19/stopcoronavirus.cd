export default {
    state: {
        fluxGeoGranularity: null,
    },
    mutations: {
        setFluxGeoGranularity(state, payload) {
            state.fluxGeoGranularity = payload
        }
    }

}