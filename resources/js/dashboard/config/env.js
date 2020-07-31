
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
    ],
    DRC_COVID_EVENT = [
        {
            id: 1,
            name: 'First case of COVID-19 confirmed (Congolese national returning from France)',
            date: '2020-03-10',
            measures: [
                {
                    item: 'First case of COVID-19 confirmed (Congolese national returning from France)',
                    zones: ['Kinshasa']
                }
            ],
            zone: ['Kinshasa'],
        },
        {
            id: 2,
            name: "First restriction measures put in place for international and national travel/ flight arrivals (health information sheets and temperature/ symptom checks on arrival at airports and ports)",
            date: '2020-03-13',
            measures: [
                {
                    item: 'First restriction measures put in place for international and national travel/ flight arrivals (health information sheets and temperature/ symptom checks on arrival at airports and ports)',
                    zones: ["Kinshasa"]
                }
            ],
            zone: ['Kinshasa']
        },
        {
            id: 3,
            name: 'Flights from at-risk countries suspended (exept some cargo)',
            measures: [
                {
                    item: `Flights from at-risk countries suspended (exept some cargo)`,
                    zones: ['Kinshasa']
                },
                {
                    item: `Bars, restaurants closed; schools closed; gatherings of more than 20 people banned; religious gatherings and sports events suspended until further notice; passengers limited on public transport in Kinshasa`,
                    zones: ['Kinshasa']
                }

            ],
            zone: ['Kinshasa'],
            isImportant: true,
            date: '2020-03-18'
        },
        {
            id: 4,
            name: 'All travel to or from Kinshasa banned (except cargo)',
            measures: [
                {
                    item: `All travel to or from Kinshasa banned (except cargo)`,
                    zones: ["Kinshasa"]
                }
            ],
            zone: ['Kinshasa'],
            date: '2020-03-19'
        },
        {
            id: 5,
            name: 'First COVID-19 related death recorded in the DRC',
            measures: [
                {
                    item: 'First COVID-19 related death recorded in the DRC',
                    zones: ['Kinshasa']
                }
            ],
            zone: ['Kinshasa'],
            date: '2020-03-21'
        },
        {
            id: 6,
            name: '48 hour lockdown (two suspected cases coming off a plane from Kinshasa)',
            measures: [
                {
                    item: '48 hour lockdown (two suspected cases coming off a plane from Kinshasa)',
                    zones: ['Lubumbashi']
                }
            ],
            zone: ['Lubumbashi'],
            date: '2020-03-23'
        },
        {
            id: 7,
            name: 'State of emergency declared by Congolese government',
            measures: [
                {
                    item: 'State of emergency declared by Congolese government',
                    zones: ['Lubumbashi']
                }
            ],
            zone: ['Lubumbashi'],
            date: '2020-03-24'
        },
        {
            id: 8,
            name: 'Domestic travel between Kinshasa and the rest of the country suspended; all borders closed except for trade',
            measures: [
                {
                    item: 'Domestic travel between Kinshasa and the rest of the country suspended; all borders closed except for trade',
                    zones: ['ALL']
                }
            ],
            zone: ['ALL'],
            date: '2020-03-25'
        },
        {
            id: 9,
            name: 'Prohibition of all gatherings of people in public spaces',
            measures: [
                {
                    item: 'Prohibition of all gatherings of people in public spaces',
                    zones: ['ALL']
                }
            ],
            zone: ['ALL'],
            date: '2020-03-26'
        },
        {
            id: 10,
            name: 'Income tax suspension for all civil servants and other state employees for 3 months',
            measures: [
                {
                    item: 'Income tax suspension for all civil servants and other state employees for 3 months',
                    zones: ["ALL"]
                },
                {
                    item: 'First COVID-19 case in Ituri Province',
                    zones: ["Ituri"]
                },
                {
                    item: '3 week lockdown announced by Governor of Kinshasa from March 28th-April 27th',
                    zones: ["Kinshasa"]
                },
                {
                    item: 'Lockdown in Kinshasa postponed amid insecurity and price speculation on basic goods',
                    zones: ['Kinshasa']
                }
            ],
            zone: ['ALL'],
            date: '2020-03-27'
        }
    ]
