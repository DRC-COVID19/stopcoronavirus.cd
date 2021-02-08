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

<!-- END_INFO -->

#AdminiRole management


<!-- START_6b710b60044785af19560ab9f91fd740 -->
## Display a listing of the admin_roles.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
[
    {
        "id": 1,
        "name": "Administrator",
        "slug": "administrator",
        "created_at": "2020-03-24T17:17:05.000000Z",
        "updated_at": "2020-03-24T17:17:05.000000Z"
    }
]
```

### HTTP Request
`GET api/admin_roles`


<!-- END_6b710b60044785af19560ab9f91fd740 -->

<!-- START_593ce68eea712cf6757763a71b641cb1 -->
## Store a newly created resource in storage.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:



### HTTP Request
`POST api/admin_roles`


<!-- END_593ce68eea712cf6757763a71b641cb1 -->

<!-- START_72bec43a5269d7f1743ded7b03c40336 -->
## Display the specified resource.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/admin_roles/{admin_role}`


<!-- END_72bec43a5269d7f1743ded7b03c40336 -->

<!-- START_b3719d13e4f86b02bfbe6bb88ffcaff3 -->
## Update the specified resource in storage.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:



### HTTP Request
`PUT api/admin_roles/{admin_role}`

`PATCH api/admin_roles/{admin_role}`


<!-- END_b3719d13e4f86b02bfbe6bb88ffcaff3 -->

<!-- START_c7b622488e9e39d56ee3808da74537a8 -->
## Remove the specified resource from storage.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:



### HTTP Request
`DELETE api/admin_roles/{admin_role}`


<!-- END_c7b622488e9e39d56ee3808da74537a8 -->

#Administrator management


<!-- START_7e2b7a1ebbd3335d2dab3468cd7b48ef -->
## Display a listing of the admin_users paginate by 15.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "data": [
        {
            "id": 1,
            "name": "Admin",
            "email": "admin@kinhsasadigital.com",
            "usernmae": "admin",
            "avatar": "http:\/\/localhost:8000\/img\/admin\/avatar_placeholder.png",
            "roles": [
                {
                    "id": 1,
                    "name": "Adm",
                    "slug": "adm",
                    "created_at": "2020-03-24 17:17:05",
                    "updated_at": "2020-03-24 17:17:05",
                    "pivot": {
                        "user_id": 1,
                        "role_id": 1
                    }
                }
            ],
            "isAdmin": true,
            "isHospitalManager": false,
            "hospital": null,
            "isHospitalAdmin": false
        }
    ],
    "links": {
        "first": "http:\/\/localhost\/api\/admin_users?page=1",
        "last": "http:\/\/localhost\/api\/admin_users?page=7",
        "prev": null,
        "next": "http:\/\/localhost\/api\/admin_users?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 7,
        "path": "http:\/\/localhost\/api\/admin_users",
        "per_page": 15,
        "to": 15,
        "total": 95
    }
}
```

### HTTP Request
`GET api/admin_users`


<!-- END_7e2b7a1ebbd3335d2dab3468cd7b48ef -->

<!-- START_2c7c40eba56e473f8e40f6f212c7db36 -->
## Store a newly created admin_users in storage.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (201):

```json
null
```
> Example response (401):

```json
{
    "message": "Unauthenticated"
}
```

### HTTP Request
`POST api/admin_users`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `username` | string |  required  | username.
        `password` | string |  required  | password
        `password_confirmation` | string |  required  | password_confirmation
        `name` | string |  required  | name
        `email` | email |  required  | email
        `roles_id` | array |  required  | roles_id
    
<!-- END_2c7c40eba56e473f8e40f6f212c7db36 -->

<!-- START_77d0a2d5bb8f4587de5f705abe169e91 -->
## Display a admin_users by id.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "id": 1,
    "name": "Admin",
    "email": "admin@kinhsasadigital.com",
    "usernmae": "admin",
    "avatar": "http:\/\/localhost:8000\/img\/admin\/avatar_placeholder.png",
    "roles": [
        {
            "id": 1,
            "name": "Adm",
            "slug": "adm",
            "created_at": "2020-03-24 17:17:05",
            "updated_at": "2020-03-24 17:17:05",
            "pivot": {
                "user_id": 1,
                "role_id": 1
            }
        }
    ],
    "isAdmin": true,
    "isHospitalManager": false,
    "hospital": null,
    "isHospitalAdmin": false
}
```

### HTTP Request
`GET api/admin_users/{admin_user}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `admin_users` |  required  | The ID of the admin_users

<!-- END_77d0a2d5bb8f4587de5f705abe169e91 -->

<!-- START_5153b8bc63349e63de278397894ab00f -->
## Update the specified admin_user by id in storage.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
{
    "id": 1,
    "name": "Admin",
    "email": "admin@kinhsasadigital.com",
    "usernmae": "admin",
    "avatar": "http:\/\/localhost:8000\/img\/admin\/avatar_placeholder.png",
    "roles": [
        {
            "id": 1,
            "name": "Adm",
            "slug": "adm",
            "created_at": "2020-03-24 17:17:05",
            "updated_at": "2020-03-24 17:17:05",
            "pivot": {
                "user_id": 1,
                "role_id": 1
            }
        }
    ],
    "isAdmin": true,
    "isHospitalManager": false,
    "hospital": null,
    "isHospitalAdmin": false
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated"
}
```

### HTTP Request
`PUT api/admin_users/{admin_user}`

`PATCH api/admin_users/{admin_user}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `admin_users` |  required  | The ID of the admin_users.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `username` | string |  required  | username.
        `password` | string |  required  | password
        `name` | string |  required  | name
        `email` | email |  required  | email
        `roles_id` | array |  required  | roles_id
    
<!-- END_5153b8bc63349e63de278397894ab00f -->

<!-- START_3c2aaa798572fdf62053d5cf4eb65ace -->
## Remove the specified resource by id from storage.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:


> Example response (200):

```json
null
```
> Example response (401):

```json
{
    "message": "Unauthenticated"
}
```

### HTTP Request
`DELETE api/admin_users/{admin_user}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `admin_users` |  required  | The ID of the admin_users

<!-- END_3c2aaa798572fdf62053d5cf4eb65ace -->

#Auth management


APIs for managing users Auth
<!-- START_3ec94b50b1c8c9ba798a36fdfacd3fef -->
## Get a JWT token via given credentials.

> Example request:



### HTTP Request
`POST api/dashboard/auth/login`


<!-- END_3ec94b50b1c8c9ba798a36fdfacd3fef -->

<!-- START_c06cffaa29eb1a4afb4762c6f9371f54 -->
## Log the user out (Invalidate the token)

> Example request:



### HTTP Request
`POST api/dashboard/auth/logout`


<!-- END_c06cffaa29eb1a4afb4762c6f9371f54 -->

<!-- START_cc5e781c890dcdb5df9a044e41b6d046 -->
## Refresh a token.

> Example request:



### HTTP Request
`POST api/dashboard/auth/refresh`


<!-- END_cc5e781c890dcdb5df9a044e41b6d046 -->

<!-- START_a42a29c08e1a8f12410ef29926b9cf37 -->
## Get the authenticated User

> Example request:



### HTTP Request
`POST api/dashboard/auth/me`


<!-- END_a42a29c08e1a8f12410ef29926b9cf37 -->

<!-- START_e01b76a41eaf415c2592c091d5cbceac -->
## api/dashboard/auth/lost-password
> Example request:



### HTTP Request
`POST api/dashboard/auth/lost-password`


<!-- END_e01b76a41eaf415c2592c091d5cbceac -->

<!-- START_26d65dc82ba5f697509288fb8771a15c -->
## api/dashboard/auth/check-token/{token}
> Example request:


> Example response (410):

```json
{
    "response": "Resource not found"
}
```

### HTTP Request
`GET api/dashboard/auth/check-token/{token}`


<!-- END_26d65dc82ba5f697509288fb8771a15c -->

<!-- START_0f4c99b97ea7c2a47962807aca43f9e8 -->
## api/dashboard/auth/reset-password/{user_id}
> Example request:



### HTTP Request
`POST api/dashboard/auth/reset-password/{user_id}`


<!-- END_0f4c99b97ea7c2a47962807aca43f9e8 -->

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

#general


<!-- START_d6261f926c26d068ce14643c8bb66ab1 -->
## Store a newly created resource in storage.

> Example request:



### HTTP Request
`POST api/medicale-orientation`


<!-- END_d6261f926c26d068ce14643c8bb66ab1 -->

<!-- START_a5638ea523c7896e9ddba59f1d631c74 -->
## Display a listing of the resource.

> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/africell/health-zone`


<!-- END_a5638ea523c7896e9ddba59f1d631c74 -->

<!-- START_a5a559225335a0534cb5858a2448816e -->
## api/dashboard/flux/africell/presence/provinces
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/africell/presence/provinces`


<!-- END_a5a559225335a0534cb5858a2448816e -->

<!-- START_c0a626b2dad640b864bd26d4862f6934 -->
## api/dashboard/flux/africell/presence/zones
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/africell/presence/zones`


<!-- END_c0a626b2dad640b864bd26d4862f6934 -->

<!-- START_262c3b29e4a6764190590b3308d86b32 -->
## api/dashboard/flux/africell/hors-zone/zones
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/africell/hors-zone/zones`


<!-- END_262c3b29e4a6764190590b3308d86b32 -->

<!-- START_2bc61c8e8b0d6c9823bc053cdf9775b8 -->
## api/dashboard/flux/africell/in-out/zones
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/africell/in-out/zones`


<!-- END_2bc61c8e8b0d6c9823bc053cdf9775b8 -->

<!-- START_6a2525c49abcbf48442b3c101ab7d8da -->
## api/dashboard/flux/predefined/zones/h-24
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/predefined/zones/h-24`


<!-- END_6a2525c49abcbf48442b3c101ab7d8da -->

<!-- START_000dbfc8b1531adc7aded98e5279b8da -->
## api/dashboard/flux/predefined/zones/h-24/daily
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/predefined/zones/h-24/daily`


<!-- END_000dbfc8b1531adc7aded98e5279b8da -->

<!-- START_1be4594974b5a905881e6b8c4e4f7f6e -->
## api/dashboard/flux/predefined/zones/h-24/daily-compare
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/predefined/zones/h-24/daily-compare`


<!-- END_1be4594974b5a905881e6b8c4e4f7f6e -->

<!-- START_486e8a162349f460091b87f1bf95fcdd -->
## api/dashboard/flux/predefined/zones/h-24/daily-in
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/predefined/zones/h-24/daily-in`


<!-- END_486e8a162349f460091b87f1bf95fcdd -->

<!-- START_fdffde34b554d7948ee195e19d543fd4 -->
## api/dashboard/flux/predefined/zones/h-24/daily-out
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/predefined/zones/h-24/daily-out`


<!-- END_fdffde34b554d7948ee195e19d543fd4 -->

<!-- START_5364843de6936b05dbc20b180cfe4589 -->
## api/dashboard/flux/origin/zones/h-24
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/zones/h-24`


<!-- END_5364843de6936b05dbc20b180cfe4589 -->

<!-- START_f8fbe4d5ce379e129e8eba5985fb22df -->
## api/dashboard/flux/origin/zones/h-24/daily
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/zones/h-24/daily`


<!-- END_f8fbe4d5ce379e129e8eba5985fb22df -->

<!-- START_03802abdb7f036f49433ee24e09477e5 -->
## api/dashboard/flux/origin/zones/h-24/daily-compare
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/zones/h-24/daily-compare`


<!-- END_03802abdb7f036f49433ee24e09477e5 -->

<!-- START_f9751b867e2d1df8cbb881833e4d444d -->
## api/dashboard/flux/origin/zones/h-24/daily-in
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/zones/h-24/daily-in`


<!-- END_f9751b867e2d1df8cbb881833e4d444d -->

<!-- START_8d5adf4f7ec9f65f7b4d6a91fac9101d -->
## api/dashboard/flux/origin/zones/h-24/daily-out
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/zones/h-24/daily-out`


<!-- END_8d5adf4f7ec9f65f7b4d6a91fac9101d -->

<!-- START_6f89b7bb585666c0f21534b713abd065 -->
## api/dashboard/flux/origin/zones/h-24/global-in/province
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/zones/h-24/global-in/province`


<!-- END_6f89b7bb585666c0f21534b713abd065 -->

<!-- START_fa35a9c1161bf86912a7edf2ec613406 -->
## api/dashboard/flux/origin/zones/h-24/global-out/province
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/zones/h-24/global-out/province`


<!-- END_fa35a9c1161bf86912a7edf2ec613406 -->

<!-- START_1b63356dee84de87122967c64756ecd4 -->
## api/dashboard/flux/origin/zones/m-30
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/origin/zones/m-30`


<!-- END_1b63356dee84de87122967c64756ecd4 -->

<!-- START_8c58af349ae17c522c2e2776ae2fa29a -->
## api/dashboard/flux/origin/zones/m-30/daily-compare
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/origin/zones/m-30/daily-compare`


<!-- END_8c58af349ae17c522c2e2776ae2fa29a -->

<!-- START_689cb04dcb76ec8689c87fc57e6dd3c2 -->
## api/dashboard/flux/origin/zones/m-30/daily
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/origin/zones/m-30/daily`


<!-- END_689cb04dcb76ec8689c87fc57e6dd3c2 -->

<!-- START_77e42f65ee0b3499e6679ae5d63ad0ee -->
## api/dashboard/flux/origin/zones/m-30/daily-in
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/origin/zones/m-30/daily-in`


<!-- END_77e42f65ee0b3499e6679ae5d63ad0ee -->

<!-- START_c9959fdcb9dab5eab56e42c446eb957d -->
## api/dashboard/flux/origin/zones/m-30/daily-out
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/origin/zones/m-30/daily-out`


<!-- END_c9959fdcb9dab5eab56e42c446eb957d -->

<!-- START_8ecbb8b195e3c5ac6067120bcdeea82b -->
## api/dashboard/flux/origin/zones/presence/h-24
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/origin/zones/presence/h-24`


<!-- END_8ecbb8b195e3c5ac6067120bcdeea82b -->

<!-- START_fc4451eaeb39b0a7a9ad7fe88fc2081c -->
## api/dashboard/flux/origin/zones/presence/h-24/daily
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/origin/zones/presence/h-24/daily`


<!-- END_fc4451eaeb39b0a7a9ad7fe88fc2081c -->

<!-- START_1748656ff3a79479501b5a2f4496d466 -->
## api/dashboard/flux/origin/zones/presence/h-24/daily-in
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/zones/presence/h-24/daily-in`


<!-- END_1748656ff3a79479501b5a2f4496d466 -->

<!-- START_828bfc4c29c8d96150f437eb1fcc65b6 -->
## api/dashboard/flux/origin/provinces/h-24
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/provinces/h-24`


<!-- END_828bfc4c29c8d96150f437eb1fcc65b6 -->

