---
title: API Reference

language_tabs:
- javascript
- php

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
## Test diagnostique covid-19

> Example request:

```javascript
const url = new URL(
    "http://localhost:8000/api/self-test"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "q-1": 8,
    "q-2": 15,
    "q-3": 2,
    "q-4": 19,
    "q-5": 9,
    "q-6": 9,
    "q-7": 13,
    "q-8": 14,
    "q-9": 18,
    "q-10": 13,
    "q-11": 13,
    "q-12": 9,
    "q-13": 17,
    "q-14": 4,
    "q-15": 3,
    "q-16": 14,
    "q-17": 17,
    "q-18": 12,
    "q-19": 13,
    "q-20": 10,
    "q-21": 12,
    "q-22": 10,
    "q-23": 10
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost:8000/api/self-test',
    [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
        'json' => [
            'q-1' => 8,
            'q-2' => 15,
            'q-3' => 2,
            'q-4' => 19,
            'q-5' => 9,
            'q-6' => 9,
            'q-7' => 13,
            'q-8' => 14,
            'q-9' => 18,
            'q-10' => 13,
            'q-11' => 13,
            'q-12' => 9,
            'q-13' => 17,
            'q-14' => 4,
            'q-15' => 3,
            'q-16' => 14,
            'q-17' => 17,
            'q-18' => 12,
            'q-19' => 13,
            'q-20' => 10,
            'q-21' => 12,
            'q-22' => 10,
            'q-23' => 10,
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```



### HTTP Request
`POST api/self-test`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `q-1` | integer |  required  | Pensez-vous avoir ou avoir eu de la fièvre ces 48 dernières heures (frissons, sueurs) ?
        `q-2` | integer |  optional  | Quelle a été votre température la plus élevée de ces dernières 48 heures ?
        `q-3` | integer |  required  | Ces derniers jours, avez-vous une toux ou une augmentation de votre toux habituelle ?
        `q-4` | integer |  required  | Ces derniers jours, avez-vous noté une forte diminution ou perte de votre goût ou de votre odorat ?
        `q-5` | integer |  required  | Ces derniers jours, avez-vous eu un mal de gorge et/ou des douleurs musculaires et/ou des courbatures inhabituelles ?
        `q-6` | integer |  required  | Ces dernières 24 heures, avez-vous de la diarrhée ? Avec au moins 3 selles molles"
        `q-7` | integer |  required  | Ces derniers jours, avez-vous une fatigue inhabituelle ?"
        `q-8` | integer |  required  | Cette fatigue vous oblige-t-elle à vous reposer plus de la moitié de la journée ?
        `q-9` | integer |  required  | Êtes vous dans l'impossibilité de vous alimenter ou de boire DEPUIS 24 HEURES OU PLUS ?
        `q-10` | integer |  required  | Comment vous sentez-vous ?
        `q-11` | integer |  required  | Dans les dernières 24 heures, avez-vous noté un manque de souffle INHABITUEL lorsque vous parlez ou faites un petit effort ?
        `q-12` | integer |  required  | Quel est votre âge ? Ceci, afin de calculer un facteur de risque spécifique.
        `q-13` | integer |  required  | Quel est votre taille ? Afin de calculer l’indice de masse corporelle qui est un facteur influençant le risque de complications de l’infection.
        `q-14` | integer |  required  | Quel est votre poids ? Afin de calculer l’indice de masse corporelle qui est un facteur influençant le risque de complications de l’infection.
        `q-15` | integer |  required  | Avez-vous de l’hypertension artérielle mal équilibrée ? Ou avez-vous une maladie cardiaque ou vasculaire ? Ou prenez vous un traitement à visée cardiologique ?
        `q-16` | integer |  required  | Êtes-vous diabétique ?
        `q-17` | integer |  required  | Avez-vous ou avez-vous eu un cancer ces trois dernières années ?
        `q-18` | integer |  required  | Avez-vous une maladie respiratoire ? Ou êtes-vous suivi par un pneumologue ?
        `q-19` | integer |  required  | Avez-vous une insuffisance rénale chronique dialysée ?
        `q-20` | integer |  required  | Avez-vous une maladie chronique du foie ?
        `q-21` | integer |  required  | Êtes-vous enceinte ?
        `q-22` | integer |  required  | Avez-vous une maladie connue pour diminuer vos défenses immunitaires ?
        `q-23` | integer |  required  | Prenez-vous un traitement immunosuppresseur ? C’est un traitement qui diminue vos défenses contre les infections. Voici quelques exemples : corticoïdes, méthotrexate, ciclosporine, tacrolimus, azathioprine, cyclophosphamide (liste non exhaustive)
    
<!-- END_60fdb642281a006b32553e18909d0533 -->


