<template>
  <div class="legend-container">
    <div class="legend">
      <div class="no-data">
        <span class="lbl mb-1">Aucune donnée</span>
        <div
          class="range empty"
          :style="'background-color : ' + color_nodata"
          :class="{hover : legendHover !== null && legendHover.de === null }"
          @mouseenter="setLegendHover({de : null, a : null})"
          @mouseleave="setLegendHover(null)"
        ></div>
      </div>
      <div class="datas">
        <div class="inner" v-for="(data, i) in colors[color]" :key="i">
          <span class="lbl">{{valDe(i)}}</span>
          <span v-if="domaineExtValues.isPercent">%</span>
          <div
            class="range"
            :style="'background-color :' + data "
            :class="{hover : legendHover !== null && legendHover.de == valDe(i) }"
            @mouseenter="setLegendHover({de : valDe(i), a : valDe(i+1) })"
            @mouseleave="setLegendHover(null)"
          ></div>
        </div>
        <div class="inner inner-last">
          <span class="lbl">{{Math.ceil(domaineExtValues.max)}}</span>
          <span v-if="domaineExtValues.isPercent">%</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapMutations, mapState } from "vuex";
import { PALETTE } from "../config/env";

export default {
  name: "Legend",
  data: function () {
    return {
      colors: [PALETTE.inflow, PALETTE.outflow, PALETTE.present],
      color_nodata: PALETTE.nodata,
    };
  },
  computed: {
    ...mapGetters(["fluxType", "legendHover"]),
    ...mapState({
      domaineExtValues: (state) => state.flux.domaineExtValues,
    }),
    color: function () {
      if (this.fluxType) {
        if (this.colors[this.fluxType - 1]) return this.fluxType - 1;
        return 0;
      }
      return 0;
    },
    pourcent: function () {
      return (
        Math.abs(this.domaineExtValues.max - this.domaineExtValues.min) / 8
      );
    },
  },
  methods: {
    ...mapMutations(["setLegendHover"]),
    valDe: function (i) {
      return Math.floor(this.domaineExtValues.min + i * this.pourcent);
    },
  },
};
</script>

<style scoped></style>

