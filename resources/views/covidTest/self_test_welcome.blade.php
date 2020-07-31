@extends('covidTest.base')
@section('title', 'Résultat test covid-19')
@section('covid_content')
<div class="container">
  <div class="row">
    <div class="col-12">
      <h1 class="mb-5 covid-test-title">
        Vous avez l'impression d'avoir des symptômes de Covid-19 et vous voulez savoir quoi faire si c'est le cas ?<br><strong>Ce questionnaire est là pour vous guider.</strong>
      </h1>
      <p>
        Ce questionnaire est uniquement destiné à vous orienter en fonction de votre état de santé et des symptômes que vous signalez. Les conseils fournis n'ont <strong>aucune valeur médicale</strong>.
      </p>
      <div class="row">
        <div class="col-12">
          <h3 >
              <strong>{{ __("Quels sont les symptômes du COVID-19 ?") }}</strong>
          </h3>
        </div>
      </div>
      <div class="row my-4 home-symptome">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3 mb-md-5 ">
          <div class="card">
            <div class="card-body"> {!! __("Fièvre, fatigue, toux sèche") !!}</div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3 mb-md-5 ">
          <div class="card">
            <div class="card-body"> {!! __("Pour certains patients: Congestion nasale, écoulement nasal, maux de gorge ou une diarrhée") !!}</div>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3 mb-md-5 ">
          <div class="card">
            <div class="card-body">{!! __("Pour d’autres: aucun symptome") !!}</div>
          </div>
        </div>
      </div>
      <p class="text-center">
        Vos réponses serviront à aider la recherche et la compréhension de l’épidémie de COVID-19.<br>
        Veuillez noter qu'aucune information vous identifiant, directement ou indirectement, n'est collectée.
      </p>

      <p class="text-center py-5">
        <a href="{{route('selfTest.get')}}" class="btn btn-danger btn-start-test" href="">Démarrez le test</a>
      </p>
    </div>



  </div>
  @endsection
