@extends('layout.app')
@section('content')

<div class="jumbotron">
    <div class="container">
    <h1 class="display-4">Stop Coronavirus COVID-19 RDC
    </h1>
    <p class="lead w-50">Site officiel où vous trouverez des informations et des conseils concernant la maladie à coronavirus 2019 (COVID-19) en RDC.</p>
  </div>
</div>

    <div class="container mb-5">

        <div id="coronavirus">
            <h3>
                <b>Mesures de protection essentielles contre le nouveau coronavirus</b>
            </h3>
            <p>Tenez-vous au courant des dernières informations sur la flambée de COVID-19, disponibles sur le site Web de l’OMS et auprès des autorités de santé publique nationales et locales. La COVID-19 continue de toucher surtout la population de la Chine, même si des flambées sévissent dans d’autres pays. La plupart des personnes infectées présentent des symptômes bénins et guérissent, mais d’autres peuvent avoir une forme plus grave. Prenez soin de votre santé et protégez les autres en suivant les conseils ci-après :
            </p>
        </div>

        <div class="row my-4 PreventativeMeasure--Wrapper">
            @foreach($preventativeMeasures as $preventativeMeasure)
                <div class="col-lg-4">
                    <div class="PreventativeMeasure--Item">
                        @if(!is_null($preventativeMeasure->image_path))
                            <img src="{{asset('storage/' . $preventativeMeasure->image_path)}}" class="PreventativeMeasure--Item__image img-fluid" alt="">
                        @else
                            <div class="PreventativeMeasure--Item_image_placeholder"></div>
                        @endif
                        <h4 class="mb-4 PreventativeMeasure--Item__title">
                            {{$preventativeMeasure->title}}
                        </h4>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="PreventativeMeasure--Cta">
            <a href="{{route('preventativeMeasures')}}" class="btn btn-success">
                Voir plus de mesures de protection
            </a>
        </div>
    </div>

  <div class="container mb-5">
      @if(count($alerts)> 0)
      <h2>
          <b>
              Dernières alertes
          </b>
      </h2>
        @foreach($alerts as $alert)
            <div class="w60 my-4">
                <h5 class="my-4">
                    {{$alert->title}}
                </h5>
                <p>
                    {{$alert->content}}
                </p>
            </div>
        @endforeach

        <div>
            <a href="{{route('home')}}" class="btn btn-success">
                Voir toutes les alertes
            </a>
        </div>
      @endif
  </div>

@endsection
