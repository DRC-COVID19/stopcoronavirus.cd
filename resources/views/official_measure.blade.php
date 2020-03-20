@extends('layout.app')
@section('content')
<div class="jumbotron">
    <div class="container">
    <h1>
        Mesures prises par le Gouvernement
    </h1>
    <p>
        Suite à son adresse à la nation de ce 18 mars 2020, voici les décisions prises ce mercredi 18 mars 2020 par le Chef de l’État Son Excellence Monsieur Félix-Antoine Tshisekedi Tshilombo, au sujet de l’épidémie au Coronavirus-COVID-19.
    </p>
  </div>
</div>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Mesures prises par le Gouvernement</li>
        </ol>
    </nav>
</div>
<div class="container">
    <div class="row my-4 OfficialMeasures--Wrapper">
        @foreach($officialMeasures as $officialMeasure)
            <article class="col-lg-12">
                <h2>
                    <b>
                        {{$officialMeasure->title}}
                    </b>
                </h2>
                <p>
                    <?php echo $officialMeasure->content; ?>
                </p>
            </article>
        @endforeach
    </div>
</div>
@endsection
