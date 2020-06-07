@extends('layout.app')
@section('title', 'Situation Épidémiologique en RDC')
@section('content')
<div class="jumbotron jumbotron-title">
    <div class="container">
        <h1>{{__('Craintes et réactions au COVID-19')}}</h1>
        <p class="lead">Résultats du sondage COVID-19 en République Démocratique du Congo
            Craintes et réactions face au Coronavirus</p>
        <a href="{{asset('/sondage/2020_04_14 Sondage_COVID_19_en_RDC.pdf')}}" target="_blank" class="btn btn-download" download>{{__("Télécharger le rapport complet")}}</a>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12 mb-4">
            <p>
                Une étude quantitative examinant le niveau de sensibilisation, les besoins, les craintes et les inquiétudes de 718 sondés représentant 26 provinces de la RDC a été entreprise par Kinshasa Digital et l'Agence Nationale d'Ingénierie Clinique, de l'Information et de l'Information de Santé (ANICiiS), dans le but d’apporter une aide et une orientation supplémentaire à l'équipe de riposte pour mieux contrer le coronavirus.
            </p>
        </div>
        <div class="col-12 col-md-6">
            <h3 class="mb-4">5 principales constatations</h3>
            <div class="sondage-items">
                <div class="sondage-item">
                    <span> 70%</span>
                    <p>Sont inquiet ou très inquiet</p>
                </div>
                <div class="sondage-item">
                    <span>18%</span>
                    <p>Ne peuvent déjà plus travailler</p>
                </div>
                <div class="sondage-item">
                    <span>36%</span>
                    <p>Appellerait le numéro vert en cas de symptômes</p>
                </div>
                <div class="sondage-item">
                    <span>76%</span>
                    <p>Constatent une augmentation des prix des denrées essentielles</p>
                </div>
                <div class="sondage-item">
                    <span>34%</span>
                    <p>Ont des difficultés à trouver des masques, 27% du charbon et de la farine, 26% de la Chloroquine, 25% de la
                        Viande et des légumes</p>
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
                    <p>1770 sondés</p>
                </div>
                <div class="sondage-methods-item">
                    <div class="illustrator">
                        <img src="{{ asset('/img/icon/calendar.png')}}" />
                    </div>
                    <p>du jeudi 2 avril au
                        mardi 22 mai 2020</p>
                </div>
                <div class="sondage-methods-item">
                    <div class="illustrator">
                        <img src="{{ asset('/img/icon/maps.png')}}" />
                    </div>
                    <p>26 provinces représentées
                        1770 sondés</p>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4 mb-4">
            <h3 class="mb-4">{{__("Méthodologies")}}</h3>
            <p>Compte tenu de la distanciation sociale recommandée, le formulaire a été partagé
                en ligne en ciblant la population congolaise sur :</p>
            <ul>
                <li>
                    Les médias sociaux tels que : Facebook, WhatsApp, Twitter, LinkedIn via les comptes de l’ANICiiS.
                </li>
                <li>Ainsi que par courrier électronique envoyé à la base de données des contacts
                    de Kinshasa Digital.</li>
            </ul>
        </div>
        <div class="col-12 mb-5">
            <a href="{{asset('/sondage/2020_04_14 Sondage_COVID_19_en_RDC.pdf')}}" target="_blank" class="btn btn-download" download>{{__("Télécharger le rapport complet")}}</a>
        </div>
    </div>
</div>
@endsection
