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

    {{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous"/> --}}
    <!-- end icon -->
    <!-- Scripts -->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,700,900&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css?v=4.91') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js?v=1.91') }}" defer></script>

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
                        <div class="col-2 d-md-none align-items-center d-flex">
                            <nav role="navigation" id="navigation">
                                <div id="menuToggle">
                                    <input type="checkbox" />
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <ul id="menu">
                                        <a href="{{route('home')}}" class="px-md-2 {{ Route::currentRouteName()== 'home' ? 'active' : '' }}">
                                            <li> Situation actuelle</li>
                                        </a>
                                        <a href="#" class="px-md-2">
                                            <li>{{__('Tout savoir sur le covid-19')}}</li>
                                        </a>
                                        <a href="{{route('preventativeMeasures')}}" class="px-md-2 {{ Route::currentRouteName()== 'preventativeMeasures' ? 'active' : '' }}">
                                            <li>{{__('Comment se protéger')}}</li>
                                        </a>
                                        <a href="{{route('officialMeasure')}}" class="px-md-2 {{ Route::currentRouteName()== 'officialMeasure' ? 'active' : '' }}">
                                            <li>{{__('Directives du Gouvernement')}}</li>
                                        </a>
                                        <a href="{{route('diagnostic')}}" class="px-md-2 {{ Route::currentRouteName()=='diagnostic'|| Route::currentRouteName()=='selfTest.get'|| Route::currentRouteName()=='seltTest.post' ? 'active' : '' }}">
                                            <li>Orientation Médicale</li>
                                        </a>
                                        <a href="{{route('preventativeMeasures')}}" class="px-md-2 {{ Route::currentRouteName()== 'preventativeMeasures' ? 'active' : '' }}">
                                            <li> Mesures de protection</li>
                                        </a>
                                        <a href="{{route('officialMeasure')}}" class="px-md-2 {{ Route::currentRouteName()== 'officialMeasure' ? 'active' : '' }}">
                                            <li> Directives du Gouvernement </li>
                                        </a>
                                        <a href="{{route('stereotypes')}}" class="px-md-2 {{ Route::currentRouteName()=='stereotypes' ? 'active' : '' }}">
                                            <li>Vrai ou Faux</li>
                                        </a>
                                        <a class="px-md-2" target="_blank" href="https://factcheck.stopcoronavirusrdc.info/">
                                            <li>{{__('Fact-checking')}} <span class="fas fa-external-link-alt"></span></li>
                                        </a>
                                        <a href="{{route('sondages')}}" class="px-md-2 {{ Route::currentRouteName()=='sondages' ? 'active' : '' }}">
                                            <li> Sondage</li>
                                        </a>

                                        <a href="{{route('aboutCmr')}}" class="px-md-2 {{ Route::currentRouteName()=='aboutCmr' ? 'active' : '' }}">
                                            <li> A propos du CMR</li>
                                        </a>

                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <div class="col-lg-6 col-10">
                            <p class="text-white m-0">
                                {{ __('messages.0')}}
                            </p>
                        </div>
                        <div class="col-lg-6 text-center text-md-right div-radio ">
                            <hr class="d-md-none">
                            <p class="text-white m-0"><span class="fa fa-broadcast-tower"></span> <span><strong><a class="text-white" target="_blank" href="https://www.radioking.com/radio/min-sante-fm">95.7 FM</a></strong> la radio du ministère de la santé</span></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="pt-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="App-Header--logo mb-1">
                            <a href="{{route('home')}}" class="">
                                <img src="{{asset('img/logo_stop_coronavirus_rdc.png')}}" class="img-fluid" alt="STOP COVID-19 RDC">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9 d-none d-md-block">
                        <div class="d-flex flex-md-row flex-column justify-content-end mb-3 mt-2 hidden-sm">
                            <img src="{{asset('img/partners_top.png')}}" height="55" width="200" class="img-fluid" alt="">
                        </div>
                        <ul class="d-flex flex-md-row flex-column justify-content-end App-Header--navbar">
                            <li class="{{ Route::currentRouteName()== 'home' ? 'active' : '' }}"> <a href="{{route('home')}}" class="px-md-2 nav-item ">Situation actuelle</a></li>
                            <li class="{{ Route::currentRouteName()== 'preventativeMeasures'||Route::currentRouteName()== 'officialMeasure'  ? 'active' : '' }}"> <a href="#" class="px-md-2 nav-item"> <span> {{__("Covid-19")}}</span> <span class="chevron fas fa-chevron-down"></span></a>
                                <ul>
                                    <li><a class="sub-nav-item" href="{{route('preventativeMeasures')}}">{{__('Tout savoir sur le covid-19')}}</a></li>
                                    {{-- <li><a class="sub-nav-item" >{{__('Comment se protéger')}}</a></li> --}}
                                    <li><a class="sub-nav-item" href="{{route('officialMeasure')}}">{{__('Directives du Gouvernement')}}</a></li>
                                </ul>
                            </li>
                            <li class="{{ Route::currentRouteName()=='diagnostic'|| Route::currentRouteName()=='selfTest.get'|| Route::currentRouteName()=='seltTest.post' ? 'active' : '' }}"> <a href="{{route('diagnostic')}}" class="px-md-2 nav-item ">Orientation Médicale</a></li>

                            <li class="{{ Route::currentRouteName()=='stereotypes'||Route::currentRouteName()=='sondages' ? 'active' : '' }}"> <a href="#" class="px-md-2 nav-item">{{__("Vrai ou Faux & sondage")}} <span class="chevron fas fa-chevron-down"></span></a>
                                <ul>
                                    <li><a class="sub-nav-item" href="{{route('stereotypes')}}">{{__('Vrai ou Faux ?')}}</a></li>
                                    <li><a title="{{__('Plateforme de signallement des fakenews et de fact checking concernant le COVID-19.')}}" class="sub-nav-item" target="_blank" href="https://factcheck.stopcoronavirusrdc.info/">{{__('Fact-checking')}} <span class="fas fa-external-link-alt"></span> </a></li>
                                    <li><a class="sub-nav-item" href="{{route('sondages')}}">{{__('Sondage')}}</a></li>
                                </ul>
                            </li>
                            <li class="{{ Route::currentRouteName()== 'aboutCmr'  ? 'active' : '' }}"> <a href="{{route('aboutCmr')}}" class="px-md-2 nav-item ">A propos du CMR</a></li>
                            {{-- <li class="{{ Route::currentRouteName()== 'officialMeasure' ? 'active' : '' }}"> <a href="{{route('officialMeasure')}}" class="px-md-2 nav-item ">Directives du Gouvernement</a></li> --}}


                        </ul>
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
        <div class="footer-socials">
            <div class="container">
                <div class="row">
                    <div class="col-12 p-2 text-right">
                        <a href="https://twitter.com/aniciisrdc" target="_blank" class="mr-2"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.facebook.com/ANICiisRDC/" target="_blank"><i class="fab fa-facebook-square"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="contenaire-float">
        <a href="https://wa.me/243844434444?text=salut" title="Whatsapp bot" target="_blank" class="float whatsapp">
            <i class="fab fa-whatsapp fa-2x"></i>
        </a>
    </div>
</body>
</html>
