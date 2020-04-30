<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.css' rel='stylesheet' />
    <link href="{{ asset('css/app.css?v=4.91') }}" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-3 mt-4">
                <h1>{{__("Carte d'orientation médicale")}}</h1>
                <hr>
                <h3>{{__("Legende")}}</h3>
                <div class="legende">
                    <div><span class="fin-8"></span> {{__("Peu probale")}}</div>
                    <div><span class="fin"></span> {{__("Probable")}}</div>
                    <div><span class="fin-5"></span> {{__("Très probable")}}</div>
                </div>
            </div>
            <div class="col-12 col-md-9">
                <div id='map'></div>
            </div>
        </div>
    </div>
    <div class="map-waiting d-none" id="map-waiting">
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
        <p>{{__("Fetching Data")}}</p>
    </div>
    <script src="{{ asset('js/app.js?v=1.81') }}" defer></script>
</body>
</html>
