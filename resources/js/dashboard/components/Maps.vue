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
          layer: {
            paint: {
              // make circles larger as the user zooms from z12 to z22
              "circle-radius": [
                "interpolate",
                ["linear"],
                ["zoom"],
                10,
                [
                  "case", 
                  [">", ["get", "confirmed"], 3840], 100]
              ],
              "circle-color": "#3bb2d0"
            }
          }
        });
      } else {
        this.map.removeSource("covidCasesSource");
        this.map.removeLayer("covidCasesLayer");
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

<style>
</style>