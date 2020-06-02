<template>
  <MglMap
    :accessToken="MAPBOX_TOKEN"
    :mapStyle.sync="MAPBOX_DEFAULT_STYLE"
    :mapboxGl="Mapbox"
    :attributionControl="false"
    @load="onMapLoaded"
  >
    <MglNavigationControl position="top-right" />

    <MglGeojsonLayer :sourceId="drcSourceId" :layerId="drcSourceId" :layer="countryLayer" />
    <MglVectorLayer :sourceId="kinSourceId" :layerId="kinSourceId" :layer="kinLayer" />
  </MglMap>
</template>

<script>
import { MAPBOX_TOKEN, MAPBOX_DEFAULT_STYLE } from "../config/env";
import Mapbox from "mapbox-gl";
import {
  MglMap,
  MglNavigationControl,
  MglGeojsonLayer,
  MglVectorLayer
} from "vue-mapbox";

export default {
  components: {
    MglMap,
    MglNavigationControl,
    MglGeojsonLayer,
    MglVectorLayer
  },
  props: {
    covidCases: {
      type: Object,
      default: null
    },
    hospitals: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      MAPBOX_TOKEN,
      MAPBOX_DEFAULT_STYLE,
      Mapbox,
      popupCoordinates: [15.31389, -4.33167],
      countryLayer: {
        paint: {
          "line-color": "#627BC1",
          "line-width": 1
        },
        type: "line"
      },
      kinLayer: {
        paint: {
          "line-color": "#627BC1",
          "line-width": 1
        },
        type: "line",
        "source-layer": "carte-administrative-de-la-vi-csh5cj"
      },
      drcSourceId: "states",
      kinSourceId: "statesKin",
      covidCasesMarkers: []
    };
  },
  created() {
    this.map = null;
  },
  watch: {
    covidCases() {
      if (this.covidCases) {
        this.map.addSource("covidCasesSource", this.covidCases);
        this.map.addLayer({
          id: "covidCasesLayer",
          type: "circle",
          source: "covidCasesSource",
          paint: {
            // make circles larger as the user zooms from z12 to z22
            "circle-opacity": 0.7,
            "circle-radius": [
              "interpolate",
              ["linear"],
              ["zoom"],
              1,
              [
                "case",
                [">=", ["number", ["get", "confirmed"]], 3840],
                6,
                [">=", ["number", ["get", "confirmed"]], 1920],
                5.5,
                [">=", ["number", ["get", "confirmed"]], 960],
                5,
                [">=", ["number", ["get", "confirmed"]], 480],
                4,
                [">=", ["number", ["get", "confirmed"]], 240],
                3.5,
                [">=", ["number", ["get", "confirmed"]], 120],
                3,
                [">=", ["number", ["get", "confirmed"]], 60],
                2.5,
                [">=", ["number", ["get", "confirmed"]], 30],
                1.5,
                [">=", ["number", ["get", "confirmed"]], 15],
                1,
                1
              ],
              3,
              [
                "case",
                [">=", ["number", ["get", "confirmed"]], 3840],
                12.5,
                [">=", ["number", ["get", "confirmed"]], 1920],
                11,
                [">=", ["number", ["get", "confirmed"]], 960],
                10,
                [">=", ["number", ["get", "confirmed"]], 480],
                8.75,
                [">=", ["number", ["get", "confirmed"]], 240],
                7.5,
                [">=", ["number", ["get", "confirmed"]], 120],
                6,
                [">=", ["number", ["get", "confirmed"]], 60],
                5,
                [">=", ["number", ["get", "confirmed"]], 30],
                3.25,
                [">=", ["number", ["get", "confirmed"]], 15],
                2.5,
                2.5
              ],
              5,
              [
                "case",
                [">=", ["number", ["get", "confirmed"]], 3840],
                25,
                [">=", ["number", ["get", "confirmed"]], 1920],
                22.5,
                [">=", ["number", ["get", "confirmed"]], 960],
                20,
                [">=", ["number", ["get", "confirmed"]], 480],
                17.5,
                [">=", ["number", ["get", "confirmed"]], 240],
                15,
                [">=", ["number", ["get", "confirmed"]], 120],
                12.5,
                [">=", ["number", ["get", "confirmed"]], 60],
                10,
                [">=", ["number", ["get", "confirmed"]], 30],
                7.5,
                [">=", ["number", ["get", "confirmed"]], 15],
                5,
                5
              ],
              10,
              [
                "case",
                [">=", ["number", ["get", "confirmed"]], 3840],
                50,
                [">=", ["number", ["get", "confirmed"]], 1920],
                45,
                [">=", ["number", ["get", "confirmed"]], 960],
                40,
                [">=", ["number", ["get", "confirmed"]], 480],
                35,
                [">=", ["number", ["get", "confirmed"]], 240],
                30,
                [">=", ["number", ["get", "confirmed"]], 120],
                25,
                [">=", ["number", ["get", "confirmed"]], 60],
                20,
                [">=", ["number", ["get", "confirmed"]], 30],
                15,
                [">=", ["number", ["get", "confirmed"]], 15],
                10,
                10
              ]
            ],
            "circle-color": "#f4c363"
          }
        });
        this.map.on("mouseenter", "covidCasesLayer", () => {
          this.map.getCanvas().style.cursor = "pointer";
        });
        this.map.on("mouseleave", "covidCasesLayer", () => {
          this.map.getCanvas().style.cursor = "";
        });
        this.map.on("click", "covidCasesLayer", e => {
          const coordinates = e.features[0].geometry.coordinates.slice();
          const {
            name,
            confirmed,
            dead,
            sick,
            healed,
            last_update
          } = e.features[0].properties;
          const template = `<div class="topToolTip" >
                            <div class="titleInfoBox">${name}</div>
                            <div class="statLine">
                                <div class="stat total">Nombre total de cas</div>
                                <div class="statCount total">${confirmed}</div>
                            </div>
                            <div class="statLine divider"></div>
                            <div class="statLine">
                                <div class="legendColor ongoing"></div>
                                <div class="stat">Actifs</div>
                                <div class="statCount">${confirmed-healed-dead}</div>
                            </div>
                            <div class="statLine">
                                <div class="legendColor recovered"></div>
                                <div class="stat">Guérisons</div>
                                <div class="statCount">${healed}</div>
                            </div>
                            <div class="statLine"> 
                                <div class="legendColor fatal"></div>
                                <div class="stat">Décès</div>
                                <div class="statCount">${dead}</div>
                            </div> 
                            <i></i>
                        </div>`;
          new Mapbox.Popup()
            .setLngLat(coordinates)
            .setHTML(template)
            .addTo(this.map);
        });
      } else {
        this.map.off("mouseenter", "covidCasesLayer");
        this.map.off("mouseleave", "covidCasesLayer");
        this.map.off("click", "covidCasesLayer");
        this.map.removeLayer("covidCasesLayer");
        this.map.removeSource("covidCasesSource");
      }

      /* this.covidCases.map(item => {
        let el = document.createElement("div");
        let el2 = document.createElement("div");
        el2.className = `covidCases-marker confirmed`;
        //el2.textContent = item[type];
        if (item.confirmed > 3840) {
          el2.style = `width:100px;height:100px;`;
        } else if (item.confirmed > 1920) {
          el2.style = `width:90px;height:90px;`;
        } else if (item.confirmed > 960) {
          el2.style = `width:80px;height:80px;`;
        } else if (item.confirmed > 480) {
          el2.style = `width:70px;height:70px;`;
        } else if (item.confirmed > 240) {
          el2.style = `width:60px;height:60px;`;
        } else if (item.confirmed > 120) {
          el2.style = `width:50px;height:50px;`;
        } else if (item.confirmed > 60) {
          el2.style = `width:40px;height:40px;`;
        } else if (item.confirmed > 30) {
          el2.style = `width:30px;height:30px;`;
        }
        el.append(el2);
        let currentMarker = new Mapbox.Marker(el)
          .setLngLat([item.longitude, item.latitude])
          //.setPopup(popup)
          .addTo(this.map);
        currentMarker.confirmed = true;
        this.covidCasesMarkers.push(currentMarker);
      });*/
    },
    hospitals() {
      if (this.hospitals) {
        this.map.addSource("covid9HospitalsSource", this.hospitals);

        this.map.addLayer({
          id: "covid9HospitalsLayer",
          type: "symbol",
          source: "covid9HospitalsSource",
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
            "text-size": ["interpolate", ["linear"], ["zoom"], 5, 10, 10, 25]
          },
          paint: {
            "text-translate-anchor": "viewport",
            "text-color": ["get", "color"]
          }
        });

        this.map.on("mouseenter", "covid9HospitalsLayer", () => {
          this.map.getCanvas().style.cursor = "pointer";
        });
        this.map.on("mouseleave", "covid9HospitalsLayer", () => {
          this.map.getCanvas().style.cursor = "";
        });

        this.map.on("click", "covid9HospitalsLayer", (e)=> {
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
            last_update
          } = e.features[0].properties;

          // computed properties
          const active = confirmed - dead - healed;
          const bedsAvailable = beds - occupied_beds;
          const respiratorsAvailable = respirators - occupied_respirators;

          const template = `
<div>
  <div class="hospital-name">${name}</div>
  ${address ? `<div>Commune: ${address}</div>` : ""}
  <hr />
  <div>
    <strong>Situation Epidémiologique</strong>
  </div>
  <div class="confirmed">
    <span>Confirmés: </span>
    <span class="count">${confirmed}</span>
  </div>
  <div class="active">
    <span>Actifs: </span>
    <span class="count">${sick}</span>
  </div>
  <div class="recovered">
    <span>Guéris: </span>
    <span class="count">${healed}</span>
  </div>
  <div class="death">
    <span>Décès: </span>
    <span class="count">${dead}</span>
  </div>
  <hr />
  <div>
    <strong>Capacité Hospitalière</strong>
  </div>
  <div>
    <span>Lits disponibles: </span>
    <span>${bedsAvailable} sur ${beds}</span>
  </div>
  <div>
    <span>Respirateurs disponibles: </span>
    <span>${respiratorsAvailable} sur ${respirators}</span>
  </div>
  <div>
    <span>Masques N95/FFP2: </span>
    <span>${masks}</span>
  </div>
 
</div>
`;

          new Mapbox.Popup()
            .setLngLat(coordinates)
            .setHTML(template)
            .addTo(this.map);
        });
      } else {
        this.map.off("mouseenter", "covid9HospitalsLayer");
        this.map.off("mouseleave", "covid9HospitalsLayer");
        this.map.off("click", "covid9HospitalsLayer");
        this.map.removeLayer("covid9HospitalsLayer");
        this.map.removeSource("covid9HospitalsSource");
      }
    }
  },
  methods: {
    async onMapLoaded(event) {
      // in component
      this.map = event.map;
      // or just to store if you want have access from other components
      this.$store.map = event.map;
      this.map.addSource(this.drcSourceId, {
        type: "geojson",
        generateId: true,
        data: `${location.protocol}//${location.host}/storage/geojson/rd_congo_admin_4_provinces.geojson`
      });

      this.map.addSource(this.kinSourceId, {
        type: "vector",
        url: "mapbox://merki230.4airwoxt"
      });

      const asyncActions = event.component.actions;
      const newParams = await asyncActions.flyTo({
        center: [15.31389, -4.33167],
        zoom: 9,
        speed: 1
      });
    }
  }
};
</script>

<style lang="scss" scoped>
</style>