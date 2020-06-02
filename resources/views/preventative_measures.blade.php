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
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="jumbotron">
                <div class="container">
                    <?php echo $category['description'] ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h1>Comment puis-je me protéger et éviter que la maladie ne se propage ?</h1>
        </div>
    </div>
    @foreach($preventativeMeasures as $key=>$preventativeMeasure)
    <div class="row my-4 PreventativeMeasure--Wrapper ">
        @if(!is_null($preventativeMeasure['image_path']))
        <div class="col-lg-2">
            <img src="{{asset('storage/' . $preventativeMeasure['image_path'])}}" class="PreventativeMeasure--Item__image img-fluid" alt="">
        </div>
        @endif
        <div class="col-lg-{{is_null($preventativeMeasure['image_path'])?'12':'9'}}">
            <div class="PreventativeMeasure--Item">
                <h4 class="mb-4 PreventativeMeasure--Item__title">
                    {{$preventativeMeasure['title']}}
                </h4>
                <p>
                    <?php echo $preventativeMeasure['content']; ?>
                </p>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