<!-- START_9bf08575078436d688451b9d973a8bd4 -->
## api/dashboard/flux/origin/provinces/h-24/daily
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/provinces/h-24/daily`


<!-- END_9bf08575078436d688451b9d973a8bd4 -->

<!-- START_c836423c68d0d7cdb12e4f80fab52d66 -->
## api/dashboard/flux/origin/provinces/h-24/daily-compare
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/provinces/h-24/daily-compare`


<!-- END_c836423c68d0d7cdb12e4f80fab52d66 -->

<!-- START_8f4e77268c1c25aeade9284e8efcfbf2 -->
## api/dashboard/flux/origin/provinces/h-24/daily-in
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/provinces/h-24/daily-in`


<!-- END_8f4e77268c1c25aeade9284e8efcfbf2 -->

<!-- START_090e9ac136af6b9f87eaf94e7e69075e -->
## api/dashboard/flux/origin/provinces/h-24/daily-out
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/provinces/h-24/daily-out`


<!-- END_090e9ac136af6b9f87eaf94e7e69075e -->

<!-- START_60316c24765f2362603d53e82f220f90 -->
## api/dashboard/flux/origin/provinces/h-24/global-in
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/provinces/h-24/global-in`


<!-- END_60316c24765f2362603d53e82f220f90 -->

<!-- START_a262e264fb04610474ea74e8f19609b5 -->
## api/dashboard/flux/origin/provinces/h-24/global-out
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/provinces/h-24/global-out`


<!-- END_a262e264fb04610474ea74e8f19609b5 -->

<!-- START_5c3804f48ac6741dcfbadff92bbf5e82 -->
## api/dashboard/flux/origin/provinces/m-30
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/provinces/m-30`


<!-- END_5c3804f48ac6741dcfbadff92bbf5e82 -->

<!-- START_46719746661518ecdcbe467aef294dfe -->
## api/dashboard/flux/origin/provinces/m-30/daily
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/provinces/m-30/daily`


<!-- END_46719746661518ecdcbe467aef294dfe -->

<!-- START_06daa2d154f22f9a451e20c46d84ce09 -->
## api/dashboard/flux/origin/provinces/m-30/daily-in
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/provinces/m-30/daily-in`


<!-- END_06daa2d154f22f9a451e20c46d84ce09 -->

<!-- START_4198ab63a10e383fa69b21ddf7d0708d -->
## api/dashboard/flux/origin/provinces/m-30/daily-out
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/provinces/m-30/daily-out`


<!-- END_4198ab63a10e383fa69b21ddf7d0708d -->

<!-- START_5ca0cf248735b710c51c91eb602d5487 -->
## api/dashboard/flux/origin/provinces/presence/h-24
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/origin/provinces/presence/h-24`


<!-- END_5ca0cf248735b710c51c91eb602d5487 -->

<!-- START_ba8c8ad24e2c756b27f47914dbbb55a7 -->
## api/dashboard/flux/origin/provinces/presence/h-24/daily
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/origin/provinces/presence/h-24/daily`


<!-- END_ba8c8ad24e2c756b27f47914dbbb55a7 -->

<!-- START_f90bba3387315f2542178f9be214307c -->
## api/dashboard/flux/origin/provinces/presence/h-24/daily-in
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/flux/origin/provinces/presence/h-24/daily-in`


<!-- END_f90bba3387315f2542178f9be214307c -->

<!-- START_4f2ecc8520adc7566b65dd9191ec6204 -->
## Display a listing of the resource.

> Example request:


> Example response (200):

```json
[
    {
        "id": 103,
        "name": "Aéroport Ndjili",
        "created_at": null,
        "updated_at": "2020-12-23T14:47:16.000000Z",
        "min_date": "2020-07-01",
        "type": "Aéroport"
    },
    {
        "id": 102,
        "name": "Aéroport Ndolo",
        "created_at": null,
        "updated_at": "2020-12-23T14:47:15.000000Z",
        "min_date": "2020-07-01",
        "type": "Aéroport"
    },
    {
        "id": 10,
        "name": "Arret Bakayaou",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:00.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 7,
        "name": "Arret Centre hospitalier de Kintambo",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:53.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 40,
        "name": "Arret moulard",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:21.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 80,
        "name": "Arret Socimat",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:46.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 8,
        "name": "Arret Stade Velodrome",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:31.000000Z",
        "min_date": "2020-05-17",
        "type": "Commerces"
    },
    {
        "id": 90,
        "name": "Arret Station Centre Superieur",
        "created_at": null,
        "updated_at": "2020-12-16T11:12:55.000000Z",
        "min_date": "2020-05-17",
        "type": "Supermarche"
    },
    {
        "id": 17,
        "name": "Arret Station Macampagne (ML)",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:39.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 78,
        "name": "ASSANEF",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:14.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 75,
        "name": "Avenue du Commerce et Kasa vubu",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:12.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 29,
        "name": "Baruti Tabernacle",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:07.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 81,
        "name": "BATETELA",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:50.000000Z",
        "min_date": "2020-05-17",
        "type": "BureauAdmin"
    },
    {
        "id": 20,
        "name": "Benseke Nouvelle Cite",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:04.000000Z",
        "min_date": "2020-05-17",
        "type": "Cimetiere"
    },
    {
        "id": 31,
        "name": "Binza Arret Maternite",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:58.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 61,
        "name": "Carrigres",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:56.000000Z",
        "min_date": "2020-05-17",
        "type": "Supermarche"
    },
    {
        "id": 12,
        "name": "CE TRINITE",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:08.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 34,
        "name": "Centre d'Evangelisation Peniel CEPE",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:24.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 76,
        "name": "Centre Evangelique Emmanuel Langa-langa",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:23.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 56,
        "name": "Cimetiere Kimbanseke",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:02.000000Z",
        "min_date": "2020-05-17",
        "type": "Cimetiere"
    },
    {
        "id": 9,
        "name": "Cimetiere Kintambo",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:21.000000Z",
        "min_date": "2020-05-17",
        "type": "Cimetiere"
    },
    {
        "id": 95,
        "name": "Cimetiere Mingadi",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:03.000000Z",
        "min_date": "2020-05-17",
        "type": "Cimetiere"
    },
    {
        "id": 69,
        "name": "Cimetiere Ndjili Brasserie",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:05.000000Z",
        "min_date": "2020-05-17",
        "type": "Cimetiere"
    },
    {
        "id": 21,
        "name": "Cimetiere sans fil",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:52.000000Z",
        "min_date": "2020-05-17",
        "type": "Cimetiere"
    },
    {
        "id": 11,
        "name": "Croissement Kianza et Universite",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:30.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 3,
        "name": "DGC barre",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:37.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 101,
        "name": "Dvin",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:02.000000Z",
        "min_date": "2020-05-18",
        "type": "Restaurants"
    },
    {
        "id": 42,
        "name": "ECC\/CEC\/BUMBU",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:32.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 37,
        "name": "Eglise Catholique Divin Maître",
        "created_at": null,
        "updated_at": "2020-12-16T11:12:59.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 72,
        "name": "Eglise des assemblées de dieu",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:02.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 55,
        "name": "Eglise Francophone Ecole de Tyrannus",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:18.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 53,
        "name": "Eglise Kimbanguiste",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:29.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 27,
        "name": "Eglise locale Cbfc Itaga",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:20.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 83,
        "name": "Eglise Notre Dame de Fatima",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:11.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 30,
        "name": "eglise protestante de lemba",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:40.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 23,
        "name": "Eglise Saint Paul",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:19.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 35,
        "name": "Ejcev Nouvelle Alliance Bima",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:25.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 84,
        "name": "FIKIN",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:27.000000Z",
        "min_date": "2020-05-17",
        "type": "Commerces"
    },
    {
        "id": 22,
        "name": "Food Market Macampagne",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:38.000000Z",
        "min_date": "2020-05-17",
        "type": "Restaurants"
    },
    {
        "id": 66,
        "name": "Gabriella",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:43.000000Z",
        "min_date": "2020-05-17",
        "type": "Restaurants"
    },
    {
        "id": 97,
        "name": "Hall de la Gombe",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:15.000000Z",
        "min_date": "2020-05-17",
        "type": "Commerces"
    },
    {
        "id": 71,
        "name": "Hopital Biamba Marie Mutombo",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:13.000000Z",
        "min_date": "2020-05-17",
        "type": "Hopitaux"
    },
    {
        "id": 24,
        "name": "Hopital general de Kintambo",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:41.000000Z",
        "min_date": "2020-05-17",
        "type": "Hopitaux"
    },
    {
        "id": 91,
        "name": "Hotel du Fleuve",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:19.000000Z",
        "min_date": "2020-05-17",
        "type": "Hotels"
    },
    {
        "id": 100,
        "name": "HOTEL DU GOUVERNEMENT",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:46.000000Z",
        "min_date": "2020-05-17",
        "type": "Supermarche"
    },
    {
        "id": 89,
        "name": "Hotel Memling",
        "created_at": null,
        "updated_at": "2020-12-16T11:12:57.000000Z",
        "min_date": "2020-05-17",
        "type": "Hotels"
    },
    {
        "id": 73,
        "name": "Hotel Sultani",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:10.000000Z",
        "min_date": "2020-05-17",
        "type": "Hotels"
    },
    {
        "id": 5,
        "name": "Huillerie",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:04.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 82,
        "name": "Immeuble CNSS",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:07.000000Z",
        "min_date": "2020-05-17",
        "type": "BureauAdmin"
    },
    {
        "id": 93,
        "name": "Immeuble Cosmos",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:37.000000Z",
        "min_date": "2020-05-17",
        "type": "Commerces"
    },
    {
        "id": 44,
        "name": "INA et ORCA",
        "created_at": null,
        "updated_at": "2020-12-16T11:12:54.000000Z",
        "min_date": "2020-05-17",
        "type": "Commerces"
    },
    {
        "id": 15,
        "name": "INBTP",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:18.000000Z",
        "min_date": "2020-05-17",
        "type": "BureauAdmin"
    },
    {
        "id": 1,
        "name": "Inconnue",
        "created_at": null,
        "updated_at": "2020-12-14T10:00:28.000000Z",
        "min_date": "2020-05-17",
        "type": null
    },
    {
        "id": 14,
        "name": "Kinkole",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:15.000000Z",
        "min_date": "2020-05-17",
        "type": "Cimetiere"
    },
    {
        "id": 38,
        "name": "Kinsuka",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:57.000000Z",
        "min_date": "2020-05-17",
        "type": "Cimetiere"
    },
    {
        "id": 86,
        "name": "La voix du fleuve",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:20.000000Z",
        "min_date": "2020-05-17",
        "type": "Restaurants"
    },
    {
        "id": 18,
        "name": "Le cerlce gourmand",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:10.000000Z",
        "min_date": "2020-05-17",
        "type": "Restaurants"
    },
    {
        "id": 62,
        "name": "le pain de vie",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:22.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 98,
        "name": "Le premier Shopping Mall",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:09.000000Z",
        "min_date": "2020-05-17",
        "type": "Commerces"
    },
    {
        "id": 64,
        "name": "Lemba Terminus",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:09.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 74,
        "name": "Maché De Kadi",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:17.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 41,
        "name": "Marché BAYAKA",
        "created_at": null,
        "updated_at": "2020-12-16T11:12:56.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 28,
        "name": "Marché central",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:20.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 49,
        "name": "Marché de la Liberté",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:12.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 46,
        "name": "Marché de Mbanza Lemba",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:08.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 32,
        "name": "Marché Delvaux",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:35.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 50,
        "name": "Marché Mangobo",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:55.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 68,
        "name": "Marché Matete",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:11.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 52,
        "name": "Marché Mbika",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:00.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 43,
        "name": "Marché selembao",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:34.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 39,
        "name": "Matadi Kibala",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:47.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 77,
        "name": "Mbudi Nature",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:56.000000Z",
        "min_date": "2020-05-17",
        "type": "Commerces"
    },
    {
        "id": 96,
        "name": "Mimoza plaza",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:51.000000Z",
        "min_date": "2020-05-17",
        "type": "Restaurants"
    },
    {
        "id": 63,
        "name": "Ministere combat spirituel",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:29.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 19,
        "name": "Ministere des affaires etrangeres",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:48.000000Z",
        "min_date": "2020-05-17",
        "type": "BureauAdmin"
    },
    {
        "id": 58,
        "name": "Mosqué Bon Marche",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:16.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 6,
        "name": "Mosqué Centrale Usoke",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:13.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 88,
        "name": "Mosqué Kingabwa",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:21.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 94,
        "name": "Necropole entre ciel et terre",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:16.000000Z",
        "min_date": "2020-05-17",
        "type": "Cimetiere"
    },
    {
        "id": 85,
        "name": "O'Poeta",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:42.000000Z",
        "min_date": "2020-05-17",
        "type": "Restaurants"
    },
    {
        "id": 70,
        "name": "ONATRA",
        "created_at": null,
        "updated_at": "2020-12-16T11:12:52.000000Z",
        "min_date": "2020-05-17",
        "type": "BureauAdmin"
    },
    {
        "id": 16,
        "name": "Parc Mont Ngaliema",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:01.000000Z",
        "min_date": "2020-05-17",
        "type": "Commerces"
    },
    {
        "id": 67,
        "name": "Paroisse Notre-Dame d'Afrique",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:28.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 99,
        "name": "Paroisse Sacre Coeur",
        "created_at": null,
        "updated_at": "2020-12-16T11:12:53.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 65,
        "name": "Paroisse Saint Eloi",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:17.000000Z",
        "min_date": "2020-05-17",
        "type": "Supermarche"
    },
    {
        "id": 36,
        "name": "Paroisse saint François-Xavier",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:26.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 33,
        "name": "Peloustore KIVU",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:59.000000Z",
        "min_date": "2020-05-17",
        "type": "Supermarche"
    },
    {
        "id": 13,
        "name": "Place Commercial de limete(7e rue)",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:22.000000Z",
        "min_date": "2020-05-17",
        "type": "Hopitaux"
    },
    {
        "id": 54,
        "name": "Place de la gare centrale",
        "created_at": null,
        "updated_at": "2020-12-16T11:12:58.000000Z",
        "min_date": "2020-05-17",
        "type": "Hotels"
    },
    {
        "id": 48,
        "name": "Place sainte therese",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:06.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 47,
        "name": "Pont Matete",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:10.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 87,
        "name": "Poste",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:05.000000Z",
        "min_date": "2020-05-17",
        "type": "BureauAdmin"
    },
    {
        "id": 57,
        "name": "Quartier 1 (croissement Boulevard Lumumba)",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:14.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 51,
        "name": "Rond Point Forescom",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:03.000000Z",
        "min_date": "2020-05-17",
        "type": "BureauAdmin"
    },
    {
        "id": 45,
        "name": "Rond Point Ngaba",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:05.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 60,
        "name": "ROND POINT SAFRICAS",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:45.000000Z",
        "min_date": "2020-05-17",
        "type": "Restaurants"
    },
    {
        "id": 25,
        "name": "Salle de fete de la Rotonde Binza",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:36.000000Z",
        "min_date": "2020-05-17",
        "type": "Restaurants"
    },
    {
        "id": 79,
        "name": "Shark Club",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:49.000000Z",
        "min_date": "2020-05-17",
        "type": "Commerces"
    },
    {
        "id": 92,
        "name": "Shoprite",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:44.000000Z",
        "min_date": "2020-05-17",
        "type": "Supermarche"
    },
    {
        "id": 59,
        "name": "SONAS",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:06.000000Z",
        "min_date": "2020-05-17",
        "type": "Supermarche"
    },
    {
        "id": 26,
        "name": "TASOK",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:54.000000Z",
        "min_date": "2020-05-17",
        "type": "BureauAdmin"
    },
    {
        "id": 2,
        "name": "UPN Djelo",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:01.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 4,
        "name": "Wenze Muselu\/Gambela",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:33.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    }
]
```

### HTTP Request
`GET api/dashboard/flux/hotspots/list`


<!-- END_4f2ecc8520adc7566b65dd9191ec6204 -->

<!-- START_c104c649fbcac1cd1fae93452c683367 -->
## api/dashboard/flux/hotspots/maps
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/hotspots/maps`


