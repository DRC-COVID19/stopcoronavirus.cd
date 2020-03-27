@extends('layout.app')
@section('title', 'En finir avec les idées reçues')
@section('content')
<div class="jumbotron jumbotron-title">
    <div class="container">
        <h1>
            En finir avec les idées reçues
        </h1>
    </div>
</div>
<div class="container">
    <div class="row my-4 PreventativeMeasure--Wrapper">
        @foreach($stereotypes as $stereotype)
            <div class="col-lg-12 mb-3">
                <div class="PreventativeMeasure--Item">
                    <h3 class="mb-4 PreventativeMeasure--Item__title">
                        {{$stereotype['title']}}
                    </h3>
                    <p>
                        <?php echo $stereotype['content']; ?>
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
