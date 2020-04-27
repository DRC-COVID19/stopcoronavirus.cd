<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.css' rel='stylesheet' />
    
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 100%;
        }

        /* Optional: Makes the sample page fill the window. */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .custom-clustericon-2 {
            --cluster-color: #FF9B00;
        }

        .custom-clustericon {
            background: var(--cluster-color);
            color: #fff;
            border-radius: 100%;
            font-weight: 700;
            font-size: 15px;
            display: flex;
            align-items: center;
            width: 40px;
            height: 40px;
        }



        .custom-clustericon::before {
            padding: 16px;
        }

        .custom-clustericon::after {
            padding: 8px;
        }
        .custom-clustericon::before,
        .custom-clustericon::after {
            content: '';
            display: block;
            position: absolute;
            width: 100%;
            height: 100%;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            background: var(--cluster-color);
            opacity: .2;
            border-radius: 100%;
        }

        .second-cluster-icon {
            position: absolute;
            text-align: center;
            width: 40px;
        }

    </style>
</head>
<body>
    <div id='map'></div>
    <script src="{{ asset('js/app.js?v=1.6') }}" defer></script>
</body>
</html>