<!-- END_c104c649fbcac1cd1fae93452c683367 -->

<!-- START_8b52af129fda3aa4bffd3f9bd77fbdb1 -->
## api/dashboard/flux/hotspots/tendance
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/hotspots/tendance`


<!-- END_8b52af129fda3aa4bffd3f9bd77fbdb1 -->

<!-- START_a5b8ffe49997637b4872d999a1308a04 -->
## api/dashboard/flux/hotspots/daily
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/hotspots/daily`


<!-- END_a5b8ffe49997637b4872d999a1308a04 -->

<!-- START_385228fd442def1591f20fc6edd4e290 -->
## api/dashboard/flux/hotspots/general
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/hotspots/general`


<!-- END_385228fd442def1591f20fc6edd4e290 -->

<!-- START_8147aa86fe300c9db9e6fd2ed830af64 -->
## Display a listing of the resource.

> Example request:


> Example response (200):

```json
[
    {
        "id": 103,
        "name": "Aéroport Ndjili",
        "created_at": null,
        "updated_at": "2020-12-23T14:47:16.000000Z",
        "min_date": "2020-07-01",
        "type": "Aéroport"
    },
    {
        "id": 102,
        "name": "Aéroport Ndolo",
        "created_at": null,
        "updated_at": "2020-12-23T14:47:15.000000Z",
        "min_date": "2020-07-01",
        "type": "Aéroport"
    },
    {
        "id": 10,
        "name": "Arret Bakayaou",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:00.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 7,
        "name": "Arret Centre hospitalier de Kintambo",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:53.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 40,
        "name": "Arret moulard",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:21.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 80,
        "name": "Arret Socimat",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:46.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 8,
        "name": "Arret Stade Velodrome",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:31.000000Z",
        "min_date": "2020-05-17",
        "type": "Commerces"
    },
    {
        "id": 90,
        "name": "Arret Station Centre Superieur",
        "created_at": null,
        "updated_at": "2020-12-16T11:12:55.000000Z",
        "min_date": "2020-05-17",
        "type": "Supermarche"
    },
    {
        "id": 17,
        "name": "Arret Station Macampagne (ML)",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:39.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 78,
        "name": "ASSANEF",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:14.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 75,
        "name": "Avenue du Commerce et Kasa vubu",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:12.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 29,
        "name": "Baruti Tabernacle",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:07.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 81,
        "name": "BATETELA",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:50.000000Z",
        "min_date": "2020-05-17",
        "type": "BureauAdmin"
    },
    {
        "id": 20,
        "name": "Benseke Nouvelle Cite",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:04.000000Z",
        "min_date": "2020-05-17",
        "type": "Cimetiere"
    },
    {
        "id": 31,
        "name": "Binza Arret Maternite",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:58.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 61,
        "name": "Carrigres",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:56.000000Z",
        "min_date": "2020-05-17",
        "type": "Supermarche"
    },
    {
        "id": 12,
        "name": "CE TRINITE",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:08.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 34,
        "name": "Centre d'Evangelisation Peniel CEPE",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:24.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 76,
        "name": "Centre Evangelique Emmanuel Langa-langa",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:23.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 56,
        "name": "Cimetiere Kimbanseke",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:02.000000Z",
        "min_date": "2020-05-17",
        "type": "Cimetiere"
    },
    {
        "id": 9,
        "name": "Cimetiere Kintambo",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:21.000000Z",
        "min_date": "2020-05-17",
        "type": "Cimetiere"
    },
    {
        "id": 95,
        "name": "Cimetiere Mingadi",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:03.000000Z",
        "min_date": "2020-05-17",
        "type": "Cimetiere"
    },
    {
        "id": 69,
        "name": "Cimetiere Ndjili Brasserie",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:05.000000Z",
        "min_date": "2020-05-17",
        "type": "Cimetiere"
    },
    {
        "id": 21,
        "name": "Cimetiere sans fil",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:52.000000Z",
        "min_date": "2020-05-17",
        "type": "Cimetiere"
    },
    {
        "id": 11,
        "name": "Croissement Kianza et Universite",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:30.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 3,
        "name": "DGC barre",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:37.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 101,
        "name": "Dvin",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:02.000000Z",
        "min_date": "2020-05-18",
        "type": "Restaurants"
    },
    {
        "id": 42,
        "name": "ECC\/CEC\/BUMBU",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:32.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 37,
        "name": "Eglise Catholique Divin Maître",
        "created_at": null,
        "updated_at": "2020-12-16T11:12:59.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 72,
        "name": "Eglise des assemblées de dieu",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:02.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 55,
        "name": "Eglise Francophone Ecole de Tyrannus",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:18.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 53,
        "name": "Eglise Kimbanguiste",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:29.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 27,
        "name": "Eglise locale Cbfc Itaga",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:20.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 83,
        "name": "Eglise Notre Dame de Fatima",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:11.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 30,
        "name": "eglise protestante de lemba",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:40.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 23,
        "name": "Eglise Saint Paul",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:19.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 35,
        "name": "Ejcev Nouvelle Alliance Bima",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:25.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 84,
        "name": "FIKIN",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:27.000000Z",
        "min_date": "2020-05-17",
        "type": "Commerces"
    },
    {
        "id": 22,
        "name": "Food Market Macampagne",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:38.000000Z",
        "min_date": "2020-05-17",
        "type": "Restaurants"
    },
    {
        "id": 66,
        "name": "Gabriella",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:43.000000Z",
        "min_date": "2020-05-17",
        "type": "Restaurants"
    },
    {
        "id": 97,
        "name": "Hall de la Gombe",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:15.000000Z",
        "min_date": "2020-05-17",
        "type": "Commerces"
    },
    {
        "id": 71,
        "name": "Hopital Biamba Marie Mutombo",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:13.000000Z",
        "min_date": "2020-05-17",
        "type": "Hopitaux"
    },
    {
        "id": 24,
        "name": "Hopital general de Kintambo",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:41.000000Z",
        "min_date": "2020-05-17",
        "type": "Hopitaux"
    },
    {
        "id": 91,
        "name": "Hotel du Fleuve",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:19.000000Z",
        "min_date": "2020-05-17",
        "type": "Hotels"
    },
    {
        "id": 100,
        "name": "HOTEL DU GOUVERNEMENT",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:46.000000Z",
        "min_date": "2020-05-17",
        "type": "Supermarche"
    },
    {
        "id": 89,
        "name": "Hotel Memling",
        "created_at": null,
        "updated_at": "2020-12-16T11:12:57.000000Z",
        "min_date": "2020-05-17",
        "type": "Hotels"
    },
    {
        "id": 73,
        "name": "Hotel Sultani",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:10.000000Z",
        "min_date": "2020-05-17",
        "type": "Hotels"
    },
    {
        "id": 5,
        "name": "Huillerie",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:04.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 82,
        "name": "Immeuble CNSS",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:07.000000Z",
        "min_date": "2020-05-17",
        "type": "BureauAdmin"
    },
    {
        "id": 93,
        "name": "Immeuble Cosmos",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:37.000000Z",
        "min_date": "2020-05-17",
        "type": "Commerces"
    },
    {
        "id": 44,
        "name": "INA et ORCA",
        "created_at": null,
        "updated_at": "2020-12-16T11:12:54.000000Z",
        "min_date": "2020-05-17",
        "type": "Commerces"
    },
    {
        "id": 15,
        "name": "INBTP",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:18.000000Z",
        "min_date": "2020-05-17",
        "type": "BureauAdmin"
    },
    {
        "id": 1,
        "name": "Inconnue",
        "created_at": null,
        "updated_at": "2020-12-14T10:00:28.000000Z",
        "min_date": "2020-05-17",
        "type": null
    },
    {
        "id": 14,
        "name": "Kinkole",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:15.000000Z",
        "min_date": "2020-05-17",
        "type": "Cimetiere"
    },
    {
        "id": 38,
        "name": "Kinsuka",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:57.000000Z",
        "min_date": "2020-05-17",
        "type": "Cimetiere"
    },
    {
        "id": 86,
        "name": "La voix du fleuve",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:20.000000Z",
        "min_date": "2020-05-17",
        "type": "Restaurants"
    },
    {
        "id": 18,
        "name": "Le cerlce gourmand",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:10.000000Z",
        "min_date": "2020-05-17",
        "type": "Restaurants"
    },
    {
        "id": 62,
        "name": "le pain de vie",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:22.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 98,
        "name": "Le premier Shopping Mall",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:09.000000Z",
        "min_date": "2020-05-17",
        "type": "Commerces"
    },
    {
        "id": 64,
        "name": "Lemba Terminus",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:09.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 74,
        "name": "Maché De Kadi",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:17.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 41,
        "name": "Marché BAYAKA",
        "created_at": null,
        "updated_at": "2020-12-16T11:12:56.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 28,
        "name": "Marché central",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:20.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 49,
        "name": "Marché de la Liberté",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:12.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 46,
        "name": "Marché de Mbanza Lemba",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:08.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 32,
        "name": "Marché Delvaux",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:35.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 50,
        "name": "Marché Mangobo",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:55.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 68,
        "name": "Marché Matete",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:11.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 52,
        "name": "Marché Mbika",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:00.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 43,
        "name": "Marché selembao",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:34.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 39,
        "name": "Matadi Kibala",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:47.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    },
    {
        "id": 77,
        "name": "Mbudi Nature",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:56.000000Z",
        "min_date": "2020-05-17",
        "type": "Commerces"
    },
    {
        "id": 96,
        "name": "Mimoza plaza",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:51.000000Z",
        "min_date": "2020-05-17",
        "type": "Restaurants"
    },
    {
        "id": 63,
        "name": "Ministere combat spirituel",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:29.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 19,
        "name": "Ministere des affaires etrangeres",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:48.000000Z",
        "min_date": "2020-05-17",
        "type": "BureauAdmin"
    },
    {
        "id": 58,
        "name": "Mosqué Bon Marche",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:16.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 6,
        "name": "Mosqué Centrale Usoke",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:13.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 88,
        "name": "Mosqué Kingabwa",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:21.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 94,
        "name": "Necropole entre ciel et terre",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:16.000000Z",
        "min_date": "2020-05-17",
        "type": "Cimetiere"
    },
    {
        "id": 85,
        "name": "O'Poeta",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:42.000000Z",
        "min_date": "2020-05-17",
        "type": "Restaurants"
    },
    {
        "id": 70,
        "name": "ONATRA",
        "created_at": null,
        "updated_at": "2020-12-16T11:12:52.000000Z",
        "min_date": "2020-05-17",
        "type": "BureauAdmin"
    },
    {
        "id": 16,
        "name": "Parc Mont Ngaliema",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:01.000000Z",
        "min_date": "2020-05-17",
        "type": "Commerces"
    },
    {
        "id": 67,
        "name": "Paroisse Notre-Dame d'Afrique",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:28.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 99,
        "name": "Paroisse Sacre Coeur",
        "created_at": null,
        "updated_at": "2020-12-16T11:12:53.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 65,
        "name": "Paroisse Saint Eloi",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:17.000000Z",
        "min_date": "2020-05-17",
        "type": "Supermarche"
    },
    {
        "id": 36,
        "name": "Paroisse saint François-Xavier",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:26.000000Z",
        "min_date": "2020-05-17",
        "type": "Eglises"
    },
    {
        "id": 33,
        "name": "Peloustore KIVU",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:59.000000Z",
        "min_date": "2020-05-17",
        "type": "Supermarche"
    },
    {
        "id": 13,
        "name": "Place Commercial de limete(7e rue)",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:22.000000Z",
        "min_date": "2020-05-17",
        "type": "Hopitaux"
    },
    {
        "id": 54,
        "name": "Place de la gare centrale",
        "created_at": null,
        "updated_at": "2020-12-16T11:12:58.000000Z",
        "min_date": "2020-05-17",
        "type": "Hotels"
    },
    {
        "id": 48,
        "name": "Place sainte therese",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:06.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 47,
        "name": "Pont Matete",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:10.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 87,
        "name": "Poste",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:05.000000Z",
        "min_date": "2020-05-17",
        "type": "BureauAdmin"
    },
    {
        "id": 57,
        "name": "Quartier 1 (croissement Boulevard Lumumba)",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:14.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 51,
        "name": "Rond Point Forescom",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:03.000000Z",
        "min_date": "2020-05-17",
        "type": "BureauAdmin"
    },
    {
        "id": 45,
        "name": "Rond Point Ngaba",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:05.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 60,
        "name": "ROND POINT SAFRICAS",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:45.000000Z",
        "min_date": "2020-05-17",
        "type": "Restaurants"
    },
    {
        "id": 25,
        "name": "Salle de fete de la Rotonde Binza",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:36.000000Z",
        "min_date": "2020-05-17",
        "type": "Restaurants"
    },
    {
        "id": 79,
        "name": "Shark Club",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:49.000000Z",
        "min_date": "2020-05-17",
        "type": "Commerces"
    },
    {
        "id": 92,
        "name": "Shoprite",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:44.000000Z",
        "min_date": "2020-05-17",
        "type": "Supermarche"
    },
    {
        "id": 59,
        "name": "SONAS",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:06.000000Z",
        "min_date": "2020-05-17",
        "type": "Supermarche"
    },
    {
        "id": 26,
        "name": "TASOK",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:54.000000Z",
        "min_date": "2020-05-17",
        "type": "BureauAdmin"
    },
    {
        "id": 2,
        "name": "UPN Djelo",
        "created_at": null,
        "updated_at": "2020-12-16T11:14:01.000000Z",
        "min_date": "2020-05-17",
        "type": "ArretTransport"
    },
    {
        "id": 4,
        "name": "Wenze Muselu\/Gambela",
        "created_at": null,
        "updated_at": "2020-12-16T11:13:33.000000Z",
        "min_date": "2020-05-17",
        "type": "Marché"
    }
]
```

### HTTP Request
`GET api/dashboard/flux/hotspots/types/list`


<!-- END_8147aa86fe300c9db9e6fd2ed830af64 -->

<!-- START_4427912b3b4a5e8a64d9d2731137f12e -->
## api/dashboard/flux/hotspots/types/maps
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/hotspots/types/maps`


<!-- END_4427912b3b4a5e8a64d9d2731137f12e -->

