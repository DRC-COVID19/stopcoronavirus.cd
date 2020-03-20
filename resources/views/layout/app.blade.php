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
    <header class="App-Header">
        <div class=" py-2 App-Header--notice">
            <div class="container">
                <p class="text-white m-0 text-right">
                    Rester à la maison
                </p>
            </div>
        </div>

        <div class="pt-3 px-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="App-Header--logo">
                        <a href="{{route('home')}}" class="">
                            <img src="{{asset('img/logo.png')}}" class="img-fluid" alt="STOP COVID-19 RDC">
                        </a>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="d-flex flex-row justify-content-end mb-3 App-Header--navbar">
                            <a href="{{route('preventativeMeasures')}}" class="px-2">Mesures de protection</a>
                            <a href="{{route('officialMeasure')}}" class="px-2">Mesures Officielles</a>
                            <a href="{{route('home')}}" class="px-2">Alertes SMS</a>
                            <a href="{{route('stereotypes')}}" class="px-2">Idées reçues</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>

    <main>
    @yield('content')
    </main>
    <footer class="">
        <div class="mb-0 jumbotron">
            <div class="container">
                <p class="lead tect-center">Envoyez un SMS avec le texte XXXXX au XXXX pour recevoir des alertes de mises à jour officielles.</p>
            </div>
        </div>
    </footer>
</body>
</html>
