var $ = require("jquery");
let AllMarkers = [];
$(function () {
    let hoveredStateId = null;
    let hoveredStateIdKin = null;
    let elementCheck = $("#map");
    if (elementCheck.length == 0) {
        return;
    }
    mapboxgl.accessToken = 'pk.eyJ1IjoibWVya2kyMzAiLCJhIjoiY2s5aWdkejJzMDhybTNkcWxtMm9la2h4aCJ9.5NwFpUn264STu43zxmTyOw';
    var map = new mapboxgl.Map({
        container: 'map'
        , center: [15.31389, -4.33167]
        , zoom: 10
        , style: 'mapbox://styles/merki230/ck9vd0zmy0lqk1jn3lpq81up8'
    });
    map.addControl(new mapboxgl.NavigationControl());
    map.on('load', function () {
        map.addSource('states', {
            'type': 'geojson',
            'generateId': true,
            'data': `${location.protocol}//${location.host}/storage/geojson/rd_congo_admin_4_provinces.geojson`
        });

        map.addSource('statesKin', {
            type: "vector",
            url: "mapbox://merki230.4airwoxt"
        });

        // The feature-state dependent fill-opacity expression will render the hover effect
        // when a feature's hover state is set to true.
        map.addLayer({
            'id': 'state-fills',
            'type': 'fill',
            'source': 'states',
            'layout': {},
            'paint': {
                'fill-color': '#627BC1',
                'fill-opacity': [
                    'case',
                    ['boolean', ['feature-state', 'hover'], false],
                    0.3,
                    0
                ]
            }
        });

        map.addLayer({
            'id': 'state-fills-kin',
            'type': 'fill',
            "minzoom": 10,
            'source': 'statesKin',
            "source-layer": "carte-administrative-de-la-vi-csh5cj",
            'layout': {},
            'paint': {
                'fill-color': '#627BC1',
                'fill-opacity': [
                    'case',
                    ['boolean', ['feature-state', 'hover'], false],
                    0.3,
                    0
                ]
            }
        });

        map.addLayer({
            'id': 'state-borders',
            'type': 'line',
            'source': 'states',
            'layout': {},
            'paint': {
                'line-color': '#627BC1',
                'line-width': 2
            }
        });

        map.addLayer({
            'id': 'state-borders-kin',
            'type': 'line',
            'source': 'statesKin',
            
            "source-layer": "carte-administrative-de-la-vi-csh5cj",
            'layout': {},
            'paint': {
                'line-color': '#627BC1',
                'line-width': 2
            }
        });

        // When the user moves their mouse over the state-fill layer, we'll update the
        // feature state for the feature under the mouse.
        map.on('mousemove', 'state-fills', function (e) {
            if (e.features.length > 0) {
                if (e.features[0].properties['ISO3166-2'] == "CD-KN") {
                    if (hoveredStateId) {
                        map.setFeatureState(
                            { source: 'states', id: hoveredStateId },
                            { hover: false }
                        );
                    }
                    hoveredStateId = null;
                    return;
                }
                if (hoveredStateId) {
                    map.setFeatureState(
                        { source: 'states', id: hoveredStateId },
                        { hover: false }
                    );
                }
                hoveredStateId = e.features[0].id;
                map.setFeatureState(
                    { source: 'states', id: hoveredStateId },
                    { hover: true }
                );
            }
        });

        map.on('mousemove', 'state-fills-kin', function (e) {
            if (e.features.length > 0) {
                if (hoveredStateIdKin) {
                    map.setFeatureState(
                        { source: 'statesKin', sourceLayer: 'carte-administrative-de-la-vi-csh5cj', id: hoveredStateIdKin },
                        { hover: false }
                    );
                }
                hoveredStateIdKin = e.features[0].id;
                map.setFeatureState(
                    { source: 'statesKin', sourceLayer: 'carte-administrative-de-la-vi-csh5cj', id: hoveredStateIdKin },
                    { hover: true }
                );
            }
        });

        // When the mouse leaves the state-fill layer, update the feature state of the
        // previously hovered feature.
        map.on('mouseleave', 'state-fills', function () {
            if (hoveredStateId) {
                map.setFeatureState(
                    { source: 'states', id: hoveredStateId },
                    { hover: false }
                );
            }
            hoveredStateId = null;
        });

        map.on('mouseleave', 'state-fills-kin', function () {
            if (hoveredStateIdKin) {
                map.setFeatureState(
                    { source: 'statesKin', sourceLayer: 'carte-administrative-de-la-vi-csh5cj', id: hoveredStateIdKin },
                    { hover: false }
                );
            }
            hoveredStateIdKin = null;
        });
    });
    //getData(map);

    $('#list_hospital').change(function (e) {
        let item = $(this);
        if (item.is(':checked')) {
            getHospitals(map);
        } else {
            map.removeLayer("covid9_hospitals_layer");
            map.removeSource('covid9_hospitals_source');
        }
    });

    $('#medical_orientation').change(function(e){
        let item=$(this);
        if (item.is(':checked')) {
            get
        }
    });
});