<!-- START_b4d41abb78d5917d1bf6f8d91c804c1f -->
## api/dashboard/flux/hotspots/types/tendance
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/hotspots/types/tendance`


<!-- END_b4d41abb78d5917d1bf6f8d91c804c1f -->

<!-- START_93e27becee6623b46abfcea59b375e49 -->
## api/dashboard/flux/hotspots/types/daily
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/hotspots/types/daily`


<!-- END_93e27becee6623b46abfcea59b375e49 -->

<!-- START_b49a0dc609d79960c8765399fee4e1a3 -->
## api/dashboard/flux/hotspots/types/general
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/flux/hotspots/types/general`


<!-- END_b49a0dc609d79960c8765399fee4e1a3 -->

<!-- START_70750654f1ddb3eee06bcbacd62d9301 -->
## api/dashboard/hospital-situations/by-hospital/{hospital_id}
> Example request:


> Example response (200):

```json
{
    "data": [
        {
            "id": 337,
            "confirmed_cumul": 119,
            "sick": 4,
            "healed_cumul": 15,
            "dead_cumul": 0,
            "confirmed": 4,
            "healed": 1,
            "dead": 0,
            "occupied_Beds": 0,
            "occupied_respirators": 0,
            "masks": 0,
            "occupied_foam_beds": 4,
            "occupied_resuscitation_beds": 0,
            "individual_protection_equipment": 0,
            "gel_hydro_alcoolique": 0,
            "resuscitation_ventilator": 0,
            "oxygenator": 2,
            "rapid_screening": 500,
            "automate_genexpert": 1,
            "x_ray": 0,
            "check_point": 1,
            "chloroquine": 0,
            "hydrochloroquine": 2100,
            "azytromicine": 300,
            "Vitamince_c": 5100,
            "last_update": "2020-08-28 00:00:00",
            "updated_manager_name": null,
            "created_manager_name": "Dr Kibwana"
        },
        {
            "id": 317,
            "confirmed_cumul": 119,
            "sick": 5,
            "healed_cumul": 15,
            "dead_cumul": 0,
            "confirmed": 4,
            "healed": 0,
            "dead": 0,
            "occupied_Beds": 0,
            "occupied_respirators": 2,
            "masks": 100,
            "occupied_foam_beds": 5,
            "occupied_resuscitation_beds": 0,
            "individual_protection_equipment": 120,
            "gel_hydro_alcoolique": 0,
            "resuscitation_ventilator": 0,
            "oxygenator": 0,
            "rapid_screening": 123,
            "automate_genexpert": 98,
            "x_ray": 0,
            "check_point": 1,
            "chloroquine": 0,
            "hydrochloroquine": 3310,
            "azytromicine": 520,
            "Vitamince_c": 5820,
            "last_update": "2020-08-26 00:00:00",
            "updated_manager_name": null,
            "created_manager_name": "DR KIBWANA"
        },
        {
            "id": 253,
            "confirmed_cumul": 119,
            "sick": 3,
            "healed_cumul": 15,
            "dead_cumul": 0,
            "confirmed": 3,
            "healed": 0,
            "dead": 0,
            "occupied_Beds": 0,
            "occupied_respirators": 0,
            "masks": 1100,
            "occupied_foam_beds": 3,
            "occupied_resuscitation_beds": 0,
            "individual_protection_equipment": 50,
            "gel_hydro_alcoolique": 0,
            "resuscitation_ventilator": 0,
            "oxygenator": 2,
            "rapid_screening": 1038,
            "automate_genexpert": 1,
            "x_ray": 0,
            "check_point": 1,
            "chloroquine": 0,
            "hydrochloroquine": 3360,
            "azytromicine": 550,
            "Vitamince_c": 5830,
            "last_update": "2020-08-14 00:00:00",
            "updated_manager_name": null,
            "created_manager_name": "Freddy kibwana"
        },
        {
            "id": 247,
            "confirmed_cumul": 119,
            "sick": 2,
            "healed_cumul": 15,
            "dead_cumul": 0,
            "confirmed": 2,
            "healed": 1,
            "dead": 0,
            "occupied_Beds": 0,
            "occupied_respirators": 0,
            "masks": 7,
            "occupied_foam_beds": 2,
            "occupied_resuscitation_beds": 0,
            "individual_protection_equipment": 23,
            "gel_hydro_alcoolique": 0,
            "resuscitation_ventilator": 0,
            "oxygenator": 2,
            "rapid_screening": 1048,
            "automate_genexpert": 1,
            "x_ray": 0,
            "check_point": 1,
            "chloroquine": 0,
            "hydrochloroquine": 3380,
            "azytromicine": 580,
            "Vitamince_c": 5870,
            "last_update": "2020-08-12 00:00:00",
            "updated_manager_name": null,
            "created_manager_name": "Freddy kibwana"
        },
        {
            "id": 239,
            "confirmed_cumul": 119,
            "sick": 3,
            "healed_cumul": 15,
            "dead_cumul": 0,
            "confirmed": 3,
            "healed": 0,
            "dead": 0,
            "occupied_Beds": 0,
            "occupied_respirators": 0,
            "masks": 8,
            "occupied_foam_beds": 3,
            "occupied_resuscitation_beds": 0,
            "individual_protection_equipment": 62,
            "gel_hydro_alcoolique": 0,
            "resuscitation_ventilator": 0,
            "oxygenator": 2,
            "rapid_screening": 1053,
            "automate_genexpert": 1,
            "x_ray": 0,
            "check_point": 1,
            "chloroquine": 0,
            "hydrochloroquine": 3380,
            "azytromicine": 590,
            "Vitamince_c": 5880,
            "last_update": "2020-08-10 00:00:00",
            "updated_manager_name": null,
            "created_manager_name": "Freddy kibwana"
        },
        {
            "id": 238,
            "confirmed_cumul": 119,
            "sick": 2,
            "healed_cumul": 15,
            "dead_cumul": 0,
            "confirmed": 2,
            "healed": 0,
            "dead": 0,
            "occupied_Beds": 0,
            "occupied_respirators": 0,
            "masks": 30,
            "occupied_foam_beds": 2,
            "occupied_resuscitation_beds": 0,
            "individual_protection_equipment": 80,
            "gel_hydro_alcoolique": null,
            "resuscitation_ventilator": 0,
            "oxygenator": 2,
            "rapid_screening": 1059,
            "automate_genexpert": 1,
            "x_ray": 0,
            "check_point": 1,
            "chloroquine": 0,
            "hydrochloroquine": 3400,
            "azytromicine": 600,
            "Vitamince_c": 5900,
            "last_update": "2020-08-09 00:00:00",
            "updated_manager_name": null,
            "created_manager_name": "Freddy kibwana"
        },
        {
            "id": 221,
            "confirmed_cumul": 119,
            "sick": 2,
            "healed_cumul": 15,
            "dead_cumul": 0,
            "confirmed": 2,
            "healed": 1,
            "dead": 0,
            "occupied_Beds": 0,
            "occupied_respirators": 0,
            "masks": 57,
            "occupied_foam_beds": 2,
            "occupied_resuscitation_beds": 0,
            "individual_protection_equipment": 95,
            "gel_hydro_alcoolique": 0,
            "resuscitation_ventilator": 0,
            "oxygenator": 2,
            "rapid_screening": 1060,
            "automate_genexpert": 1,
            "x_ray": 0,
            "check_point": 1,
            "chloroquine": 0,
            "hydrochloroquine": 3400,
            "azytromicine": 600,
            "Vitamince_c": 5900,
            "last_update": "2020-08-05 00:00:00",
            "updated_manager_name": null,
            "created_manager_name": "Freddy kibwana"
        },
        {
            "id": 208,
            "confirmed_cumul": 119,
            "sick": 3,
            "healed_cumul": 15,
            "dead_cumul": 0,
            "confirmed": 3,
            "healed": 0,
            "dead": 0,
            "occupied_Beds": 0,
            "occupied_respirators": 0,
            "masks": 80,
            "occupied_foam_beds": 3,
            "occupied_resuscitation_beds": 0,
            "individual_protection_equipment": 107,
            "gel_hydro_alcoolique": 0,
            "resuscitation_ventilator": 0,
            "oxygenator": 2,
            "rapid_screening": 1066,
            "automate_genexpert": 173,
            "x_ray": 0,
            "check_point": 1,
            "chloroquine": 0,
            "hydrochloroquine": 3400,
            "azytromicine": 600,
            "Vitamince_c": 5900,
            "last_update": "2020-08-04 00:00:00",
            "updated_manager_name": null,
            "created_manager_name": "Freddy kibwana"
        },
        {
            "id": 111,
            "confirmed_cumul": 119,
            "sick": 8,
            "healed_cumul": 15,
            "dead_cumul": 0,
            "confirmed": 8,
            "healed": 2,
            "dead": 0,
            "occupied_Beds": 0,
            "occupied_respirators": 0,
            "masks": 430,
            "occupied_foam_beds": 8,
            "occupied_resuscitation_beds": 0,
            "individual_protection_equipment": 21,
            "gel_hydro_alcoolique": 0,
            "resuscitation_ventilator": 0,
            "oxygenator": 2,
            "rapid_screening": 224,
            "automate_genexpert": 1,
            "x_ray": 1,
            "check_point": 1,
            "chloroquine": 0,
            "hydrochloroquine": 0,
            "azytromicine": 0,
            "Vitamince_c": 0,
            "last_update": "2020-07-16 00:00:00",
            "updated_manager_name": null,
            "created_manager_name": "Freddy kibwana"
        },
        {
            "id": 96,
            "confirmed_cumul": 119,
            "sick": 10,
            "healed_cumul": 15,
            "dead_cumul": 0,
            "confirmed": 10,
            "healed": 2,
            "dead": 0,
            "occupied_Beds": 0,
            "occupied_respirators": 0,
            "masks": 480,
            "occupied_foam_beds": 10,
            "occupied_resuscitation_beds": 0,
            "individual_protection_equipment": 22,
            "gel_hydro_alcoolique": 5,
            "resuscitation_ventilator": 0,
            "oxygenator": 2,
            "rapid_screening": 250,
            "automate_genexpert": 1,
            "x_ray": 1,
            "check_point": 1,
            "chloroquine": 0,
            "hydrochloroquine": 0,
            "azytromicine": 0,
            "Vitamince_c": 0,
            "last_update": "2020-07-15 00:00:00",
            "updated_manager_name": null,
            "created_manager_name": "Freddy kibwana"
        },
        {
            "id": 90,
            "confirmed_cumul": 119,
            "sick": 12,
            "healed_cumul": 15,
            "dead_cumul": 0,
            "confirmed": 34,
            "healed": 3,
            "dead": 0,
            "occupied_Beds": 0,
            "occupied_respirators": 0,
            "masks": 0,
            "occupied_foam_beds": 14,
            "occupied_resuscitation_beds": 0,
            "individual_protection_equipment": 0,
            "gel_hydro_alcoolique": 5,
            "resuscitation_ventilator": 0,
            "oxygenator": 2,
            "rapid_screening": 1002,
            "automate_genexpert": 1,
            "x_ray": 1,
            "check_point": 1,
            "chloroquine": 0,
            "hydrochloroquine": 0,
            "azytromicine": 0,
            "Vitamince_c": 0,
            "last_update": "2020-07-14 00:00:00",
            "updated_manager_name": null,
            "created_manager_name": "Freddy kibwana"
        },
        {
            "id": 89,
            "confirmed_cumul": 119,
            "sick": 12,
            "healed_cumul": 15,
            "dead_cumul": 0,
            "confirmed": 12,
            "healed": 0,
            "dead": 0,
            "occupied_Beds": 0,
            "occupied_respirators": 0,
            "masks": 0,
            "occupied_foam_beds": 14,
            "occupied_resuscitation_beds": 0,
            "individual_protection_equipment": 0,
            "gel_hydro_alcoolique": 5,
            "resuscitation_ventilator": 0,
            "oxygenator": 2,
            "rapid_screening": 1002,
            "automate_genexpert": 1,
            "x_ray": 1,
            "check_point": 1,
            "chloroquine": 0,
            "hydrochloroquine": 0,
            "azytromicine": 0,
            "Vitamince_c": 0,
            "last_update": "2020-07-14 00:00:00",
            "updated_manager_name": null,
            "created_manager_name": "Freddy kibwana"
        },
        {
            "id": 81,
            "confirmed_cumul": 119,
            "sick": 14,
            "healed_cumul": 15,
            "dead_cumul": 0,
            "confirmed": 11,
            "healed": 0,
            "dead": 0,
            "occupied_Beds": 0,
            "occupied_respirators": 0,
            "masks": 34,
            "occupied_foam_beds": 30,
            "occupied_resuscitation_beds": 0,
            "individual_protection_equipment": 30,
            "gel_hydro_alcoolique": 5,
            "resuscitation_ventilator": 0,
            "oxygenator": 2,
            "rapid_screening": 0,
            "automate_genexpert": 1,
            "x_ray": 0,
            "check_point": 1,
            "chloroquine": 0,
            "hydrochloroquine": 0,
            "azytromicine": 0,
            "Vitamince_c": 0,
            "last_update": "2020-07-13 00:00:00",
            "updated_manager_name": null,
            "created_manager_name": "Freddy kibwana"
        },
        {
            "id": 70,
            "confirmed_cumul": 119,
            "sick": 13,
            "healed_cumul": 15,
            "dead_cumul": 0,
            "confirmed": 11,
            "healed": 3,
            "dead": 0,
            "occupied_Beds": 0,
            "occupied_respirators": 0,
            "masks": 0,
            "occupied_foam_beds": 13,
            "occupied_resuscitation_beds": 0,
            "individual_protection_equipment": 0,
            "gel_hydro_alcoolique": 0,
            "resuscitation_ventilator": 0,
            "oxygenator": 2,
            "rapid_screening": 0,
            "automate_genexpert": 1,
            "x_ray": 1,
            "check_point": 1,
            "chloroquine": 0,
            "hydrochloroquine": 0,
            "azytromicine": 0,
            "Vitamince_c": 0,
            "last_update": "2020-07-11 00:00:00",
            "updated_manager_name": null,
            "created_manager_name": "Freddy kibwana"
        },
        {
            "id": 95,
            "confirmed_cumul": 119,
            "sick": 10,
            "healed_cumul": 15,
            "dead_cumul": 0,
            "confirmed": 10,
            "healed": 2,
            "dead": 0,
            "occupied_Beds": 0,
            "occupied_respirators": 0,
            "masks": 480,
            "occupied_foam_beds": 0,
            "occupied_resuscitation_beds": 0,
            "individual_protection_equipment": 22,
            "gel_hydro_alcoolique": 5,
            "resuscitation_ventilator": 0,
            "oxygenator": 2,
            "rapid_screening": 250,
            "automate_genexpert": 1,
            "x_ray": 1,
            "check_point": 1,
            "chloroquine": 0,
            "hydrochloroquine": 0,
            "azytromicine": 0,
            "Vitamince_c": 0,
            "last_update": "2020-07-08 00:00:00",
            "updated_manager_name": null,
            "created_manager_name": "Freddy kibwana"
        }
    ],
    "links": {
        "first": "http:\/\/localhost\/api\/dashboard\/hospital-situations\/by-hospital\/1?page=1",
        "last": "http:\/\/localhost\/api\/dashboard\/hospital-situations\/by-hospital\/1?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http:\/\/localhost\/api\/dashboard\/hospital-situations\/by-hospital\/1",
        "per_page": 15,
        "to": 15,
        "total": 15
    }
}
```

### HTTP Request
`GET api/dashboard/hospital-situations/by-hospital/{hospital_id}`


<!-- END_70750654f1ddb3eee06bcbacd62d9301 -->

<!-- START_f607cdd631b29975e82e7b3fce539609 -->
## api/dashboard/hospital-situations/agent-last-update
> Example request:


> Example response (200):

```json
[
    {
        "hospital_id": 6,
        "name": "VIJANA",
        "last_update": "2020-12-15 00:00:00",
        "confirmed": 320
    },
    {
        "hospital_id": 11,
        "name": "HASC",
        "last_update": "2020-10-12 00:00:00",
        "confirmed": 120
    },
    {
        "hospital_id": 10,
        "name": "KINKOLE",
        "last_update": "2020-10-08 00:00:00",
        "confirmed": 52
    },
    {
        "hospital_id": 4,
        "name": "SAINT JOSEPH",
        "last_update": "2020-10-08 00:00:00",
        "confirmed": 759
    },
    {
        "hospital_id": 3,
        "name": "MONKOLE",
        "last_update": "2020-09-11 00:00:00",
        "confirmed": 430
    },
    {
        "hospital_id": 7,
        "name": "ZONE DE SANTE STADE DE MARTYRS",
        "last_update": "2020-09-02 00:00:00",
        "confirmed": 754
    },
    {
        "hospital_id": 12,
        "name": "CMK",
        "last_update": "2020-09-02 00:00:00",
        "confirmed": 1
    },
    {
        "hospital_id": 5,
        "name": "CUK",
        "last_update": "2020-08-28 00:00:00",
        "confirmed": 60
    },
    {
        "hospital_id": 1,
        "name": "NGALIEMA",
        "last_update": "2020-08-28 00:00:00",
        "confirmed": 119
    },
    {
        "hospital_id": 2,
        "name": "DIAMANT",
        "last_update": "2020-08-28 00:00:00",
        "confirmed": 8
    }
]
```

### HTTP Request
`GET api/dashboard/hospital-situations/agent-last-update`


<!-- END_f607cdd631b29975e82e7b3fce539609 -->

<!-- START_ce9a88f8d8c1d0ee8eb8fd59910bb7cd -->
## api/dashboard/health-zones
> Example request:


> Example response (200):

```json
[
    {
        "zone": "Kintambo",
        "province": "Kinshasa"
    },
    {
        "zone": "Bena Tshiadi",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Ndjili",
        "province": "Kinshasa"
    },
    {
        "zone": "Mutena",
        "province": "Kasaï"
    },
    {
        "zone": "Boto",
        "province": "Sud-Ubangi"
    },
    {
        "zone": "Masuika",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Ndesha",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Mulumba",
        "province": "Lomami"
    },
    {
        "zone": "Mubumbano",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Penjwa",
        "province": "Maï-Ndombe"
    },
    {
        "zone": "Nsele",
        "province": "Kinshasa"
    },
    {
        "zone": "Binza",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Popokabaka",
        "province": "Kwango"
    },
    {
        "zone": "Panzi",
        "province": "Kwango"
    },
    {
        "zone": "Lemera",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Alimbongo",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Pangi",
        "province": "Maniema"
    },
    {
        "zone": "Mont-Ngafula I",
        "province": "Kinshasa"
    },
    {
        "zone": "Vangu",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Maluku II",
        "province": "Kinshasa"
    },
    {
        "zone": "Monga",
        "province": "Bas-Uele"
    },
    {
        "zone": "Bomongo",
        "province": "Equateur"
    },
    {
        "zone": "Diulu",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Laybo",
        "province": "Ituri"
    },
    {
        "zone": "Nia-Nia",
        "province": "Ituri"
    },
    {
        "zone": "Manono",
        "province": "Tanganyika"
    },
    {
        "zone": "Makiso-Kisangani",
        "province": "Tshopo"
    },
    {
        "zone": "Demba",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Luozi",
        "province": "Kongo-Central"
    },
    {
        "zone": "Kalole",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Kabinda",
        "province": "Lomami"
    },
    {
        "zone": "Biringi",
        "province": "Ituri"
    },
    {
        "zone": "N'djili",
        "province": "Kinshasa"
    },
    {
        "zone": "Ruzizi",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Kongolo",
        "province": "Tanganyika"
    },
    {
        "zone": "Bokungu",
        "province": "Tshuapa"
    },
    {
        "zone": "Saramabila",
        "province": "Maniema"
    },
    {
        "zone": "Kajiji",
        "province": "Kwango"
    },
    {
        "zone": "Binza Ozone",
        "province": "Kinshasa"
    },
    {
        "zone": "Lisala",
        "province": "Mongala"
    },
    {
        "zone": "Mitwaba",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Mwenga",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Bolenge",
        "province": "Equateur"
    },
    {
        "zone": "Lubero",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Bikoro",
        "province": "Equateur"
    },
    {
        "zone": "Yasa-Bonga",
        "province": "Kwilu"
    },
    {
        "zone": "Kansele",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Tshilenge",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Wangata",
        "province": "Equateur"
    },
    {
        "zone": "Isangi",
        "province": "Tshopo"
    },
    {
        "zone": "Drodro",
        "province": "Ituri"
    },
    {
        "zone": "Walikale",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Malemba Nkulu",
        "province": "Haut-Lomami"
    },
    {
        "zone": "Lubumbashi",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Bongandanga",
        "province": "Mongala"
    },
    {
        "zone": "Wapinda",
        "province": "Nord-Ubangi"
    },
    {
        "zone": "Bwamanda",
        "province": "Sud-Ubangi"
    },
    {
        "zone": "Bonzola",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Rwashi",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Mbaya",
        "province": "Sud-Ubangi"
    },
    {
        "zone": "Nyemba",
        "province": "Tanganyika"
    },
    {
        "zone": "Niangara",
        "province": "Haut-Uele"
    },
    {
        "zone": "Tshishimbi",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Katuba",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Ango",
        "province": "Bas-Uele"
    },
    {
        "zone": "Luputa",
        "province": "Lomami"
    },
    {
        "zone": "Kafakumba",
        "province": "Lualaba"
    },
    {
        "zone": "Seke-Banza",
        "province": "Kongo-Central"
    },
    {
        "zone": "Dekese",
        "province": "Kasaï"
    },
    {
        "zone": "Lukelenge",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Mukedi",
        "province": "Kwilu"
    },
    {
        "zone": "Kanzenze",
        "province": "Lualaba"
    },
    {
        "zone": "Mangembo",
        "province": "Kongo-Central"
    },
    {
        "zone": "Gombari",
        "province": "Haut-Uele"
    },
    {
        "zone": "Kabondo Dianda",
        "province": "Haut-Lomami"
    },
    {
        "zone": "Binga",
        "province": "Mongala"
    },
    {
        "zone": "Rimba",
        "province": "Ituri"
    },
    {
        "zone": "Kilwa",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Kikwit-Sud",
        "province": "Kwilu"
    },
    {
        "zone": "Kamiji",
        "province": "Lomami"
    },
    {
        "zone": "Inga",
        "province": "Kongo-Central"
    },
    {
        "zone": "Boende",
        "province": "Tshuapa"
    },
    {
        "zone": "Moanza",
        "province": "Kwilu"
    },
    {
        "zone": "Bibanga",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Birambizo",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Mangobo",
        "province": "Tshopo"
    },
    {
        "zone": "Bilomba",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Bili",
        "province": "Bas-Uele"
    },
    {
        "zone": "Tchomia",
        "province": "Ituri"
    },
    {
        "zone": "Bonga Yasa",
        "province": "Kwilu"
    },
    {
        "zone": "Kungu",
        "province": "Sud-Ubangi"
    },
    {
        "zone": "Befale",
        "province": "Tshuapa"
    },
    {
        "zone": "Kasansa",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Wamba",
        "province": "Haut-Uele"
    },
    {
        "zone": "Kakenge",
        "province": "Kasaï"
    },
    {
        "zone": "Kasa-vubu",
        "province": "Kinshasa"
    },
    {
        "zone": "Kisanji",
        "province": "Kwango"
    },
    {
        "zone": "Rwampara",
        "province": "Ituri"
    },
    {
        "zone": "Inongo",
        "province": "Maï-Ndombe"
    },
    {
        "zone": "Lubondaie",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Kinkonzi",
        "province": "Kongo-Central"
    },
    {
        "zone": "Vanga Kete",
        "province": "Sankuru"
    },
    {
        "zone": "Mvuzi",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Ikela",
        "province": "Tshuapa"
    },
    {
        "zone": "Lubudi",
        "province": "Lualaba"
    },
    {
        "zone": "Bumba",
        "province": "Mongala"
    },
    {
        "zone": "Kuimba",
        "province": "Kongo-Central"
    },
    {
        "zone": "Mimia",
        "province": "Maï-Ndombe"
    },
    {
        "zone": "Kitenge",
        "province": "Haut-Lomami"
    },
    {
        "zone": "Gbadolite",
        "province": "Nord-Ubangi"
    },
    {
        "zone": "Pinga",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Djolu",
        "province": "Tshuapa"
    },
    {
        "zone": "Bagata",
        "province": "Kwilu"
    },
    {
        "zone": "Barumbu",
        "province": "Kinshasa"
    },
    {
        "zone": "Banjow Moke",
        "province": "Maï-Ndombe"
    },
    {
        "zone": "Katoka",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Mutuanga",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Matadi",
        "province": "Kongo-Central"
    },
    {
        "zone": "Lwamba",
        "province": "Haut-Lomami"
    },
    {
        "zone": "Ntandembelo",
        "province": "Maï-Ndombe"
    },
    {
        "zone": "Banga Lubaka",
        "province": "Kasaï"
    },
    {
        "zone": "Kabondo",
        "province": "Tshopo"
    },
    {
        "zone": "Luiza",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Mulongo",
        "province": "Haut-Lomami"
    },
    {
        "zone": "Kalonda Ouest",
        "province": "Kasaï"
    },
    {
        "zone": "Nioki",
        "province": "Maï-Ndombe"
    },
    {
        "zone": "Lubutu",
        "province": "Maniema"
    },
    {
        "zone": "Pay Kongila",
        "province": "Kwilu"
    },
    {
        "zone": "Bengamisa",
        "province": "Tshopo"
    },
    {
        "zone": "Boma-Mangbetu",
        "province": "Haut-Uele"
    },
    {
        "zone": "Bambu",
        "province": "Ituri"
    },
    {
        "zone": "Kaziba",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Mobayi Mbongo",
        "province": "Nord-Ubangi"
    },
    {
        "zone": "Kwilu Ngongo",
        "province": "Kongo-Central"
    },
    {
        "zone": "Mosango",
        "province": "Kwilu"
    },
    {
        "zone": "Rwanguba",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Mabalako",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Wembo Nyama",
        "province": "Sankuru"
    },
    {
        "zone": "Kanzala",
        "province": "Kasaï"
    },
    {
        "zone": "Bafwagbogbo",
        "province": "Tshopo"
    },
    {
        "zone": "Kashobwe",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Mushenge",
        "province": "Kasaï"
    },
    {
        "zone": "Basoko",
        "province": "Tshopo"
    },
    {
        "zone": "Kangu",
        "province": "Kongo-Central"
    },
    {
        "zone": "Mangala",
        "province": "Ituri"
    },
    {
        "zone": "N'sele",
        "province": "Kinshasa"
    },
    {
        "zone": "Libenge",
        "province": "Sud-Ubangi"
    },
    {
        "zone": "Opienge",
        "province": "Tshopo"
    },
    {
        "zone": "Yalimbongo",
        "province": "Tshopo"
    },
    {
        "zone": "Kalima",
        "province": "Maniema"
    },
    {
        "zone": "Kapolowe",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Pweto",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Lomela",
        "province": "Sankuru"
    },
    {
        "zone": "Kasindi",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Lolo",
        "province": "Mongala"
    },
    {
        "zone": "Lusambo",
        "province": "Sankuru"
    },
    {
        "zone": "Kitangwa",
        "province": "Kasaï"
    },
    {
        "zone": "Boko-Kivulu",
        "province": "Kongo-Central"
    },
    {
        "zone": "Omendjadi",
        "province": "Sankuru"
    },
    {
        "zone": "Bolobo",
        "province": "Maï-Ndombe"
    },
    {
        "zone": "Gungu",
        "province": "Kwilu"
    },
    {
        "zone": "Wema",
        "province": "Tshuapa"
    },
    {
        "zone": "Yaleko",
        "province": "Tshopo"
    },
    {
        "zone": "Bandalungwa",
        "province": "Kinshasa"
    },
    {
        "zone": "Lita",
        "province": "Ituri"
    },
    {
        "zone": "Kibirizi",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Kabalo",
        "province": "Tanganyika"
    },
    {
        "zone": "Moba",
        "province": "Tanganyika"
    },
    {
        "zone": "Ludimbi Lukula",
        "province": "Lomami"
    },
    {
        "zone": "Budjala",
        "province": "Sud-Ubangi"
    },
    {
        "zone": "Kingandu",
        "province": "Kwilu"
    },
    {
        "zone": "Kindu",
        "province": "Maniema"
    },
    {
        "zone": "Tshopo",
        "province": "Tshopo"
    },
    {
        "zone": "Kyondo",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Basali",
        "province": "Tshopo"
    },
    {
        "zone": "Butembo",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Masereka",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Kabare",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Bunia",
        "province": "Ituri"
    },
    {
        "zone": "Luambo",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Bobozo",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Sia",
        "province": "Kwilu"
    },
    {
        "zone": "Zongo",
        "province": "Sud-Ubangi"
    },
    {
        "zone": "Ubundu",
        "province": "Tshopo"
    },
    {
        "zone": "Lukafu",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Bokonzi",
        "province": "Sud-Ubangi"
    },
    {
        "zone": "Mbandaka",
        "province": "Equateur"
    },
    {
        "zone": "Koshibanda",
        "province": "Kwilu"
    },
    {
        "zone": "Tunda",
        "province": "Maniema"
    },
    {
        "zone": "Wanierukula",
        "province": "Tshopo"
    },
    {
        "zone": "Tshitenge",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Kalehe",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Ferekeni",
        "province": "Maniema"
    },
    {
        "zone": "Baka",
        "province": "Haut-Lomami"
    },
    {
        "zone": "Kambove",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Kisenso",
        "province": "Kinshasa"
    },
    {
        "zone": "Wikong",
        "province": "Lomami"
    },
    {
        "zone": "Gemena",
        "province": "Sud-Ubangi"
    },
    {
        "zone": "Aru",
        "province": "Ituri"
    },
    {
        "zone": "Doruma",
        "province": "Haut-Uele"
    },
    {
        "zone": "Hauts-Plateaux",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Kalamba",
        "province": "Lualaba"
    },
    {
        "zone": "Lowa",
        "province": "Tshopo"
    },
    {
        "zone": "Kisanga",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Katoyi",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Ototo",
        "province": "Sankuru"
    },
    {
        "zone": "Kingasani",
        "province": "Kinshasa"
    },
    {
        "zone": "Boga",
        "province": "Ituri"
    },
    {
        "zone": "Bunkonde",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Lingomo",
        "province": "Tshuapa"
    },
    {
        "zone": "Ngandajika",
        "province": "Lomami"
    },
    {
        "zone": "Basankusu",
        "province": "Equateur"
    },
    {
        "zone": "Musienene",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Kasaji",
        "province": "Lualaba"
    },
    {
        "zone": "Lodja",
        "province": "Sankuru"
    },
    {
        "zone": "Kamalondo",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Nyanga",
        "province": "Kasaï"
    },
    {
        "zone": "Loko",
        "province": "Nord-Ubangi"
    },
    {
        "zone": "Butumba",
        "province": "Haut-Lomami"
    },
    {
        "zone": "Boko Kivula",
        "province": "Kongo-Central"
    },
    {
        "zone": "Kenge",
        "province": "Kwango"
    },
    {
        "zone": "Masina II",
        "province": "Kinshasa"
    },
    {
        "zone": "Bena Dibele",
        "province": "Sankuru"
    },
    {
        "zone": "Banalia",
        "province": "Tshopo"
    },
    {
        "zone": "Dikungu",
        "province": "Sankuru"
    },
    {
        "zone": "Iboko",
        "province": "Equateur"
    },
    {
        "zone": "Minembwe",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Lubunga",
        "province": "Tshopo"
    },
    {
        "zone": "Kaniama",
        "province": "Haut-Lomami"
    },
    {
        "zone": "Kitutu",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Kirotshe",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Kipushi",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Mufunga Sampwe",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Ngidinga",
        "province": "Kongo-Central"
    },
    {
        "zone": "Kowe",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Kimpese",
        "province": "Kongo-Central"
    },
    {
        "zone": "Samba",
        "province": "Maniema"
    },
    {
        "zone": "Kikwit-Nord",
        "province": "Kwilu"
    },
    {
        "zone": "Miti Murhesa",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Bagira",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Yahuma",
        "province": "Tshopo"
    },
    {
        "zone": "Irebu",
        "province": "Equateur"
    },
    {
        "zone": "Yakusu",
        "province": "Tshopo"
    },
    {
        "zone": "Mokala",
        "province": "Kwilu"
    },
    {
        "zone": "Gombe",
        "province": "Kinshasa"
    },
    {
        "zone": "Kwilu-Ngongo",
        "province": "Kongo-Central"
    },
    {
        "zone": "Tshofa",
        "province": "Lomami"
    },
    {
        "zone": "Dibaya",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Mulungu",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Mahagi",
        "province": "Ituri"
    },
    {
        "zone": "Kimvula",
        "province": "Kongo-Central"
    },
    {
        "zone": "Fungurume",
        "province": "Lualaba"
    },
    {
        "zone": "Bominenge",
        "province": "Sud-Ubangi"
    },
    {
        "zone": "Tshudi Loto",
        "province": "Sankuru"
    },
    {
        "zone": "Lubilanji",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Kikula",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Nzanza",
        "province": "Kongo-Central"
    },
    {
        "zone": "Songa",
        "province": "Haut-Lomami"
    },
    {
        "zone": "Mikope",
        "province": "Kasaï"
    },
    {
        "zone": "Kampemba",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Nundu",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Yamaluka",
        "province": "Mongala"
    },
    {
        "zone": "Alunguli",
        "province": "Maniema"
    },
    {
        "zone": "Ganga",
        "province": "Bas-Uele"
    },
    {
        "zone": "Oshwe",
        "province": "Maï-Ndombe"
    },
    {
        "zone": "Matete",
        "province": "Kinshasa"
    },
    {
        "zone": "Kalambayi Kabanga",
        "province": "Lomami"
    },
    {
        "zone": "Yamongili",
        "province": "Mongala"
    },
    {
        "zone": "Mweka",
        "province": "Kasaï"
    },
    {
        "zone": "Kunda",
        "province": "Maniema"
    },
    {
        "zone": "Lulingu",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Itebero",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Mambasa",
        "province": "Ituri"
    },
    {
        "zone": "Idjwi",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Viadana",
        "province": "Bas-Uele"
    },
    {
        "zone": "Lingwala",
        "province": "Kinshasa"
    },
    {
        "zone": "Mikalayi",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Kikongo",
        "province": "Kwilu"
    },
    {
        "zone": "Kalomba",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Sandoa",
        "province": "Lualaba"
    },
    {
        "zone": "Dilolo",
        "province": "Lualaba"
    },
    {
        "zone": "Logo",
        "province": "Ituri"
    },
    {
        "zone": "Nsona-Mpangu",
        "province": "Kongo-Central"
    },
    {
        "zone": "Boko",
        "province": "Kwango"
    },
    {
        "zone": "Mwela Lembwa",
        "province": "Kwango"
    },
    {
        "zone": "Manika",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Kimbanseke",
        "province": "Kinshasa"
    },
    {
        "zone": "Bokoro",
        "province": "Maï-Ndombe"
    },
    {
        "zone": "Kinda",
        "province": "Haut-Lomami"
    },
    {
        "zone": "Kole",
        "province": "Sankuru"
    },
    {
        "zone": "Tshikula",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Mutshatsha",
        "province": "Lualaba"
    },
    {
        "zone": "Abuzi",
        "province": "Nord-Ubangi"
    },
    {
        "zone": "Komanda",
        "province": "Ituri"
    },
    {
        "zone": "Kabeya Kamuanga",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Masisi",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Opala",
        "province": "Tshopo"
    },
    {
        "zone": "Buta",
        "province": "Bas-Uele"
    },
    {
        "zone": "Mongbalu",
        "province": "Ituri"
    },
    {
        "zone": "Himbi",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Obokote",
        "province": "Maniema"
    },
    {
        "zone": "Vuhovi",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Uvira",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Minga",
        "province": "Sankuru"
    },
    {
        "zone": "Tshibala",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Oicha",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Kamana",
        "province": "Lomami"
    },
    {
        "zone": "Shabunda",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Katende",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Bulape",
        "province": "Kasaï"
    },
    {
        "zone": "Yalifafo",
        "province": "Tshuapa"
    },
    {
        "zone": "Makoro",
        "province": "Haut-Uele"
    },
    {
        "zone": "Bipemba",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Sonabata",
        "province": "Kongo-Central"
    },
    {
        "zone": "Kanda Kanda",
        "province": "Lomami"
    },
    {
        "zone": "Titule",
        "province": "Bas-Uele"
    },
    {
        "zone": "Ipamu",
        "province": "Kwilu"
    },
    {
        "zone": "Tshamilemba",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Tshikaji",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Lukala",
        "province": "Kongo-Central"
    },
    {
        "zone": "Kiyambi",
        "province": "Tanganyika"
    },
    {
        "zone": "Nyarambe",
        "province": "Ituri"
    },
    {
        "zone": "Binza Méteo",
        "province": "Kinshasa"
    },
    {
        "zone": "Mumbunda",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Fizi",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Mbanza-Ngungu",
        "province": "Kongo-Central"
    },
    {
        "zone": "Aungba",
        "province": "Ituri"
    },
    {
        "zone": "Kamwesha",
        "province": "Kasaï"
    },
    {
        "zone": "Gethy",
        "province": "Ituri"
    },
    {
        "zone": "Nyangezi",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Kalamu I",
        "province": "Kinshasa"
    },
    {
        "zone": "Kokolo",
        "province": "Kinshasa"
    },
    {
        "zone": "Nyiragongo",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Muya",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Kabambare",
        "province": "Maniema"
    },
    {
        "zone": "Jiba",
        "province": "Ituri"
    },
    {
        "zone": "Nselo",
        "province": "Kongo-Central"
    },
    {
        "zone": "Kabongo",
        "province": "Haut-Lomami"
    },
    {
        "zone": "Fataki",
        "province": "Ituri"
    },
    {
        "zone": "Tshikapa",
        "province": "Kasaï"
    },
    {
        "zone": "Kasenga",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Gombe-Matadi",
        "province": "Kongo-Central"
    },
    {
        "zone": "Idiofa",
        "province": "Kwilu"
    },
    {
        "zone": "Ndjoko-Mpunda",
        "province": "Kasaï"
    },
    {
        "zone": "Kitona",
        "province": "Kongo-Central"
    },
    {
        "zone": "Kalonda Est",
        "province": "Lomami"
    },
    {
        "zone": "Faradje",
        "province": "Haut-Uele"
    },
    {
        "zone": "Kansimba",
        "province": "Tanganyika"
    },
    {
        "zone": "Muanda",
        "province": "Kongo-Central"
    },
    {
        "zone": "Dibindi",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Aketi",
        "province": "Bas-Uele"
    },
    {
        "zone": "Kiri",
        "province": "Maï-Ndombe"
    },
    {
        "zone": "Yabaondo",
        "province": "Tshopo"
    },
    {
        "zone": "Djalo Djeka",
        "province": "Sankuru"
    },
    {
        "zone": "Limete",
        "province": "Kinshasa"
    },
    {
        "zone": "Lusanga",
        "province": "Kwilu"
    },
    {
        "zone": "Aba",
        "province": "Haut-Uele"
    },
    {
        "zone": "Mwana",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Mukumbi",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Punia",
        "province": "Maniema"
    },
    {
        "zone": "Selembao",
        "province": "Kinshasa"
    },
    {
        "zone": "Kapanga",
        "province": "Lualaba"
    },
    {
        "zone": "Makala",
        "province": "Kinshasa"
    },
    {
        "zone": "Kapemba",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Adja",
        "province": "Ituri"
    },
    {
        "zone": "Mweso",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Kampene",
        "province": "Maniema"
    },
    {
        "zone": "Bunkeya",
        "province": "Lualaba"
    },
    {
        "zone": "Djombo",
        "province": "Equateur"
    },
    {
        "zone": "Kamina",
        "province": "Haut-Lomami"
    },
    {
        "zone": "Lolwa",
        "province": "Ituri"
    },
    {
        "zone": "Mont-Ngafula II",
        "province": "Kinshasa"
    },
    {
        "zone": "Bukama",
        "province": "Haut-Lomami"
    },
    {
        "zone": "Lukolela",
        "province": "Equateur"
    },
    {
        "zone": "Sakania",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Masi-Manimba",
        "province": "Kwilu"
    },
    {
        "zone": "Masina I",
        "province": "Kinshasa"
    },
    {
        "zone": "Kinshasa",
        "province": "Kinshasa"
    },
    {
        "zone": "Katako Kombe",
        "province": "Sankuru"
    },
    {
        "zone": "Kamituga",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Tembo",
        "province": "Kwango"
    },
    {
        "zone": "Vanga",
        "province": "Kwilu"
    },
    {
        "zone": "Biyela",
        "province": "Kinshasa"
    },
    {
        "zone": "Ntondo",
        "province": "Equateur"
    },
    {
        "zone": "Kilo",
        "province": "Ituri"
    },
    {
        "zone": "Angumu",
        "province": "Ituri"
    },
    {
        "zone": "Yambuku",
        "province": "Mongala"
    },
    {
        "zone": "Likati",
        "province": "Bas-Uele"
    },
    {
        "zone": "Tshela",
        "province": "Kongo-Central"
    },
    {
        "zone": "Bolomba",
        "province": "Equateur"
    },
    {
        "zone": "Businga",
        "province": "Nord-Ubangi"
    },
    {
        "zone": "Kinkondja",
        "province": "Haut-Lomami"
    },
    {
        "zone": "Bulungu",
        "province": "Kwilu"
    },
    {
        "zone": "Nyatende",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Kenya",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Kibombo",
        "province": "Maniema"
    },
    {
        "zone": "Mbanza Ngungu",
        "province": "Kongo-Central"
    },
    {
        "zone": "Lilanga Bobangi",
        "province": "Equateur"
    },
    {
        "zone": "Boso Manzi",
        "province": "Mongala"
    },
    {
        "zone": "Isiro",
        "province": "Haut-Uele"
    },
    {
        "zone": "Malemba",
        "province": "Haut-Lomami"
    },
    {
        "zone": "Bunyakiri",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Kibunzi",
        "province": "Kongo-Central"
    },
    {
        "zone": "Bosondjo",
        "province": "Mongala"
    },
    {
        "zone": "Mandima",
        "province": "Ituri"
    },
    {
        "zone": "Kilela Balanda",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Yumbi",
        "province": "Maï-Ndombe"
    },
    {
        "zone": "Mutwanga",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Bosanga",
        "province": "Tshuapa"
    },
    {
        "zone": "Goma",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Ilebo",
        "province": "Kasaï"
    },
    {
        "zone": "Makota",
        "province": "Lomami"
    },
    {
        "zone": "Dungu",
        "province": "Haut-Uele"
    },
    {
        "zone": "Damas",
        "province": "Ituri"
    },
    {
        "zone": "Wamba Lwadi",
        "province": "Kwango"
    },
    {
        "zone": "Pimu",
        "province": "Mongala"
    },
    {
        "zone": "Djuma",
        "province": "Kwilu"
    },
    {
        "zone": "Boma Bungu",
        "province": "Kongo-Central"
    },
    {
        "zone": "Bogosenubia",
        "province": "Sud-Ubangi"
    },
    {
        "zone": "Minova",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Kaniola",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Bosobolo",
        "province": "Nord-Ubangi"
    },
    {
        "zone": "Kasongo",
        "province": "Maniema"
    },
    {
        "zone": "Nizi",
        "province": "Ituri"
    },
    {
        "zone": "Kimputu",
        "province": "Kwilu"
    },
    {
        "zone": "Mompono",
        "province": "Tshuapa"
    },
    {
        "zone": "Kibua",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Ariwara",
        "province": "Ituri"
    },
    {
        "zone": "Sona-Bata",
        "province": "Kongo-Central"
    },
    {
        "zone": "Sekebanza",
        "province": "Kongo-Central"
    },
    {
        "zone": "Bandundu",
        "province": "Kwilu"
    },
    {
        "zone": "Karisimbi",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Adi",
        "province": "Ituri"
    },
    {
        "zone": "Kafubu",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Kalonge",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Kambala",
        "province": "Ituri"
    },
    {
        "zone": "Bafwasende",
        "province": "Tshopo"
    },
    {
        "zone": "Nyakunde",
        "province": "Ituri"
    },
    {
        "zone": "Masa",
        "province": "Kongo-Central"
    },
    {
        "zone": "Feshi",
        "province": "Kwango"
    },
    {
        "zone": "Muetshi",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Kalenda",
        "province": "Lomami"
    },
    {
        "zone": "Mpokolo",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Kalamu II",
        "province": "Kinshasa"
    },
    {
        "zone": "Lusangi",
        "province": "Maniema"
    },
    {
        "zone": "Ndage",
        "province": "Sud-Ubangi"
    },
    {
        "zone": "Miabi",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Kalemie",
        "province": "Tanganyika"
    },
    {
        "zone": "Mungindu",
        "province": "Kwilu"
    },
    {
        "zone": "Mutoto",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Kamango",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Biena",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Mondombe",
        "province": "Tshuapa"
    },
    {
        "zone": "Miti-Murhesa",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Katwa",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Watsa",
        "province": "Haut-Uele"
    },
    {
        "zone": "Boso Mondanda",
        "province": "Mongala"
    },
    {
        "zone": "Ingende",
        "province": "Equateur"
    },
    {
        "zone": "Kamonia",
        "province": "Kasaï"
    },
    {
        "zone": "Pawa",
        "province": "Haut-Uele"
    },
    {
        "zone": "Rungu",
        "province": "Haut-Uele"
    },
    {
        "zone": "Lubao",
        "province": "Lomami"
    },
    {
        "zone": "Bangabola",
        "province": "Sud-Ubangi"
    },
    {
        "zone": "Linga",
        "province": "Ituri"
    },
    {
        "zone": "Yakoma",
        "province": "Nord-Ubangi"
    },
    {
        "zone": "Bena Leka",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Bulu",
        "province": "Sud-Ubangi"
    },
    {
        "zone": "Panda",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Ngaba",
        "province": "Kinshasa"
    },
    {
        "zone": "Kayamba",
        "province": "Haut-Lomami"
    },
    {
        "zone": "Lotumbe",
        "province": "Equateur"
    },
    {
        "zone": "Nzaba",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Kisantu",
        "province": "Kongo-Central"
    },
    {
        "zone": "Nyunzu",
        "province": "Tanganyika"
    },
    {
        "zone": "Rethy",
        "province": "Ituri"
    },
    {
        "zone": "Boma",
        "province": "Kongo-Central"
    },
    {
        "zone": "Bumbu",
        "province": "Kinshasa"
    },
    {
        "zone": "Kasumbalesa",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Dilala",
        "province": "Lualaba"
    },
    {
        "zone": "Pania Mutombo",
        "province": "Sankuru"
    },
    {
        "zone": "Mukanga",
        "province": "Haut-Lomami"
    },
    {
        "zone": "Walungu",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Kingabwa",
        "province": "Kinshasa"
    },
    {
        "zone": "Mwene Ditu",
        "province": "Lomami"
    },
    {
        "zone": "Ibanda",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Kananga",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Ngiri-Ngiri",
        "province": "Kinshasa"
    },
    {
        "zone": "Makanza",
        "province": "Equateur"
    },
    {
        "zone": "Kayna",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Mbulula",
        "province": "Tanganyika"
    },
    {
        "zone": "Lualaba",
        "province": "Lualaba"
    },
    {
        "zone": "Rutshuru",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Kimbau",
        "province": "Kwango"
    },
    {
        "zone": "Lolanga Mampoko",
        "province": "Equateur"
    },
    {
        "zone": "Yangala",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Bambo",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Nyantende",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Kimpangu",
        "province": "Kongo-Central"
    },
    {
        "zone": "Kimbi Lulenge",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Katana",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Wasolo",
        "province": "Nord-Ubangi"
    },
    {
        "zone": "Kikimi",
        "province": "Kinshasa"
    },
    {
        "zone": "Karawa",
        "province": "Nord-Ubangi"
    },
    {
        "zone": "Poko",
        "province": "Bas-Uele"
    },
    {
        "zone": "Lukula",
        "province": "Kongo-Central"
    },
    {
        "zone": "Manguredjipa",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Bondo",
        "province": "Bas-Uele"
    },
    {
        "zone": "Bukavu",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Tshumbe",
        "province": "Sankuru"
    },
    {
        "zone": "Kasongo Lunda",
        "province": "Kwango"
    },
    {
        "zone": "Lukonga",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Itombwe",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Maluku I",
        "province": "Kinshasa"
    },
    {
        "zone": "Vaku",
        "province": "Kongo-Central"
    },
    {
        "zone": "Kwamouth",
        "province": "Maï-Ndombe"
    },
    {
        "zone": "Monieka",
        "province": "Equateur"
    },
    {
        "zone": "Monkoto",
        "province": "Tshuapa"
    },
    {
        "zone": "Mushie",
        "province": "Maï-Ndombe"
    },
    {
        "zone": "Ankoro",
        "province": "Tanganyika"
    },
    {
        "zone": "Kalunguta",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Luebo",
        "province": "Kasaï"
    },
    {
        "zone": "Mawuya",
        "province": "Sud-Ubangi"
    },
    {
        "zone": "Beni",
        "province": "Nord-Kivu"
    },
    {
        "zone": "Kahemba",
        "province": "Kwango"
    },
    {
        "zone": "Police",
        "province": "Kinshasa"
    },
    {
        "zone": "Makiso",
        "province": "Bas-Uele"
    },
    {
        "zone": "Kizu",
        "province": "Kongo-Central"
    },
    {
        "zone": "Likasi",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Bosobe",
        "province": "Maï-Ndombe"
    },
    {
        "zone": "Cilundu",
        "province": "Kasaï-Oriental"
    },
    {
        "zone": "Kailo",
        "province": "Maniema"
    },
    {
        "zone": "Lemba",
        "province": "Kinshasa"
    },
    {
        "zone": "Tandala",
        "province": "Sud-Ubangi"
    },
    {
        "zone": "Kadutu",
        "province": "Sud-Kivu"
    },
    {
        "zone": "Yahisuli",
        "province": "Tshopo"
    },
    {
        "zone": "Ndekesha",
        "province": "Kasaï-Central"
    },
    {
        "zone": "Mambunda",
        "province": "Haut-Katanga"
    },
    {
        "zone": "Kitenda",
        "province": "Kwango"
    },
    {
        "zone": "Moanda",
        "province": "Kongo-Central"
    }
]
```

### HTTP Request
`GET api/dashboard/health-zones`


<!-- END_ce9a88f8d8c1d0ee8eb8fd59910bb7cd -->

<!-- START_ca595fbc25ffe036df8883e27f96ca70 -->
## Display a listing of the resource.

> Example request:


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/dashboard/hospital-situations`


