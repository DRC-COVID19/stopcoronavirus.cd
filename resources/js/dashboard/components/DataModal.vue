<template>
  <b-modal
    size="xl"
    :hide-footer="true"
    cancel-disabled
    ok-disabled
    centered
    :id="id"
    @shown="show"
  >
    <b-row>
      <b-col>
        <b-tabs content-class="mt-3">
          <b-tab title="Orientation" v-if="hasOrientation">
            <SideOrientation :medicalOrientations="medicalOrientations" />
          </b-tab>
          <b-tab title="Orientation chart" v-if="hasOrientation" :active="hasOrientation">
            <OrientationChart :medicalOrientationsStat="medicalOrientationsStat" />
          </b-tab>
          <b-tab title="FLux chart" v-if="hasFlux24Daily">
            <FluxChart
              :flux24Daily="flux24Daily"
              :flux24DailyIn="flux24DailyIn"
              :flux24DailyOut="flux24DailyOut"
            />
          </b-tab>
          <b-tab title="Flux data" v-if="hasFlux24">
            <SideFluxChart :flux24="flux24Local" />
          </b-tab>
          <b-tab title="Cas covid-19" v-if="covidCases">
            <SideCaseCovid :covidCases="covidCases" />
          </b-tab>
        </b-tabs>
      </b-col>
    </b-row>
  </b-modal>
</template>

<script>
import SideFluxChart from "./SideFlux";
import FluxChart from "./FluxChart";
import SideCaseCovid from "./SideCaseCovid";
import SideOrientation from "./SideOrientation";
import OrientationChart from "./OrientationChart";
export default {
  components: {
    SideFluxChart,
    FluxChart,
    SideCaseCovid,
    SideOrientation,
    OrientationChart
  },
  props: {
    id: {
      type: String,
      default: "data-modal"
    },
    flux24: {
      type: Array,
      default: () => []
    },
    flux24Daily: {
      type: Array,
      default: () => []
    },
    flux24DailyIn: {
      type: Array,
      default: () => []
    },
    flux24DailyOut: {
      type: Array,
      default: () => []
    },
    covidCases: {
      type: Object,
      default: null
    },
    medicalOrientations: {
      type: Array,
      default: null
    },
    medicalOrientationsStat: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      flux24Local: []
    };
  },
  computed: {
    hasFlux24() {
      return this.flux24.length > 0;
    },
    hasFlux24Daily() {
      return this.flux24Daily.length > 0;
    },
    hasCovidCases() {
      return this.getHasCoviCases();
    },
    hasOrientation() {
      return this.getHasOrientation();
    }
  },
  methods: {
    show() {
      this.flux24Local = this.flux24;
    },
    getHasCoviCases() {
      return this.covidCases && this.covidCases.data.features.length > 0;
    },
    getHasOrientation() {
      return this.medicalOrientations && this.medicalOrientations.length > 0;
    }
  }
};
</script>

<style>
</style>