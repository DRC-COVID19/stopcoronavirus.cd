<template>
  <b-modal
    size="xl"
    :hide-footer="true"
    cancel-disabled
    ok-disabled
    centered
    :id="id"
    @shown="show"
    @hidden="hidden"
  >
    <b-row>
      <b-col>
        <b-tabs content-class="mt-3">
          <b-tab title="Flux data" v-if="hasFlux24">
            <SideFluxChart :flux24="flux24Local" />
          </b-tab>
          <b-tab title="FLux chart">
            <FluxChart :flux24Daily="flux24Local" />
          </b-tab>
        </b-tabs>
      </b-col>
    </b-row>
  </b-modal>
</template>

<script>
import SideFluxChart from "./SideFlux";
import FluxChart from "./FluxChart";
export default {
  components: {
    SideFluxChart,
    FluxChart
  },
  data() {
    return {
      flux24Local: [],
      flux24DailyLocal: []
    };
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
    }
  },
  watch: {
    flux24Daily() {
      this.flux24DailyLocal = this.flux24Daily;
    }
  },
  computed: {
    hasFlux24() {
      return this.flux24Local.length > 0;
    },
    hasFlux24Daily() {
      return this.flux24Daily.length > 0;
    }
  },
  methods: {
    show() {
      this.flux24Local = this.flux24;
      this.flux24DailyLocal = this.flux24Daily;
    },
    hidden() {
      this.flux24Local = [];
      this.flux24DailyLocal = [];
    }
  }
};
</script>

<style>
</style>