<!-- END_ca595fbc25ffe036df8883e27f96ca70 -->

<!-- START_957f11ff0b3df14a2d886ac1fdcd08a9 -->
## Store a newly created resource in storage.

> Example request:



### HTTP Request
`POST api/dashboard/hospital-situations`


<!-- END_957f11ff0b3df14a2d886ac1fdcd08a9 -->

<!-- START_33e8bd496ef56f16f170f43ed1dc11c0 -->
## Display the specified resource.

> Example request:


> Example response (404):

```json
{
    "message": "No query results for model [App\\HospitalSituation] 1"
}
```

### HTTP Request
`GET api/dashboard/hospital-situations/{hospital_situation}`


<!-- END_33e8bd496ef56f16f170f43ed1dc11c0 -->

<!-- START_dcf7600e95986882b6e59636642971ba -->
## Update the specified resource in storage.

> Example request:



### HTTP Request
`PUT api/dashboard/hospital-situations/{hospital_situation}`

`PATCH api/dashboard/hospital-situations/{hospital_situation}`


<!-- END_dcf7600e95986882b6e59636642971ba -->

<!-- START_0b970c309ab0229e808aa38a74fc84a8 -->
## Remove the specified resource from storage.

> Example request:



### HTTP Request
`DELETE api/dashboard/hospital-situations/{hospital_situation}`


