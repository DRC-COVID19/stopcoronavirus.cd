@extends('layout.app')
@section('title', 'Situation Épidémiologique en RDC')
@section('content')

    <div class="jumbotron jumbotron-title">
        <div class="container">
            <h1>Stop Coronavirus COVID-19 RDC</h1>
            <p class="lead">Site officiel d'informations et de conseils</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="jumbotron jubmotron-alert">
                    <p class="lead">
                        <i class="fas fa-exclamation-triangle"></i>
                        {{ __("Prenez deux minutes pour partager vos perceptions et réactions afin d'aider et d’orienter l'équipe de la riposte dans la lutte contre le COVID-19 :") }}
                    </p>
                    <p class="text-center mb-0">
                        <a class="btn btn-secondary" target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLScgvdoM8gr1HAUHSDOA0zTLED7rmmofPsbG1Qqplj9pcxQ8XA/viewform?usp=sf_link">
                            {{ __('Accédez au Sondage') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @isset($pandemicStats)
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="mt-5">Situation Épidémiologique en RDC</h2>
                    <p>Mise à jour le {{ \Carbon\Carbon::parse($pandemicStats->last_update )->format('d.m.Y')}}</p>
                </div>
            </div>
            <div class="row statistiques">
                <div class="col-md-3 col-sm-6 col-xs-12 mb-3">
                    <div class="card bg-gray-200">
                        <div class="card-header">Confirmés</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $pandemicStats->confirmed }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 mb-3">
                    <div class="card bg-flag-yellow">
                        <div class="card-header">Actifs</div>
                        <div class="card-body">
                            <h5 class="card-title">
                                @isset($pandemicStats->sick)
                                    {{ $pandemicStats->sick }}
                                @else
                                    0
                                @endisset</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 mb-3">
                    <div class="card bg-success text-white">
                        <div class="card-header">Guéris</div>
                        <div class="card-body">
                            <h5 class="card-title">
                                @isset($pandemicStats->healed)
                                    {{ $pandemicStats->healed }}
                                @else
                                    0
                                @endisset
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12 mb-3">
                    <div class="card bg-dark text-white">
                        <div class="card-header">Décès</div>
                        <div class="card-body">
                            <h5 class="card-title">
                                @isset($pandemicStats->dead)
                                    {{ $pandemicStats->dead }}
                                @else
                                    0
                                @endisset
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div id="statsChartContainer" class="col-12">
                    <canvas id="statsChart"></canvas>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-5">
                    <em class="statistiques-footnote">Données officielles validées par le comité technique.</em>
                </div>
            </div>
        </div>
    @endisset

    <div class="container mb-5">

        <div class="row">
            <div class="col-12">
                <h2 class="mt-5">
                    <i class="fas fa-virus"></i>
                    {{ __("Quels sont les symptômes du COVID-19 ?") }}
                </h2>
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
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3 mb-md-5 ">
                <div class="card">
                    <div class="card-body">{!! __("Environ 80 % des personnes guérissent sans avoir besoin de traitement particulier.") !!}</div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-3 mb-md-5 ">
                <div class="card">
                    <div class="card-body">
                        {!! __("Les personnes âgées et celles qui ont d’autres problèmes de santé (hypertension artérielle, problèmes cardiaques ou diabète) ont plus de risques de présenter des symptômes graves.") !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h2 class="mt-5">
                    <i class="fas fa-first-aid"></i>
                    {{ __("Consignes de sécurité et d'hygiène") }}
                </h2>
            </div>
        </div>
        <div class="row my-4 home-consignes">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-5">
                <div class="ico">
                    <i class="fas fa-house-user"></i>
                </div>
                {!! __("<strong>Restez</strong> chez vous ou <strong>limitez</strong> vos déplacements à l'essentiel") !!}
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 mb-5">
                <div class="ico">
                    <i class="fas fa-head-side-cough-slash"></i>
                </div>
                {!! __("<strong>Éternuez</strong> ou toussez dans le <strong>pli du coude</strong> ou dans un mouchoir en papier jetable") !!}
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-5">
                <div class="ico">
                    <i class="fas fa-hands-wash"></i>
                </div>
                {!! __("<strong>Lavez</strong> vous les <strong>mains</strong> régulièrement à l'eau et au savon pendant 20 secondes") !!}
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-5">
                <div class="ico">
                    <i class="fas fa-box-tissue"></i>
                </div>
                {!! __("Utilisez un <strong>mouchoir</strong> à usage unique et le <strong>jeter</strong> après usage") !!}
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-5">
                <div class="ico">
                    <i class="fas fa-people-arrows"></i>
                </div>
                {!! __("<strong>Evitez</strong> de <strong>serrer des mains</strong> ou de faire la bise") !!}
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 mb-5">
                <div class="ico">
                    <i class="fas fa-head-side-mask"></i>
                </div>
                {!! __("Portez un <strong>masque médical</strong> jetable pour limiter la propagation du virus<br><small>(le masque doit être changé toutes les 3 heures)</small>") !!}
            </div>
        </div>
        <?php /*
<div class="row my-4 PreventativeMeasure--Wrapper">
@foreach($preventativeMeasures as $preventativeMeasure)
    <div class="col-lg-{{$preventativeMeasure->width}}">
        <div class="PreventativeMeasure--Item">
            @if(!is_null($preventativeMeasure->image_path))
                <img src="{{asset('storage/' . $preventativeMeasure->image_path)}}" class="PreventativeMeasure--Item__image img-fluid" alt="">
            @else
                @if($preventativeMeasure->width==4)
                    <div class="PreventativeMeasure--Item_image_placeholder"></div>
                @endif
            @endif
            <h4 class="mb-4 PreventativeMeasure--Item__title">
                {{$preventativeMeasure->title}}
            </h4>
            <p>
                <?php echo $preventativeMeasure->content; ?>
    </p>
</div>
</div>
@endforeach
</div>
*/ ?>
        <div class="PreventativeMeasure--Cta text-center mt-3">
            <a href="{{route('preventativeMeasures')}}" class="btn btn-secondary p-3">
                {{ __('Voir les détails des mesures de protection') }}
            </a>
        </div>
    </div>

    <div class="container-fluid container-directive py-5">
        <div class="container mb-5">

            <div class="row">
                <div class="col-12">
                    <h2 class="mt-5">
                        <i class="fas fa-file-contract"></i>
                        {{ __('Directives prises par le Gouvernement') }}
                    </h2>
                </div>
            </div>
            <?php /*
            <div class="row">
                <div class="col-12">
                    <h3>{{ __('Mesure pour la ville de Kinshasa à partir du 28 mars 2020') }}</h3>
                    <p>{{ __('3 semaines de confinement par intermittence à partir du samedi 28 mars 2020') }}</p>
                </div>
            </div>
            <div class="row my-4 home-directives">
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="ico">
                        <i class="fas fa-house-user"></i>
                    </div>
                    <strong>{{ __('28 mars 2020 au 31 mars') }}</strong>
                    {{ __('Interdiction totale de quitter votre domicile : restez chez vous') }}
                </div>
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="ico">
                        <i class="fas fa-shopping-basket"></i>
                    </div>
                    <strong>{{ __('01 avril et 02 avril') }}</strong>
                    {!! __('Autorisation de circulation afin de s’approvisionner, <strong>en respectant les mesures de protection</strong>') !!}
                </div>
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="ico">
                        <i class="fas fa-house-user"></i>
                    </div>
                    <strong>{{ __('03 avril au 06 avril') }}</strong>
                    {{ __('Restez-chez vous') }}
                </div>
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="ico">
                        <i class="fas fa-shopping-basket"></i>
                    </div>
                    <strong>{{ __('07 avril et 08 avril') }}</strong>
                    {{ __('Autorisation de circulation pour faire vos provisions') }}
                </div>
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="ico">
                        <i class="fas fa-house-user"></i>
                    </div>
                    <strong>{{ __('09 avril au 12 avril') }}</strong>
                    {{ __('Restez-chez vous') }}
                </div>
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="ico">
                        <i class="fas fa-shopping-basket"></i>
                    </div>
                    <strong>{{ __('13 avril et 14 avril') }}</strong>
                    {{ __('Autorisation de circulation pour faire vos provisions') }}
                </div>
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="ico">
                        <i class="fas fa-house-user"></i>
                    </div>
                    <strong>{{ __('15 avril au 18 avril') }}</strong>
                    {{ __('Restez-chez vous') }}
                </div>
            </div>
        </div>
        */ ?>
            <div class="row my-4 PreventativeMeasure--Wrapper">
                @foreach($directives as $directive)
                    <div class="col-lg-12">
                        <div class="PreventativeMeasure--Item">
                            @if(!is_null($directive->image_path))
                                <img src="{{asset('storage/' . $directive->image_path)}}" class="PreventativeMeasure--Item__image img-fluid" alt="">
                            @endif
                            <h4 class="mb-4 PreventativeMeasure--Item__title">
                                {{$directive->title}}
                            </h4>
                            <p>
                                <?php echo $directive->content; ?>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="PreventativeMeasure--Cta text-center mt-3">
                <a href="{{route('officialMeasure')}}" class="btn btn-secondary p-3">
                    Voir toutes les directives du Gouvernement
                </a>
            </div>
        </div>

    {{-- @if(count($alerts)> 0)
    <div class="container mb-5">
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
    </div>
    @endif --}}

@endsection
