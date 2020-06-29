<template>
  <div class="map-wrapper">
    <div id="map"></div>
    <ToolTipMaps
      v-if="ArcLayerSelectedObject.item"
      :position="ArcLayerSelectedObject.position"
      :item="ArcLayerSelectedObject.item"
    />
  </div>
</template>
<script>
import { MAPBOX_TOKEN, MAPBOX_DEFAULT_STYLE } from "../config/env";
import Mapbox from "mapbox-gl";
import { ScatterplotLayer, ArcLayer } from "@deck.gl/layers";
import { MapboxLayer } from "@deck.gl/mapbox";
import ToolTipMaps from "./ToolTipMaps";
import { mapState, mapMutations } from "vuex";

export default {
  components: { ToolTipMaps },
  props: {
    covidCases: {
      type: Object,
      default: null
    },
    hospitals: {
      type: Object,
      default: null
    },
    medicalOrientations: {
      type: Array,
      default: null
    },
    medicalOrientationSelected: {
      type: String,
      default: null
    },
    sondages: {
      type: Array,
      default: null
    },
    worried: {
      type: Boolean,
      default: null
    },
    catchVirus: {
      type: Boolean,
      default: null
    },
    priceIncrease: {
      type: Boolean,
      default: null
    },
    mask: {
      type: Boolean,
      default: null
    },
    makala: {
      type: Boolean,
      default: null
    },
    flour: {
      type: Boolean,
      default: null
    },
    antiBacterialGel: {
      type: Boolean,
      default: null
    },
    flux24: {
      type: Array,
      default: []
    }
  },
  data() {
    return {
      MAPBOX_TOKEN,
      MAPBOX_DEFAULT_STYLE,
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
      drcHealthZone: "drcHealthZone",
      covidCasesMarkers: [],
      medicalOrientationMakers: [],
      medicalOrientationData: [],
      map: null,
      AllSondagesMarkers: [],
      ArcLayerSelectedObject: {}
    };
  },
  mounted() {
    Mapbox.accessToken = this.MAPBOX_TOKEN;
    window.map = new Mapbox.Map({
      container: "map",
      center: [15.31389, -4.33167],
      zoom: 10,
      style: this.MAPBOX_DEFAULT_STYLE,
      bearing: 30,
      pitch: 30
    });
    map.addControl(new Mapbox.NavigationControl());
    map.on("load", () => {
      map.addSource(this.drcSourceId, {
        type: "geojson",
        generateId: true,
        data: `${location.protocol}//${location.host}/storage/geojson/rd_congo_admin_4_provinces.geojson`
      });
      map.addSource(this.drcHealthZone, {
        type: "geojson",
        generateId: true,
        data: `${location.protocol}//${location.host}/storage/geojson/rdc_micro_zonesdedante_regroupees.json`
      });
      map.addSource(this.kinSourceId, {
        type: "vector",
        url: "mapbox://merki230.4airwoxt"
      });

      map.addLayer({
        id: this.drcSourceId,
        type: "line",
        source: this.drcSourceId,
        layout: {},
        paint: {
          "line-color": "#627BC1",
          "line-width": 1
        }
      });

      map.addLayer({
        id: this.kinSourceId,
        type: "line",
        source: this.kinSourceId,

        "source-layer": "carte-administrative-de-la-vi-csh5cj",
        layout: {},
        paint: {
          "line-color": "#627BC1",
          "line-width": 1
        }
      });
    });
    this.map = map;
    this.$store.watch(
      state => state.flux.fluxGeoGranularity,
      value => {
        this.mapGeoJsonSourceFlux(value);
      }
    );
  },
  computed: {
    ...mapState({
      fluxGeoGranularityState(state) {
        console.log(state);

        this.mapGeoJsonSourceFlux(state.flux.fluxGeoGranularity);
        return;
      }
    }),

    flux24WithoutReference() {
      return this.flux24.filter(x => !x.isReference);
    }
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
                                <div class="statCount">${confirmed -
                                  healed -
                                  dead}</div>
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

        this.map.on("click", "covid9HospitalsLayer", e => {
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
    },
    medicalOrientations() {
      this.getMedicalOrientations();
    },
    medicalOrientationSelected() {
      if (this.medicalOrientations.length == 0) {
        return;
      }
      if (this.medicalOrientationSelected == "ALL") {
        this.getMedicalOrientations();
        return;
      }
      this.RemoveOrientationMakers();
      let orientation = this.medicalOrientationSelected;
      this.medicalOrientations.map(value => {
        if (value[orientation] >= 0) {
          let el = document.createElement("div");
          el.className = `default-makers ${orientation}`;
          if (value[orientation] > 3840) {
            el.style = "width:100px;height:100px;";
          } else if (value[orientation] > 1920) {
            el.style = "width:90px;height:90px;";
          } else if (value[orientation] > 960) {
            el.style = "width:80px;height:80px;";
          } else if (value[orientation] > 480) {
            el.style = "width:70px;height:70px;";
          } else if (value[orientation] > 240) {
            el.style = "width:60px;height:60px;";
          } else if (value[orientation] > 120) {
            el.style = "width:50px;height:50px;";
          } else if (value[orientation] > 60) {
            el.style = "width:40px;height:40px;";
          } else if (value[orientation] > 30) {
            el.style = "width:30px;height:30px;";
          } else if (value[orientation] > 15) {
            el.style = "width:20px;height:20px;";
          }
          el.style.zIndex = value[orientation];

          let longitude = value.longitude;
          let latitude = value.latitude;

          if (value.province.toUpperCase() != "KINSHASA") {
            longitude = (Number(longitude) + 500 / 100000).toFixed(5);
            latitude = (Number(latitude) - 300 / 100000).toFixed(5);
          }
          // popup
          let popup = new Mapbox.Popup({ offset: 25 }).setText(value.township);
          // add marker to map
          let offSet = { offset: [-70, 30] };
          let currentMarker = new Mapbox.Marker(el)
            .setLngLat([longitude, latitude])
            .setPopup(popup)
            .addTo(this.map);
          currentMarker.defaultOffset = offSet.offset;
          this.medicalOrientationMakers.push(currentMarker);
        }
      });
    },
    sondages() {
      if (!this.sondages) {
        this.AllSondagesMarkers.map(item => {
          item.remove();
        });
      }
    },
    worried() {
      if (this.worried) {
        this.setMarkersSondage("worried");
      } else {
        this.removeMarkersSondage("worried");
      }
    },
    catchVirus() {
      if (this.catchVirus) {
        this.setMarkersSondage("catch_virus");
      } else {
        this.removeMarkersSondage("catch_virus");
      }
    },
    priceIncrease() {
      if (this.priceIncrease) {
        this.setMarkersSondage("price_increase");
      } else {
        this.removeMarkersSondage("price_increase");
      }
    },
    mask() {
      if (this.mask) {
        this.setMarkersSondage("mask");
      } else {
        this.removeMarkersSondage("mask");
      }
    },
    makala() {
      if (this.makala) {
        this.setMarkersSondage("makala");
      } else {
        this.removeMarkersSondage("makala");
      }
    },
    flour() {
      if (this.flour) {
        this.setMarkersSondage("flour");
      } else {
        this.removeMarkersSondage("flour");
      }
    },
    antiBacterialGel() {
      if (this.antiBacterialGel) {
        this.setMarkersSondage("antibacterial_gel");
      } else {
        this.removeMarkersSondage("antibacterial_gel");
      }
    },
    flux24() {
      if (this.flux24.length > 0) {
        if (map.getLayer("arc")) {
          map.removeLayer("arc");
          map.removeLayer("fluxCircleDataLayer");
          map.removeSource("fluxCircleDataSource");
        }

        const features = [];
        this.flux24
          .filter(x => !x.isReference)
          .map(item => {
            // let element = features.find(
            //   x => x.properties.origin == item.origin
            // );
            // if (element) {
            //   element.properties.volume += 1;
            // } else {
            //   features.push({
            //     type: "Feature",
            //     geometry: {
            //       type: "Point",
            //       coordinates: item.position_start
            //     },
            //     properties: {
            //       origin: item.origin,
            //       color: "#ED5F68",
            //       volume: 1
            //     }
            //   });
            // }
            const element2 = features.find(
              x => x.properties.origin == item.destination
            );
            if (element2) {
              element2.properties.volume += item.volume;
            } else {
              features.push({
                type: "Feature",
                geometry: {
                  type: "Point",
                  coordinates: item.position_end
                },
                properties: {
                  origin: item.destination,
                  color: "#ED5F68",
                  volume: 1
                }
              });
            }
          });

        const circleData = {
          type: "geojson",
          data: {
            type: "FeatureCollection",
            features: features
          }
        };

        map.addSource("fluxCircleDataSource", circleData);
        map.addLayer({
          id: "fluxCircleDataLayer",
          type: "circle",
          source: "fluxCircleDataSource",
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
                [">=", ["number", ["get", "volume"]], 1280],
                6,
                [">=", ["number", ["get", "volume"]], 640],
                5.5,
                [">=", ["number", ["get", "volume"]], 320],
                5,
                [">=", ["number", ["get", "volume"]], 160],
                4,
                [">=", ["number", ["get", "volume"]], 80],
                3.5,
                [">=", ["number", ["get", "volume"]], 40],
                3,
                [">=", ["number", ["get", "volume"]], 20],
                2.5,
                [">=", ["number", ["get", "volume"]], 10],
                1.5,
                [">=", ["number", ["get", "volume"]], 5],
                1,
                1
              ],
              3,
              [
                "case",
                [">=", ["number", ["get", "volume"]], 1280],
                12.5,
                [">=", ["number", ["get", "volume"]], 640],
                11,
                [">=", ["number", ["get", "volume"]], 320],
                10,
                [">=", ["number", ["get", "volume"]], 160],
                8.75,
                [">=", ["number", ["get", "volume"]], 80],
                7.5,
                [">=", ["number", ["get", "volume"]], 40],
                6,
                [">=", ["number", ["get", "volume"]], 20],
                5,
                [">=", ["number", ["get", "volume"]], 10],
                3.25,
                [">=", ["number", ["get", "volume"]], 5],
                2.5,
                2.5
              ],
              5,
              [
                "case",
                [">=", ["number", ["get", "volume"]], 1280],
                25,
                [">=", ["number", ["get", "volume"]], 640],
                22.5,
                [">=", ["number", ["get", "volume"]], 320],
                20,
                [">=", ["number", ["get", "volume"]], 160],
                17.5,
                [">=", ["number", ["get", "volume"]], 80],
                15,
                [">=", ["number", ["get", "volume"]], 40],
                12.5,
                [">=", ["number", ["get", "volume"]], 20],
                10,
                [">=", ["number", ["get", "volume"]], 10],
                7.5,
                [">=", ["number", ["get", "volume"]], 5],
                5,
                5
              ],
              10,
              [
                "case",
                [">=", ["number", ["get", "volume"]], 1280],
                50,
                [">=", ["number", ["get", "volume"]], 640],
                45,
                [">=", ["number", ["get", "volume"]], 320],
                40,
                [">=", ["number", ["get", "volume"]], 160],
                35,
                [">=", ["number", ["get", "volume"]], 80],
                30,
                [">=", ["number", ["get", "volume"]], 40],
                25,
                [">=", ["number", ["get", "volume"]], 20],
                20,
                [">=", ["number", ["get", "volume"]], 10],
                15,
                [">=", ["number", ["get", "volume"]], 5],
                10,
                10
              ]
            ],
            "circle-color": "#2e5bff"
          }
        });

        let arcData = [];
        let FluxFiltered = this.flux24.filter(x => !x.isReference);

        for (const key in FluxFiltered) {
          const item = FluxFiltered[key];
          const index = arcData.findIndex(
            x =>
              (x.destination == item.destination && x.origin == item.origin) ||
              (x.destination == item.origin && x.origin == item.destination)
          );
          if (index != -1) {
            arcData[index].volume += item.volume;
          } else {
            arcData.push(item);
          }
        }

        // arcData=this.flux24.filter(x=>!x.isReference);
        const myDeckLayer = new MapboxLayer({
          id: "arc",
          data: arcData,
          type: ArcLayer,
          stroked: false,
          filled: true,
          getFillColor: [0, 0, 0, 0],
          getSourcePosition: d => d.position_start,
          getTargetPosition: d => d.position_end,
          getSourceColor: d =>
            d.isReference ? [158, 158, 158] : [105, 179, 162],
          getTargetColor: d =>
            d.isReference ? [158, 158, 158] : [105, 179, 162],
          getHeight: 1,
          getTilt: (d, { data }) => {
            let tilt = 2;
            if (d.isReference) {
              tilt = -2;
            }
            return tilt;
          },
          getWidth: d => {
            let width = 3;
            if (d.volume > 20000) {
              width = 12;
            } else if (d.volume > 10000) {
              width = 11;
            } else if (d.volume > 5000) {
              width = 10;
            } else if (d.volume > 3000) {
              width = 9;
            } else if (d.volume > 1000) {
              width = 7;
            } else if (d.volume > 500) {
              width = 6.5;
            } else if (d.volume > 300) {
              width = 6;
            } else if (d.volume > 100) {
              width = 5;
            }
            return width;
          },
          pickable: true,
          onHover: (info, event) => {
            this.$set(this.ArcLayerSelectedObject, "position", {
              top: info.y,
              left: info.x
            });
            this.$set(this.ArcLayerSelectedObject, "item", info.object);
          }
        });
        map.addLayer(myDeckLayer);
      } else {
        if (map.getLayer("arc")) {
          map.removeLayer("arc");
          map.removeLayer("fluxCircleDataLayer");
          map.removeSource("fluxCircleDataSource");
        }
      }
    }
  },
  methods: {
    mapGeoJsonSourceFlux(fluxGeoGranularity) {
      map.removeLayer(this.drcSourceId);
      if (fluxGeoGranularity == 1) {
        map.addLayer({
          id: this.drcSourceId,
          type: "line",
          source: this.drcSourceId,
          layout: {},
          paint: {
            "line-color": "#627BC1",
            "line-width": 1
          }
        });
      } else {
        map.addLayer({
          id: this.drcSourceId,
          type: "line",
          source: this.drcHealthZone,
          layout: {},
          paint: {
            "line-color": "#627BC1",
            "line-width": 1
          }
        });
      }
      return;
    },
    getMedicalOrientations() {
      if (!this.medicalOrientations) {
        this.RemoveOrientationMakers();
        return;
      }
      this.RemoveOrientationMakers();
      let AllDianosticData = [];
      let total_fin = 0;
      let total_fin5 = 0;
      let total_fin8 = 0;
      let AllMarkers = [];
      this.medicalOrientations.map(item => {
        var el = document.createElement("div");
        el.className = "pie";
        let total = item.FIN + item.FIN8 + item.FIN5;

        if (total > 3840) {
          el.style = "width:80px;height:80px;";
        } else if (total > 1920) {
          el.style = "width:75px;height:75px;";
        } else if (total > 960) {
          el.style = "width:70px;height:70px;";
        } else if (total > 480) {
          el.style = "width:65px;height:65px;";
        } else if (total > 240) {
          el.style = "width:60px;height:60px;";
        } else if (total > 120) {
          el.style = "width:55px;height:55px;";
        } else if (total > 60) {
          el.style = "width:50px;height:50px;";
        } else if (total > 30) {
          el.style = "width:45px;height:45px;";
        } else if (total > 15) {
          el.style = "width:40px;height:40px;";
        }
        let elSpan = document.createElement("span");
        let elSpan2 = document.createElement("span");
        let elSpan3 = document.createElement("span");
        elSpan.className = "fin-5";
        elSpan2.className = "fin-8";
        elSpan3.className = "fin";
        elSpan.textContent = item.FIN5 ?? 0;
        elSpan2.textContent = item.FIN8 ?? 0;
        elSpan3.textContent = item.FIN ?? 0;
        el.appendChild(elSpan);
        el.appendChild(elSpan2);
        el.appendChild(elSpan3);

        let longitude = item.longitude;
        let latitude = item.latitude;

        if (item.province.toUpperCase() != "KINSHASA") {
          longitude = (Number(longitude) + 500 / 100000).toFixed(5);
          latitude = (Number(latitude) - 300 / 100000).toFixed(5);
        }

        // popup
        let popup = new Mapbox.Popup({ offset: 25 }).setText(item.township);
        // add marker to map
        let offSet = { offset: [-70, 30] };
        let currentMarker = new Mapbox.Marker(el)
          .setLngLat([longitude, latitude])
          .setPopup(popup)
          .addTo(this.map);
        currentMarker.defaultOffset = offSet.offset;
        AllMarkers.push(currentMarker);
        total_fin += item.FIN ?? 0;
        total_fin5 += item.FIN5 ?? 0;
        total_fin8 += item.FIN8 ?? 0;
      });

      this.medicalOrientationMakers = AllMarkers;
    },
    RemoveOrientationMakers() {
      if (this.medicalOrientationMakers) {
        this.medicalOrientationMakers.map(item => {
          item.remove();
        });
      }
    },
    setMarkersSondage(sondage) {
      let values = this.sondages.filter(x => x[sondage] && x[sondage] > 0);
      values.map(item => {
        let el = document.createElement("div");
        let el2 = document.createElement("div");
        el.className = `default-makers ${sondage}`;
        let defaultSize = "width:30px;height:30px;";
        if (item[sondage] > 50) {
          el.style = defaultSize;
        }
        if (item[sondage] > 100) {
          defaultSize = "width:50px;height:50px;";
          el.style = defaultSize;
        }
        el2.style.zIndex = item[sondage];
        let offset = { offset: [0, 0] };
        let longitude = item.longitude;
        let latitude = item.latitude;
        switch (sondage) {
          case "worried":
            offset = { offset: [10, 0] };
            let worried = item.worried ? item.worried : 0;
            let not_worried = item.not_worried ? item.not_worried : 0;
            let worried_count = worried + not_worried;
            el.innerText = worried_count;
            longitude = item.longitude + 100 / 100000;
            latitude = item.latitude + 800 / 100000;
            el.style.background = `linear-gradient(to right,#00b065 ${(worried *
              100) /
              worried_count}%, #ff3b3b ${(worried * 100) /
              worried_count}%, #ff3b3b ${(not_worried * 100) /
              worried_count}%)`;
            break;
          case "catch_virus":
            let catch_virus = item.catch_virus ? item.catch_virus : 0;
            let not_catch_virus = item.not_catch_virus
              ? item.not_catch_virus
              : 0;
            let catch_virus_count = catch_virus + not_catch_virus;
            el.innerText = catch_virus_count;
            longitude = item.longitude - 200 / 10000;
            latitude = item.latitude - 200 / 100000;
            el.style.background = `linear-gradient(to right,#00b065 ${(catch_virus *
              100) /
              catch_virus_count}%, #ff3b3b ${(catch_virus * 100) /
              catch_virus_count}%, #ff3b3b ${(not_catch_virus * 100) /
              catch_virus_count}%)`;
            break;
          case "price_increase":
            let price_increase = item.price_increase ? item.price_increase : 0;
            let not_price_increase = item.not_price_increase
              ? item.not_price_increase
              : 0;
            let price_increase_count = price_increase + not_price_increase;
            el.innerText = price_increase_count;
            longitude = item.longitude - 300 / 10000;
            latitude = item.latitude + 500 / 100000;
            el.style.background = `linear-gradient(to right,#00b065 ${(price_increase *
              100) /
              price_increase_count}%, #ff3b3b ${(price_increase * 100) /
              price_increase_count}%, #ff3b3b ${(not_price_increase * 100) /
              price_increase_count}%)`;
            break;
          case "mask":
            let mask = item.mask ? item.mask : 0;
            let not_mask = item.not_mask ? item.not_mask : 0;
            let mask_count = mask + not_mask;
            el.innerText = mask_count;
            longitude = item.longitude - 350 / 100000;
            latitude = item.latitude - 300 / 100000;
            el.style.background = `linear-gradient(to right,#00b065 ${(mask *
              100) /
              mask_count}%, #ff3b3b ${(mask * 100) /
              mask_count}%, #ff3b3b ${(not_mask * 100) / mask_count}%)`;
            break;
          case "makala":
            let makala = item.makala ? item.makala : 0;
            let not_makala = item.not_makala ? item.not_makala : 0;
            let makala_count = makala + not_makala;
            el.innerText = makala_count;
            longitude = item.longitude + 300 / 10000;
            latitude = item.latitude + 150 / 100000;
            el.style.background = `linear-gradient(to right,#00b065 ${(makala *
              100) /
              makala_count}%, #ff3b3b ${(makala * 100) /
              makala_count}%, #ff3b3b ${(not_makala * 100) / makala_count}%)`;
            break;
          case "flour":
            let flour = item.flour ? item.flour : 0;
            let not_flour = item.not_flour ? item.not_flour : 0;
            let flour_count = flour + not_flour;
            el.innerText = flour_count;
            longitude = item.longitude - 330 / 10000;
            latitude = item.latitude - 250 / 100000;
            el.style.background = `linear-gradient(to right,#00b065 ${(flour *
              100) /
              flour_count}%, #ff3b3b ${(flour * 100) /
              flour_count}%, #ff3b3b ${(not_flour * 100) / flour_count}%)`;
            break;
          case "antibacterial_gel":
            let antibacterial_gel = item.antibacterial_gel
              ? item.antibacterial_gel
              : 0;
            let not_antibacterial_gel = item.not_antibacterial_gel
              ? item.not_antibacterial_gel
              : 0;
            let antibacterial_gel_count =
              antibacterial_gel + not_antibacterial_gel;
            el.innerText = antibacterial_gel_count;
            longitude = item.longitude - 200 / 10000;
            latitude = item.latitude + 800 / 100000;
            el.style.background = `linear-gradient(to right,#00b065 ${(antibacterial_gel *
              100) /
              antibacterial_gel_count}%, #ff3b3b ${(antibacterial_gel * 100) /
              antibacterial_gel_count}%, #ff3b3b ${(not_antibacterial_gel *
              100) /
              antibacterial_gel_count}%)`;
            break;
          default:
            break;
        }

        // popup
        let popup = new Mapbox.Popup({ offset: 25 }).setText(item.town);
        el2.append(el);
        // add marker to map
        let currentMarker = new Mapbox.Marker(el2)
          .setLngLat([longitude, latitude])
          .setPopup(popup)
          .addTo(map);
        currentMarker[sondage] = true;
        currentMarker.defaultSize = defaultSize;
        this.AllSondagesMarkers.push(currentMarker);
      });
    },
    removeMarkersSondage(sondage) {
      this.AllSondagesMarkers.filter(x => x[sondage]).map(item => {
        item.remove();
      });
    }
  }
};
</script>

<style lang="scss" scoped>
</style>