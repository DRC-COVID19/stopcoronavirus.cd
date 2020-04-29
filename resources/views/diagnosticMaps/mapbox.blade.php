<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.css' rel='stylesheet' />
    <link href="{{ asset('css/app.css?v=4.8') }}" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-3 mt-4">
                <h1>Carte d'orientation médicale</h1>
                
                <form  method="GET" class="well" id="form-map-filter">
                    <div class="form-group">
                        <select name="orientation" id="orientation" class="form-control">
                            <option selected value="all">Tout</option>
                            <option value="FIN1">FIN1</option>
                            <option value="FIN2">FIN2</option>
                            <option value="FIN3">FIN3</option>
                            <option value="FIN4">FIN4</option>
                            <option value="FIN5">FIN5</option>
                            <option value="FIN6">FIN6</option>
                            <option value="FIN7">FIN7</option>
                            <option value="FIN8">FIN8</option>
                        </select>
                    </div>
                    <button class="btn btn-download btn-lg">Filtrer <span class="badge badge-success" id="total-count">0</span></button>
                </form>
                <div class="pie"></div>
            </div>
            <div class="col-12 col-md-9">
                <div id='map'></div>
            </div>
        </div>
    </div>
    <div class="map-waiting d-none" id="map-waiting">
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
        <p>Fetching Data</p>
    </div>
    <script src="{{ asset('js/app.js?v=1.7') }}" defer></script>
</body>
</html>
