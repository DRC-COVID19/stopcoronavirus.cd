@extends('covidTest.base')
@section('title', 'Résultat test covid-19')
@section('covid_content')
<div class="container">
    <div class="row mb-5">
        <div class="col-12">
            <div class="resultHead">
                <p class="resultText mb-0">
                    La recommandation affichée peut évoluer suivant les informations en provenance des autorités de santé et des chercheurs. Elle ne constitue pas un avis médical.<br> En cas
                    de doute, demandez conseil à votre médecin ou pharmacien.
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="results">
                <div class="d-flex flex-column">
                    <div class="resultAlert">
                        <p class="resultSubtitle font-weight-bold">
                           <i class="fas fa-2x fa-exclamation-triangle"></i><br>{{$resultat['text']}}
                        </p>
                        <!--<p class="resultSubtitle result-pad font-weight-bold">Restez chez vous.</p>-->
                        <p class="resultText">
                            #RestezChezVous - limitez les contacts avec d'autres personnes. Le virus
                            peut être propagé par des porteurs ne montrant pas de symptômes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row pb-5 pt-3">
        <div class="col-12 text-center">
            <a href="{{url()->current()}}" class="btn btn-danger" href="">Recommancez le test</a>
        </div>
    </div>
    @endsection
