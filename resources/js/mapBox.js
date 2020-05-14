var $ = require("jquery");
let AllMarkers = [];
let AllDianosticData = [];
let AllSondagesData = [];
let AllSondagesMarkers = [];
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
        // map.addLayer({
        //     'id': 'state-fills',
        //     'type': 'fill',
        //     'source': 'states',
        //     'layout': {},
        //     'paint': {
        //         'fill-color': '#627BC1',
        //         'fill-opacity': [
        //             'case',
        //             ['boolean', ['feature-state', 'hover'], false],
        //             0.3,
        //             0
        //         ]
        //     }
        // });

        // map.addLayer({
        //     'id': 'state-fills-kin',
        //     'type': 'fill',
        //     "minzoom": 10,
        //     'source': 'statesKin',
        //     "source-layer": "carte-administrative-de-la-vi-csh5cj",
        //     'layout': {},
        //     'paint': {
        //         'fill-color': '#627BC1',
        //         'fill-opacity': [
        //             'case',
        //             ['boolean', ['feature-state', 'hover'], false],
        //             0.3,
        //             0
        //         ]
        //     }
        // });

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
        // map.on('mousemove', 'state-fills', function (e) {
        //     if (e.features.length > 0) {
        //         if (e.features[0].properties['ISO3166-2'] == "CD-KN") {
        //             if (hoveredStateId) {
        //                 map.setFeatureState(
        //                     { source: 'states', id: hoveredStateId },
        //                     { hover: false }
        //                 );
        //             }
        //             hoveredStateId = null;
        //             return;
        //         }
        //         if (hoveredStateId) {
        //             map.setFeatureState(
        //                 { source: 'states', id: hoveredStateId },
        //                 { hover: false }
        //             );
        //         }
        //         hoveredStateId = e.features[0].id;
        //         map.setFeatureState(
        //             { source: 'states', id: hoveredStateId },
        //             { hover: true }
        //         );
        //     }
        // });

        // map.on('mousemove', 'state-fills-kin', function (e) {
        //     if (e.features.length > 0) {
        //         if (hoveredStateIdKin) {
        //             map.setFeatureState(
        //                 { source: 'statesKin', sourceLayer: 'carte-administrative-de-la-vi-csh5cj', id: hoveredStateIdKin },
        //                 { hover: false }
        //             );
        //         }
        //         hoveredStateIdKin = e.features[0].id;
        //         map.setFeatureState(
        //             { source: 'statesKin', sourceLayer: 'carte-administrative-de-la-vi-csh5cj', id: hoveredStateIdKin },
        //             { hover: true }
        //         );
        //     }
        // });

        // When the mouse leaves the state-fill layer, update the feature state of the
        // previously hovered feature.
        // map.on('mouseleave', 'state-fills', function () {
        //     if (hoveredStateId) {
        //         map.setFeatureState(
        //             { source: 'states', id: hoveredStateId },
        //             { hover: false }
        //         );
        //     }
        //     hoveredStateId = null;
        // });

        // map.on('mouseleave', 'state-fills-kin', function () {
        //     if (hoveredStateIdKin) {
        //         map.setFeatureState(
        //             { source: 'statesKin', sourceLayer: 'carte-administrative-de-la-vi-csh5cj', id: hoveredStateIdKin },
        //             { hover: false }
        //         );
        //     }
        //     hoveredStateIdKin = null;
        // });
    });
    map.on('zoomend', function () {
        var currentZoom = map.getZoom();
        // AllSondagesMarkers.map((item) => {
        //     if (currentZoom < 9) {
        //         item.setOffset([0, 0]);
        //     }
        //     else {
        //         item.setOffset(item.defaultOffset);
        //     }
        // });

        // AllMarkers.map((item) => {
        //     if (currentZoom < 9) {
        //         item.setOffset([0, 0]);
        //     }
        //     else {
        //         item.setOffset(item.defaultOffset);
        //     }
        // });

    });
    $('#hospital-data-close').click(function (e) {
        $('#hospital-data').addClass('d-none');
    });

    $('#list_hospital').change(function (e) {
        let item = $(this);
        if (item.is(':checked')) {
            getHospitals(map);
        } else {
            map.off("mouseenter", "covid9_hospitals_layer");
            map.off("mouseleave", "covid9_hospitals_layer");
            map.off("click", "covid9_hospitals_layer");
            map.removeLayer("covid9_hospitals_layer");
            map.removeSource('covid9_hospitals_source');
            $('#hospital-data').addClass('d-none');
        }
    });

    $('#medical_orientation').change(function (e) {
        let item = $(this);
        if (item.is(':checked')) {
            getAllDianostics(map);
            $('#orientation_result').removeAttr('disabled');
        }
        else {
            RemoveDianosticMakers();
            $('#orientation_result').attr('disabled', 'disabled');
        }
    });

    $('#orientation_result').change(function (e) {
        let item = $(this);
        if (item.val()) {
            getUniqueDiagnostics(item.val(), map);
        } else {
            getAllDianostics(map);
        }

    });

    $("#has_sondage").change(function (e) {
        let item = $(this);
        if (item.is(':checked')) {
            getAllSondages();
            $('#sondage-item input').removeAttr('disabled');
        } else {
            $('#sondage-item input').attr('disabled', 'disabled');
            $('#sondage-item input').prop('checked', false);
            AllSondagesMarkers.map((item) => {
                item.remove();
            });
        }
    });

    $("#sondage-item input").change(function (e) {
        let item = $(this);
        if (item.is(':checked')) {
            setMarkersSondage(item.attr('id'), map);
        } else {
            let sondage = item.attr('id');
            AllSondagesMarkers.filter(x => x[sondage]).map((item) => {
                item.remove();
            });
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
                    confirmed: value.last_situation ? value.last_situation.confirmed : 0,
                    dead: value.last_situation ? value.last_situation.dead : 0,
                    sick: value.last_situation ? value.last_situation.sick : 0,
                    healed: value.last_situation ? value.last_situation.healed : 0,
                    last_update: value.last_situation ? value.last_situation.last_update : 0,
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
            // minzoom: 10,
            layout: {
                "text-line-height": 1,
                "text-padding": 0,
                "text-anchor": "center",
                "text-allow-overlap": true,
                "text-ignore-placement": true,
                "text-field": String.fromCharCode("0xf47e"),
                "icon-optional": true,
                "text-font": ["Font Awesome 5 Free Solid"],
                "text-size": [
                    "interpolate", ["linear"], ["zoom"],
                    5, 10,
                    10, 25
                ],

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

        map.on("click", "covid9_hospitals_layer", function (e) {
            const coordinates = e.features[0].geometry.coordinates.slice();
            const {
                name,
                address,
                beds,
                occupied_beds,
                masks,
                respirators,
                occupied_respirators,
                confirmed,
                dead,
                sick,
                healed,
                last_update,
            } = e.features[0].properties;


            // computed properties
            const active = confirmed - dead - healed;
            const bedsAvailable = beds - occupied_beds;
            const respiratorsAvailable = respirators - occupied_respirators;

            $('#hospital_name').text(name);
            $('#hospital_address').text(address);
            $('#beds').text(`${bedsAvailable} sur ${beds}`);
            $('#masks').text(masks);
            $('#respirators').text(`${respiratorsAvailable} sur ${respirators}`);
            $('#sick_confirmed').text(confirmed);
            $('#sick_active').text(active);
            $('#sick_recovered').text(healed);
            $('#sick_death').text(dead);

            const HTML = `
      <div>
        <div class="hospital-name">${name}</div>
      </div>
      `;

            new mapboxgl.Popup().setLngLat(coordinates).setHTML(HTML).addTo(map);
            $('#hospital-data').removeClass('d-none');
        });

        // Change the cursor to a pointer when the mouse is over the covid9 layer.
        map.on("mouseenter", "covid9", function () {
            map.getCanvas().style.cursor = "pointer";
        });

        removeMapWaiting();
    });

}

function RemoveDianosticMakers() {
    AllMarkers.forEach(function (marker) {
        marker.remove();
    });
}
function getAllDianostics(map) {
    addMapWaiting();
    $.get(`/api/dashboard/orientation-medical-result`, function (data) {
        RemoveDianosticMakers();
        AllDianosticData = [];
        let total = 0;
        for (const marker in data) {
            // create a DOM element for the marker
            let item = data[marker];
            AllDianosticData.push(item);
            var el = document.createElement('div');
            el.className = 'pie';
            let total = item.FIN + item.FIN8 + item.FIN5;

            if (total > 50) {
                el.style = "width:40px;height:40px;";
            }
            let elSpan = document.createElement('span');
            let elSpan2 = document.createElement('span');
            let elSpan3 = document.createElement('span');
            elSpan.className = "fin-5";
            elSpan2.className = "fin-8";
            elSpan3.className = "fin";
            elSpan.textContent = data[marker].FIN5 ?? 0;
            elSpan2.textContent = data[marker].FIN8 ?? 0;
            elSpan3.textContent = data[marker].FIN ?? 0;
            el.appendChild(elSpan);
            el.appendChild(elSpan2);
            el.appendChild(elSpan3);

            let longitude = data[marker].longitude;
            let latitude = data[marker].latitude;
            

            if (data[marker].province.toUpperCase() != "KINSHASA") {
                longitude = (Number(longitude) + (500 / 100000)).toFixed(5);
                latitude = (Number(latitude) - (300 / 100000)).toFixed(5);
            }

            // popup 
            let popup = new mapboxgl.Popup({ offset: 25 }).setText(
                data[marker].township
            );
            // add marker to map
            let offSet = { offset: [-70, 30] };
            let currentMarker = new mapboxgl.Marker(el
                // , map.getZoom() < 9 ? { offset: [0, 0] } : offSet
            )
                .setLngLat([longitude, latitude])
                .setPopup(popup)
                .addTo(map);
            currentMarker.defaultOffset = offSet.offset;
            AllMarkers.push(currentMarker);
            total += data[marker].count;
        }
        removeMapWaiting();
    });
}

function getUniqueDiagnostics(orientation, map) {
    if (AllDianosticData.length > 0) {
        addMapWaiting();
        RemoveDianosticMakers();
        AllDianosticData.map(function (value) {
            if (value[orientation] >= 0) {
                let el = document.createElement('div');
                el.className = `default-makers ${orientation}`;
                if (value[orientation] > 50) {
                    el.style = "width:40px;height:40px;";
                }
                el.style += `z-index:${value[orientation]}`;
                el.innerText = value[orientation];

                let longitude = value.longitude;
                let latitude = value.latitude;

                if (value.province.toUpperCase() != "KINSHASA") {
                    longitude = (Number(longitude) + (500 / 100000)).toFixed(5);
                    latitude = (Number(latitude) - (300 / 100000)).toFixed(5);
                }
                // popup 
                let popup = new mapboxgl.Popup({ offset: 25 }).setText(
                    value.township
                );
                // add marker to map
                let offSet = { offset: [-70, 30] };
                let currentMarker = new mapboxgl.Marker(el
                    // , map.getZoom() < 9 ? { offset: [0, 0] } : offSet
                )
                    .setLngLat([longitude, latitude])
                    .setPopup(popup)
                    .addTo(map);
                currentMarker.defaultOffset = offSet.offset;
                AllMarkers.push(currentMarker);
                removeMapWaiting();
            }
        });

    }
}

function getAllSondages() {
    addMapWaiting();
    $.get(`/api/dashboard/sondages`, function (data) {
        AllSondagesData = data;
        removeMapWaiting();
    });
}

function setMarkersSondage(sondage, map) {
    addMapWaiting();
    let values = AllSondagesData.filter(x => x[sondage] && x[sondage] > 0);
    values.map((item) => {
        let el = document.createElement('div');
        let el2 = document.createElement('div');
        el.className = `default-makers ${sondage}`;
        let defaultSize = "width:30px;height:30px;";
        if (item[sondage] > 50) {
            el.style = defaultSize;
        }
        if (item[sondage] > 100) {
            defaultSize="width:50px;height:50px;";;
            el.style = defaultSize;
        }
        el2.style.zIndex = item[sondage];
        let offset = { offset: [0, 0] };
        let longitude = item.longitude;
        let latitude = item.latitude;
        switch (sondage) {
            case 'worried':
                offset = { offset: [10, 0] };
                let worried = item.worried ? item.worried : 0;
                let not_worried = item.not_worried ? item.not_worried : 0;
                let worried_count = worried + not_worried;
                el.innerText = worried_count;
                longitude = item.longitude + (100 / 100000);
                latitude = item.latitude + (500 / 100000)
                el.style.background = `linear-gradient(to right,#00b065 ${worried * 100 / worried_count}%, #ff3b3b ${not_worried * 100 / worried_count}%)`;
                break;
            case 'catch_virus':
                offset = { offset: [10, 50] };
                let catch_virus = item.catch_virus ? item.catch_virus : 0;
                let not_catch_virus = item.not_catch_virus ? item.not_catch_virus : 0;
                let catch_virus_count = catch_virus + not_catch_virus;
                el.innerText = catch_virus_count;
                longitude = item.longitude - (200 / 10000);
                latitude = item.latitude - (200 / 100000)
                el.style.background = `linear-gradient(to right,#00b065 ${catch_virus * 100 / catch_virus_count}%, #ff3b3b ${not_catch_virus * 100 / catch_virus_count}%)`;
                break;
            case 'not_work':
                offset = { offset: [20, 50] };
                el.innerText = item[sondage];
                break;
            case 'toll_free_number':
                offset = { offset: [50, 30] };
                el.innerText = item[sondage];
                break;
            case 'price_increase':
                offset = { offset: [-20, 30] };
                el.innerText = item[sondage];
                longitude = item.longitude - (300 / 10000);
                latitude = item.latitude + (150 / 100000)
                break;
            case 'other_difficulty':
                offset = { offset: [-40, 0] };
                el.innerText = item[sondage];
                longitude = item.longitude - (400 / 10000);
                latitude = item.latitude + (100 / 100000)
                break;
            default:
                break;
        }


        // popup 
        let popup = new mapboxgl.Popup({ offset: 25 }).setText(
            item.town
        );
        el2.append(el);
        // add marker to map
        let currentMarker = new mapboxgl.Marker(el2
            // ,
            //  map.getZoom() < 9 ? { offset: [0, 0] } : offset
        )
            .setLngLat([longitude, latitude])
            .setPopup(popup)
            .addTo(map);

        currentMarker[sondage] = true;
        currentMarker.defaultOffset = offset.offset;
        currentMarker.defaultSize = defaultSize;
        AllSondagesMarkers.push(currentMarker);
        removeMapWaiting();
    });
    removeMapWaiting();
}
