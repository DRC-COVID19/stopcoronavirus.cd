@extends('covidTest.base')
@section('title', 'Test covid-19')
@section('covid_content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <form method="post" class="question-form" action="{{url()->current()}}">
                <div class="question">
                    <div class="question-header">
                        <a href="{{$backUrl}}">
                            <span class="fa fa-chevron-left"></span>
                            &nbsp;
                            Question {{ $content['id'] }} sur 23
                        </a>
                    </div>
                    <p class="question-title">
                        {{ $content['q'] }}
                    </p>
                    @if ($errors->any())
                    <div class="col-12">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                    <p class="question-options-indication">
                        @if($content['r']==3)
                        Remplissez le champ :
                        @else
                        Sélectionnez une option :
                        @endif
                    </p>

                    <div class="question-options">
                        <div class="d-flex flex-column justify-content-between">
                            @if($content['r']==1 || $content['r']==2 || $content['r']==8)
                            <div class="custom-control custom-radio">
                                <input type="radio" id="input-radio-step_fever-on" name="step_value" value="1" tabindex="1">
                                <label for="input-radio-step_fever-on">
                                    Oui
                                    <span class="hover-border"></span>
                                </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="input-radio-step_fever-off" name="step_value" value="0" tabindex="2">
                                <label for="input-radio-step_fever-off">
                                    Non
                                    <span class="hover-border"></span>
                                </label>
                            </div>
                            @endif
                            @if($content['r']==2 || $content['r']==8)
                            <div class="custom-control custom-radio">
                                <input type="radio" id="input-radio-step_fever-none" name="step_value" value="2" tabindex="3">
                                <label for="input-radio-step_fever-none">
                                    {{ $content['r']==2 ? 'Ne sait pas':'Non applicable'}}
                                    <span class="hover-border"></span>
                                </label>
                            </div>
                            @endif

                            @if($content['r']==3)
                            <div class="custom-control custom-text">
                                <div class="custom-text-label"></div>
                                <input id="step_fever_details" class="input-text " type="number" name="step_value" value="" min="34" max="42" step="0.1" placeholder="37,0" required tabindex="1">

                                <label class="custom-text-suffix" for="step_fever_details">degrés</label>
                            </div>
                            @endif

                            @if($content['r']==4)
                            <div class="custom-control custom-radio">
                                <input type="radio" id="input-radio-step_fever-well" name="step_value" value="1" tabindex="1">
                                <label for="input-radio-step_fever-well">
                                    Bien
                                    <span class="hover-border"></span>
                                </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="input-radio-step_fever-enough" name="step_value" value="2" tabindex="2">
                                <label for="input-radio-step_fever-enough">
                                    Assez bien
                                    <span class="hover-border"></span>
                                </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="input-radio-step_fever-bad" name="step_value" value="3" tabindex="1">
                                <label for="input-radio-step_fever-bad">
                                    Mal
                                    <span class="hover-border"></span>
                                </label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="input-radio-step_fever-very-bad" name="step_value" value="4" tabindex="2">
                                <label for="input-radio-step_fever-very-bad">
                                    Très mal
                                    <span class="hover-border"></span>
                                </label>
                            </div>
                            @endif

                            @if($content['r']==5)
                            <div class="custom-control custom-text">
                                <div class="custom-text-label"></div>
                                <input id="step_age" class="input-text " type="number" name="step_value" value="" min="1" max="110" required="" tabindex="1">

                                <label class="custom-text-suffix" for="step_age">ans</label>
                            </div>
                            @endif

                            @if($content['r']==6)
                            <div class="custom-control custom-text">
                                <div class="custom-text-label">Votre taille</div>
                                <input id="step_height" class="input-text " type="number" name="step_value" value="" min="80" max="250" required="" tabindex="1">

                                <label class="custom-text-suffix" for="step_height">cm</label>
                            </div>
                            @endif

                            @if($content['r']==7)
                            <div class="custom-control custom-text">
                                <div class="custom-text-label">Votre poids</div>
                                <input id="step_weight" class="input-text " type="number" name="step_value" value="" min="20" max="250" required="" tabindex="1">

                                <label class="custom-text-suffix" for="step_weight">kg</label>
                            </div>
                            @endif

                            @if($content['r']==9)
                            <div class="custom-control custom-text">
                            <div class="custom-text-label">{{__('Province, Ville, Commune, Quartier')}}</div>
                                <textarea  class="input-text-area" cols="100" rows="100" name="step_value"   tabindex="1"></textarea>
                            </div>
                            @endif
                        </div>
                    </div>
                    <input type="hidden" name="current_step" value="{{$content['id']}}">
                    @csrf

                </div>

                {{-- <div class="row justify-content-center">
                  <div class="cols-12 col-md-10">
                    <div class="warning-form">
                      <p class="warning-form-title">Anti-inflammatoires non stéroïdiens</p>
                      <p>
                        La prise d'anti-inflammatoires (ibuprofène, cortisone ...) pourrait être un facteur
                        d'aggravation de l’infection. En cas de fièvre, prenez du paracétamol. Cette remarque
                        concerte les traitements par gélules ou comprimés et ne concerne pas les formes inhalées.
                        Si vous êtes déjà sous traitement, n'arrêtez pas ce traitement, demandez l'avis de votre
                        médecin ou de votre pharmacien.
                      </p>
                    </div>
                  </div>
                </div> --}}
                <div class="question-submit d-flex justify-content-center">

                    <button class="btn btn-secondary">
                        Enregistrer et continuer
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
