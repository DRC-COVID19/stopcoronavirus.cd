<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.css' rel='stylesheet' />
    <link href="{{ asset('css/app.css?v=4.94') }}" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-3 column-left">
                <h1 class="row  map-form-header mb-3"><i class="fas fa-hospital-symbol"></i> {{__('Capacité Hospitalière COVID-19')}}</h1>
                {{-- <a href="{{route('admin.home')}}"><i class="fa fa-arrow-left"></i> Retour</a> --}}

                <div class="card">
                    <div class="group-control card-body">
                        <input type="checkbox" class="styled-checkbox" name="list_hospital" id="list_hospital">
                        <label for="list_hospital">{{__('Liste hôpitaux')}}</label>
                    </div>
                </div>

                <hr>
                <div class="card">
                    <div class="group-control card-header">
                        <input type="checkbox" class="styled-checkbox" name="medical_orientation" id="medical_orientation">
                        <label for="medical_orientation">{{__('Cas probable(Orientation médical)')}}</label>
                    </div>
                    <div class="group-control card-body">
                        <select name="orientation_result" disabled class="form-control mb-3" id="orientation_result">
                            <option value=""></option>
                            <option value="FIN8">{{__('Peu probable')}}</option>
                            <option value="FIN">{{__('Probable')}}</option>
                            <option value="FIN5">{{__('Très probable')}}</option>
                        </select>
                        <h4>Legende</h4>
                        <div class="legende">
                            <div><span class="fin-8"></span> Peu probale</div>
                            <div><span class="fin"></span> Probable</div>
                            <div><span class="fin-5"></span> Très probable</div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card">
                    <div class="group-control card-header">
                        <input type="checkbox" class="styled-checkbox" name="has_sondage" id="has_sondage">
                        <label for="has_sondage">Sondages</label>
                    </div>
                    <div class="card-body " id="sondage-item">
                        <div class="group-control">
                            <input type="checkbox" class="styled-checkbox" name="worried" id="worried">
                            <label for="worried">Sont inquiet ou très inquiet</label>
                        </div>
                        <div class="group-control">
                            <input type="checkbox" class="styled-checkbox" name="not_work" id="not_work">
                            <label for="not_work">Ne peuvent déjà plus travailler</label>
                        </div>
                        <div class="group-control">
                            <input type="checkbox" class="styled-checkbox" name="toll_free_number" id="toll_free_number">
                            <label for="toll_free_number">Appellerait le numéro vert en cas de symptômes</label>
                        </div>
                        <div class="group-control">
                            <input type="checkbox" class="styled-checkbox" name="price_increase" id="price_increase">
                            <label for="price_increase">Constatent une augmentation des prix des denrées essentielles</label>
                        </div>
                        <div class="group-control">
                            <input type="checkbox" class="styled-checkbox" name="other_difficulty" id="other_difficulty">
                            <label for="other_difficulty">Ont des difficultés à trouver des masques, 29% du charbon et de la farine, 28% de la Chloroquine, 26% de la Viande et des légumes</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-9 p-0">

                <div id='map'></div>
            </div>
        </div>
    </div>
    <div class="map-waiting d-none" id="map-waiting">
        <div class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <p>{{__("Fetching Data")}}</p>
    </div>
    <script src="{{ asset('js/app.js?v=1.84') }}" defer></script>
</body>
</html>