function addMapWaiting() {
    $('#map-waiting').removeClass('d-none');
}

function removeMapWaiting() {
    $('#map-waiting').addClass('d-none');
}

function getHospitals(map) {
    addMapWaiting()
    $.get(`/api/dashboard/hospitals`, function (data) {
        let hospitalData = data.map((value, index) => {
            return {
                type: "Feature",
                geometry: {
                    type: "Point",
                    coordinates: [value.longitude, value.latitude]
                },
                properties: {
                    name: value.name ? value.name : "Hopital",
                    address: value.address,
                    beds: value.beds,
                    occupied_beds: value.occupied_beds,
                    masks: value.masks,
                    respirators: value.respirators,
                    occupied_respirators: value.occupied_respirators,
                    confirmed: value.last_situation.confirmed,
                    dead: value.last_situation.dead,
                    sick: value.last_situation.sick,
                    healed: value.last_situation.healed,
                    last_update: value.last_situation.last_update,
                    color: "#ED5F68"
                }
            };
        });

        map.addSource("covid9_hospitals_source", {
            type: "geojson",
            data: {
                type: "FeatureCollection",
                features: hospitalData
            }
        });

        map.addLayer({
            id: "covid9_hospitals_layer",
            type: "symbol",
            source: "covid9_hospitals_source",
            minzoom: 10,
            layout: {
                "text-line-height": 1,
                "text-padding": 0,
                "text-anchor": "center",
                "text-allow-overlap": true,
                "text-ignore-placement": true,
                "text-field": String.fromCharCode("0xf47e"),
                "icon-optional": true,
                "text-font": ["Font Awesome 5 Free Solid"],
                "text-size": 30,

            },
            paint: {
                "text-translate-anchor": "viewport",
                "text-color": ["get", "color"]
            }
        });

        map.on("mouseenter", "covid9_hospitals_layer", function () {
            map.getCanvas().style.cursor = "pointer";
          });
          map.on("mouseleave", "covid9_hospitals_layer", function () {
            map.getCanvas().style.cursor = "";
          });
        removeMapWaiting();
    });

}
function getData(map, params = null) {
    addMapWaiting();
    $.get(`/api/maps-stat?${params}`, function (data) {

        AllMarkers.forEach(function (marker) {
            marker.remove();
        });
        let total = 0;

        for (const marker in data) {
            // create a DOM element for the marker
            let item = data[marker];
            var el = document.createElement('div');
            el.className = 'pie';
            let total = item.FIN + item.FIN8 + item.FIN5;

            if (total > 20) {
                el.style = "width:90px;height:90px";
            }
            else if (total > 50) {
                el.style = "width:120px;height:120px";
            }
            var elSpan = document.createElement('span');
            var elSpan2 = document.createElement('span');
            var elSpan3 = document.createElement('span');
            elSpan.className = "fin-5";
            elSpan2.className = "fin-8";
            elSpan3.className = "fin";
            elSpan.textContent = data[marker].FIN5 ?? 0;
            elSpan2.textContent = data[marker].FIN8 ?? 0;
            elSpan3.textContent = data[marker].FIN ?? 0;
            el.appendChild(elSpan);
            el.appendChild(elSpan2);
            el.appendChild(elSpan3);

            // popup 
            var popup = new mapboxgl.Popup({ offset: 25 }).setText(
                data[marker].township
            );
            // add marker to map
            let currentMarker = new mapboxgl.Marker(el)
                .setLngLat([data[marker].longitude, data[marker].latitude])
                .setPopup(popup)
                .addTo(map);
            AllMarkers.push(currentMarker);
            total += data[marker].count;
        }
        $('#total-count').text(total);
        $('#map-waiting').addClass('d-none');
    });
}