<!-- END_0b970c309ab0229e808aa38a74fc84a8 -->

<!-- START_de8cce562755cf4fdcc198710d40a5a8 -->
## Display a listing of the resource.

> Example request:



### HTTP Request
`GET api/dashboard/hospitals-data`


<!-- END_de8cce562755cf4fdcc198710d40a5a8 -->

<!-- START_645864c0263b5836f5893134dacdd87d -->
## Store a newly created resource in storage.

> Example request:



### HTTP Request
`POST api/dashboard/hospitals-data`


<!-- END_645864c0263b5836f5893134dacdd87d -->

<!-- START_403a4862a31e5e5a6cdbfbea275340a7 -->
## Display the specified resource.

> Example request:


> Example response (200):

```json
{
    "id": 1,
    "created_at": null,
    "updated_at": "2020-08-26T20:19:26.000000Z",
    "name": "NGALIEMA",
    "address": "Ngaliema",
    "beds": 0,
    "respirators": 2,
    "masks": 0,
    "latitude": "-4.31435",
    "longitude": "15.27123",
    "foam_beds": 30,
    "resuscitation_beds": 0,
    "doctors": 17,
    "nurses": 39,
    "para_medicals": 17,
    "agent_id": 28,
    "township_id": 21
}
```

### HTTP Request
`GET api/dashboard/hospitals-data/{hospitals_datum}`


