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
            @foreach($officialMeasures as $key=>$officialMeasure)
                <article class="col-lg-12 mb-3">
                    <input id="collapsible{{$officialMeasure['id']}}" class="toggle" type="checkbox" {{ $key==0? 'checked':''  }}>
                    <label for="collapsible{{$officialMeasure['id']}}" class="lbl-toggle PreventativeMeasure--Item__title">
                     {{$officialMeasure['title']}}
                    </label>
                    <div class="collapsible-content">
                        <div class="content-inner">
                            <?php echo $officialMeasure['content']; ?>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
@endsection
