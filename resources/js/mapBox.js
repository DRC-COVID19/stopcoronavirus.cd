const $ = require('jquery');
const AllMarkers = [];
let AllDianosticData = [];
let AllSondagesData = [];
const AllSondagesMarkers = [];
let AllCovideCases = [];
const AllCovidCasesMarkers = [];
$(function () {
  const hoveredStateId = null;
  const hoveredStateIdKin = null;
  const elementCheck = $('#map');
  if (elementCheck.length == 0) {
    return;
  }
  mapboxgl.accessToken =
    'pk.eyJ1IjoibWVya2kyMzAiLCJhIjoiY2s5aWdkejJzMDhybTNkcWxtMm9la2h4aCJ9.5NwFpUn264STu43zxmTyOw';
  const map = new mapboxgl.Map({
    container: 'map',
    center: [15.31389, -4.33167],
    zoom: 10,
    style: 'mapbox://styles/merki230/ck9vd0zmy0lqk1jn3lpq81up8',
  });
  map.addControl(new mapboxgl.NavigationControl());
  map.on('load', function () {
    map.addSource('states', {
      type: 'geojson',
      generateId: true,
      data: `${location.protocol}//${location.host}/storage/geojson/rd_congo_admin_4_provinces.geojson`,
    });

    map.addSource('statesKin', {
      type: 'vector',
      url: 'mapbox://merki230.4airwoxt',
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
      id: 'state-borders',
      type: 'line',
      source: 'states',
      layout: {},
      paint: {
        'line-color': '#627BC1',
        'line-width': 1,
      },
    });

    map.addLayer({
      id: 'state-borders-kin',
      type: 'line',
      source: 'statesKin',

      'source-layer': 'carte-administrative-de-la-vi-csh5cj',
      layout: {},
      paint: {
        'line-color': '#627BC1',
        'line-width': 1,
      },
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
    const currentZoom = map.getZoom();
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
  $('#covid_case').change(function (e) {
    const item = $(this);
    if (item.is(':checked')) {
      getCovideCases();
      $('#covid_case_group_item input[type=radio]').removeAttr('disabled');
    } else {
      AllCovidCasesMarkers.map((item) => {
        item.remove();
      });
      $('#covid_case_group_item input[type=radio]').attr(
        'disabled',
        'disabled'
      );
      $('#covid_case_group_item input[type=radio]').prop('checked', false);
    }
  });

  $('#covid_case_group_item input[type=radio]').change(function (e) {
    const item = $(this);
    if (item.is(':checked')) {
      AllCovidCasesMarkers.map((item) => {
        item.remove();
      });
      setMarkerCovidCases(item.attr('id'), map);
    }
  });

  $('#hospital-data-close').click(function (e) {
    $('#hospital-data').addClass('d-none');
  });

  $('#list_hospital').change(function (e) {
    const item = $(this);
    if (item.is(':checked')) {
      getHospitals(map);
    } else {
      map.off('mouseenter', 'covid9_hospitals_layer');
      map.off('mouseleave', 'covid9_hospitals_layer');
      map.off('click', 'covid9_hospitals_layer');
      map.removeLayer('covid9_hospitals_layer');
      map.removeSource('covid9_hospitals_source');
      $('#hospital-data').addClass('d-none');
      $('#hospital_count').text('');
    }
  });

  $('#medical_orientation').change(function (e) {
    const item = $(this);
    if (item.is(':checked')) {
      getAllDianostics(map);
      $('#orientation_result').removeAttr('disabled');
    } else {
      RemoveDianosticMakers();
      $('#orientation_result').attr('disabled', 'disabled');
      $('#medical_orientation_count').text('');
      $('#medical_orientation_fin_count').text('');
      $('#medical_orientation_fin5_count').text('');
      $('#medical_orientation_fin8_count').text('');
    }
  });

  $('#orientation_result').change(function (e) {
    const item = $(this);
    if (item.val()) {
      getUniqueDiagnostics(item.val(), map);
    } else {
      getAllDianostics(map);
    }
  });

  $('#has_sondage').change(function (e) {
    const item = $(this);
    if (item.is(':checked')) {
      getAllSondages();
      $('#sondage-item input').removeAttr('disabled');
    } else {
      $('#sondage-item input').attr('disabled', 'disabled');
      $('#sondage-item input').prop('checked', false);
      AllSondagesMarkers.map((item) => {
        item.remove();
      });
      $('#sondage_count').text('');
    }
  });

  $('#sondage-item input').change(function (e) {
    const item = $(this);
    if (item.is(':checked')) {
      setMarkersSondage(item.attr('id'), map);
    } else {
      const sondage = item.attr('id');
      AllSondagesMarkers.filter((x) => x[sondage]).map((item) => {
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

function getCovideCases() {
  addMapWaiting();
  $.get('/api/dashboard/cavid-cases', function (data) {
    AllCovideCases = data;
    $('#confirmed').click();
    removeMapWaiting();
  });
}

function setMarkerCovidCases(type, map) {
  const data = AllCovideCases.filter((x) => x[type] && x[type] > 0);
  data.map((item) => {
    const el = document.createElement('div');
    const el2 = document.createElement('div');
    el2.className = `covidCases-marker ${type}`;
    el2.textContent = item[type];

    if (item[type] > 3840) {
      el2.style = 'width:100px;height:100px;';
    } else if (item[type] > 1920) {
      el2.style = 'width:90px;height:90px;';
    } else if (item[type] > 960) {
      el2.style = 'width:80px;height:80px;';
    } else if (item[type] > 480) {
      el2.style = 'width:70px;height:70px;';
    } else if (item[type] > 240) {
      el2.style = 'width:60px;height:60px;';
    } else if (item[type] > 120) {
      el2.style = 'width:50px;height:50px;';
    } else if (item[type] > 60) {
      el2.style = 'width:40px;height:40px;';
    } else if (item[type] > 30) {
      el2.style = 'width:30px;height:30px;';
    }
    el.append(el2);
    const currentMarker = new mapboxgl.Marker(el)
      .setLngLat([item.longitude, item.latitude])
      // .setPopup(popup)
      .addTo(map);
    currentMarker[type] = true;
    AllCovidCasesMarkers.push(currentMarker);
  });
}

function getHospitals(map) {
  addMapWaiting();
  $.get('/api/dashboard/hospitals', function (data) {
    const hospitalData = data.map((value, index) => {
      return {
        type: 'Feature',
        geometry: {
          type: 'Point',
          coordinates: [value.longitude, value.latitude],
        },
        properties: {
          name: value.name ? value.name : 'Hopital',
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
          last_update: value.last_situation
            ? value.last_situation.last_update
            : 0,
          color: '#ED5F68',
        },
      };
    });

    $('#hospital_count').text(`(${hospitalData.length})`);

    map.addSource('covid9_hospitals_source', {
      type: 'geojson',
      data: {
        type: 'FeatureCollection',
        features: hospitalData,
      },
    });

    map.addLayer({
      id: 'covid9_hospitals_layer',
      type: 'symbol',
      source: 'covid9_hospitals_source',
      // minzoom: 10,
      layout: {
        'text-line-height': 1,
        'text-padding': 0,
        'text-anchor': 'center',
        'text-allow-overlap': true,
        'text-ignore-placement': true,
        'text-field': String.fromCharCode('0xf47e'),
        'icon-optional': true,
        'text-font': ['Font Awesome 5 Free Solid'],
        'text-size': ['interpolate', ['linear'], ['zoom'], 5, 10, 10, 25],
      },
      paint: {
        'text-translate-anchor': 'viewport',
        'text-color': ['get', 'color'],
      },
    });

    map.on('mouseenter', 'covid9_hospitals_layer', function () {
      map.getCanvas().style.cursor = 'pointer';
    });
    map.on('mouseleave', 'covid9_hospitals_layer', function () {
      map.getCanvas().style.cursor = '';
    });

    map.on('click', 'covid9_hospitals_layer', function (e) {
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
    map.on('mouseenter', 'covid9', function () {
      map.getCanvas().style.cursor = 'pointer';
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
  $.get('/api/dashboard/orientation-medical-result', function (data) {
    RemoveDianosticMakers();
    AllDianosticData = [];
    let total_fin = 0;
    let total_fin5 = 0;
    let total_fin8 = 0;
    for (const marker in data) {
      // create a DOM element for the marker
      const item = data[marker];
      AllDianosticData.push(item);
      const el = document.createElement('div');
      el.className = 'pie';
      const total = item.FIN + item.FIN8 + item.FIN5;

      if (total > 50) {
        el.style = 'width:60px;height:60px;';
      }
      if (total > 100) {
        el.style = 'width:75px;height:75px;';
      }
      const elSpan = document.createElement('span');
      const elSpan2 = document.createElement('span');
      const elSpan3 = document.createElement('span');
      elSpan.className = 'fin-5';
      elSpan2.className = 'fin-8';
      elSpan3.className = 'fin';
      elSpan.textContent = data[marker].FIN5 ?? 0;
      elSpan2.textContent = data[marker].FIN8 ?? 0;
      elSpan3.textContent = data[marker].FIN ?? 0;
      el.appendChild(elSpan);
      el.appendChild(elSpan2);
      el.appendChild(elSpan3);

      let longitude = data[marker].longitude;
      let latitude = data[marker].latitude;

      if (data[marker].province.toUpperCase() != 'KINSHASA') {
        longitude = (Number(longitude) + 500 / 100000).toFixed(5);
        latitude = (Number(latitude) - 300 / 100000).toFixed(5);
      }

      // popup
      const popup = new mapboxgl.Popup({ offset: 25 }).setText(
        data[marker].township
      );
      // add marker to map
      const offSet = { offset: [-70, 30] };
      const currentMarker = new mapboxgl.Marker(
        el
        // , map.getZoom() < 9 ? { offset: [0, 0] } : offSet
      )
        .setLngLat([longitude, latitude])
        .setPopup(popup)
        .addTo(map);
      currentMarker.defaultOffset = offSet.offset;
      AllMarkers.push(currentMarker);
      total_fin += item.FIN ?? 0;
      total_fin5 += item.FIN5 ?? 0;
      total_fin8 += item.FIN8 ?? 0;
    }
    $('#medical_orientation_count').text(
      `(${total_fin + total_fin5 + total_fin8})`
    );
    $('#medical_orientation_fin_count').text(`(${total_fin})`);
    $('#medical_orientation_fin5_count').text(`(${total_fin5})`);
    $('#medical_orientation_fin8_count').text(`(${total_fin8})`);

    removeMapWaiting();
  });
}

function getUniqueDiagnostics(orientation, map) {
  if (AllDianosticData.length > 0) {
    addMapWaiting();
    RemoveDianosticMakers();
    AllDianosticData.map(function (value) {
      if (value[orientation] >= 0) {
        const el = document.createElement('div');
        el.className = `default-makers ${orientation}`;
        if (value[orientation] > 20) {
          el.style = 'width:30px;height:30px;';
        }
        if (value[orientation] > 50) {
          el.style = 'width:50px;height:50px;';
        }
        if (value[orientation] > 100) {
          el.style = 'width:70px;height:70px;';
        }
        el.style.zIndex = value[orientation];
        el.innerText = value[orientation];

        let longitude = value.longitude;
        let latitude = value.latitude;

        if (value.province.toUpperCase() != 'KINSHASA') {
          longitude = (Number(longitude) + 500 / 100000).toFixed(5);
          latitude = (Number(latitude) - 300 / 100000).toFixed(5);
        }
        // popup
        const popup = new mapboxgl.Popup({ offset: 25 }).setText(
          value.township
        );
        // add marker to map
        const offSet = { offset: [-70, 30] };
        const currentMarker = new mapboxgl.Marker(
          el
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
  $.get('/api/dashboard/sondages', function (data) {
    AllSondagesData = data;
    let total_count = 0;
    data.map((item) => {
      total_count += item.count;
    });
    $('#sondage_count').text(`(${total_count})`);
    removeMapWaiting();
  });
}

function setMarkersSondage(sondage, map) {
  addMapWaiting();
  const values = AllSondagesData.filter((x) => x[sondage] && x[sondage] > 0);
  values.map((item) => {
    const el = document.createElement('div');
    const el2 = document.createElement('div');
    el.className = `default-makers ${sondage}`;
    let defaultSize = 'width:30px;height:30px;';
    if (item[sondage] > 50) {
      el.style = defaultSize;
    }
    if (item[sondage] > 100) {
      defaultSize = 'width:50px;height:50px;';
      el.style = defaultSize;
    }
    el2.style.zIndex = item[sondage];
    let offset = { offset: [0, 0] };
    let longitude = item.longitude;
    let latitude = item.latitude;
    switch (sondage) {
      case 'worried':
        offset = { offset: [10, 0] };
        const worried = item.worried ? item.worried : 0;
        const not_worried = item.not_worried ? item.not_worried : 0;
        const worried_count = worried + not_worried;
        el.innerText = worried_count;
        longitude = item.longitude + 100 / 100000;
        latitude = item.latitude + 800 / 100000;
        el.style.background = `linear-gradient(to right,#00b065 ${
          (worried * 100) / worried_count
        }%, #ff3b3b ${(worried * 100) / worried_count}%, #ff3b3b ${
          (not_worried * 100) / worried_count
        }%)`;
        break;
      case 'catch_virus':
        const catch_virus = item.catch_virus ? item.catch_virus : 0;
        const not_catch_virus = item.not_catch_virus ? item.not_catch_virus : 0;
        const catch_virus_count = catch_virus + not_catch_virus;
        el.innerText = catch_virus_count;
        longitude = item.longitude - 200 / 10000;
        latitude = item.latitude - 200 / 100000;
        el.style.background = `linear-gradient(to right,#00b065 ${
          (catch_virus * 100) / catch_virus_count
        }%, #ff3b3b ${(catch_virus * 100) / catch_virus_count}%, #ff3b3b ${
          (not_catch_virus * 100) / catch_virus_count
        }%)`;
        break;
      case 'price_increase':
        const price_increase = item.price_increase ? item.price_increase : 0;
        const not_price_increase = item.not_price_increase
          ? item.not_price_increase
          : 0;
        const price_increase_count = price_increase + not_price_increase;
        el.innerText = price_increase_count;
        longitude = item.longitude - 300 / 10000;
        latitude = item.latitude + 500 / 100000;
        el.style.background = `linear-gradient(to right,#00b065 ${
          (price_increase * 100) / price_increase_count
        }%, #ff3b3b ${
          (price_increase * 100) / price_increase_count
        }%, #ff3b3b ${(not_price_increase * 100) / price_increase_count}%)`;
        break;
      case 'mask':
        const mask = item.mask ? item.mask : 0;
        const not_mask = item.not_mask ? item.not_mask : 0;
        const mask_count = mask + not_mask;
        el.innerText = mask_count;
        longitude = item.longitude - 350 / 100000;
        latitude = item.latitude - 300 / 100000;
        el.style.background = `linear-gradient(to right,#00b065 ${
          (mask * 100) / mask_count
        }%, #ff3b3b ${(mask * 100) / mask_count}%, #ff3b3b ${
          (not_mask * 100) / mask_count
        }%)`;
        break;
      case 'makala':
        const makala = item.makala ? item.makala : 0;
        const not_makala = item.not_makala ? item.not_makala : 0;
        const makala_count = makala + not_makala;
        el.innerText = makala_count;
        longitude = item.longitude + 300 / 10000;
        latitude = item.latitude + 150 / 100000;
        el.style.background = `linear-gradient(to right,#00b065 ${
          (makala * 100) / makala_count
        }%, #ff3b3b ${(makala * 100) / makala_count}%, #ff3b3b ${
          (not_makala * 100) / makala_count
        }%)`;
        break;
      case 'flour':
        const flour = item.flour ? item.flour : 0;
        const not_flour = item.not_flour ? item.not_flour : 0;
        const flour_count = flour + not_flour;
        el.innerText = flour_count;
        longitude = item.longitude - 330 / 10000;
        latitude = item.latitude - 250 / 100000;
        el.style.background = `linear-gradient(to right,#00b065 ${
          (flour * 100) / flour_count
        }%, #ff3b3b ${(flour * 100) / flour_count}%, #ff3b3b ${
          (not_flour * 100) / flour_count
        }%)`;
        break;
      case 'antibacterial_gel':
        const antibacterial_gel = item.antibacterial_gel
          ? item.antibacterial_gel
          : 0;
        const not_antibacterial_gel = item.not_antibacterial_gel
          ? item.not_antibacterial_gel
          : 0;
        const antibacterial_gel_count =
          antibacterial_gel + not_antibacterial_gel;
        el.innerText = antibacterial_gel_count;
        longitude = item.longitude - 200 / 10000;
        latitude = item.latitude + 800 / 100000;
        el.style.background = `linear-gradient(to right,#00b065 ${
          (antibacterial_gel * 100) / antibacterial_gel_count
        }%, #ff3b3b ${
          (antibacterial_gel * 100) / antibacterial_gel_count
        }%, #ff3b3b ${
          (not_antibacterial_gel * 100) / antibacterial_gel_count
        }%)`;
        break;
      default:
        break;
    }

    // popup
    const popup = new mapboxgl.Popup({ offset: 25 }).setText(item.town);
    el2.append(el);
    // add marker to map
    const currentMarker = new mapboxgl.Marker(el2)
      .setLngLat([longitude, latitude])
      .setPopup(popup)
      .addTo(map);
    currentMarker[sondage] = true;
    currentMarker.defaultSize = defaultSize;
    AllSondagesMarkers.push(currentMarker);
    removeMapWaiting();
  });
  removeMapWaiting();
}
