@extends('covidTest.base')
@section('title', 'Résultat test covid-19')
@section('covid_content')
<div class="container">
    <div class="row">
        <div class="col-12 jumbotron">
            <p>
                Vous avez l'impression d'avoir des symptômes de Covid-19 et vous voulez savoir quoi faire si c'est le cas ? Ce questionnaire est là pour vous guider.
            </p>
            <p>
                Ce questionnaire est uniquement destiné à vous orienter en fonction de votre état de santé et des symptômes que vous signalez. Les conseils fournis n'ont aucune valeur médicale.
            </p>
            <p>
                Vos réponses serviront à aider la recherche et la compréhension de l’épidémie de COVID-19.
            </p>
            <p>
                Veuillez noter qu'aucune information vous identifiant, directement ou indirectement, n'est collectée.
            </p>
        </div>
    </div>
    <div class="row pb-5 pt-3">
        <div class="col-12 text-right">
            <a href="{{route('selfTest.get')}}" class="btn btn-danger" href="">Démarrez le test</a>
        </div>
    </div>
    @endsection