<!-- END_403a4862a31e5e5a6cdbfbea275340a7 -->

<!-- START_10eed1b858a87363223ad70ef62d727b -->
## Update the specified resource in storage.

> Example request:



### HTTP Request
`PUT api/dashboard/hospitals-data/{hospitals_datum}`

`PATCH api/dashboard/hospitals-data/{hospitals_datum}`


<!-- END_10eed1b858a87363223ad70ef62d727b -->

<!-- START_33b36d6b54cd47ecf6e072e1a030e79f -->
## Remove the specified resource from storage.

> Example request:



### HTTP Request
`DELETE api/dashboard/hospitals-data/{hospitals_datum}`


<!-- END_33b36d6b54cd47ecf6e072e1a030e79f -->

<!-- START_1b8aef954674d784e0b63a36cfb82cae -->
## api/dashboard/hospitals
> Example request:


> Example response (200):

```json
[]
```

### HTTP Request
`GET api/dashboard/hospitals`


<!-- END_1b8aef954674d784e0b63a36cfb82cae -->

<!-- START_6d9b14ea14a0c32ad5c3fafe8c939bc5 -->
## api/dashboard/hospitals/evolution/{hospital?}
> Example request:


> Example response (200):

```json
{
    "last_update": [],
    "occupied_respirators": [],
    "occupied_resuscitation_beds": [],
    "respirators": [],
    "resuscitation_beds": []
}
```

### HTTP Request
`GET api/dashboard/hospitals/evolution/{hospital?}`


<!-- END_6d9b14ea14a0c32ad5c3fafe8c939bc5 -->

<!-- START_06607724e5312805e02e892542fb6fcd -->
## api/dashboard/hospitals/totaux
> Example request:


> Example response (200):

```json
{
    "beds": 0,
    "respirators": 0,
    "foam_beds": 0,
    "resuscitation_beds": 0,
    "doctors": 0,
    "nurses": 0,
    "para_medicals": 0,
    "occupied_foam_beds": null,
    "occupied_resuscitation_beds": null,
    "occupied_respirators": null,
    "resuscitation_ventilator": null,
    "oxygenator": null,
    "confirmed": null,
    "healed": null,
    "dead": null,
    "sick": null
}
```

### HTTP Request
`GET api/dashboard/hospitals/totaux`


<!-- END_06607724e5312805e02e892542fb6fcd -->

