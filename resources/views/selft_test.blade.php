@extends('layout.app')
@section('title', 'Directives prises par le Gouvernement')
@section('content')
<div class="container">
    <div class="row">
        <div class="stepper">
            <div class="step">
              <div class="step-circle">
                <p>1</p>
              </div>
              <p class="step-title">Informations</p>
            </div>
            <div class="step active">
              <div class="step-circle">
                <p>2</p>
              </div>
              <p class="step-title">Questionnaire</p>
            </div>
            <div class="step">
              <div class="step-circle">
                <p>3</p>
              </div>
              <p class="step-title">Résultats</p>
            </div>
          </div>
    </div>
    <div class="row">
        <div class="cols-12">
            <form method="post" class="question-form" id="question-form">
                <div class="question">
                  <div class="question-header">
                    <a href="">
                      <span class="fa fa-chevron-left"></span>
                      &nbsp;
                      Question 1 sur 23
                    </a>
                  </div>
                  <p class="question-title">
                    {{ $content['q'] }}
                  </p>
                  <p class="question-options-indication">Sélectionnez une option :</p>
                  
                  <div class="question-options">
                    <div class="d-flex">
                      <div class="custom-control custom-radio">
                        <input type="radio" id="input-radio-step_fever-on" name="step_value" value="1" required="" tabindex="1">
              <label for="input-radio-step_fever-on">
                Oui
                <span class="hover-border"></span>
              </label>
              
                      </div>
                      <div class="custom-control custom-radio">
                        <input type="radio" id="input-radio-step_fever-off" name="step_value" value="0" required="" tabindex="2">
              <label for="input-radio-step_fever-off">
                Non
                <span class="hover-border"></span>
              </label>
              
                      </div>
                    </div>
                    
              
                    
              
                    
              
                  </div>
              
                  <input type="hidden" name="current_step" value="step_fever">
                  <input type="hidden" name="current_context" value="version=1.10,session_started_at=2020-03-30T11:53:31.820566,user_fingerprint=2ccbc92af186c0955e707d3f8cb61ee84e790cdbcfc4d3857a3942311f3e0c066639d44d83eb4a60f265028a792276dc,session_signature=665eeb85203880dd12e62e3dad0d690c4fc31aa8ef1e1cab80eeae27ce9e90f24e81c63956d4e6679792cb237480916f">
                  <input type="hidden" name="current_sign" value="3595ee2851ab0ed71a07cbcd076e832da75f63a6150d7ce4a4c5429e3dbc70f0e11f6ec03c8172fdd327fc2c516efb34">
                  <input type="hidden" name="current_question_number" value="">
              
                </div>
              
                <div class="row justify-content-center">
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
                </div>
                <div class="question-submit d-flex justify-content-center">
                  
              <button class="btn btn-secondary" >
                Enregistrer et continuer
              </button>
              
                </div>
              </form>
        </div>
    </div>
</div>
@endsection