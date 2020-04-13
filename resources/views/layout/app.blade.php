<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="Stop Coronavirus COVID-19 RDC - @yield('title')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.stopcoronavirusrdc.info">
    <meta property="og:image" content="https://www.stopcoronavirusrdc.info/img/og.jpg" />
    <title>Stop Coronavirus COVID-19 RDC - @yield('title')</title>
    <!-- icon -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{asset('/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{asset('/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#00b065">
    <!-- end icon -->
    <!-- Scripts -->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,700,900&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css?v=1') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js?v=1') }}" defer></script>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime()
                , event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0]
                , j = d.createElement(s)
                , dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-M82BXK9');

    </script>
    <!-- End Google Tag Manager -->
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M82BXK9" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <header class="App-Header">
        <div>
            <div class=" py-2 App-Header--notice">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="text-white m-0">
                                {{ __('messages.0')}}
                            </p>
                        </div>
                        <div class="col-lg-6">
                            <p class="text-white m-0 text-right d-none">
                                #RestezChezVous
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


        <div class="pt-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="App-Header--logo mb-1">
                            <a href="{{route('home')}}" class="">
                                <img src="{{asset('img/logo_stop_coronavirus_rdc.png')}}" class="img-fluid" alt="STOP COVID-19 RDC">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-8 d-none d-md-block">
                        <div class="d-flex flex-md-row flex-column justify-content-end mb-3 mt-2 hidden-sm">
                            <img src="img/partners_top.png" height="55" width="200" class="img-fluid" alt="">
                        </div>
                        <div class="d-flex flex-md-row flex-column justify-content-end App-Header--navbar">
                            <a href="{{route('home')}}" class="px-md-2 {{ Route::currentRouteName()== 'home' ? 'active' : '' }}">Situation actuelle</a>
                            <a href="{{route('preventativeMeasures')}}" class="px-md-2 {{ Route::currentRouteName()== 'preventativeMeasures' ? 'active' : '' }}">Mesures de protection</a>
                            <a href="{{route('officialMeasure')}}" class="px-md-2 {{ Route::currentRouteName()== 'officialMeasure' ? 'active' : '' }}">Directives du Gouvernement</a>
                            <a href="{{route('stereotypes')}}" class="px-md-2 {{ Route::currentRouteName()=='stereotypes' ? 'active' : '' }}">Idées reçues</a>
                            <a href="{{route('selfTest.get')}}" class="px-md-2 {{ Route::currentRouteName()=='selfTest.get'|| Route::currentRouteName()=='seltTest.post' ? 'active' : '' }}">Test Covid-19</a>
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
            <div class="container text-center">
                <img src="{{asset('img/partners_small.png')}}" class="img-fluid" alt="Partenaires">
            </div>
        </div>
        <div class="footer-partners">
            <div class="container">
                <div class="row align-items-end">
                    <div class="col-lg-8 col-md-12 col-lg-offset-2 col-md-offset-0 pb-2">
                        <p>
                            {{ __("Avec l'appui d'Internews au travers du projet Médias2I de l'Union Européenne et du programme MSDA financé par l'USAID avec un financement complémentaire de la Coopération Suédoise") }}
                        </p>
                        <p>
                            <img src="img/Logo_UE_MSDA_USAID.png" class="img-fluid" alt="Logo UE, USAID, Sverige, fhi360, Internews">
                        </p>
                        <p>
                            {{ __('Un projet réalisé avec le soutien de la Fondation Roi Baudouin et de la Loterie Nationale') }}
                        </p>
                        <p class="pt-4">
                            Designed by <a href="https://www.kinshasadigital.com" target="_blank">Kinshasa Digital</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
