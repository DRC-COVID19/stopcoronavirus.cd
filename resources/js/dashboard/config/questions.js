export default {
  epidemiologicalData: [
    {
      text: 'Nombre de cas confirmés',
      column: 'confirmed',
      type: 'number'
    },
    {
      text: 'Nombre de cas hospitalisés',
      column: 'sick',
      type: 'number'
    },
    {
      text: 'Nombre de patients ayant été guéris',
      column: 'healed',
      type: 'number'
    },
    {
      text: 'Décès',
      column: 'dead',
      type: 'number'
    },
    {
      text: 'Nombre de guéris déchargés',
      column: 'number_healed_discharged',
      type: 'number'
    },
    {
      text: 'Nombre de patients ayant été référés',
      column: 'number_patients_referred',
      type: 'number'
    },
    {
      text: 'Nom du CTCO de référence',
      column: 'reference_ctco_name',
      type: 'text'
    },
  ],
  patientCareCapacity: [
    {
      text: 'Lits avec mousse occupés',
      column: 'occupied_foam_beds',
      type: 'number'
    },
    {
      text: 'Nombre de lits réservés pour des cas COVID-19',
      column: 'number_beds_reserved_covid_19',
      type: 'number'
    },
    {
      text: 'Nombre de lits occupés par des patients COVID-19',
      column: 'number_beds_occupied_covid_19',
      type: 'number'
    },
    {
      text: 'Lits de réanimation occupés',
      column: 'occupied_resuscitation_beds',
      type: 'number'
    },
    {
      text: 'Nombre de lits de réanimation réservés pour des cas COVID-19',
      column: 'reserved_resuscitation_beds_covid_19',
      type: 'number'
    },
    {
      text: 'Nombre de lits de réanimation occupés par des cas COVID-19',
      column: 'occupied_resuscitation_beds_covid_19',
      type: 'number'
    },
    {
      text: 'Respirateurs occupés',
      column: 'occupied_respirators',
      type: 'number'
    },
    {
      text: 'Nombre de respirateurs réservés pour des cas COVID-19',
      column: 'reserved_respirators_covid_19',
      type: 'number'
    },
    {
      text: 'Ventilateur de réanimation occupés',
      column: 'resuscitation_ventilator',
      type: 'number'
    },
    {
      text: 'Nombre de ventilateurs de réanimation réservés pour des cas COVID-19',
      column: 'reserved_resuscitation_ventilator_covid_19',
      type: 'number'
    },
    {
      text: 'Nombre de ventilateurs de réanimation occupés par des cas COVID-19',
      column: 'occupied_resuscitation_ventilator_covid_19',
      type: 'number'
    },
    {
      text: 'Masques',
      column: 'masks',
      type: 'number'
    },
    {
      text: 'Equipement de protection individuelle',
      column: 'individual_protection_equipment',
      type: 'number'
    },
    {
      text: 'Oxygénérateur',
      column: 'oxygenator',
      type: 'number'
    },
    {
      text: 'Nombre d’oxygénateur réservés pour des cas COVID-19',
      column: 'reserved_oxygenator_covid_19',
      type: 'number'
    },
    {
      text: 'Nombre d’oxygénateur occupés par des cas COVID-19',
      column: 'occupied_oxygenator_covid_19',
      type: 'number'
    },
    {
      text: 'EPI en manque',
      column: 'lack_epi',
      type: 'text'
    },
    {
      text: 'Nombre de TDR COVID-19 requis',
      column: 'tdr_covid_19_required',
      type: 'number'
    },
    {
      text: 'Nombre de TDR COVID-19 disponible',
      column: 'tdr_covid_19_available',
      type: 'number'
    },
    {
      text: 'Dépistage rapide',
      column: 'rapid_screening',
      type: 'number'
    },
    {
      text: 'Nombre d’appareil de radiographie requis',
      column: 'x_ray_required',
      type: 'number'
    },
    {
      text: 'Nombre d’appareil de radiographie disponible',
      column: 'x_ray',
      type: 'number'
    },
    {
      text: 'Nombre d’automate genexpert requis',
      column: 'automate_genexpert_required',
      type: 'number'
    },
    {
      text: 'Nombre d’automate genexpert disponible',
      column: 'automate_genexpert',
      type: 'number'
    },
    {
      text: 'Gel hydro alcoolique',
      column: 'gel_hydro_alcoolique',
      type: 'number'
    },
    {
      text: 'Nombre de check point fonctionnel',
      column: 'check_point',
      type: 'number'
    }
  ],
  medications: [
    {
      text: 'Nombre de cures de chloroquine requis',
      column: 'chloroquine_required',
      type: 'number'
    },
    {
      text: 'Nombre de cures de chloroquine disponible',
      column: 'chloroquine',
      type: 'number'
    },
    {
      text: 'Hydrochloroquine',
      column: 'hydrochloroquine',
      type: 'number'
    },
    {
      text: 'Nombre de cures d’azytromycine requis',
      column: 'azytromycine_required',
      type: 'number'
    },
    {
      text: 'Nombre de cures d’azytromycine disponible',
      column: 'azytromicine',
      type: 'number'
    },
    {
      text: 'Nombre de cures de vitamine C requis',
      column: 'vitamine_c_required',
      type: 'number'
    },
    {
      text: 'Nombre de cures de vitamine C disponible',
      column: 'Vitamince_c',
      type: 'number'
    },
    {
      text: 'Nombre de cures de zinc requis',
      column: 'zinc_required',
      type: 'number'
    },
    {
      text: 'Nombre de cures de zinc disponible',
      column: 'zinc_available',
      type: 'number'
    },
  ]
}
