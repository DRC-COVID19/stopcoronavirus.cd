@extends('layout.app')
@section('content')
<div class="jumbotron jumbotron-title">
    <div class="container">
    <h1>
        Directives prises par le Gouvernement
    </h1>
</div>
</div>
{{-- <div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page">Mesures prises par le Gouvernement</li>
        </ol>
    </nav>
</div> --}}
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
