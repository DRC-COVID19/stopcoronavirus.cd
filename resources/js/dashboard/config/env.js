
export const
  GOOGLE_ANALYTICS_ID="UA-113285849-14",
  MAPBOX_TOKEN = "pk.eyJ1IjoibWVya2kyMzAiLCJhIjoiY2s5aWdkejJzMDhybTNkcWxtMm9la2h4aCJ9.5NwFpUn264STu43zxmTyOw",
  MAPBOX_DEFAULT_STYLE = "mapbox://styles/merki230/ckas344r30gmj1ips9gar4uxw",
  ADMIN_DASHBOARD = "admin-dashboard",
  AGENT_HOSPITAL = "agent-hospital",
  ADMIN_HOSPITAL = "admin-hospital",
  PALETTE = {
    inflow: ["#2166ac", "#4393c3", "#92c5de", "#d1e5f0", "#fddbc7", "#f4a582", "#d6604d", "#b2182b"],
    inflow_positif: ["rgb(253, 219, 199)", "rgb(244, 165, 130)", "rgb(214, 96, 77)", "rgb(178, 24, 43)", "rgb(103, 0, 31)"],
    inflow_negatif: ["rgb(5, 48, 97)", "rgb(33, 102, 172)", "rgb(67, 147, 195)", "rgb(146, 197, 222)", "rgb(209, 229, 240)"],
    outflow: ["#2d004b", "#542788", "#8073ac", "#b2abd2", "#fdb863", "#e08214", "#b35806", "#7f3b08"],
    outflow_positif: ["rgb(254, 224, 182)", "rgb(253, 184, 99)", "rgb(224, 130, 20)", "rgb(179, 88, 6)", "rgb(127, 59, 8)"],
    outflow_negatif: ["rgb(45, 0, 75)", "rgb(84, 39, 136)", "rgb(128, 115, 172)", "rgb(178, 171, 210)", "rgb(216, 218, 235)"],
    general_positif: ['#d3f9ce', '#93d691', '#47c357', '#108337', '#035d21'],
    general_negatif: ['#2c012f', '#7d0088', '#a048af', '#c790d2', '#e9cbea'],
    presence_positif: ['#fdbb84', '#fc8d59', '#ef6548', '#d7301f', '#990000'],
    presence_negatif: ['#182f4d', '#3b4c61', '#5875a6', '#7d9cd1', '#b4c3dc'],
    present: ["#E31A1C"],
    nodata: "#eeeeee",
    bordure_shape_file: " #BFC5D2",
    flux_out_color: "#88419d",
    flux_in_color: "#225ea8",
    flux_presence: "#E31A1C",
    dash_green: "#33ac2e",
    dash_red: "#f44336",
    epidemic: ["#FFFFB2", "#FECC5C", "#FD8D3C", "#E31A1C"]
  },
  PREFERENCE_START = "2020-02-18",
  PREFERENCE_END = "2020-03-18",
  HOTSPOT_PREFERENCE_START="2020-05-17",
  HOTSPOT_PREFERENCE_END="2020-05-24",
  HOTSPOT_OBSERVATION_START="2020-05-25",
  HOTSPOT_OBSERVATION_END="2020-08-11",
  FLUX_LAST_UPDATE = "2020-08-12",
  OBSERVATION_START = "2020-03-19",
  OBSERVATION_END = "2020-08-12",
  DATEFORMAT = "Y-MM-DD",
  INFRASTRUCTURE_FIRST_UPDATE = "2020-07-01",
  FLUX_PREDEFINED_INPUT = [
    // {
    //     id: 1,
    //     name: "Aujourd'hui"
    // },
    // {
    //     id: 2,
    //     name: "Semaine en cours"
    // },
    // {
    //     id: 3,
    //     name: "Mois en cours"
    // },
    // {
    //     id: 4,
    //     name: "Mois passé"
    // },
    {
      id: 6,
      name:
        "Mobilité à la Gombe une semaine après le debut du confinement (24h)"
    },
    {
      id: 5,
      name: "Mobilité à la Gombe depuis le début du confinement"
    },
    {
      id: 7,
      name: "Mobilité générale à la Gombe depuis le début du confinement"
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
    },
    {
      id: 3,
      name: "Hotspot"
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
    {
      id: 2,
      name: 'Cas Guéris'
    },
    {
      id: 3,
      name: 'Décès'
    },
  ],
  INDICATEUR_PREDEFINED_INPUT = [
    {
      id: 1,
      name: 'Mobilité vs Epidémiologie à la Gombe, une semaine après le debut du confinement'
    },
    {
      id: 2,
      name: 'Mobilité vs Nombre de cas, depuis le debut du confinement'
    }
  ],
  DRC_COVID_EVENT = [
    {
        id: 1,
        name: 'Premier cas de COVID-19 confirmé (ressortissant congolais de retour de France)',
        date: '2020-03-10',
        measures: [
            {
                item: 'Premier cas de COVID-19 confirmé (ressortissant congolais de retour de France)',
                zones: ['Kinshasa']
            }
        ],
        zone: ['Kinshasa'],
    },
    {
        id: 2,
        name: `Premières mesures de restriction mises en place pour les voyages / vols internationaux et nationaux
(fiches d'information sanitaire et contrôles de température / symptômes à l'arrivée dans les aéroports
et les ports)`,
        date: '2020-03-13',
        measures: [
            {
                item: `Premières mesures de restriction mises en place pour les voyages / vols internationaux et nationaux
(fiches d'information sanitaire et contrôles de température / symptômes à l'arrivée dans les aéroports
et les ports)`,
                zones: ["Kinshasa"]
            }
        ],
        zone: ['Kinshasa']
    },
    {
        id: 3,
        name: 'Vols en provenance de pays à risque suspendus (sauf certaines cargaisons)',
        measures: [
            {
                item: `Vols en provenance de pays à risque suspendus (sauf certaines cargaisons)`,
                zones: ['Kinshasa']
            },
            {
                item: `Bars, restaurants fermés; écoles fermées; les rassemblements de plus de 20 personnes interdits;
                les rassemblements religieux et les événements sportifs suspendus jusqu'à nouvel ordre; passagers
                limités dans les transports publics à Kinshasa`,
                zones: ['Kinshasa']
            }

        ],
        zone: ['Kinshasa'],
        isImportant: true,
        date: '2020-03-18'
    },
    {
        id: 4,
        name: 'Tous les voyages à destination ou en provenance de Kinshasa sont interdits (sauf le fret)',
        measures: [
            {
                item: `Tous les voyages à destination ou en provenance de Kinshasa sont interdits (sauf le fret)`,
                zones: ["Kinshasa"]
            }
        ],
        zone: ['Kinshasa'],
        date: '2020-03-19'
    },
    {
        id: 5,
        name: 'Premier décès lié au COVID-19 enregistré en RDC',
        measures: [
            {
                item: 'Premier décès lié au COVID-19 enregistré en RDC',
                zones: ['Kinshasa']
            }
        ],
        zone: ['Kinshasa'],
        date: '2020-03-21'
    },
    {
        id: 6,
        name: `Confinement de 48 heures (deux cas suspects sortant d'un avion de Kinshasa)`,
        measures: [
            {
                item: `Confinement de 48 heures (deux cas suspects sortant d'un avion de Kinshasa)`,
                zones: ['Lubumbashi']
            }
        ],
        zone: ['Lubumbashi'],
        date: '2020-03-23'
    },
    {
        id: 7,
        name: `État d'urgence déclaré par le gouvernement congolais`,
        measures: [
            {
                item: `État d'urgence déclaré par le gouvernement congolais`,
                zones: ['Lubumbashi']
            }
        ],
        zone: ['Lubumbashi'],
        date: '2020-03-24'
    },
    {
        id: 8,
        name: `Les voyages intérieurs entre Kinshasa et le reste du pays sont suspendus; toutes les frontières sont fermées sauf pour le commerce`,
        measures: [
            {
                item: `Les voyages intérieurs entre Kinshasa et le reste du pays sont suspendus; toutes les frontières sont fermées sauf pour le commerce`,
                zones: ['ALL']
            }
        ],
        zone: ['ALL'],
        date: '2020-03-25'
    },
    {
        id: 9,
        name: `Interdiction de tout rassemblement de personnes dans les espaces publics`,
        measures: [
            {
                item: `Interdiction de tout rassemblement de personnes dans les espaces publics`,
                zones: ['ALL']
            }
        ],
        zone: ['ALL'],
        date: '2020-03-26'
    },
    {
        id: 10,
        name: `Suspension de l'impôt sur le revenu pour tous les fonctionnaires et autres employés de l'État pendant 3 mois`,
        measures: [
            {
                item: `Suspension de l'impôt sur le revenu pour tous les fonctionnaires et autres employés de l'État pendant 3 mois`,
                zones: ["ALL"]
            },
            {
                item: `Premier cas de COVID-19 dans la province d'Ituri`,
                zones: ["Ituri"]
            },
            {
                item: `Confinement de 3 semaines annoncé par le gouverneur de Kinshasa du 28 mars au 27 avril`,
                zones: ["Kinshasa"]
            },
            {
                item: `Le confinement à Kinshasa reporté dans un contexte d'insécurité et de spéculation sur les prix des produits de base`,
                zones: ['Kinshasa']
            }
        ],
        zone: ['ALL'],
        date: '2020-03-27'
    },
    {
        id: 11,
        name: 'Premier cas COVID-19 (Bunia)',
        measures: [
            {
                item: 'Premier cas COVID-19 (Bunia)',
                zones: ["Bunia", "Ituri"]
            }
        ],
        date: '2020-04-01'
    },
    {
        id: 12,
        name: 'Premier cas COVID-19 (Beni)',
        measures: [
            {
                item: 'Premier cas COVID-19 (Beni)',
                zones: ["Beni", "Nord-kivu"]
            }
        ],
        date: '2020-04-03'
    },
    {
        id: 13,
        name: 'Premier cas COVID-19 (Idiofa)',
        measures: [
            {
                item: 'Premier cas COVID-19 (Idiofa)',
                zones: ["Idiofa", "Kwilu"]
            }
        ],
        date: '2020-04-04'
    },
    {
        id: 14,
        name: "2 semaines de «confinement» / confinement introduit à Goma",
        measures: [
            {
                item: "2 semaines de «confinement» / confinement introduit à Goma",
                zones: ["Goma", "Nord-kivu"]
            }
        ],
        date: '2020-04-05'
    },
    {
        id: 15,
        name: `Mouvements vers l'extérieur de Goma, Beni et Butembo suspendus
(""confinement de 14 jours""), les résidents doivent rester chez eux`,
        measures: [
            {
                item: `Mouvements vers l'extérieur de Goma, Beni et Butembo suspendus
(""confinement de 14 jours""), les résidents doivent rester chez eux`,
                zones: ["Nord-kivu"]
            },
            {
                item: 'Voyage entre Goma et Bukavu suspendu',
                zones: ["Nord-kivu", "Sud-kivu"]
            },
            {
                item: `Mise en place d'un «confinement» / confinement de 2 semaines
                (les gens ne peuvent pas quitter leur domicile) à Gombe`,
                zones: ["Gombe", "Kinshasa"]
            }
        ],
        date: '2020-04-06'
    },
    {
        id: 16,
        name: `Prolongation des mesures de confinement dans la province du Nord-Kivu (jusqu'au 30/4)`,
        measures: [
            {
                item: `Prolongation des mesures de confinement dans la province du Nord-Kivu (jusqu'au 30/4)`,
                zones: ["Nord-kivu"]
            }
        ],
        date: '2020-04-13'
    },
    {
        id: 17,
        name: `Masques faciaux obligatoires dans les espaces publics à Kinshasa  (5000 CF si les masques ne sont pas portés)`,
        measures: [
            {
                item: `Masques faciaux obligatoires dans les espaces publics à Kinshasa  (5000 CF si les masques ne sont pas portés)`,
                zones: ["Kinshasa"]
            },
            {
                item: `Auto-quarantaine pour les personnes à haut risque (plus de 60 ans ou avec des conditions
                    préexistantes) obligatoire au Sud-Kivu.`,
                zones: ["Sud-kivu"]
            },
            {
                item: `Les déplacements internes entre les villes de Goma, Beni et Butembo ont continué d'être suspendus`,
                zones: ["Nord-kivu"]
            },
            {
                item: 'Couvre-feu à Lualaba et Lubumbashi à partir de 22h à 5 h',
                zones: ["Lualaba", "Lubumbashi"]
            }
        ],
        date: '2020-04-20'
    },
    {
        id: 17,
        name: `État d'urgence prorogé par le gouvernement congolais - 20 jours (21/4 - 10/5)`,
        measures: [
            {
                item: `État d'urgence prorogé par le gouvernement congolais - 20 jours (21/4 - 10/5)`,
                zones: ["ALL"]
            },
        ],
        date: '2020-04-21'
    },
    {
        id: 18,
        name: `Les restrictions de confinement de Gombe assouplies (réouverture des banques et de certains
magasins vendant de la nourriture)`,
        measures: [
            {
                item: `Les restrictions de confinement de Gombe assouplies (réouverture des banques et de certains
magasins vendant de la nourriture)`,
                zones: ["Gombe", "Kinshasa"]
            },
        ],
        date: '2020-04-22'
    },
    {
        id: 19,
        name: `L'état d'urgence sanitaire a été prolongé par le Parlement pour deux semaines.`,
        measures: [
            {
                item: `L'état d'urgence sanitaire a été prolongé par le Parlement pour deux semaines.`,
                zones: ["ALL"]
            },
        ],
        date: '2020-04-23'
    },
    {
        id: 20,
        name: 'Premier cas de COVID-19 confirmé à Lubumbashi',
        measures: [
            {
                item: 'Premier cas de COVID-19 confirmé à Lubumbashi',
                zones: ["Lubumbashi"]
            },
        ],
        date: '2020-04-24'
    },
    {
        id: 21,
        name: `Lubumbashi et Kasumbalesa sous un confinement de 24 heures pour la recherche des contacts`,
        measures: [
            {
                item: `Lubumbashi et Kasumbalesa sous un confinement de 24 heures pour la recherche des contacts`,
                zones: ["Lubumbashi", "Kasumbalesa"]
            },
        ],
        date: '2020-04-29'
    },
    {
        id: 22,
        name: `Masques faciaux obligatoires dans les espaces publics (Lubumbashi) Amende de 5000 CF pour
les non-conformes`,
        measures: [
            {
                item: `Masques faciaux obligatoires dans les espaces publics (Lubumbashi) Amende de 5000 CF pour
les non-conformes`,
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
                item: `Communication du gouverneur de l'Ituri:
                - Les vols commerciaux entre Ituri - Isiro - Goma - Kisangani via CAA et Congo Airways ont repris
                - Les passagers en provenance de Kinshasa sont également autorisés, à condition qu'ils respectent
                les mesures IPC à bord et à leur arrivée en Ituri`,
                zones: ["Ituri"]
            },
        ],
        date: '2020-05-05'
    },
    {
        id: 24,
        name: `Réouverture partielle de la frontière entre la RDC et la Zambie aux piétons suite aux affrontements entre civils et forces de sécurité`,
        measures: [
            {
                item: `Réouverture partielle de la frontière entre la RDC et la Zambie aux piétons suite aux affrontements entre civils et forces de sécurité`,
                zones: ["Kasumbalesa"]
            },
        ],
        date: '2020-05-08'
    },
    {
        id: 25,
        name: 'Masques faciaux obligatoires dans les espaces publics de Matadi (province du Kongo Central)',
        measures: [
            {
                item: `Masques faciaux obligatoires dans les espaces publics de Matadi (province du Kongo Central)`,
                zones: ["Matadi", "Kongo-central"]
            },
        ],
        date: '2020-05-11'
    },
    {
        id: 26,
        name: `L'impôt sur le revenu (suspendu le 27 mars pendant 3 mois pour les fonctionnaires / employés
de l'État) a été rétabli pour combler le déficit de 11 millions de dollars américains (le ministre
des Finances justifie cette décision en accusant les fermetures de mines et de frontières de perte
de revenus pour Kinshasa`,
        measures: [
            {
                item: `L'impôt sur le revenu (suspendu le 27 mars pendant 3 mois pour les fonctionnaires / employés
                    de l'État) a été rétabli pour combler le déficit de 11 millions de dollars américains (le ministre
                    des Finances justifie cette décision en accusant les fermetures de mines et de frontières de perte
                    de revenus pour Kinshasa`,
                zones: ["Kinshasa"]
            },
        ],
        date: '2020-05-14'
    },
    {
        id: 27,
        name: `Couvre-feu (à partir de 20h00) et isolement de Goma des autres territoires de la province pendant 14 jours
- La police est chargée d’appliquer les mesures de couvre-feu`,
        measures: [
            {
                item: `Couvre-feu (à partir de 20h00) et isolement de Goma des autres territoires de la province pendant 14 jours
                - La police est chargée d’appliquer les mesures de couvre-feu`,
                zones: ["Goma"]
            },
        ],
        date: '2020-05-17'
    },
    {
        id: 28,
        name: `Activités de la mairie de Goma suspendues jusqu'à nouvel ordre (membre testé positif au COVID)`,
        measures: [
            {
                item: `Activités de la mairie de Goma suspendues jusqu'à nouvel ordre (membre testé positif au COVID)`,
                zones: ["Goma"]
            },
        ],
        date: '2020-05-18'
    },
    {
        id: 29,
        name: `Des rapports d'attaques contre les équipes de riposte au COVID se sont multipliées
        au niveau communautaire à Kinshasa;
        - A entraîné une interruption des activités de surveillance et de recherche des contacts
        - Plus récent enregistré dans la zone de santé de Kimbanseke (concernant des violences contre
        trois agents de la riposte qui étaient détenus dans un ménage du district de Maviokele)`,
        measures: [
            {
                item: `Des rapports d'attaques contre les équipes de riposte au COVID se sont multipliées
                au niveau communautaire à Kinshasa;
                - A entraîné une interruption des activités de surveillance et de recherche des contacts
                - Plus récent enregistré dans la zone de santé de Kimbanseke (concernant des violences contre
                trois agents de la riposte qui étaient détenus dans un ménage du district de Maviokele)`,
                zones: ["Kinshasa"]
            },
        ],
        date: '2020-05-19'
    },
    {
        id: 30,
        name: `Le trafic entre Goma et Bukavu suspendu`,
        measures: [
            {
                item: `Le trafic entre Goma et Bukavu suspendu`,
                zones: ["Goma"]
            },
        ],
        date: '2020-05-20'
    },
    {
        id: 31,
        name: `Le Parlement vote pour prolonger la période d'urgence sanitaire de 15 jours`,
        measures: [
            {
                item: `Le Parlement vote pour prolonger la période d'urgence sanitaire de 15 jours`,
                zones: ["ALL"]
            },
        ],
        date: '2020-05-22'
    },
    {
        id: 32,
        name: `Ouverture du centre de dépistage COVID au stade des Martyrs`,
        measures: [
            {
                item: `Ouverture du centre de dépistage COVID au stade des Martyrs`,
                zones: ["Kinshasa"]
            },
        ],
        date: '2020-05-26'
    },
    {
        id: 33,
        name: `Confinement de la commune d'Ibanda, Bukavu et couvre-feu à l'échelle de la ville (20h-17h)`,
        measures: [
            {
                item: `Confinement de la commune d'Ibanda, Bukavu et couvre-feu à l'échelle de la ville (20h-17h)`,
                zones: ["Bukavu"]
            },
        ],
        date: '2020-06-01'
    },
    {
        id: 34,
        name: `Couvre-feu à Goma levé`,
        measures: [
            {
                item: `Couvre-feu à Goma levé`,
                zones: ["Goma"]
            },
            {
                item: `Suspension de l'isolement de Goma et de ses environs (sauf voyage entre Goma et Bukavu et
                    voyage en avion)`,
                zones: ["Goma"]
            },
        ],
        date: '2020-06-03'
    },
    {
        id: 35,
        name: `État d'urgence prolongé de 15 jours (à partir du 06/08/20)`,
        measures: [
            {
                item: `État d'urgence prolongé de 15 jours (à partir du 06/08/20)`,
                zones: ["ALL"]
            },
        ],
        date: '2020-06-08'
    },
    {
        id: 36,
        name: `3 morts dans des manifestations contre les restrictions COVID sur le marché central de Kinshasa
        (les commerçants faisaient du commerce malgré la fermeture obligatoire)`,
        measures: [
            {
                item: `3 morts dans des manifestations contre les restrictions COVID sur le marché central de Kinshasa
        (les commerçants faisaient du commerce malgré la fermeture obligatoire)`,
                zones: ["Kinshasa"]
            },
        ],
        date: '2020-06-09'
    },
    {
        id: 37,
        name: `Confinement localisé dans la province du Haut-Katanga (y compris Lubumbashi) pour la campagne de tests de masse COVID (20e et 21e)`,
        measures: [
            {
                item: `Confinement localisé dans la province du Haut-Katanga (y compris Lubumbashi) pour la campagne de tests de masse COVID (20e et 21e)`,
                zones: ["Haut-katanga"]
            },
            {
                item: `État d'urgence sanitaire`,
                zones: ["ALL"]
            },
            {
                item: `prolongé jusqu'au 5 juillet`,
                zones: ["ALL"]
            },
        ],
        date: '2020-06-20'
    },
    {
        id: 38,
        name: `COVID-19 déclaré dans la province du Sud-Ubangi (14e province en RDC à confirmer les cas)`,
        measures: [
            {
                item: `COVID-19 déclaré dans la province du Sud-Ubangi (14e province en RDC à confirmer les cas)`,
                zones: ["Sud-Ubangi"]
            },
        ],
        date: '2020-06-28'
    },
    {
        id: 39,
        name: `(À l'exception du marché central) Ouverture de clubs, bars, écoles, universités / restrictions levées`,
        measures: [
            {
                item: `(À l'exception du marché central) Ouverture de clubs, bars, écoles, universités / restrictions levées`,
                zones: ["Kinshasa", "Gombe"]
            },
        ],
        date: '2020-06-29'
    },
    {
        id: 40,
        name: `3e cas confirmé dans la province d'Ituri (ville de Mahagi)`,
        measures: [
            {
                item: `3e cas confirmé dans la province d'Ituri (ville de Mahagi)`,
                zones: ["Ituri", "Mahagi"]
            },
        ],
        date: '2020-07-01'
    },
    {
        id: 41,
        name: `État d'urgence du COVID-19 levé (ouverture des banques, des magasins, des restaurants et des bars)`,
        measures: [
            {
                item: `État d'urgence du COVID-19 levé (ouverture des banques, des magasins, des restaurants et des bars)`,
                zones: ["ALL"]
            },
        ],
        date: '2020-07-22'
    },
    {
        id: 42,
        name: `Les écoles, les universités, les institutions académiques peuvent ouvrir`,
        measures: [
            {
                item: `Les écoles, les universités, les institutions académiques peuvent ouvrir`,
                zones: ["ALL"]
            },
        ],
        date: '2020-08-03'
    },
    {
        id: 43,
        name: `Lieux de culte, stades, aéroports, frontières internationales ouvertes`,
        measures: [
            {
                item: `Lieux de culte, stades, aéroports, frontières internationales ouvertes`,
                zones: ["ALL"]
            },
        ],
        date: '2020-08-15'
    },
]
