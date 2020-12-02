@extends('layout.app')
@section('title', 'Situation Épidémiologique en RDC')
@section('content')
<div class="jumbotron jumbotron-title">
    <div class="container">
        <h1>Impacts socio-économiques du COVID-19</h1>
        <p class="lead">Enquêtes auprès des ménages en République démocratique du Congo</p>
        {{-- <a href="{{asset('/sondage/2020_04_14 Sondage_COVID_19_en_RDC.pdf')}}" target="_blank" class="btn btn-download" download>{{__("Télécharger le rapport complet")}}</a> --}}
        <a href="http://covidenquetemenage.opendatadrc.io/" target="_blank" class="btn btn-primary">Consulter les résultats</a>
      </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <p>
              Une série d'enquêtes visant à évaluer les impacts de la pandémie COVID-19 sur les ménages en RDC
              est menée conjointement par ELAN RDC et Kinshasa Digital avec le soutien d'Orange et d'UKAid.
              L’objectif de ces enquêtes est de fournir des données factuelles pour guider les décideurs publics
              ainsi que les acteurs des secteurs privé et associatif dans leurs initiatives destinées à lutter
              contre les effets socio-économiques négatifs de la pandémie.
            </p>
        </div>
        <div class="col-12 col-md-6">
            <h3 class="mb-4">Principales conclusions</h3>
            <div class="sondage-items">
                <div class="sondage-item">
                    <span> 57%</span>
                    <p>La proportion des ménages déclarant une baisse de leurs revenus comparativement au niveau précédant la pandémie reste élevée</p>
                </div>
                <div class="sondage-item">
                  <span> 57%</span>
                  <p>des ménages ont signalé une augmentation des coûts auxquels ils ont dû faire face en septembre comparativement au mois d’août où cette proportion était de 50%.</p>
                </div>
                <div class="sondage-item">
                  <span> 89%</span>
                  <p>des ménages estiment que la pandémie aura un impact négatif à long terme sur leurs finances.</p>
                </div>
                <div class="sondage-item">
                  <span> 2/3</span>
                  <p>des ménages à faibles revenus ont vu leur consommation en nourriture et en eau diminuer comparativement au niveau précédant la pandémie.</p>
                </div>
                <div class="sondage-item">
                  <span>39%</span>
                  <p>des ménages ne savent pas s'ils pourront effectuer leur prochain remboursement de dette.</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 sondage-methods">
            <h3 class="mb-4">Portée</h3>
            <div class="sondage-methods-items">
                <div class="sondage-methods-item">
                    <div class="illustrator">
                        <img src="{{ asset('/img/icon/list.png')}}" />
                    </div>
                    <p>2200 sondés</p>
                </div>
                <div class="sondage-methods-item">
                    <div class="illustrator">
                        <img src="{{ asset('/img/icon/calendar.png')}}" />
                    </div>
                    <p>Du 22 Septembre au 13 Octobre 2020</p>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4 mb-4">
            <h3 class="mb-4">{{__("Méthodologie")}}</h3>
            <p>Les répondants sont atteints par le contact d'au moins un de leurs membres adultes dans les
              régions suivantes: Kinshasa et autres. Le contact est établi à partir d'une grande base de
              données de numéros de téléphone répertoriés dans la base de données du centre d'appels
              indépendant qui effectue des appels sortants vers des répondants potentiels. <br><br>
              Ils sont contactés par un appel téléphonique du lundi au vendredi entre 8h30 et 17h00.
              Ces appels sont effectués par des intervieweurs bilingues. Ils constituent un ensemble
              d'interlocuteurs capables de converser dans toutes les langues nationales de la RDC.</p>
        </div>
        <div class="col-12 mb-5">
          <img src="{{asset('/img/Orange_logo.svg')}}" alt="" class="mr-3" height="50px">
          <img src="{{asset('/img/elan-rdc-logo.png')}}" class="mr-3" alt="" height="50px">
          <img src="{{asset('/img/logo_kinshasa_digital.png')}}" class="mr-3" alt="" height="50px">
          <img src="{{asset('/img/ukaid-logo-6FCE8595F5-seeklogo.com.png')}}" class="mr-3" alt="" height="50px">
        </div>
    </div>
</div>
@endsection
