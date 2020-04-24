<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnostic extends Model
{
    protected $fillable=[
        'age',
        'fever_algo',
        'temperature_cat',
        'cough',
        'agueusia_anosmia',
        'sore_throat_aches',
        'diarrhea',
        'tiredness',
        'tiredness_details',
        'feeding_day',
        'breathlessness',
        'age_range',
        'diabetes',
        'cancer',
        'kidney_disease',
        'liver_disease',
        'pregnant',
        'breathing_disease',
        'immunosuppressant_disease',
        'immunosuppressant_drug',
        'immunosuppressant_disease_algo',
        'immunosuppressant_drug_algo',
        'orientation',
        'algo_version',
        'form_version',
        'duration',
        'imc',
        'heart_disease',
        'heart_disease_algo',
        'province',
        'town',
        'township',
        'latitude',
        'longitude',
        'results_message',
    ];
}
