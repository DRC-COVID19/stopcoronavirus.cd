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
        , style: 'mapbox://styles/merki230/ck9lfctvs2p2a1ilooj2fddnw'
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
    getData(map);
});


function getData(map,params = null) {
    $('#map-waiting').removeClass('d-none');
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