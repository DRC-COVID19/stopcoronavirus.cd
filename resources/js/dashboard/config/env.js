
export const
    MAPBOX_TOKEN = "pk.eyJ1IjoibWVya2kyMzAiLCJhIjoiY2s5aWdkejJzMDhybTNkcWxtMm9la2h4aCJ9.5NwFpUn264STu43zxmTyOw",
    MAPBOX_DEFAULT_STYLE = "mapbox://styles/merki230/ckas344r30gmj1ips9gar4uxw",
    ADMIN_DASHBOARD = "admin-dashboard",
    AGENT_HOSPITAL = "agent-hospital",
    ADMIN_HOSPITAL = "admin-hospital",
    PALETTE = {
        outflow: ["#7f00d4", "#7400c1", "#6800ad", "#5c009", "#500086", "#450072", "#39005f", "#2d004b"],
        inflow: ["#2189ac", "#3f8cda", "#2a7fd6", "#2573c1", "#2166ac", "#1d5997", "#194d81", "#15406c"],
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
        },
        {
            id: 11,
            name: 'First COVID-19 case (Bunia)',
            measures: [
                {
                    item: 'First COVID-19 case (Bunia)',
                    zones: ["Bunia", "Ituri"]
                }
            ],
            date: '2020-04-01'
        },
        {
            id: 12,
            name: 'First COVID-19 case (Beni)',
            measures: [
                {
                    item: 'First COVID-19 case (Bunia)',
                    zones: ["Beni", "Nord-kivu"]
                }
            ],
            date: '2020-04-03'
        },
        {
            id: 13,
            name: 'First COVID-19 case (Idiofa)',
            measures: [
                {
                    item: 'First COVID-19 case (Bunia)',
                    zones: ["Idiofa", "Kwilu"]
                }
            ],
            date: '2020-04-04'
        },
        {
            id: 14,
            name: '2 week "lockdown"/ confinement introduced in Goma',
            measures: [
                {
                    item: '2 week "lockdown"/ confinement introduced in Goma',
                    zones: ["Goma", "Nord-kivu"]
                }
            ],
            date: '2020-04-05'
        },
        {
            id: 15,
            name: 'Outward movements from Goma, Beni, Butemo suspended (6/4 - 20/4) ("14 day confinement"), residents required to stay at home',
            measures: [
                {
                    item: 'Outward movements from Goma, Beni, Butemo suspended (6/4 - 20/4) ("14 day confinement"), residents required to stay at home',
                    zones: ["Nord-kivu"]
                },
                {
                    item: 'Travel between Goma and Bukavu suspended (6/4 - 20/4)',
                    zones: ["Nord-kivu", "Sud-kivu"]
                },
                {
                    item: '2 week "lockdown"/ confinement introduced (6/4 - 20/4) (people cannot leave homes) in Gombe',
                    zones: ["Gombe", "Kinshasa"]
                }
            ],
            date: '2020-04-06'
        },
        {
            id: 16,
            name: 'Lockdown measures in North Kivu province extended (until 30/4)',
            measures: [
                {
                    item: 'Lockdown measures in North Kivu province extended (until 30/4)',
                    zones: ["Nord-kivu"]
                }
            ],
            date: '2020-04-13'
        },
        {
            id: 17,
            name: 'Face masks mandatory in public spaces in Kinshasa (5000 CF if masks not worn)',
            measures: [
                {
                    item: 'Face masks mandatory in public spaces in Kinshasa (5000 CF if masks not worn)',
                    zones: ["Kinshasa"]
                },
                {
                    item: 'Self-quarantine for high-risk people (over age 60 or with preexisting conditions) mandatory in South Kivu.',
                    zones: ["Sud-kivu"]
                },
                {
                    item: 'Internal travel between the towns of Goma, Beni and Butembo continued to be suspended',
                    zones: ["Nord-kivu"]
                },
                {
                    item: 'Curfew in Lualaba and Lubumbashi from 10 p.m. to 5 a.m',
                    zones: ["Lualaba", "Lubumbashi"]
                }
            ],
            date: '2020-04-20'
        },
        {
            id: 17,
            name: 'State of emergency extended by Congolese government - 20 days (21/4 - 10/5) ',
            measures: [
                {
                    item: 'State of emergency extended by Congolese government - 20 days (21/4 - 10/5) ',
                    zones: ["ALL"]
                },
            ],
            date: '2020-04-21'
        },
        {
            id: 18,
            name: 'Gombe lockdown restrictions eased (reopening of banks and some shops selling food)',
            measures: [
                {
                    item: 'Gombe lockdown restrictions eased (reopening of banks and some shops selling food)',
                    zones: ["Gombe", "Kinshasa"]
                },
            ],
            date: '2020-04-22'
        },
        {
            id: 19,
            name: 'State of health emergency extended by Parliament for two weeks.',
            measures: [
                {
                    item: 'State of health emergency extended by Parliament for two weeks. ',
                    zones: ["ALL"]
                },
            ],
            date: '2020-04-23'
        },
        {
            id: 20,
            name: 'First confirmed COVID-19 case in Lubumbashi',
            measures: [
                {
                    item: 'First confirmed COVID-19 case in Lubumbashi',
                    zones: ["Lubumbashi"]
                },
            ],
            date: '2020-04-24'
        },
        {
            id: 21,
            name: 'Lubumbashi and Kasumbalesa under a 24-hour lockdown for contact tracing',
            measures: [
                {
                    item: 'Lubumbashi and Kasumbalesa under a 24-hour lockdown for contact tracing',
                    zones: ["Lubumbashi", "Kasumbalesa"]
                },
            ],
            date: '2020-04-29'
        },
        {
            id: 22,
            name: 'Face masks mandatory in public spaces (Lubumbashi) 5000 CF fine for non-compliers',
            measures: [
                {
                    item: 'Face masks mandatory in public spaces (Lubumbashi) 5000 CF fine for non-compliers',
                    zones: ["Lubumbashi"]
                },
            ],
            date: '2020-05-04'
        },
        {
            id: 23,
            name: 'Communication from the governor of Ituri',
            measures: [
                {
                    item: `"Communication from the governor of Ituri: 
                    - Commercial flights between Ituri - Isiro - Goma - Kisangani via CAA and Congo Airways resumed
                    - Passengers coming from Kinshasa also allowed, as long as they respect IPC measures on board and on arrival in Ituri"`,
                    zones: ["Ituri"]
                },
            ],
            date: '2020-05-05'
        },
        {
            id: 24,
            name: 'Partial reopening of border between DRC and Zambia for pedestrians following clashes between civilians and security forces',
            measures: [
                {
                    item: `Partial reopening of border between DRC and Zambia for pedestrians following clashes between civilians and security forces`,
                    zones: ["Kasumbalesa"]
                },
            ],
            date: '2020-05-08'
        },
        {
            id: 25,
            name: 'Face masks mandatory in public spaces in Matadi (Kongo Central province)',
            measures: [
                {
                    item: `Face masks mandatory in public spaces in Matadi (Kongo Central province)`,
                    zones: ["Matadi", "Kongo-central"]
                },
            ],
            date: '2020-05-11'
        },
        {
            id: 26,
            name: 'Income tax (suspended on 27th March for 3 months for civil servants/state employees) reinstated to address shortfall of $11 million USD (finance minister justifies this move by blaming mine and border closures for loss in revenue for Kinshasa',
            measures: [
                {
                    item: `Income tax (suspended on 27th March for 3 months for civil servants/state employees) reinstated to address shortfall of $11 million USD (finance minister justifies this move by blaming mine and border closures for loss in revenue for Kinshasa`,
                    zones: ["Kinshasa"]
                },
            ],
            date: '2020-05-14'
        },
        {
            id: 27,
            name: `"Curfew (from 20h00) and isolation of Goma from other territories in province for 14 days
            - Police instructed to enforce curfew measures"`,
            measures: [
                {
                    item: `"Curfew (from 20h00) and isolation of Goma from other territories in province for 14 days
                    - Police instructed to enforce curfew measures"`,
                    zones: ["Goma"]
                },
            ],
            date: '2020-05-17'
        },
        {
            id: 28,
            name: `Goma town hall activities suspended until further notice (member tested positive for COVID)`,
            measures: [
                {
                    item: `Goma town hall activities suspended until further notice (member tested positive for COVID)`,
                    zones: ["Goma"]
                },
            ],
            date: '2020-05-18'
        },
        {
            id: 29,
            name: `"Reports that seizures and attacks on the COVID response teams have multiplied at the community level in Kinshasa; 
            - Resulted in pausing of surveillence and contact tracing activities
            - Most recent recorded in Kimbanseke health zone (concerning violence against three agents de la riposte who were held in a household in the Maviokele district)"`,
            measures: [
                {
                    item: `"Reports that seizures and attacks on the COVID response teams have multiplied at the community level in Kinshasa; 
                    - Resulted in pausing of surveillence and contact tracing activities
                    - Most recent recorded in Kimbanseke health zone (concerning violence against three agents de la riposte who were held in a household in the Maviokele district)"`,
                    zones: ["Kinshasa"]
                },
            ],
            date: '2020-05-19'
        },
        {
            id: 30,
            name: `Traffic between Goma and Bukavu suspended`,
            measures: [
                {
                    item: `Traffic between Goma and Bukavu suspended`,
                    zones: ["Goma"]
                },
            ],
            date: '2020-05-20'
        },
        {
            id: 31,
            name: `Parliament vote to extend period of health emergency for 15 days`,
            measures: [
                {
                    item: `Parliament vote to extend period of health emergency for 15 days`,
                    zones: ["ALL"]
                },
            ],
            date: '2020-05-22'
        },
        {
            id: 32,
            name: `COVID screening centre opens at Martyrs stadium`,
            measures: [
                {
                    item: `COVID screening centre opens at Martyrs stadium`,
                    zones: ["Kinshasa"]
                },
            ],
            date: '2020-05-26'
        },
        {
            id: 33,
            name: `Containment of Ibanda commune, Bukavu, and city-wide curfew (8pm-5pm)`,
            measures: [
                {
                    item: `Containment of Ibanda commune, Bukavu, and city-wide curfew (8pm-5pm)`,
                    zones: ["Bukavu"]
                },
            ],
            date: '2020-06-01'
        },
        {
            id: 34,
            name: `Curfew in Goma lifted`,
            measures: [
                {
                    item: `Curfew in Goma lifted`,
                    zones: ["Goma"]
                },
                {
                    item: `Suspension of isolation of Goma and surroundings (except travel between Goma and Bukavu, and air travel)`,
                    zones: ["Goma"]
                },
            ],
            date: '2020-06-03'
        },
        {
            id: 35,
            name: `State of emergency extended for 15 days (from 8/6/20)`,
            measures: [
                {
                    item: `State of emergency extended for 15 days (from 8/6/20)`,
                    zones: ["ALL"]
                },
            ],
            date: '2020-06-08'
        },
        {
            id: 36,
            name: `3 dead in protests against COVID restrictions in Kinshasa central market (merchants were trading despite mandated closure)`,
            measures: [
                {
                    item: `3 dead in protests against COVID restrictions in Kinshasa central market (merchants were trading despite mandated closure)`,
                    zones: ["Kinshasa"]
                },
            ],
            date: '2020-06-09'
        },
        {
            id: 37,
            name: `Localised lockdown in haut-katanga province (incl. Lubumbashi) for mass COVID testing campaign (20th and 21st)`,
            measures: [
                {
                    item: `Localised lockdown in haut-katanga province (incl. Lubumbashi) for mass COVID testing campaign (20th and 21st)`,
                    zones: ["Haut-katanga"]
                },
                {
                    item: `State of Health Emergency extended until July 5th`,
                    zones: ["ALL"]
                },
            ],
            date: '2020-06-20'
        },
        {
            id: 38,
            name: `COVID-19 declared in Sud-Ubangi province (14th province in DRC to confirm cases)`,
            measures: [
                {
                    item: `COVID-19 declared in Sud-Ubangi province (14th province in DRC to confirm cases)`,
                    zones: ["Sud-Ubangi"]
                },
            ],
            date: '2020-06-28'
        },
        {
            id: 39,
            name: `(With exception of central market) clubs, bars, schools, universities to open/ restrictions lifted`,
            measures: [
                {
                    item: `(With exception of central market) clubs, bars, schools, universities to open/ restrictions lifted`,
                    zones: ["Kinshasa", "Gombe"]
                },
            ],
            date: '2020-06-29'
        },
        {
            id: 40,
            name: `3rd case confirmed in Ituri province (Mahagi town)`,
            measures: [
                {
                    item: `3rd case confirmed in Ituri province (Mahagi town)`,
                    zones: ["Ituri", "Mahagi"]
                },
            ],
            date: '2020-07-01'
        },
        {
            id: 41,
            name: `COVID-19 state of emergency lifted (banks, shops, restaurants and bars allowed to open)`,
            measures: [
                {
                    item: `COVID-19 state of emergency lifted (banks, shops, restaurants and bars allowed to open)`,
                    zones: ["ALL"]
                },
            ],
            date: '2020-07-22'
        },
        {
            id: 42,
            name: `Schools, universities, academic institutions can open`,
            measures: [
                {
                    item: `Schools, universities, academic institutions can open`,
                    zones: ["ALL"]
                },
            ],
            date: '2020-08-03'
        },
        {
            id: 43,
            name: `Places of worship, stadiums, airports, international borders open`,
            measures: [
                {
                    item: `Places of worship, stadiums, airports, international borders open`,
                    zones: ["ALL"]
                },
            ],
            date: '2020-08-15'
        },
    ]