<!-- START_8679f7d39354383993193c6430007af1 -->
## api/dashboard/indicators/zones
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "x": [
            "Le champ x est obligatoire."
        ],
        "y": [
            "Le champ y est obligatoire."
        ],
        "geoOptions": [
            "Le champ geo options est obligatoire."
        ],
        "observation_start": [
            "Le champ observation start est obligatoire."
        ],
        "observation_end": [
            "Le champ observation end est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/indicators/zones`


<!-- END_8679f7d39354383993193c6430007af1 -->

<!-- START_ee8ca687d21553b08355eba89aa3ad80 -->
## api/dashboard/orientation-medical-result
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/orientation-medical-result`


<!-- END_ee8ca687d21553b08355eba89aa3ad80 -->

<!-- START_ce9bdf13f8013c328effc5cbbbf0f160 -->
## api/dashboard/orientation-medical-stats
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/orientation-medical-stats`


<!-- END_ce9bdf13f8013c328effc5cbbbf0f160 -->

<!-- START_eb417f60c80d04047308bcc7d63940b7 -->
## api/dashboard/sondages
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/sondages`


<!-- END_eb417f60c80d04047308bcc7d63940b7 -->

<!-- START_291357dbc409969f13556bc458e7bf4a -->
## api/dashboard/cavid-cases
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/cavid-cases`


<!-- END_291357dbc409969f13556bc458e7bf4a -->

<!-- START_43243d39fc6c165664d70135c73c6d37 -->
## api/dashboard/cavid-cases/statistics
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/cavid-cases/statistics`


<!-- END_43243d39fc6c165664d70135c73c6d37 -->

<!-- START_5741b81535e88b26744143bb531f5696 -->
## api/dashboard/cavid-cases/statistics/daily
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/cavid-cases/statistics/daily`


<!-- END_5741b81535e88b26744143bb531f5696 -->

<!-- START_501198afdc35c7405e31e9ddc276f946 -->
## api/dashboard/flux-24
> Example request:



### HTTP Request
`POST api/dashboard/flux-24`


<!-- END_501198afdc35c7405e31e9ddc276f946 -->

<!-- START_cf56dfdb4e0db197c92d3c976f80810f -->
## api/dashboard/flux-24-daily
> Example request:



### HTTP Request
`POST api/dashboard/flux-24-daily`


<!-- END_cf56dfdb4e0db197c92d3c976f80810f -->

<!-- START_5a331bf23fdf209fdc70a74055426e6d -->
## Display a listing of the resource.

> Example request:


> Example response (200):

```json
[
    {
        "origin": "Aba"
    },
    {
        "origin": "Adi"
    },
    {
        "origin": "Alimbongo"
    },
    {
        "origin": "Angumu"
    },
    {
        "origin": "Ankoro"
    },
    {
        "origin": "Ariwara"
    },
    {
        "origin": "Bafwasende"
    },
    {
        "origin": "Baka"
    },
    {
        "origin": "Banalia"
    },
    {
        "origin": "Barumbu"
    },
    {
        "origin": "Basoko"
    },
    {
        "origin": "Bena Leka"
    },
    {
        "origin": "Bena Tshiadi"
    },
    {
        "origin": "Bengamisa"
    },
    {
        "origin": "Beni"
    },
    {
        "origin": "Bibanga"
    },
    {
        "origin": "Biena"
    },
    {
        "origin": "Bikoro"
    },
    {
        "origin": "Bilomba"
    },
    {
        "origin": "Binga"
    },
    {
        "origin": "Binza"
    },
    {
        "origin": "Binza Meteo"
    },
    {
        "origin": "Binza Ozone"
    },
    {
        "origin": "Birambizo"
    },
    {
        "origin": "Boko"
    },
    {
        "origin": "Boko-Kivulu"
    },
    {
        "origin": "Bokoro"
    },
    {
        "origin": "Bolobo"
    },
    {
        "origin": "Bolomba"
    },
    {
        "origin": "Boma"
    },
    {
        "origin": "Boma Bungu"
    },
    {
        "origin": "Bominenge"
    },
    {
        "origin": "Bosondjo"
    },
    {
        "origin": "Bukama"
    },
    {
        "origin": "Bulungu"
    },
    {
        "origin": "Bumba"
    },
    {
        "origin": "Bumbu"
    },
    {
        "origin": "Bunia"
    },
    {
        "origin": "Bunkeya"
    },
    {
        "origin": "Bunkonde"
    },
    {
        "origin": "Bunyakiri"
    },
    {
        "origin": "Businga"
    },
    {
        "origin": "Buta"
    },
    {
        "origin": "Cilundu"
    },
    {
        "origin": "Demba"
    },
    {
        "origin": "Dibaya"
    },
    {
        "origin": "Dilala"
    },
    {
        "origin": "Dilolo"
    },
    {
        "origin": "Diulu"
    },
    {
        "origin": "Djalo Djeka"
    },
    {
        "origin": "Djuma"
    },
    {
        "origin": "Drodro"
    },
    {
        "origin": "Fizi"
    },
    {
        "origin": "Fungurume"
    },
    {
        "origin": "Gbadolite"
    },
    {
        "origin": "Gemena"
    },
    {
        "origin": "Gethy"
    },
    {
        "origin": "Gombari"
    },
    {
        "origin": "Gombe"
    },
    {
        "origin": "Hauts-Plateaux"
    },
    {
        "origin": "Hors_Zone"
    },
    {
        "origin": "Ibanda"
    },
    {
        "origin": "Idiofa"
    },
    {
        "origin": "Idjwi"
    },
    {
        "origin": "Ilebo"
    },
    {
        "origin": "Inga"
    },
    {
        "origin": "Isangi"
    },
    {
        "origin": "Isiro"
    },
    {
        "origin": "Itebero"
    },
    {
        "origin": "Itombwe"
    },
    {
        "origin": "Kabambare"
    },
    {
        "origin": "Kabare"
    },
    {
        "origin": "Kabeya Kamuanga"
    },
    {
        "origin": "Kabinda"
    },
    {
        "origin": "Kabondo"
    },
    {
        "origin": "Kabondo Dianda"
    },
    {
        "origin": "Kabongo"
    },
    {
        "origin": "Kahemba"
    },
    {
        "origin": "Kalamba"
    },
    {
        "origin": "Kalamu I"
    },
    {
        "origin": "Kalamu II"
    },
    {
        "origin": "Kalemie"
    },
    {
        "origin": "Kalenda"
    },
    {
        "origin": "Kalima"
    },
    {
        "origin": "Kalole"
    },
    {
        "origin": "Kalonda Ouest"
    },
    {
        "origin": "Kalonge"
    },
    {
        "origin": "Kamango"
    },
    {
        "origin": "Kamiji"
    },
    {
        "origin": "Kamina"
    },
    {
        "origin": "Kamituga"
    },
    {
        "origin": "Kamonia"
    },
    {
        "origin": "Kampemba"
    },
    {
        "origin": "Kampene"
    },
    {
        "origin": "Kamwesha"
    },
    {
        "origin": "Kananga"
    },
    {
        "origin": "Kanda Kanda"
    },
    {
        "origin": "Kangu"
    },
    {
        "origin": "Kaniama"
    },
    {
        "origin": "Kanzenze"
    },
    {
        "origin": "Kapolowe"
    },
    {
        "origin": "Karawa"
    },
    {
        "origin": "Karisimbi"
    },
    {
        "origin": "Kasa-Vubu"
    },
    {
        "origin": "Kasaji"
    },
    {
        "origin": "Kasansa"
    },
    {
        "origin": "Kashobwe"
    },
    {
        "origin": "Kasongo"
    },
    {
        "origin": "Katako Kombe"
    },
    {
        "origin": "Katana"
    },
    {
        "origin": "Katwa"
    },
    {
        "origin": "Kayna"
    },
    {
        "origin": "Kenge"
    },
    {
        "origin": "Kibirizi"
    },
    {
        "origin": "Kibunzi"
    },
    {
        "origin": "Kikimi"
    },
    {
        "origin": "Kikongo"
    },
    {
        "origin": "Kikula"
    },
    {
        "origin": "Kikwit-Sud"
    },
    {
        "origin": "Kilwa"
    },
    {
        "origin": "Kimbanseke"
    },
    {
        "origin": "Kimpangu"
    },
    {
        "origin": "Kimpese"
    },
    {
        "origin": "Kinda"
    },
    {
        "origin": "Kindu"
    },
    {
        "origin": "Kingabwa"
    },
    {
        "origin": "Kinkonzi"
    },
    {
        "origin": "Kinshasa"
    },
    {
        "origin": "Kintambo"
    },
    {
        "origin": "Kipushi"
    },
    {
        "origin": "Kirotshe"
    },
    {
        "origin": "Kisantu"
    },
    {
        "origin": "Kisenso"
    },
    {
        "origin": "Kitangwa"
    },
    {
        "origin": "Kitenda"
    },
    {
        "origin": "Kitenge"
    },
    {
        "origin": "Kitona"
    },
    {
        "origin": "Kokolo"
    },
    {
        "origin": "Kole"
    },
    {
        "origin": "Komanda"
    },
    {
        "origin": "Kuimba"
    },
    {
        "origin": "Kwilu-Ngongo"
    },
    {
        "origin": "Kyondo"
    },
    {
        "origin": "Lemba"
    },
    {
        "origin": "Lemera"
    },
    {
        "origin": "Likasi"
    },
    {
        "origin": "Limete"
    },
    {
        "origin": "Lisala"
    },
    {
        "origin": "Lodja"
    },
    {
        "origin": "Logo"
    },
    {
        "origin": "Loko"
    },
    {
        "origin": "Lualaba"
    },
    {
        "origin": "Luambo"
    },
    {
        "origin": "Lubero"
    },
    {
        "origin": "Lubondaie"
    },
    {
        "origin": "Lubudi"
    },
    {
        "origin": "Lubumbashi"
    },
    {
        "origin": "Lubunga"
    },
    {
        "origin": "Ludimbi Lukula"
    },
    {
        "origin": "Luebo"
    },
    {
        "origin": "Luiza"
    },
    {
        "origin": "Lukula"
    },
    {
        "origin": "Luozi"
    },
    {
        "origin": "Luputa"
    },
    {
        "origin": "Lusangi"
    },
    {
        "origin": "Lwamba"
    },
    {
        "origin": "Mahagi"
    },
    {
        "origin": "Makala"
    },
    {
        "origin": "Makiso-Kisangani"
    },
    {
        "origin": "Malemba Nkulu"
    },
    {
        "origin": "Maluku I"
    },
    {
        "origin": "Mambasa"
    },
    {
        "origin": "Mangembo"
    },
    {
        "origin": "Manguredjipa"
    },
    {
        "origin": "Manika"
    },
    {
        "origin": "Masa"
    },
    {
        "origin": "Masereka"
    },
    {
        "origin": "Masina I"
    },
    {
        "origin": "Masina II"
    },
    {
        "origin": "Masisi"
    },
    {
        "origin": "Masuika"
    },
    {
        "origin": "Matadi"
    },
    {
        "origin": "Matete"
    },
    {
        "origin": "Mbanza-Ngungu"
    },
    {
        "origin": "Miabi"
    },
    {
        "origin": "Mikalayi"
    },
    {
        "origin": "Minembwe"
    },
    {
        "origin": "Minova"
    },
    {
        "origin": "Moanda"
    },
    {
        "origin": "Mokala"
    },
    {
        "origin": "Monga"
    },
    {
        "origin": "Mongbalu"
    },
    {
        "origin": "Mont Ngafula I"
    },
    {
        "origin": "Mont Ngafula II"
    },
    {
        "origin": "Mukanga"
    },
    {
        "origin": "Mukumbi"
    },
    {
        "origin": "Mulongo"
    },
    {
        "origin": "Mulumba"
    },
    {
        "origin": "Mushie"
    },
    {
        "origin": "Musienene"
    },
    {
        "origin": "Mutena"
    },
    {
        "origin": "Mutoto"
    },
    {
        "origin": "Mutshatsha"
    },
    {
        "origin": "Mutwanga"
    },
    {
        "origin": "Mweka"
    },
    {
        "origin": "Mwene Ditu"
    },
    {
        "origin": "Mwenga"
    },
    {
        "origin": "Mweso"
    },
    {
        "origin": "Ndage"
    },
    {
        "origin": "Ndekesha"
    },
    {
        "origin": "Ndjili"
    },
    {
        "origin": "Ngandajika"
    },
    {
        "origin": "Ngidinga"
    },
    {
        "origin": "Ngiri-Ngiri"
    },
    {
        "origin": "Nia-Nia"
    },
    {
        "origin": "Niangara"
    },
    {
        "origin": "Nioki"
    },
    {
        "origin": "Nsele"
    },
    {
        "origin": "Nsona-Mpangu"
    },
    {
        "origin": "Nundu"
    },
    {
        "origin": "Nyakunde"
    },
    {
        "origin": "Nyangezi"
    },
    {
        "origin": "Nyarambe"
    },
    {
        "origin": "Nyemba"
    },
    {
        "origin": "Nyiragongo"
    },
    {
        "origin": "Oicha"
    },
    {
        "origin": "Omendjadi"
    },
    {
        "origin": "Pimu"
    },
    {
        "origin": "Poko"
    },
    {
        "origin": "Police"
    },
    {
        "origin": "Pweto"
    },
    {
        "origin": "Rungu"
    },
    {
        "origin": "Rutshuru"
    },
    {
        "origin": "Ruzizi"
    },
    {
        "origin": "Rwanguba"
    },
    {
        "origin": "Rwashi"
    },
    {
        "origin": "Sakania"
    },
    {
        "origin": "Samba"
    },
    {
        "origin": "Sandoa"
    },
    {
        "origin": "Saramabila"
    },
    {
        "origin": "Seke-Banza"
    },
    {
        "origin": "Selembao"
    },
    {
        "origin": "Shabunda"
    },
    {
        "origin": "Sona-Bata"
    },
    {
        "origin": "Tandala"
    },
    {
        "origin": "Tembo"
    },
    {
        "origin": "Tshamilemba"
    },
    {
        "origin": "Tshela"
    },
    {
        "origin": "Tshikapa"
    },
    {
        "origin": "Tshilenge"
    },
    {
        "origin": "Tshishimbi"
    },
    {
        "origin": "Ubundu"
    },
    {
        "origin": "Uvira"
    },
    {
        "origin": "Vaku"
    },
    {
        "origin": "Vanga"
    },
    {
        "origin": "Vanga Kete"
    },
    {
        "origin": "Vuhovi"
    },
    {
        "origin": "Walungu"
    },
    {
        "origin": "Wamba"
    },
    {
        "origin": "Wangata"
    },
    {
        "origin": "Wanierukula"
    },
    {
        "origin": "Watsa"
    },
    {
        "origin": "Yabaondo"
    },
    {
        "origin": "Yahuma"
    },
    {
        "origin": "Yakusu"
    },
    {
        "origin": "Yambuku"
    },
    {
        "origin": "Yangala"
    },
    {
        "origin": "Zongo"
    },
    {
        "origin": "Aru"
    },
    {
        "origin": "Boende"
    },
    {
        "origin": "Bondo"
    },
    {
        "origin": "Bongandanga"
    },
    {
        "origin": "Dungu"
    },
    {
        "origin": "Feshi"
    },
    {
        "origin": "Gungu"
    },
    {
        "origin": "Kafakumba"
    },
    {
        "origin": "Kongolo"
    },
    {
        "origin": "Kunda"
    },
    {
        "origin": "Likati"
    },
    {
        "origin": "Lolo"
    },
    {
        "origin": "Lubao"
    },
    {
        "origin": "Mangala"
    },
    {
        "origin": "Manono"
    },
    {
        "origin": "Moba"
    },
    {
        "origin": "Mufunga Sampwe"
    },
    {
        "origin": "Ototo"
    },
    {
        "origin": "Punia"
    },
    {
        "origin": "Tshofa"
    },
    {
        "origin": "Yaleko"
    },
    {
        "origin": "Kasongo Lunda"
    },
    {
        "origin": "Kabalo"
    },
    {
        "origin": "Lomela"
    },
    {
        "origin": "Yamongili"
    },
    {
        "origin": "Minga"
    },
    {
        "origin": "Tshumbe"
    },
    {
        "origin": "Kapanga"
    },
    {
        "origin": "Dikungu"
    },
    {
        "origin": "Wembo Nyama"
    },
    {
        "origin": "Mikope"
    },
    {
        "origin": "Banga Lubaka"
    },
    {
        "origin": "Lubutu"
    },
    {
        "origin": "Kalonda Est"
    },
    {
        "origin": "Kitutu"
    },
    {
        "origin": "Bangabola"
    },
    {
        "origin": "Kinkondja"
    }
]
```

### HTTP Request
`GET api/dashboard/flux-zone`


<!-- END_5a331bf23fdf209fdc70a74055426e6d -->

<!-- START_771172e71e1b6cb6de6e8fd7e84f8518 -->
## api/dashboard/flux-provinces
> Example request:


> Example response (200):

```json
[
    {
        "origin": "Bas-Uele"
    },
    {
        "origin": "Equateur"
    },
    {
        "origin": "Haut-Katanga"
    },
    {
        "origin": "Haut-Lomami"
    },
    {
        "origin": "Haut-Uele"
    },
    {
        "origin": "Hors_Zone"
    },
    {
        "origin": "Ituri"
    },
    {
        "origin": "Kasai"
    },
    {
        "origin": "Kasai-Central"
    },
    {
        "origin": "Kasai-Oriental"
    },
    {
        "origin": "Kinshasa"
    },
    {
        "origin": "Kongo-Central"
    },
    {
        "origin": "Kwango"
    },
    {
        "origin": "Kwilu"
    },
    {
        "origin": "Lomami"
    },
    {
        "origin": "Lualaba"
    },
    {
        "origin": "Mai-Ndombe"
    },
    {
        "origin": "Maniema"
    },
    {
        "origin": "Mongala"
    },
    {
        "origin": "Nord-Kivu"
    },
    {
        "origin": "Nord-Ubangi"
    },
    {
        "origin": "Sankuru"
    },
    {
        "origin": "Sud-Kivu"
    },
    {
        "origin": "Sud-Ubangi"
    },
    {
        "origin": "Tanganyika"
    },
    {
        "origin": "Tshopo"
    },
    {
        "origin": "Tshuapa"
    }
]
```

### HTTP Request
`GET api/dashboard/flux-provinces`


<!-- END_771172e71e1b6cb6de6e8fd7e84f8518 -->

<!-- START_f21495e53b04eb565efa059fc92eaf02 -->
## api/dashboard/townships
> Example request:


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/dashboard/townships`


<!-- END_f21495e53b04eb565efa059fc92eaf02 -->

<!-- START_92726ed280897baec1fa2f410d062622 -->
## api/dashboard/pandemics/top-confirmed
> Example request:


> Example response (422):

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "fluxGeoOptions": [
            "Le champ flux geo options est obligatoire."
        ]
    }
}
```

### HTTP Request
`GET api/dashboard/pandemics/top-confirmed`


<!-- END_92726ed280897baec1fa2f410d062622 -->


