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
          <span class="lbl">
            {{valDe(i)}}
            <span v-if="domaineExtValues.isPercent">%</span>
          </span>

          <div
            class="range"
            :style="'background-color :' + data "
            :class="{hover : legendHover !== null && legendHover.de == valDe(i) }"
            @mouseenter="setLegendHover({de : valDe(i), a : valDe(i+1) })"
            @mouseleave="setLegendHover(null)"
          ></div>
        </div>
        <div class="inner inner-last">
          <span class="lbl">
            {{lastValue}}
            <span v-if="domaineExtValues.isPercent">%</span>
          </span>
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
      colors: [
        [...PALETTE.inflow_negatif, ...PALETTE.inflow_positif],
        [...PALETTE.outflow_negatif, ...PALETTE.outflow_positif],
        [...PALETTE.presence_negatif, ...PALETTE.presence_positif],
        [...PALETTE.general_negatif, ...PALETTE.general_positif],
      ],
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
    pourcentNegatif: function () {
      if (this.domaineExtValues.min >= 0) return 0;
      return Math.abs(this.domaineExtValues.min) / 5;
    },
    pourcentPositif: function () {
      if (this.domaineExtValues.max <= 0) return 0;
      return Math.abs(this.domaineExtValues.max) / 5;
    },
    lastValue() {
      if (this.domaineExtValues.max <= 0) return 100;
      else return Math.ceil(this.domaineExtValues.max);
    },
  },
  methods: {
    ...mapMutations(["setLegendHover"]),
    valDe: function (i) {
      if (this.domaineExtValues.min >= 0) {
        switch (i) {
          case 0:
            return "-100%";
          case 1:
            return "-80%";
          case 2:
            return "-60%";
          case 3:
            return "-40%";
          case 4:
            return "-20%";
        }
      } else if (this.domaineExtValues.max <= 0) {
        switch (i) {
          case 5:
            return "0%";
          case 6:
            return "20%";
          case 7:
            return "40%";
          case 8:
            return "60%";
          case 9:
            return "80%";
        }
      }

      if (i == 5) {
        return 0;
      } else if (i < 5)
        return Math.floor(this.domaineExtValues.min + i * this.pourcentNegatif);
      else return Math.floor((i - 5) * this.pourcentPositif);
    },
  },
};
</script>

<style scoped></style>

