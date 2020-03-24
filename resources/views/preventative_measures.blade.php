@extends('layout.app')
@section('title', 'Mesures de protection contre le Coronavirus COVID-19')
@section('content')
<div class="jumbotron jumbotron-title">
    <div class="container">
    <h1>
        Mesures de protection contre le Coronavirus COVID-19
    </h1>
</div>
</div>
{{-- <div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                 Mesures de protection essentielles contre le nouveau coronavirus
            </li>
        </ol>
    </nav>
</div> --}}
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="jumbotron">
                <div class="container">
                    <?php echo $category->description ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h1>Comment puis-je me protéger et éviter que la maladie ne se propage ?</h1>
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
</div>
@endsection
