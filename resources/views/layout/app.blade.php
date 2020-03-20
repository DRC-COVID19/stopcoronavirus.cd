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

    <link href="https://fonts.googleapis.com/css?family=Rubik:400,900&display=swap" rel="stylesheet">

    <link rel="icon" href="img/logo2.png"/>

    <style type="text/css">

    h1, h2, h3, h4, h5, h6, *{font-family: 'Rubik', sans-serif}

    </style>
</head>
<body>

    <header>
        <div class="w-100 py-2 bg-raspberry">
            <div class="w80 mauto color-white">
                Rester à la maison
            </div>
        </div>

        <div id="header" class="w80 mauto pt-3 px-5">

            <div class="row">
                <div class="col-lg-5">
                    <h3><a href="#" class="">STOP COVID-19 RDC
                    </a></h3>
                </div>
                <div class="col-lg-7">
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

    <main>

  @yield('mainSection')

    </>

    <footer>

        <div class="jumbotron">
            <p class="lead">Envoyez un SMS avec le texte XXXXX au XXXX pour recevoir des alertes de mises à jour officielles.</p>
        </div>

        <div class="bg-dark">

            <div class="container">
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4"></div>
                </div>
            </div>

        </div>

    </footer>

</body>

</html>
