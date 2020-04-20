---
title: API Reference

language_tabs:

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost:8000/docs/collection.json)

<!-- END_INFO -->

#User management


APIs for managing users
<!-- START_60fdb642281a006b32553e18909d0533 -->
## Test diagnostic covid-19

> Example request:



### HTTP Request
`POST api/self-test`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `temperature_cat` | integer |  required  | between:1,5 Pensez-vous avoir ou avoir eu de la fièvre ces 48 dernières heures (frissons, sueurs) ?
        `cough` | integer |  required  | between:0,1 Ces derniers jours, avez-vous une toux ou une augmentation de votre toux habituelle ?
        `agueusia_anosmia` | integer |  required  | between:0,1 Ces derniers jours, avez-vous noté une forte diminution ou perte de votre goût ou de votre odorat ?
        `sore_throat_aches` | integer |  required  | between:0,1 Ces derniers jours, avez-vous eu un mal de gorge et/ou des douleurs musculaires et/ou des courbatures inhabituelles ?
        `diarrhea` | integer |  required  | between:0,1 Ces dernières 24 heures, avez-vous de la diarrhée ? Avec au moins 3 selles molles"
        `tiredness` | integer |  required  | between:0,1 Ces derniers jours, avez-vous une fatigue inhabituelle ?"
        `tiredness_details` | integer |  required  | between:0,1 Cette fatigue vous oblige-t-elle à vous reposer plus de la moitié de la journée ?
        `feeding_day` | integer |  required  | between:0,1 Êtes vous dans l'impossibilité de vous alimenter ou de boire DEPUIS 24 HEURES OU PLUS ?
        `breathlessness` | integer |  required  | between:0,1 Dans les dernières 24 heures, avez-vous noté un manque de souffle INHABITUEL lorsque vous parlez ou faites un petit effort ?
        `age` | integer |  required  | between:1,120 Quel est votre âge ? Ceci, afin de calculer un facteur de risque spécifique.
        `size` | integer |  required  | between:80,250 Quel est votre taille ? Afin de calculer l’indice de masse corporelle qui est un facteur influençant le risque de complications de l’infection.
        `weight` | integer |  required  | between:20,250 Quel est votre poids ? Afin de calculer l’indice de masse corporelle qui est un facteur influençant le risque de complications de l’infection.
        `heart_disease` | integer |  required  | between:0,2 Avez-vous de l’hypertension artérielle mal équilibrée ? Ou avez-vous une maladie cardiaque ou vasculaire ? Ou prenez vous un traitement à visée cardiologique ?
        `diabetes` | integer |  required  | between:0,1 Êtes-vous diabétique ?
        `cancer` | integer |  required  | between:0,1 Avez-vous ou avez-vous eu un cancer ces trois dernières années ?
        `breathing_disease` | integer |  required  | between:0,1 Avez-vous une maladie respiratoire ? Ou êtes-vous suivi par un pneumologue ?
        `kidney_disease` | integer |  required  | between:0,1 Avez-vous une insuffisance rénale chronique dialysée ?
        `liver_disease` | integer |  required  | between:0,1 Avez-vous une maladie chronique du foie ?
        `pregnant` | integer |  required  | between:0,2 Êtes-vous enceinte ?
        `immunosuppressant_disease` | integer |  required  | between:0,2 Avez-vous une maladie connue pour diminuer vos défenses immunitaires ?
        `immunosuppressant_drug` | integer |  required  | between:0,2 Prenez-vous un traitement immunosuppresseur ? C’est un traitement qui diminue vos défenses contre les infections. Voici quelques exemples : corticoïdes, méthotrexate, ciclosporine, tacrolimus, azathioprine, cyclophosphamide (liste non exhaustive)
        `province` | string |  optional  | Quel est votre Province ? Cette information nous permet de réaliser un suivi épidémiologique.
        `town` | string |  optional  | Quel est votre ville ? Cette information nous permet de réaliser un suivi épidémiologique.
        `township` | string |  optional  | Quel est votre commune  ? Cette information nous permet de réaliser un suivi épidémiologique.
        `longitude` | longitude, |  optional  | Cette information nous permet de réaliser un suivi épidémiologique.
        `latitude` | latitude, |  optional  | Cette information nous permet de réaliser un suivi épidémiologique.
    
<!-- END_60fdb642281a006b32553e18909d0533 -->


