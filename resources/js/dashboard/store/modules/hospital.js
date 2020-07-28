export default {
    state: {
        hospitalData: null,
        hospitalCount: null,
        isLoading: false,
        selectedHospital: null,
        detailHospital: null,
        situationHospital: [],
        situationHospitalLoading: false,
        hospitalTotalData: null,
        hospitalManagerName: null,
    },
    mutations: {
        selectHospital(state, payload) {
            state.selectedHospital = payload;
        },
        setDetailHospital(state, payload) {
            state.detailHospital = payload;
        },
        setHospitalManagerName(state, payload) {
            state.hospitalManagerName = payload;
        }
    },
    actions: {
        getHospitalsData({ state }, payload) {
            state.isLoading = true;
            if (payload) {
                axios
                    .get(`/api/dashboard/hospitals`)
                    .then(({ data }) => {
                        let Features = data.map((value) => {
                            return {
                                type: "Feature",
                                geometry: {
                                    type: "Point",
                                    coordinates: [value.longitude, value.latitude]
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

                                    last_update: value.last_situation?.last_update,
                                    last_situation: value.last_situation,
                                    confirmed: value.last_situation?.confirmed ?? 0,
                                    sick: value.last_situation?.sick ?? 0,
                                    healed: value.last_situation?.healed ?? 0,
                                    dead: value.last_situation?.dead ?? 0,
                                    occupied_Beds: value.last_situation?.occupied_Beds ?? 0,
                                    occupied_respirators: value.last_situation?.occupied_respirators ?? 0,
                                    masks: value.last_situation?.masks ?? 0,
                                    occupied_foam_beds: value.last_situation?.occupied_foam_beds ?? 0,
                                    occupied_resuscitation_beds: value.last_situation?.occupied_resuscitation_beds ?? 0,
                                    individual_protection_equipment: value.last_situation?.individual_protection_equipment ?? 0,
                                    gel_hydro_alcoolique: value.last_situation?.gel_hydro_alcoolique ?? 0,
                                    resuscitation_ventilator: value.last_situation?.resuscitation_ventilator ?? 0,
                                    oxygenator: value.last_situation?.oxygenator ?? 0,
                                    rapid_screening: value.last_situation?.rapid_screening ?? 0,
                                    automate_genexpert: value.last_situation?.automate_genexpert ?? 0,
                                    x_ray: value.last_situation?.x_ray ?? 0,
                                    check_point: value.last_situation?.check_point ?? 0,
                                    chloroquine: value.last_situation?.chloroquine ?? 0,
                                    hydrochloroquine: value.last_situation?.hydrochloroquine ?? 0,
                                    azytromicine: value.last_situation?.azytromicine ?? 0,
                                    Vitamince_c: value.last_situation?.Vitamince_c ?? 0,
                                    color: "#ED5F68"
                                }
                            };
                        });
                        state.hospitalData = {
                            type: "geojson",
                            data: {
                                type: "FeatureCollection",
                                features: Features
                            }
                        };
                        state.hospitalCount = data.length;
                        state.isLoading = false;
                    })
                    .catch(() => {
                        state.isLoading = false;
                    });

                axios
                    .get(`/api/dashboard/hospitals/totaux`)
                    .then(({ data }) => {
                        state.hospitalTotalData = data
                    })
            } else {
                state.hospitalData = null;
                state.hospitalCount = null;
                state.isLoading = false;
                state.selectedHospital = null;
                state.hospitalTotalData = null;
            }
        },
        getSituationHospital({ state }, payload) {
            const selectedHospital = payload ? payload : ''
            state.situationHospitalLoading = true
            axios
                .get(`/api/dashboard/hospitals/evolution/${selectedHospital}`)
                .then(({ data }) => {
                    state.situationHospital = data
                    state.situationHospitalLoading = false
                })
        }
    }
}
