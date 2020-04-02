@extends('layout.app')
@section('title', 'Directives prises par le Gouvernement')
@section('content')
<div class="container-fluid jumbotron-title mb-4">
    <div class="row">
        <div class="stepper">
            <div class="step ">
                <div class="step-circle {{!$isResultat?'active':''}} ">
                    <p>1</p>
                </div>
                <p class="step-title">Questionnaire</p>
            </div>
            <div class="step">
                <div class="step-circle {{$isResultat?'active':''}}">
                    <p>2</p>
                </div>
                <p class="step-title">Résultats</p>
            </div>
        </div>
    </div>
</div>
@yield('covid_content')
@endsection