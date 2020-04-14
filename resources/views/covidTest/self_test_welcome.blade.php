@extends('covidTest.base')
@section('title', 'Résultat test covid-19')
@section('covid_content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>
                Vous avez l'impression d'avoir des symptômes de Covid-19 et vous voulez savoir quoi faire si c'est le cas ?<br><strong>Ce questionnaire est là pour vous guider.</strong>
            </h1>
            <p>
                Ce questionnaire est uniquement destiné à vous orienter en fonction de votre état de santé et des symptômes que vous signalez. Les conseils fournis n'ont <strong>aucune valeur médicale</strong>.
            </p>
            <p>
                Vos réponses serviront à aider la recherche et la compréhension de l’épidémie de COVID-19.<br>
                Veuillez noter qu'aucune information vous identifiant, directement ou indirectement, n'est collectée.
            </p>
            <p class="text-center py-5">
            <a href="{{route('selfTest.get')}}" class="btn btn-danger" href="">Démarrez le test</a>
            </p>
        </div>
    </div>
    @endsection