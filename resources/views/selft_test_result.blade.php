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
    <div class="resultHead">
        <p class="resultText">
          La recommandation affichée peut évoluer suivant les informations en provenance
          des autorités de santé et des chercheurs. Elle ne constitue pas un avis médical. En cas
          de doute, demandez conseil à votre médecin ou pharmacien.
        </p>
      </div>
      <div class="results">
        <div class="d-flex flex-column">
          <span class="justify-content-center text-center resultTitle">
            
              Vos symptômes nécessitent <u>une prise en charge rapide</u>.
            
          </span>
    
          <div class="resultAlert">
            
              <p class="resultSubtitle font-weight-bold d-flex align-items-center">
                {{$resultat}}
              </p>
              <p class="resultText">
                Les SAMU-centres 15 disposent des dernières procédures en vigueur dans votre zone géographique.
                Une prise en charge adaptée à votre région et à votre état de santé vous sera proposée.<br><br>
                Suivant votre département et votre état de santé, 
                le SAMU pourra vous orienter vers une permanence de médecine générale.
              </p>
            <p class="resultSubtitle result-pad font-weight-bold">Restez chez vous.</p>
            <p class="resultText">
              #RestezChezVous - limitez les contacts avec d'autres personnes. Le virus
              peut être propagé par des porteurs ne montrant pas de symptômes.
            </p>
          </div>
          <div class="moreQuestions">
      <p class="resultSubtitle font-weight-bold align-items-center">
        <img class="resultImgWarning" src="static/svg/alert-circle.svg">
        Vous avez des questions sur la prise de vos médicaments ?
      </p>
      <p class="resultText">
        Pour vérifier si un médicament pourrait présenter un risque potentiel d'aggraver vos symptômes :
        <a href="https://covid19-medicaments.com" target="_blank" class="underline">
          https://covid19-medicaments.com
        </a>
      </p>
    </div>
    <div class="moreQuestions">
      <p class="resultSubtitle font-weight-bold align-items-center">
        <img class="resultImgWarning" src="static/svg/alert-circle.svg">
        Vous avez des questions additionnelles ?
      </p>
      <p class="resultText">
        Appelez le <a href="tel:0800130000">0800 130 000</a>
      </p>
      <p class="resultText">
          et suivez l'actualité sur <a href="https://gouvernement.fr/info-coronavirus" target="_blank" class="underline">https://gouvernement.fr/info-coronavirus
        </a>
      </p>
    </div>
    
        <span class="resultSubtitle text-center mb-4">Pour éviter de propager le virus, adoptez les gestes barrière :</span>
      <div class="row goodPractices">
        <div class="col-sm justify-content-center d-flex flex-column goodPracticesItem">
          <img class="img1" src="static/svg/icon-washing-hands.svg">
          <p class="goodPracticesText">Lavez-vous <strong>très régulièrement</strong> les mains</p>
        </div>
        <div class="col-sm justify-content-center d-flex flex-column goodPracticesItem">
          <img class="img2" src="static/svg/icon-cough.svg">
          <p class="goodPracticesText">Toussez ou éternuez <strong>dans votre coude ou dans un mouchoir</strong></p>
        </div>
        <div class="col-sm justify-content-center d-flex flex-column goodPracticesItem">
          <img class="img3" src="static/svg/icon-wave.svg">
          <p class="goodPracticesText">Saluez <strong>sans serrer la main, évitez les embrassades</strong></p>
        </div>
        <div class="col-sm justify-content-center d-flex flex-column goodPracticesItem">
          <img class="img4" src="static/svg/icon-tissues.svg">
          <p class="goodPracticesText">Utilisez un <strong>mouchoir à usage unique</strong> et jetez-le</p>
        </div>
      </div>
    
    </div>
    
    <div class="result-foot-numbers-container">
      <div class="result-foot-numbers-top-container">
        <img class="headset-img" src="static/svg/icon-headset.svg">
        <p class="result-foot-numbers-text">
          Un dispositif national grand public de soutien psychologique 
          au bénéfice des personnes qui en auraient besoin est accessible via le numéro vert :
        </p>
        
    <a href="tel:0800130000" class="button button-white">
    
      0 800 130 000 <span class="option">(appel gratuit)</span>
      
      
    
    </a>
    
      </div>
      <div class="result-foot-numbers-bottom-container">
        <div class="result-foot-numbers-bottom-link-container">
          <p>Vous voulez suivre l'actualité :</p>
          <a href="https://gouvernement.fr/info-coronavirus">gouvernement.fr/info-coronavirus</a>
        </div>
        <div class="result-foot-numbers-bottom-link-container">
          <p>Vous avez des questions d'ordre général :</p>
          <a href="tel:0800130000">0 800 130 000 - (appel gratuit)</a>
        </div>
      </div>
    </div>
    
    <div class="resultFoot d-flex flex-column">
      <p class="mb-5">
        Si vos symptômes évoluent dans les heures ou les jours à venir, <strong>refaites
          ce test</strong> <br>
        ou recherchez un avis médical.
      </p>
      <a href="/se-tester" class="btn btn-primary btn-lg buttonRetake">Recommencez
        le test</a>
    </div>
    
    </div>
    @endsection