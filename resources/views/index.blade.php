@extends('layout.app')
@section('content')

    <div class="jumbotron jumbotron-title">
        <div class="container">
            <h1>Stop Coronavirus COVID-19 RDC</h1>
            <p class="lead">Site officiel d'informations et de conseils</p>
        </div>
    </div>
    <?php /*
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Accueil</li>
        </ol>
    </nav>
</div>
 */ ?>
    @isset($pandemicStats)
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="mt-5">Situation actuelle en RDC</h2>
                    <p>Mise à jour le {{ \Carbon\Carbon::parse($pandemicStats->last_update )->format('d.m.Y à H:i')}}</p>
                </div>
            </div>
            <div class="row statistiques">
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <div class="card-header">Confirmés</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $pandemicStats->confirmed }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card bg-gray-200">
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
                <div class="col-md-3 mb-3">
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
                <div class="col-md-3 mb-3">
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
                    Mesures de protection essentielles contre le coronavirus
                </h2>
            </div>
        </div>
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
        <div class="PreventativeMeasure--Cta text-center mt-3">
            <a href="{{route('preventativeMeasures')}}" class="btn btn-secondary p-4">
                Voir le détail des mesures de protection
            </a>
        </div>
    </div>

    <div class="container mb-5">

        <div class="row">
            <div class="col-12">
                <h2 class="mt-5">
                    Dernières directives prises par le Gouvernement
                </h2>
            </div>
        </div>
        <div class="row my-4 PreventativeMeasure--Wrapper">
            @foreach($directives as $directive)
                <div class="col-lg-{{$directive->width}}">
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
            <a href="{{route('officialMeasure')}}" class="btn btn-secondary p-4">
                Voir toutes les directives du Gouvernement
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
