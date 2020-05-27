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
    <MglVectorLayer
      :sourceId="kinSourceId"
      :layerId="kinSourceId"
      :layer="kinLayer"
    />
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
        "source-layer":"carte-administrative-de-la-vi-csh5cj"
      },
      drcSourceId: "states",
      kinSourceId: "statesKin"
    };
  },
  created() {
    this.map = null;
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