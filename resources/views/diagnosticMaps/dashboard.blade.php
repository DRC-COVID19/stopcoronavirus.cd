<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dashboard COVID-19 RDC</title>
  <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css" rel="stylesheet" />
<<<<<<< HEAD
  <link href="{{ mix('css/vueApp.css?v=2.896') }}" rel="stylesheet">
=======
  <link href="{{ asset('css/vueApp.css?v=2.898') }}" rel="stylesheet">
>>>>>>> dev
</head>
<body>
  <div id="app">
    <div class="map-waiting" id="map-waiting">
      <div class="lds-ring">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
      </div> 
      <p>Fetching Data</p>
    </div>

<<<<<<< HEAD
    <script src="{{mix('js/vueApp.js?v=2.896') }}"></script>
=======
    <script src="{{asset('js/vueApp.js?v=2.898') }}"></script>
>>>>>>> dev

</body>
</html>
