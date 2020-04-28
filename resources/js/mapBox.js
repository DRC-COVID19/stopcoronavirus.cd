var $ = require("jquery");
let AllMarkers=[];

mapboxgl.accessToken = 'pk.eyJ1IjoibWVya2kyMzAiLCJhIjoiY2s5aWdkejJzMDhybTNkcWxtMm9la2h4aCJ9.5NwFpUn264STu43zxmTyOw';
var map = new mapboxgl.Map({
    container: 'map'
    , center: [15.31389, -4.33167]
    , zoom: 10
    , style: 'mapbox://styles/mapbox/streets-v11'
});
$(function () {
    getData();

    $('#form-map-filter').submit(function (e) {
        e.preventDefault();
        let dataForm=$("#form-map-filter").serialize();
        console.log(dataForm);
        getData(dataForm);
    });
});

function getData(params=null) {
    $('#map-waiting').removeClass('d-none');
    $.get(`/api/maps-stat?${params}`, function (data) {
        AllMarkers.forEach(function (marker) {
            marker.remove();
        });
        let total=0;
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
    
            // popup 
            var popup = new mapboxgl.Popup({ offset: 25 }).setText(
                marker.township
                );
            // add marker to map
            let currentMarker=new mapboxgl.Marker(el)
                .setLngLat([marker.longitude,marker.latitude])
                .setPopup(popup)
                .addTo(map);
            AllMarkers.push(currentMarker);
            total+=marker.count;
        });
        $('#total-count').text(total);
        $('#map-waiting').addClass('d-none');
    });
}