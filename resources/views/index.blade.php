<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> Stop Coronavirus COVID-19 RDC
    </title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/rs.css">
    <link rel="stylesheet" href="css/rs.color.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,300,400,500,600" rel="stylesheet">

    <link rel="icon" href="img/logo2.png"/>
</head>
<body>

    <header>
        <div class="w-100 py-4 bg-firebrick">
            <div class="w80 mauto">
                Rester à la maison
            </div>
        </div>

        <div id="header" class="w80 mauto pt-3 px-5">

            <div class="row">
                <div class="col-lg-6">
                    <h4><a href="#">Stop Coronavirus COVID-19 RDC
                    </a></h4>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex flex-row bd-highlight mb-3">
                        <a href="#" class="px-2">Mesures de protection</a>
                        <a href="#" class="px-2">Mesures Officielles</a>
                        <a href="#" class="px-2">Alertes SMS</a>
                        <a href="#" class="px-2">Idées reçues</a>
                    </div>
                </div>
            </div>
        </div>

    </header>

    <body>

        <div class="jumbotron">
            <h1 class="display-4">Recevez des alertes texte sur le coronavirus
            </h1>
            <p class="lead">Envoyez un SMS avec le texte XXXXX au XXXX pour recevoir des alertes de mises à jour officielles.</p>
          </div>

          <div class="w80 mauto">

            <div class="row">
                  <div class="col-lg-4">
                      <a href=""></a>
                  </div>

                  <div class="col-lg-8">
                      <h5>Mesures de protection essentielles contre le nouveau coronavirus
                    </h5>
                    <p>Tenez-vous au courant des dernières informations sur la flambée de COVID-19, disponibles sur le site Web de l’OMS et auprès des autorités de santé publique nationales et locales. La COVID-19 continue de toucher surtout la population de la Chine, même si des flambées sévissent dans d’autres pays. La plupart des personnes infectées présentent des symptômes bénins et guérissent, mais d’autres peuvent avoir une forme plus grave. Prenez soin de votre santé et protégez les autres en suivant les conseils ci-après :
                    </p>
                  </div>
              </div>

              <div class="row">
                <div class="col-lg-4">
                    <a href=""></a>
                </div>

                <div class="col-lg-8">
                    <h5>Alertes SMS
                    </h5>
                  <p>Voir toutes les alertes texte envoyées au sujet de COVID-19. Cette page sera mise à jour au fur et à mesure de l'envoi des alertes.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <a href=""></a>
                </div>

                <div class="col-lg-8">
                    <h5>En finir avec les idées reçues
                    </h5>
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                </div>
            </div>

        </div>

          </div>

    </body>

    <footer></footer>

</body>

</html>
