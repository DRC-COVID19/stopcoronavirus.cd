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
import { MAPBOX_TOKEN, MAPBOX_DEFAULT_STYLE, PALETTE } from "../config/env";
import Mapbox from "mapbox-gl";
import { ScatterplotLayer, ArcLayer } from "@deck.gl/layers";
import { MapboxLayer } from "@deck.gl/mapbox";
import ToolTipMaps from "./ToolTipMaps";
import { mapState, mapMutations, mapActions } from "vuex";
import U from "mapbox-gl-utils";
import { includes } from "lodash";
import * as d3 from "d3";
import * as turf from "@turf/turf";

const sourceHealthZoneGeojsonCentered = "sourHealthZoneGeojsonCentered",
  sourceHealthZoneGeojson = "sourceHealthZoneGeojson",
  sourceHealthProvinceGeojsonCentered = "sourHealthProvinceGeojsonCentered",
  sourceHealthProvinceGeojson = "sourceHealthProvinceGeojson",
  EPIDEMIC_LAYER = "EPIDEMIC_LAYER",
  HATCHED_MOBILITY_LAYER = "HATCHED_MOBILITY_LAYER";
export default {
  components: { ToolTipMaps },
  props: {
    covidCases: {
      type: Object,
      default: null,
    },
    hospitals: {
      type: Object,
      default: null,
    },
    medicalOrientations: {
      type: Array,
      default: null,
    },
    medicalOrientationSelected: {
      type: String,
      default: null,
    },
    sondages: {
      type: Array,
      default: null,
    },
    worried: {
      type: Boolean,
      default: null,
    },
    catchVirus: {
      type: Boolean,
      default: null,
    },
    priceIncrease: {
      type: Boolean,
      default: null,
    },
    mask: {
      type: Boolean,
      default: null,
    },
    makala: {
      type: Boolean,
      default: null,
    },
    flour: {
      type: Boolean,
      default: null,
    },
    antiBacterialGel: {
      type: Boolean,
      default: null,
    },
    flux24: {
      type: Array,
      default: [],
    },
    flux24DailyIn: {
      type: Array,
      default: () => [],
    },
    flux24DailyOut: {
      type: Array,
      default: () => [],
    },
    flux24DailyGenerale: {
      type: Array,
      default: () => [],
    },
    isLoading: {
      type: Boolean,
      default: null,
    },
    flux24Presence: {
      type: Object,
      default: () => ({}),
    },
    fluxDataGroupedByDateOut: {
      type: Object,
      default: () => ({}),
    },
    fluxDataGroupedByDateIn: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      MAPBOX_TOKEN,
      MAPBOX_DEFAULT_STYLE,
      popupCoordinates: [15.31389, -4.33167],
      countryLayer: {
        paint: {
          "line-color": "#627BC1",
          "line-width": 1,
        },
        type: "line",
      },
      kinLayer: {
        paint: {
          "line-color": "#627BC1",
          "line-width": 1,
        },
        type: "line",
        "source-layer": "carte-administrative-de-la-vi-csh5cj",
      },
      drcSourceId: "states",
      kinSourceId: "statesKin",
      drcHealthZone: "drcHealthZone",
      hashedLayerId: "hashedLayerid",
      covidCasesMarkers: [],
      medicalOrientationMakers: [],
      medicalOrientationData: [],
      map: null,
      AllSondagesMarkers: [],
      ArcLayerSelectedObject: {},
      centerCoordinates: [],
      healthZoneGeojson: null,
      healthZoneGeojsonCentered: null,
      healthProvinceGeojson: null,
      healthProvinceGeojsonCentered: null,
      isMapLoaded: false,
      isZoneSourceLoaded: false,
      isProvinceSourceLoaded: false,
    };
  },
  created() {
    this.loadSource();
  },
  mounted() {
    Mapbox.accessToken = this.MAPBOX_TOKEN;
    window.map = new Mapbox.Map({
      container: "map",
      center: [15.31389, -4.33167],
      zoom: 10,
      pitch: 10,
      style: this.MAPBOX_DEFAULT_STYLE,
    });
    U.init(map, Mapbox);
    map.addControl(new Mapbox.NavigationControl());
    this.isMapLoaded = false;
    map.on("load", () => {
      this.isMapLoaded = true;
      map.addSource(this.drcSourceId, {
        type: "geojson",
        generateId: true,
        data: `${location.protocol}//${location.host}/storage/geojson/rd_congo_admin_4_provinces.geojson`,
      });

      map.addSource(this.drcHealthZone, {
        type: "geojson",
        generateId: true,
        data: `${location.protocol}//${location.host}/storage/geojson/rdc_micro_zonesdedante_regroupees.json`,
      });

      // map.addSource(this.kinSourceId, {
      //   type: "vector",
      //   url: "mapbox://merki230.4airwoxt"
      // });

      if (!this.isZoneSourceLoaded && this.healthZoneGeojson) {
        this.addZoneSource();
      }

      if (!this.isProvinceSourceLoaded && this.healthProvinceGeojson) {
        this.addProvinceSource();
      }

      this.addPolygoneLayer(2);
      this.addPolygoneHoverLayer(2);
    });

    this.map = map;

    //watch store
    this.$store.watch(
      (state) => state.flux.fluxGeoGranularity,
      (value) => {
        // if (this.activeMenu != 1) {
        //   return;
        // }
        this.addPolygoneLayer(value);
        this.addPolygoneHoverLayer(value);
      }
    );
    this.$store.watch(
      (state) => state.flux.mapStyle,
      (value) => {
        // if (this.activeMenu != 1) {
        //   return;
        // }
        this.flux24Func();
      }
    );
    this.$store.watch(
      (state) => state.flux.fluxType,
      (value) => {
        // if (this.activeMenu != 1) {
        //   return;
        // }
        this.flux24Func();
      }
    );

    //watch activeMenu store state
    this.$store.watch(
      (state) => state.nav.activeMenu,
      (value) => {
        switch (value) {
          case 1:
            break;
          case 5:
            this.addPolygoneLayer(2);
            this.addPolygoneHoverLayer(2);
          default:
            break;
        }
      }
    );

    //watch flux legendHover store state
    this.$store.watch(
      (state) => state.flux.legendHover,
      (value) => {
        this.flux24Func();
      }
    );

    this.$store.watch(
      (state) => state.epidemic.legendEpidHover,
      (value) => {
        this.covidHatchedStyle(this.covidCases, value);
      }
    );
  },
  computed: {
    ...mapState({
      fluxMapStyle: (state) => state.flux.mapStyle,
      fluxGeoGranularity: (state) => state.flux.fluxGeoGranularity,
      fluxType: (state) => state.flux.fluxType,
      fluxGeoOptions: (state) => state.flux.fluxGeoOptions,
      fluxEnabled: (state) => state.flux.fluxEnabled,
      activeMenu: (state) => state.nav.activeMenu,
      legendHover: (state) => state.flux.legendHover,
      epidemicLengendHover: (state) => state.epidemic.legendEpidHover,
    }),
    flux24WithoutReference() {
      return this.flux24.filter((x) => !x.isReference);
    },
  },
  watch: {
    covidCases() {
      if (this.covidCases) {
        this.covidHatchedStyle(this.covidCases, this.epidemicLengendHover);
      } else {
        map.U.removeLayer([EPIDEMIC_LAYER]);
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
            "text-size": ["interpolate", ["linear"], ["zoom"], 5, 10, 10, 25],
          },
          paint: {
            "text-translate-anchor": "viewport",
            "text-color": ["get", "color"],
          },
        });

        const popup = new Mapbox.Popup({
          closeButton: false,
          closeOnClick: false,
        });

        const mouseMove = (e) => {
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
            resuscitation_beds,
            occupied_resuscitation_beds,
          } = e.features[0].properties;

          const HTML = `<div class="row">
                <div class="col-12 bold text-center hospital-name">${name}</div>
                <hr class="col-12 m-0 p-0">

                <div class="col-9 small">Confirmés</div>
                <div class="col-3 bold">${confirmed}</div>
                <hr class="col-12 m-0 p-0">

                <div class="col-9 small">Hospitalisés</div>
                <div class="col-3 bold">${sick}</div>
                <hr class="col-12 m-0 p-0">

                <div class="col-9 small">Lits de réanimation</div>
                <div class="col-3 bold">${resuscitation_beds}</div>
                <hr class="col-12 m-0 p-0">

                <div class="col-9 small">Lits de réanimation occupés</div>
                <div class="col-3 bold">${occupied_resuscitation_beds}</div>
                <hr class="col-12 m-0 p-0">

                <div class="col-9 small">Respirateurs</div>
                <div class="col-3 bold">${respirators}</div>
                <hr class="col-12 m-0 p-0">

                <div class="col-9 small">Respirateurs occupés</div>
                <div class="col-3 bold">${occupied_respirators}</div>
            </div>`;
          popup.setLngLat(e.lngLat).setHTML(HTML).addTo(map);
        };

        const mouseOut = (e) => {
          this.map.getCanvas().style.cursor = "";
          popup.remove();
        };

        const mouseClick = (e) => {
          this.selectHospital(e.features[0].properties);
        };

        this.map.on("mouseenter", "covid9HospitalsLayer", () => {
          this.map.getCanvas().style.cursor = "pointer";
        });
        this.map.on("mouseleave", "covid9HospitalsLayer", mouseOut);
        this.map.on("mousemove", "covid9HospitalsLayer", mouseMove);
        this.map.on("click", "covid9HospitalsLayer", mouseClick);
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
      this.medicalOrientations.map((value) => {
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
        this.AllSondagesMarkers.map((item) => {
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
    flux24DailyIn() {
      this.flux24Func();
    },
    flux24DailyGenerale() {
      if (this.fluxType == 4) this.flux24Func();
    },
    isLoading() {
      if (this.centerCoordinates.length > 0) {
        map.flyTo({ center: this.centerCoordinates });
      }
    },
  },
  methods: {
    ...mapMutations([
      "selectHospital",
      "setFluxGeoOptions",
      "setDomaineExtValues",
      "setEpidemicExtValues",
    ]),
    ...mapActions(["resetState"]),
    addPolygoneLayer(geoGranularity) {
      map.U.removeLayer([this.drcSourceId]);
      map.addLayer(
        {
          id: this.drcSourceId,
          type: "line",
          source: geoGranularity != 2 ? this.drcSourceId : this.drcHealthZone,
          layout: {},
          paint: {
            "line-color": PALETTE.bordure_shape_file,
            "line-width": 1,
          },
        },
        map.getLayer(EPIDEMIC_LAYER) ? EPIDEMIC_LAYER : null
      );
    },
    addPolygoneHoverLayer(geoGranularity) {
      map.U.removeLayer(["state-hover"]);
      let hoveredStateId = null;
      let hoveredStateKinId = null;
      map.U.addFill(
        "state-hover",
        geoGranularity != 2 ? this.drcSourceId : this.drcHealthZone,
        map.U.properties({
          "fill-opacity": [
            "case",
            ["boolean", ["feature-state", "hover"], false],
            0.2,
            0,
          ],
          "fill-color": "#627BC1",
        })
      );

      map.off("mouseleave", "state-hover");
      map.off("mousemove", "state-hover");
      map.off("click", "state-hover");

      //polygone hover
      map.on("mousemove", "state-hover", (e) => {
        if (e.features.length > 0) {
          if (hoveredStateId) {
            map.setFeatureState(
              {
                source:
                  geoGranularity != 2 ? this.drcSourceId : this.drcHealthZone,
                id: hoveredStateId,
              },
              { hover: false }
            );
          }
          hoveredStateId = e.features[0].id;
          map.setFeatureState(
            {
              source:
                geoGranularity != 2 ? this.drcSourceId : this.drcHealthZone,
              id: hoveredStateId,
            },
            { hover: true }
          );
        }
      });

      map.on("mouseleave", "state-hover", () => {
        if (hoveredStateId) {
          map.setFeatureState(
            {
              source:
                geoGranularity != 2 ? this.drcSourceId : this.drcHealthZone,
              id: hoveredStateId,
            },
            { hover: false }
          );
        }
        hoveredStateId = null;
      });

      map.on("click", "state-hover", (e) => {
        this.centerCoordinates = [e.lngLat.lng, e.lngLat.lat];
        // map.flyTo({center: this.centerCoordinates})

        switch (this.activeMenu) {
          case 1:
            if (geoGranularity != 2) {
              this.setFluxGeoOptions([e.features[0].properties.name]);
            } else {
              this.setFluxGeoOptions([e.features[0].properties["Zone+Peupl"]]);
            }
            break;

          default:
            break;
        }
      });
    },
    loadSource() {
      axios
        .get(
          `${location.protocol}//${location.host}/storage/geojson/rdc_micro_zonesdedante_regroupees.json`
        )
        .then(({ data }) => {
          // console.log("data", data);
          this.isZoneSourceLoaded = false;
          this.healthZoneGeojson = data;
          const features = data.features.map((item) => {
            let polygone = null;
            switch (item.geometry.type) {
              case "MultiPolygon":
                polygone = turf.multiPolygon(item.geometry.coordinates);
                break;
              case "Polygon":
                polygone = turf.polygon(item.geometry.coordinates);
                break;
              default:
                break;
            }
            const feature = turf.centerOfMass(polygone);
            feature.properties = item.properties;
            return feature;
          });
          this.healthZoneGeojsonCentered = {
            type: "FeatureCollection",
            features: features,
          };
          // console.log(this.healthZoneGeojsonCentered);
          this.addZoneSource();
        });

      axios
        .get(
          `${location.protocol}//${location.host}/storage/geojson/rd_congo_admin_4_provinces.geojson`
        )
        .then(({ data }) => {
          // console.log("data", data);
          this.isProvinceSourceLoaded = false;
          this.healthProvinceGeojson = data;
          const features = data.features.map((item) => {
            let polygone = null;
            switch (item.geometry.type) {
              case "MultiPolygon":
                polygone = turf.multiPolygon(item.geometry.coordinates);
                break;
              case "Polygon":
                polygone = turf.polygon(item.geometry.coordinates);
                break;
              default:
                break;
            }
            const feature = turf.centerOfMass(polygone);
            feature.properties = item.properties;
            return feature;
          });
          this.healthProvinceGeojsonCentered = {
            type: "FeatureCollection",
            features: features,
          };
          this.addProvinceSource();
        });
    },
    addProvinceSource() {
      if (!this.isMapLoaded) {
        return;
      }
      map.U.addGeoJSON(
        sourceHealthProvinceGeojsonCentered,
        this.healthProvinceGeojsonCentered
      );
      map.U.addGeoJSON(sourceHealthProvinceGeojson, this.healthProvinceGeojson);
      this.isProvinceSourceLoaded = true;
    },
    addZoneSource() {
      if (!this.isMapLoaded) {
        return;
      }
      map.U.addGeoJSON(
        sourceHealthZoneGeojsonCentered,
        this.healthZoneGeojsonCentered
      );
      map.U.addGeoJSON(sourceHealthZoneGeojson, this.healthZoneGeojson);
      this.isZoneSourceLoaded = true;
    },
    covidHatchedStyle(
      covidCasesData,
      legendHover = null,
      property = "confirmed",
      geoGranularity = 2
    ) {
      let features = covidCasesData.data.features;

      features = features.sort((a, b) => {
        return Number(a[property] ?? 0) < Number(b[property] ?? 0) ? 1 : -1;
      });

      //domaine
      const domaineMax = d3.max(features, (d) => d.properties[property]);
      const domaineMin = d3.min(features, (d) => d.properties[property]);

      this.setEpidemicExtValues({ max: domaineMax, min: domaineMin });

      const colorScale = d3
        .scaleQuantile()
        .domain([domaineMin, domaineMax])
        .range(PALETTE.epidemic);

      let dataKey = "name";
      if (geoGranularity == 2) {
        dataKey = "Zone+Peupl";
      }

      const colorExpression = [];
      colorExpression.push("case");
      features.forEach((x) => {
        const color = colorScale(x.properties[property]);
        colorExpression.push(["==", ["get", dataKey], x.properties.name]);
        colorExpression.push(color);
      });
      colorExpression.push("white");

      //remove previous layer
      map.U.removeLayer([EPIDEMIC_LAYER]);

      const source = map.getSource(
        geoGranularity == 1 ? this.drcSourceId : this.drcHealthZone
      );

      if (legendHover) {
        features = features.filter(
          (x) =>
            x.properties[property] >= legendHover.de &&
            x.properties[property] <= legendHover.a
        );
        if (features.length == 0) {
          return;
        }
      }

      //Added layer
      // map.U.addFill(
      //   this.hashedLayerId,
      //   geoGranularity == 1 ? this.drcSourceId : this.drcHealthZone,
      //   map.U.properties({
      //     fillColor: colorExpression,
      //     fillOpacity: [
      //       "match",
      //       ["get", dataKey],
      //       features.map(x => x.properties.name),
      //       0.9,
      //       0
      //     ]
      //   }),
      //   this.drcSourceId
      // );

      // map.U.addCircle(
      //   this.hashedLayerId,
      //   geoGranularity == 1
      //     ? sourceHealthProvinceGeojsonCentered
      //     : sourceHealthZoneGeojsonCentered,
      //   map.U.properties({
      //     circleColor: colorExpression,
      //     circlePitchAlignment: "map",
      //     circleBlur: 0.1,
      //     circleRaduis: 200,
      //     cirleOpacity: [
      //       "match",
      //       ["get", dataKey],
      //       features.map(x => x.properties.name),
      //       0.7,
      //       0
      //     ],
      //   }),
      //   this.drcSourceId
      // );

      map.addLayer({
        id: EPIDEMIC_LAYER,
        type: "circle",
        source:
          geoGranularity == 1
            ? sourceHealthProvinceGeojsonCentered
            : sourceHealthZoneGeojsonCentered,

        paint: {
          "circle-pitch-alignment": "map",
          "circle-blur": 0,
          "circle-opacity": [
            "match",
            ["get", dataKey],
            features.map((x) => x.properties.name),
            0.7,
            0,
          ],
          "circle-radius": [
            "interpolate",
            ["linear"],
            ["zoom"],
            0,
            0.2,
            22,
            20,
          ],
          "circle-color": colorExpression,
          "circle-stroke-color": PALETTE.dash_green,
          "circle-stroke-width": [
            "match",
            ["get", dataKey],
            features.map((x) => x.properties.name),
            0.5,
            0,
          ],
        },
      });

      const popup = new Mapbox.Popup({
        closeButton: false,
        closeOnClick: false,
      });

      const mouseMove = (e) => {
        // Change the cursor style as a UI indicator.
        // map.getCanvas().style.cursor = "pointer";

        const coordinates = e.features[0].geometry.coordinates[0].slice();

        const item = e.features[0].properties;

        const name = item["Zone+Peupl"] ?? item["name"];
        let value = null;
        const feature = features.find((x) => x.properties.name == name);

        if (feature) {
          value = feature.properties[property];
        }
        const HTML = `<div>${name} ${
          value ? `: ${Math.round(value)} cas` : ""
        }</div>`;

        // Populate the popup and set its coordinates
        // based on the feature found.
        popup.setLngLat(e.lngLat).setHTML(HTML).addTo(map);
      };

      const mouseOut = () => {
        map.getCanvas().style.cursor = "";
        popup.remove();
      };

      const mouseClick = (e) => {
        const item = e.features[0].properties;

        const featureName = item["Zone+Peupl"] ?? item["name"];
        const feature = features.find((x) => x.properties.name == featureName);
        if (!features) {
          return;
        }
        popup.remove();
        const {
          name,
          confirmed,
          dead,
          sick,
          healed,
          last_update,
        } = feature.properties;

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
                                <div class="statCount">${
                                  confirmed - healed - dead
                                }</div>
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
          .setLngLat(e.lngLat)
          .setHTML(template)
          .addTo(this.map);
      };

      map.off("mousemove", EPIDEMIC_LAYER, mouseMove);
      map.off("mouseout", EPIDEMIC_LAYER, mouseOut);
      map.off("click", EPIDEMIC_LAYER, mouseClick);

      map.on("click", EPIDEMIC_LAYER, mouseClick);

      map.on("mousemove", EPIDEMIC_LAYER, mouseMove);

      map.on("mouseout", EPIDEMIC_LAYER, mouseOut);
    },
    flux24Func() {
      if (this.flux24DailyIn.length > 0) {
        let data = [];
        let DataGroupByDate = [];
        if (this.fluxType == 1) {
          data = this.flux24DailyIn;
          DataGroupByDate = this.fluxDataGroupedByDateIn;
        } else if (this.fluxType == 2) {
          data = this.flux24DailyOut;
          DataGroupByDate = this.fluxDataGroupedByDateOut;
        } else if (this.fluxType == 4) {
          data = this.flux24DailyGenerale;
        }
        switch (this.fluxMapStyle) {
          case 2:
            this.fluxArcStyle(data, this.fluxGeoGranularity, this.legendHover);
            map.flyTo({
              pitch: 40,
              speed: 0.2, // make the flying slow
              curve: 1, // change the speed at which it zooms out

              // This can be any easing function: it takes a number between
              // 0 and 1 and returns another number between 0 and 1.
              easing: function (t) {
                return t;
              },

              // this animation is considered essential with respect to prefers-reduced-motion
              essential: true,
            });
            break;
          case 1:
          default:
            this.fluxHatchedStyle(
              data,
              DataGroupByDate,
              this.flux24Presence,
              this.legendHover
            );
            map.flyTo({
              pitch: 10,
              speed: 0.2, // make the flying slow
              curve: 1, // change the speed at which it zooms out

              // This can be any easing function: it takes a number between
              // 0 and 1 and returns another number between 0 and 1.
              easing: function (t) {
                return t;
              },

              // this animation is considered essential with respect to prefers-reduced-motion
              essential: true,
            });
            break;
        }
      } else {
        map.U.removeSource(["fluxCircleDataSource"]);
        map.U.removeLayer([this.hashedLayerId, "arc", "fluxCircleDataLayer"]);
        map.off("mouseleave", "fluxCircleDataLayer");
        map.off("mouseleave", "fluxCircleDataLayer");
      }
    },
    fluxHatchedStyle(
      flux24Data,
      DataGroupByDate,
      flux24DataPresence,
      legendHover = null
    ) {
      const localData = this.fluxType == 3 ? flux24DataPresence : flux24Data;

      let features = [];

      /**
       * format features data
       */
      const formatData = ({ references, observations }, key) => {
        if (!observations || !references) {
          return {
            percent: null,
            difference: null,
          };
        }
        let referenceVolume = null;
        let observationVolume = null;
        const countReference = references.length;
        if (countReference > 0) {
          if (countReference % 2 == 0) {
            let index = (countReference + 1) / 2;
            index = parseInt(index);
            const volume1 = references[index].volume;
            const volume2 = references[index - 1].volume;
            referenceVolume = (volume1 + volume2) / 2;
          } else {
            const index = (countReference + 1) / 2;
            referenceVolume = references[index - 1].volume;
          }
        }

        const countObservation = observations.length;
        if (countObservation > 0) {
          if (countObservation % 2 == 0) {
            let index = (countObservation + 1) / 2;
            index = parseInt(index);
            const volume1 = observations[index].volume;
            const volume2 = observations[index - 1].volume;
            observationVolume = (volume1 + volume2) / 2;
          } else {
            const index = (countObservation + 1) / 2;
            observationVolume = observations[index - 1].volume;
          }
        }
        const difference = observationVolume - referenceVolume;

        features.push({
          type: "Feature",
          geometry: {
            type: "Point",
            coordinates:
              key == "origin"
                ? observations[0].position_start
                : observations[0].position_end,
          },
          properties: {
            origin: observations[0][key],
            color: "#ED5F68",
            volume: observationVolume,
            volumeReference: referenceVolume,
            percent: Math.round((difference / referenceVolume) * 100),
            difference: difference,
          },
        });
      };

      const formatCurrentZone = ({ referencesByDate, observationsByDate }) => {
        if (!referencesByDate || !observationsByDate) {
          return {
            percent: null,
            difference: null,
          };
        }
        let referenceVolume = null;
        let observationVolume = null;
        const countReference = referencesByDate.length;
        if (countReference > 0) {
          if (countReference % 2 == 0) {
            let index = (countReference + 1) / 2;
            index = parseInt(index);
            const volume1 = referencesByDate[index].volume;
            const volume2 = referencesByDate[index - 1].volume;
            referenceVolume = (volume1 + volume2) / 2;
          } else {
            const index = (countReference + 1) / 2;
            referenceVolume = referencesByDate[index - 1].volume;
          }
        }

        const countObservation = observationsByDate.length;
        if (countObservation > 0) {
          if (countObservation % 2 == 0) {
            let index = (countObservation + 1) / 2;
            index = parseInt(index);
            const volume1 = observationsByDate[index].volume;
            const volume2 = observationsByDate[index - 1].volume;
            observationVolume = (volume1 + volume2) / 2;
          } else {
            const index = (countObservation + 1) / 2;
            observationVolume = observationsByDate[index - 1].volume;
          }
        }
        const difference = observationVolume - referenceVolume;

        features.push({
          type: "Feature",
          geometry: {
            type: "Point",
            coordinates: observationsByDate[0].position_start,
          },
          properties: {
            origin: observationsByDate[0].zone,
            color: "#ED5F68",
            volume: observationVolume,
            volumeReference: referenceVolume,
            percent: Math.round((difference / referenceVolume) * 100),
            difference: difference,
          },
        });
      };

      if (this.fluxType == 2) {
        localData.map((item) => {
          formatData(item, "destination");
        });
        formatCurrentZone(DataGroupByDate);
        // localData.map((item) => {
        //   formatData(item, "origin");
        // });
      } else if (this.fluxType == 3) {
        // localData.map((item) => {
        //   formatData(item, "origin");
        // });

        const { referencesByDate, observationsByDate } = localData;
        let referenceVolume = null;
        let observationVolume = null;
        const countReference = referencesByDate.length;
        if (countReference > 0) {
          if (countReference % 2 == 0) {
            let index = (countReference + 1) / 2;
            index = parseInt(index);
            const volume1 = referencesByDate[index].volume;
            const volume2 = referencesByDate[index - 1].volume;
            referenceVolume = (volume1 + volume2) / 2;
          } else {
            const index = (countReference + 1) / 2;
            referenceVolume = referencesByDate[index - 1].volume;
          }
        }

        const countObservation = observationsByDate.length;
        if (countObservation > 0) {
          if (countObservation % 2 == 0) {
            let index = (countObservation + 1) / 2;
            index = parseInt(index);
            const volume1 = observationsByDate[index].volume;
            const volume2 = observationsByDate[index - 1].volume;
            observationVolume = (volume1 + volume2) / 2;
          } else {
            const index = (countObservation + 1) / 2;
            observationVolume = observationsByDate[index - 1].volume;
          }
        }
        const difference = observationVolume - referenceVolume;
        const percent = Math.round((difference / referenceVolume) * 100);

        features.push({
          type: "Feature",
          geometry: {
            type: "Point",
            coordinates: [],
          },
          properties: {
            origin: observationsByDate[0].zone,
            color: "#ED5F68",
            volume: observationVolume,
            volumeReference: referenceVolume,
            percent: percent,
            difference: difference,
          },
        });
      } else if (this.fluxTYpe == 4) {
        localData.map((item) => {
          formatData(item, "zone");
        });
        localData.map((item) => {
          formatData(item, "targetZone");
        });
      } else {
        localData.map((item) => {
          formatData(item, "origin");
        });
        formatCurrentZone(DataGroupByDate);
      }

      console.log(features.map((x) => x.properties.origin));

      // features = features.filter((x) => x.properties.volume != 0);

      const max = d3.max(features, (d) => d.properties.volume);

      map.U.removeSource(["fluxCircleDataSource"]);
      map.U.removeLayer([HATCHED_MOBILITY_LAYER, "arc", "fluxCircleDataLayer"]);

      const domaineMax = d3.max(features, (d) => d.properties.percent);
      const domaineMin = d3.min(features, (d) => d.properties.percent);

      const colorScalePositive = d3.scaleQuantile();
      const colorScaleNegative = d3.scaleQuantile();

      colorScalePositive.domain([0, domaineMax]);
      colorScaleNegative.domain([domaineMin, 0]);

      // if (domaineMax >= 0 && domaineMin <= 0) {
      //   colorScalePositive.domain([0, domaineMax]);
      //   colorScaleNegative.domain([domaineMin, 0]);
      // } else if (domaineMax <= 0) {
      //   colorScaleNegative.domain([domaineMin, 0]);
      // } else if (domaineMin >= 0) {
      //   colorScalePositive.domain([[0, domaineMax]]);
      // } else if (domaineMax <= 0) {
      //   colorScaleNegative.domain([[domaineMin, 0]]);
      // }

      const colorScale = d3.scaleQuantile().domain([domaineMin, domaineMax]);

      this.setDomaineExtValues({
        min: domaineMin,
        max: domaineMax,
        isPercent: true,
      });

      if (this.fluxType == 1 || this.fluxType == 4) {
        colorScaleNegative.range(PALETTE.inflow_negatif);
        colorScalePositive.range(PALETTE.inflow_positif);

        colorScale.range(PALETTE.inflow);
      } else if (this.fluxType == 3) {
        colorScale.range(PALETTE.present);
      } else {
        colorScale.range(PALETTE.outflow);

        colorScaleNegative.range(PALETTE.outflow_negatif);
        colorScalePositive.range(PALETTE.outflow_positif);
      }

      let dataKey = "name";
      if (this.fluxGeoGranularity == 2) {
        dataKey = "Zone+Peupl";
      }

      const colorExpression = [];
      colorExpression.push("case");
      features.forEach((x) => {
        let color = PALETTE.dash_green;
        if (
          this.fluxGeoOptions.includes(x.properties.origin) ||
          this.fluxType == 3
        ) {
          color = PALETTE.dash_green;
        } else {
          if (x.properties.percent >= 0) {
            color = colorScalePositive(x.properties.percent);
          } else {
            color = colorScaleNegative(x.properties.percent);
          }
        }

        colorExpression.push(["==", ["get", dataKey], x.properties.origin]);
        colorExpression.push(color);
      });
      colorExpression.push("white");

      if (legendHover) {
        features = features.filter(
          (x) =>
            x.properties.percent >= legendHover.de &&
            x.properties.percent <= legendHover.a
        );
        if (features.length == 0) {
          return;
        }
      }

      map.U.addFill(
        HATCHED_MOBILITY_LAYER,
        this.fluxGeoGranularity == 1 ? this.drcSourceId : this.drcHealthZone,
        map.U.properties({
          fillColor: colorExpression,
          fillOpacity: [
            "match",
            ["get", dataKey],
            features.map((x) => x.properties.origin),
            0.9,
            0,
          ],
        }),
        this.drcSourceId
      );

      const popup = new Mapbox.Popup({
        closeButton: false,
        closeOnClick: false,
      });

      const mouseMove = (e) => {
        // Change the cursor style as a UI indicator.
        // map.getCanvas().style.cursor = "pointer";
        if (this.activeMenu != 1) {
          return;
        }
        const coordinates = e.features[0].geometry.coordinates[0].slice();

        const item = e.features[0].properties;

        const name = item["Zone+Peupl"] ?? item["name"];
        let value = null;
        const feature = features.find((x) => x.properties.origin == name);

        if (feature) {
          value = feature.properties.percent;
        }
        const HTML = `<div>${name} ${
          value ? `: ${Math.round(value)}%` : ""
        }</div>`;

        // Populate the popup and set its coordinates
        // based on the feature found.
        popup.setLngLat(e.lngLat).setHTML(HTML).addTo(map);
      };

      const mouseOut = () => {
        if (this.activeMenu != 1) {
          return;
        }
        map.getCanvas().style.cursor = "";
        popup.remove();
      };

      map.off("mousemove", HATCHED_MOBILITY_LAYER, mouseMove);
      map.off("mouseout", HATCHED_MOBILITY_LAYER, mouseOut);

      map.on("mousemove", HATCHED_MOBILITY_LAYER, mouseMove);

      map.on("mouseout", HATCHED_MOBILITY_LAYER, mouseOut);
    },
    getHealthZoneCoordonate(value, geoGranularity) {
      let coordinates = [];
      let dataKey = "name";
      if (geoGranularity == 2) {
        dataKey = "Zone+Peupl";
      }
      if (geoGranularity == 1) {
        let newValue = value;

        switch (value) {
          case "Kasai":
            newValue = "Kasaï";
            break;
          case "Kasai-Oriental":
            newValue = "Kasaï-Oriental";
            break;
          case "Kasai-Central":
            newValue = "Kasaï-Central";
            break;
          case "Equateur":
            newValue = "Équateur";
            break;
        }
        const feature = this.healthProvinceGeojsonCentered.features.find(
          (x) => x.properties[dataKey] == newValue
        );
        if (feature) {
          coordinates = feature.geometry.coordinates;
        }
      } else {
        const feature = this.healthZoneGeojsonCentered.features.find(
          (x) => x.properties[dataKey] == value
        );

        if (feature) {
          coordinates = feature.geometry.coordinates;
        }
      }
      return coordinates;
    },
    fluxArcStyle(flux24Data, geoGranularity, legendHover = null) {
      map.U.removeSource(["fluxCircleDataSource"]);
      map.U.removeLayer([HATCHED_MOBILITY_LAYER, "arc", "fluxCircleDataLayer"]);
      map.off("mouseleave", "fluxCircleDataLayer");
      map.off("mouseleave", "fluxCircleDataLayer");

      if (this.fluxType == 3) {
        return;
      }

      const localData = flux24Data;

      let features = [];
      let color = "#33ac2e";
      let arcData = [];
      let FluxFiltered = flux24Data;

      let dataKey = "name";
      if (geoGranularity == 2) {
        dataKey = "Zone+Peupl";
      }
      /**
       * format features data
       */
      const formatData = ({ references, observations }, key) => {
        if (!observations || !references) {
          return {
            percent: null,
            difference: null,
          };
        }
        let referenceVolume = null;
        let observationVolume = null;
        const countReference = references.length;
        if (countReference > 0) {
          if (countReference % 2 == 0) {
            let index = (countReference + 1) / 2;
            index = parseInt(index);
            const volume1 = references[index].volume;
            const volume2 = references[index - 1].volume;
            referenceVolume = (volume1 + volume2) / 2;
          } else {
            const index = (countReference + 1) / 2;
            referenceVolume = references[index - 1].volume;
          }
        }

        const countObservation = observations.length;
        if (countObservation > 0) {
          if (countObservation % 2 == 0) {
            let index = (countObservation + 1) / 2;
            index = parseInt(index);
            const volume1 = observations[index].volume;
            const volume2 = observations[index - 1].volume;
            observationVolume = (volume1 + volume2) / 2;
          } else {
            const index = (countObservation + 1) / 2;
            observationVolume = observations[index - 1].volume;
          }
        }
        const difference = observationVolume - referenceVolume;

        features.push({
          type: "Feature",
          geometry: {
            type: "Point",
            coordinates: this.getHealthZoneCoordonate(
              observations[0][key],
              geoGranularity
            ),
          },
          properties: {
            origin: observations[0][key],
            color: includes(this.fluxGeoOptions, observations[0][key])
              ? PALETTE.flux_in_color
              : PALETTE.flux_out_color,
            volume: observationVolume,
            volumeReference: referenceVolume,
            percent: Math.round((difference / referenceVolume) * 100),
            difference: difference,
          },
        });
      };

      if (this.fluxType == 2) {
        FluxFiltered.map((item) => {
          formatData(item, "destination");
        });
      } else if (this.fluxType == 4) {
        FluxFiltered.map((item) => {
          formatData(item, "zone");
        });
      } else {
        FluxFiltered.map((item) => {
          formatData(item, "origin");
        });
      }

      const filterArcData = (item, key) => {
        if (item.observations[0][key] == "Hors_Zone") {
          return;
        }
        
        const result = this.formatFluxData(item);
        arcData.push({
          percent: result.percent,
          volume: result.observationVolume,
          difference: result.difference,
          volume_reference: result.referenceVolume,
          origin: item.observations[0].origin,
          destination: item.observations[0].destination,
        });
      };

      let arcBrutData = [];
      if (this.fluxType == 1) {
        arcBrutData = FluxFiltered.map((item) => {
          filterArcData(item, "origin");
        });
      } else if (this.fluxType == 4) {
        arcBrutData = FluxFiltered.filter((item) => {
          return includes(this.fluxGeoOptions, item.targetZone);
        }).map((item) => {
          filterArcData(item, "zone");
        });
      } else {
        arcBrutData = FluxFiltered.map((item) => {
          filterArcData(item, "destination");
        });
      }



      const max = Math.max(...features.map((x) => x.properties.volume));
      const minArc = Math.min(...arcData.map((x) => x.percent));
      const maxArc = Math.max(...arcData.map((x) => x.percent));

      this.setDomaineExtValues({ min: minArc, max: maxArc, isPercent: true });

      console.log({ min: minArc, max: maxArc });
      if (legendHover) {
        if (features.length > 0) {
          features = features.filter(
            (x) =>
              x.properties.percent >= legendHover.de &&
              x.properties.percent <= legendHover.a
          );
        }
        if (arcData.length > 0) {
          arcData = arcData.filter(
            (x) => x.percent >= legendHover.de && x.percent <= legendHover.a
          );
        }
      }

      const circleData = {
        type: "geojson",
        generateId: true,
        data: {
          type: "FeatureCollection",
          features: features,
        },
      };

      const colorScalePositive = d3.scaleQuantile();
      const colorScaleNegative = d3.scaleQuantile();

      colorScalePositive.domain([0, maxArc]);
      colorScaleNegative.domain([minArc, 0]);

      const colorScale = d3.scaleQuantile().domain([minArc, maxArc]);

      if (this.fluxType == 1 || this.fluxType == 4) {
        colorScale.range(PALETTE.inflow);
        colorScaleNegative.range(PALETTE.inflow_negatif);
        colorScalePositive.range(PALETTE.inflow_positif);
      } else if (this.fluxType == 3) {
        colorScale.range(PALETTE.present);
      } else {
        colorScale.range(PALETTE.outflow);
        colorScaleNegative.range(PALETTE.outflow_negatif);
        colorScalePositive.range(PALETTE.outflow_positif);
      }

      map.addSource("fluxCircleDataSource", circleData);
      map.addLayer({
        id: "fluxCircleDataLayer",
        type: "circle",
        source: "fluxCircleDataSource",

        paint: {
          "circle-pitch-alignment": "map",
          "circle-blur": 0.1,
          "circle-opacity": [
            "case",
            ["boolean", ["feature-state", "hover"], false],
            0.7,
            0.5,
          ],
          "circle-radius": [
            "interpolate",
            ["linear"],
            ["zoom"],
            0,
            0.2,
            22,
            ["+", ["*", ["/", ["get", "volume"], max], 30], 10],
          ],
          "circle-color": ["get", "color"],
          "circle-stroke-color": ["get", "color"],
          "circle-stroke-width": 1,
        },
      });

      let hoveredStateId = null;
      const popup = new Mapbox.Popup({
        closeButton: false,
        closeOnClick: false,
      });
      // When the user moves their mouse over the state-fill layer, we'll update the
      // feature state for the feature under the mouse.
      map.on("mouseenter", "fluxCircleDataLayer", () => {
        if (this.activeMenu != 1) {
          return;
        }
        map.getCanvas().style.cursor = "pointer";
      });
      map.on("mousemove", "fluxCircleDataLayer", (e) => {
        if (this.activeMenu != 1) {
          return;
        }
        if (e.features.length > 0) {
          if (hoveredStateId) {
            map.setFeatureState(
              { source: "fluxCircleDataSource", id: hoveredStateId },
              { hover: false }
            );
          }
          hoveredStateId = e.features[0].id;
          map.setFeatureState(
            { source: "fluxCircleDataSource", id: hoveredStateId },
            { hover: true }
          );
        }
        const { origin, volume } = e.features[0].properties;
        const HTML = `<div>${origin} ${volume ? `: ${volume}` : ""}</div>`;

        // Populate the popup and set its coordinates
        // based on the feature found.
        popup.setLngLat(e.lngLat).setHTML(HTML).addTo(map);
      });

      // When the mouse leaves the state-fill layer, update the feature state of the
      // previously hovered feature.
      map.on("mouseout", "fluxCircleDataLayer", () => {
        if (this.activeMenu != 1) {
          return;
        }
        if (hoveredStateId) {
          map.setFeatureState(
            { source: "fluxCircleDataSource", id: hoveredStateId },
            { hover: false }
          );
        }
        hoveredStateId = null;
        map.getCanvas().style.cursor = "";
        popup.remove();
      });

      /**
       * get Rgb color from percent
       */
      const rgbColor = (percent) => {
        let color = null;

        if (percent >= 0) {
          color = colorScalePositive(percent);
        } else {
          color = colorScaleNegative(percent);
        }

        const colorRgb = d3.rgb(color);

        return [colorRgb.r, colorRgb.g, colorRgb.b];
      };

      // arcData=this.flux24.filter(x=>!x.isReference);
      const myDeckLayer = new MapboxLayer({
        id: "arc",
        data: arcData,
        type: ArcLayer,
        stroked: true,
        filled: true,
        getSourcePosition: (d) => {
          const coordinates = this.getHealthZoneCoordonate(
            d.origin,
            geoGranularity
          );
          return coordinates ?? d.position_start;
        },
        getTargetPosition: (d) => {
          const coordinates = this.getHealthZoneCoordonate(
            d.destination,
            geoGranularity
          );
          return coordinates ?? d.position_end;
        },
        getSourceColor: (d) => {
          return rgbColor(d.percent);
        },
        getTargetColor: (d) => {
          return rgbColor(d.percent);
        },
        getHeight: 1,
        getTilt: 1,
        opacity: 0.7,
        highlightColor: [51, 172, 46],
        autoHighlight: true,
        getWidth: (d) => {
          // return (d.volume / maxArc) * 9 + 3;
          return 3;
        },
        pickable: true,
        onHover: (info, event) => {
          this.$set(this.ArcLayerSelectedObject, "position", {
            top: info.y,
            left: info.x,
          });
          this.$set(this.ArcLayerSelectedObject, "item", info.object);
        },
      });
      map.addLayer(myDeckLayer);
    },
    infrastructure() {},
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
            "line-width": 1,
          },
        });
      } else {
        map.addLayer({
          id: this.drcSourceId,
          type: "line",
          source: this.drcHealthZone,
          layout: {},
          paint: {
            "line-color": "#627BC1",
            "line-width": 1,
          },
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
      this.medicalOrientations.map((item) => {
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
        this.medicalOrientationMakers.map((item) => {
          item.remove();
        });
      }
    },
    setMarkersSondage(sondage) {
      let values = this.sondages.filter((x) => x[sondage] && x[sondage] > 0);
      values.map((item) => {
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
            el.style.background = `linear-gradient(to right,#00b065 ${
              (worried * 100) / worried_count
            }%, #ff3b3b ${(worried * 100) / worried_count}%, #ff3b3b ${
              (not_worried * 100) / worried_count
            }%)`;
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
            el.style.background = `linear-gradient(to right,#00b065 ${
              (catch_virus * 100) / catch_virus_count
            }%, #ff3b3b ${(catch_virus * 100) / catch_virus_count}%, #ff3b3b ${
              (not_catch_virus * 100) / catch_virus_count
            }%)`;
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
            el.style.background = `linear-gradient(to right,#00b065 ${
              (price_increase * 100) / price_increase_count
            }%, #ff3b3b ${
              (price_increase * 100) / price_increase_count
            }%, #ff3b3b ${(not_price_increase * 100) / price_increase_count}%)`;
            break;
          case "mask":
            let mask = item.mask ? item.mask : 0;
            let not_mask = item.not_mask ? item.not_mask : 0;
            let mask_count = mask + not_mask;
            el.innerText = mask_count;
            longitude = item.longitude - 350 / 100000;
            latitude = item.latitude - 300 / 100000;
            el.style.background = `linear-gradient(to right,#00b065 ${
              (mask * 100) / mask_count
            }%, #ff3b3b ${(mask * 100) / mask_count}%, #ff3b3b ${
              (not_mask * 100) / mask_count
            }%)`;
            break;
          case "makala":
            let makala = item.makala ? item.makala : 0;
            let not_makala = item.not_makala ? item.not_makala : 0;
            let makala_count = makala + not_makala;
            el.innerText = makala_count;
            longitude = item.longitude + 300 / 10000;
            latitude = item.latitude + 150 / 100000;
            el.style.background = `linear-gradient(to right,#00b065 ${
              (makala * 100) / makala_count
            }%, #ff3b3b ${(makala * 100) / makala_count}%, #ff3b3b ${
              (not_makala * 100) / makala_count
            }%)`;
            break;
          case "flour":
            let flour = item.flour ? item.flour : 0;
            let not_flour = item.not_flour ? item.not_flour : 0;
            let flour_count = flour + not_flour;
            el.innerText = flour_count;
            longitude = item.longitude - 330 / 10000;
            latitude = item.latitude - 250 / 100000;
            el.style.background = `linear-gradient(to right,#00b065 ${
              (flour * 100) / flour_count
            }%, #ff3b3b ${(flour * 100) / flour_count}%, #ff3b3b ${
              (not_flour * 100) / flour_count
            }%)`;
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
      this.AllSondagesMarkers.filter((x) => x[sondage]).map((item) => {
        item.remove();
      });
    },
  },
};
</script>

<style lang="scss" scoped>
</style>
