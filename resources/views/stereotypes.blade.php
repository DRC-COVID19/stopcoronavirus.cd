@extends('layout.app')
@section('title', 'En finir avec les idées reçues')
@section('content')
<div class="jumbotron jumbotron-title">
    <div class="container">
        <h1>
            {{ __('Idées reçues et Fake News') }}
        </h1>
    </div>
</div>
<div class="container">
    <div class="row my-4 PreventativeMeasure--Wrapper">
        @foreach($stereotypes as $stereotype)
            <div class="col-lg-12 mb-3">
                <div class="PreventativeMeasure--Item">
                <input id="collapsible{{$stereotype->id}}" class="toggle" type="checkbox">
                    <label for="collapsible{{$stereotype->id}}" class="lbl-toggle mb-4 PreventativeMeasure--Item__title">
                     {{$stereotype->title}}
                    </label>
                    <div class="collapsible-content">
                        <div class="content-inner">
                    <p>
                        <?php echo $stereotype->content; ?>
                    </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
