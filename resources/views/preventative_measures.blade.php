@extends('layout.app')
@section('content')
<div class="jumbotron">
    <div class="container">
    <h1>
        Mesures de protection essentielles contre le nouveau coronavirus
    </h1>
  </div>
</div>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                 Mesures de protection essentielles contre le nouveau coronavirus
            </li>
        </ol>
    </nav>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <p class="lead w-80">
                Tenez-vous au courant des dernières informations sur la flambée de COVID-19, disponibles sur le site Web de l’OMS et auprès des autorités de santé publique nationales et locales.
                <br>
                La COVID-19 continue de toucher surtout la population de la Chine, même si des flambées sévissent dans d’autres pays. La plupart des personnes infectées présentent des symptômes bénins et guérissent, mais d’autres peuvent avoir une forme plus grave.
                <br>
                Prenez soin de votre santé et protégez les autres en suivant les conseils ci-après :
            </p>
        </div>
    </div>
    <div class="row my-4 PreventativeMeasure--Wrapper">
        @foreach($preventativeMeasures as $preventativeMeasure)
    <div class="col-lg-{{$preventativeMeasure->width}}">
                <div class="PreventativeMeasure--Item">
                    @if(!is_null($preventativeMeasure->image_path))
                        <img src="{{asset('storage/' . $preventativeMeasure->image_path)}}" class="PreventativeMeasure--Item__image img-fluid" alt="">
                    @else
                        <div class="PreventativeMeasure--Item_image_placeholder"></div>
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
</div>
@endsection
