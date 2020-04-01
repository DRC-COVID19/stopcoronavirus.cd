@extends('layout.app')
@section('title', 'Directives prises par le Gouvernement')
@section('content')
<div class="container">
    <div class="row">
        <div class="stepper">
            <div class="step">
                <div class="step-circle">
                    <p>1</p>
                </div>
                <p class="step-title">Informations</p>
            </div>
            <div class="step active">
                <div class="step-circle">
                    <p>2</p>
                </div>
                <p class="step-title">Questionnaire</p>
            </div>
            <div class="step">
                <div class="step-circle">
                    <p>3</p>
                </div>
                <p class="step-title">Résultats</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="resultHead">
                <p class="resultText">
                    La recommandation affichée peut évoluer suivant les informations en provenance
                    des autorités de santé et des chercheurs. Elle ne constitue pas un avis médical. En cas
                    de doute, demandez conseil à votre médecin ou pharmacien.
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="results">
                <div class="d-flex flex-column">
                    <span class="justify-content-center text-center resultTitle">
                        Vos symptômes nécessitent <u>une prise en charge rapide</u>.
                    </span>
                    <div class="resultAlert">
                        <p class="resultSubtitle font-weight-bold d-flex align-items-center">
                            {{$resultat}}
                        </p>
                        <p class="resultSubtitle result-pad font-weight-bold">Restez chez vous.</p>
                        <p class="resultText">
                            #RestezChezVous - limitez les contacts avec d'autres personnes. Le virus
                            peut être propagé par des porteurs ne montrant pas de symptômes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endsection
