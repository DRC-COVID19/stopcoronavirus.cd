<template>
  <MglMap
    :accessToken="MAPBOX_TOKEN"
    :mapStyle.sync="MAPBOX_DEFAULT_STYLE"
    :mapboxGl="Mapbox"
    :attributionControl="false"
    @load="onMapLoaded"
  >
    <MglAttributionControl />
    <MglNavigationControl position="top-right" />
    <MglGeolocateControl position="top-right" />
    <MglNavigationControl position="top-right" />
    <MglGeolocateControl position="top-right" />
    <MglScaleControl />
  </MglMap>
</template>

<script>
import { MAPBOX_TOKEN, MAPBOX_DEFAULT_STYLE } from "../config/env";
import Mapbox from "mapbox-gl";
import {
  MglMap,
  MglAttributionControl,
  MglNavigationControl,
  MglGeolocateControl,
  MglFullscreenControl,
  MglScaleControl
} from "vue-mapbox";

export default {
  components: {
    MglMap,
    MglNavigationControl,
    MglGeolocateControl
  },
  data() {
    return {
      MAPBOX_TOKEN,
      MAPBOX_DEFAULT_STYLE,
      Mapbox,
      popupCoordinates: [15.31389, -4.33167]
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