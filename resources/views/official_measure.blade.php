@extends('layout.app')
@section('title', 'Directives prises par le Gouvernement')
@section('content')
    <div class="jumbotron jumbotron-title">
        <div class="container">
            <h1>
                Directives prises par le Gouvernement
            </h1>
        </div>
    </div>
    <div class="container">
        <div class="row my-4 OfficialMeasures--Wrapper">
            @foreach($officialMeasures as $officialMeasure)
                <article class="col-lg-12">
                    <h2>
                        {{$officialMeasure->title}}
                    </h2>
                    <p>
                        <?php echo $officialMeasure->content; ?>
                    </p>
                </article>
            @endforeach
        </div>
    </div>
@endsection
