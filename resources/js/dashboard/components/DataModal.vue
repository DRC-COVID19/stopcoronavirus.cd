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
          <b-tab title="FLux chart" v-if="hasFlux24Daily">
            <FluxChart :flux24Daily="flux24Daily" />
          </b-tab>
          <b-tab title="Flux data" v-if="hasFlux24">
            <SideFluxChart :flux24="flux24Local" />
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
      flux24Local: []
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
  computed: {
    hasFlux24() {
      return this.flux24.length > 0;
    },
    hasFlux24Daily() {
      return this.flux24Daily.length > 0;
    }
  },
  methods: {
    show() {
      this.flux24Local = this.flux24;
    }
  }
};
</script>

<style>
</style>