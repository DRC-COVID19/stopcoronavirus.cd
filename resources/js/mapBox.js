var $ = require("jquery");

mapboxgl.accessToken = 'pk.eyJ1IjoibWVya2kyMzAiLCJhIjoiY2s5aWdkejJzMDhybTNkcWxtMm9la2h4aCJ9.5NwFpUn264STu43zxmTyOw';
var map = new mapboxgl.Map({
    container: 'map'
    , center: [15.31389, -4.33167]
    , zoom: 5
    , style: 'mapbox://styles/mapbox/streets-v11'
});

$.get('/api/maps-stat', function (data) {
    data.forEach(function (marker) {
        // create a DOM element for the marker
        var el = document.createElement('div');
        el.className = 'custom-clustericon custom-clustericon-2';
        var el2 = document.createElement('div');
        el2.className = "second-cluster-icon";
        var elSpan = document.createElement('span');
        elSpan.textContent = marker.count;
        el2.appendChild(elSpan);
        el.appendChild(el2);
    
        // add marker to map
        new mapboxgl.Marker(el)
            .setLngLat([marker.longitude,marker.latitude])
            .addTo(map);
    });
    
});
