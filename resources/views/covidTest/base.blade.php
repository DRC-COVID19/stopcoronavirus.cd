@extends('layout.app')
@section('title', 'Directives prises par le Gouvernement')
@section('content')
<div class="container-fluid jumbotron-title mb-4 p-5">
    <div class="row stepper justify-content-center">
        <div class="col-12 col-md-4 col-lg-2 mb-4 mb-md-0">
            <div class="step d-flex justify-content-center ">
                <div class="step-circle {{$isResultat==1?'active':''}} ">
                    <p>1</p>
                </div>
                <p class="step-title">Information</p>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-2 mb-4 mb-md-0">
            <div class="step d-flex justify-content-center ">
                <div class="step-circle {{$isResultat==2?'active':''}} ">
                    <p>2</p>
                </div>
                <p class="step-title">Questionnaire</p>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-2">
            <div class="step d-flex justify-content-center">
                <div class="step-circle {{$isResultat==3?'active':''}}">
                    <p>2</p>
                </div>
                <p class="step-title">Résultats</p>
            </div>

        </div>
    </div>
</div>
@yield('covid_content')
@endsection
