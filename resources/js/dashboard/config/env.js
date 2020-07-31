
export const
    MAPBOX_TOKEN = "pk.eyJ1IjoibWVya2kyMzAiLCJhIjoiY2s5aWdkejJzMDhybTNkcWxtMm9la2h4aCJ9.5NwFpUn264STu43zxmTyOw",
    MAPBOX_DEFAULT_STYLE = "mapbox://styles/merki230/ckas344r30gmj1ips9gar4uxw",
    ADMIN_DASHBOARD = "admin-dashboard",
    AGENT_HOSPITAL = "agent-hospital",
    ADMIN_HOSPITAL = "admin-hospital",
    PALETTE = {
        outflow: ["#7F3B08", "#B35806", "#E08214", "#FDB863", "#B2ABD2", "#8073AC", "#542788", "#2D004B"],
        inflow: ["#2166AC", "#4393C3", "#92C5DE", "#D1E5F0", "#FDDBC7", "#F4A582", "#D6604D", "#B2182B"],
        present: ["#F4A582", "#F8D28C", "#CCEBC5", "#A8DDB5", "#7BCCC4", "#4EB3D3", "#2B8CBE", "#08589E"],
        nodata: "#eeeeee",
        bordure_shape_file: " #BFC5D2",
        flux_out_color: "#88419d",
        flux_in_color: "#225ea8",
        flux_presence: "#E31A1C",
        dash_green: "#33ac2e",
        epidemic: ["#FFFFB2", "#FECC5C", "#FD8D3C", "#E31A1C"]
    },
    PREFERENCE_START = "2020-02-01",
    PREFERENCE_END = "2020-03-18",
    DATEFORMAT = "Y-MM-DD",
    FLUX_PREDEFINED_INPUT = [
        {
            id: 1,
            name: "Aujourd'hui"
        },
        {
            id: 2,
            name: "Semaine en cours"
        },
        {
            id: 3,
            name: "Mois en cours"
        },
        {
            id: 4,
            name: "Mois passé"
        },
        {
            id: 6,
            name:
                "Mobilité à la Gombe une semaine après le debut du confinement (24h)"
        },
        {
            id: 5,
            name: "Mobilité à la Gombe depuis le début du confinement"
        }
    ],
    GEO_GRANULARITIES = [
        {
            id: 1,
            name: "Provinces"
        },
        {
            id: 2,
            name: "Zones des santés"
        }
    ],
    TEMP_GRANULARITIES = [
        {
            id: 1,
            name: "24h"
        },
        {
            id: 2,
            name: "30'"
        }
    ],
    INDICATEUR_X = [
        {
            id: 1,
            name: 'Mobilité entrante'
        },
        {
            id: 2,
            name: 'Mobilité sortante'
        }
    ],
    INDICATEUR_Y = [
        {
            id: 1,
            name: 'Cas Confirmés'
        },
    ],
    INDICATEUR_PREDEFINED_INPUT = [
        {
            id: 1,
            name: 'Mobilité vs Epidémiologie à la Gombe, une semaine après le debut du confinement'
        }
    ]