<template>
  <div>
    <b-container v-if="isProvinceStatSeeing">
      <b-row>
        <b-col cols="12" md="6">
          <h5 @click="seeProvinceStat" class="return-global">
            <span class="fa fa-chevron-left"></span>
            {{fluxGeoOptions[0]}}
          </h5>
        </b-col>
        <b-col cols="12" md="6" class="text-right">
          <h5 class="m-0" style="font-size: 19px;">{{moment(last_update).format('Y-MM-DD')}}</h5>
          <span class="small text-muted">Dernière mise à jour</span>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols="12" md="6">
          <GlobalProvice
            title="Mobilité entrante par zone"
            :color="palette.flux_in_color"
            :globalData="fluxZoneGlobalIn"
            reference="fluxZoneglobalIn"
          />
        </b-col>
        <b-col cols="12" md="6">
          <GlobalProvice
            title="Mobilité sortante par zone"
            :color="palette.flux_out_color"
            :globalData="fluxZoneGlobalOut"
            reference="fluxZoneglobalOut"
          />
        </b-col>
      </b-row>
    </b-container>

    <b-container v-show="!isProvinceStatSeeing" class="p-0 flux-chart">
      <b-row>
        <b-col cols="12" md="6">
          <h3 class="d-flex">
            <span class="ml-2">{{targetZone}}</span>
            <button
              class="btn-alt-screen"
              @click="seeProvinceStat"
              title="Statistique des zones"
              v-if="fluxZoneGlobalIn.length>0|| fluxZoneGlobalOut.length>0"
            >
              <i class="fa fa-eye see-province-stat"></i>
            </button>
            <button
              class="btn-alt-screen"
              @click="toggleGlobalMobility()"
              title="Mobilité génerale"
            >
              <i v-if="!showMobiliteGenerale" class="fa fa-exchange-alt"></i>
              <i v-else class="fa fa-globe"></i>
            </button>
          </h3>
        </b-col>
        <b-col cols="12" md="6" class="text-right">
          <h5 class="m-0" style="font-size: 19px;">{{moment(last_update).format('Y-MM-DD')}}</h5>
          <span class="small text-muted">Dernière mise à jour</span>
        </b-col>
      </b-row>
      <b-row no-gutters>
        <b-col
          cols="12"
          v-show="showMobiliteGenerale"
          md="12"
          class="pl-0 pr-2 col-mobilite-generale"
        >
          <b-card
            class="mb-3 flux-mobility"
            :class="{'active':fluxType==4}"
            @click="selectFluxType(4)"
          >
            <h5 class="percent-title">Mobilité générale</h5>
            <div class="percent flux-in-color">{{percentGenerale}}%​</div>

            <p v-if="differenceGenerale>0" class="percent-p text-dash-color">
              {{differenceGenerale}} personnes de plus sont
              <br />entrées et sorties de la zone
            </p>
            <p v-else class="percent-p text-dash-color">
              {{ `${differenceGenerale}`}} personnes de moins sont
              <br />entrées et sorties de la zone
            </p>
          </b-card>

          <div class="fullscreen-container fullscreen-container1">
            <fullscreen ref="fullscreenGenerale" @change="fullscreenGeneraleChange">
              <b-card no-body class="cardtype1 mb-3 p-2" :ref="`mobile_generale_card`">
                <div class="chart-container">
                  <canvas height="200" width="100vh" ref="mobile_generale" id="mobile_generale"></canvas>
                </div>
              </b-card>
            </fullscreen>
            <button type="button" @click="toggleFullscreenGenerale" class="fullscreen-btn mini">
              <i class="fa fa-expand"></i>
            </button>
          </div>

          <!-- <div class="fullscreen-container fullscreen-container2">
            <fullscreen ref="fullscreenGenerale2" @change="fullscreenGenerale2Change">
              <b-card no-body class="cardtype2 p-2">
                <canvas
                  height="200"
                  width="100vh"
                  ref="mobile_generale_2_card"
                  id="mobile_generale_2_card"
                ></canvas>
              </b-card>
            </fullscreen>
            <button type="button" @click="toggleFullscreenGenerale2" class="fullscreen-btn mini">
              <i class="fa fa-expand"></i>
            </button>
          </div> -->
        </b-col>

        <b-col cols="12" v-show="!showMobiliteGenerale" md="4" class="pl-0 pr-2" ref="mobility">
          <b-row class="mb-3">
            <b-col cols="12">
              <b-card
                class="mb-3 flux-mobility"
                :class="{'active':fluxType==1}"
                @click="selectFluxType(1)"
              >
                <h5 class="percent-title">Mobilité entrante</h5>

                <div class="percent flux-in-color">{{percentIn}}%​</div>
                <p
                  v-if="differenceIn>0"
                  class="percent-p text-dash-color"
                >{{differenceIn}} personnes de plus sont entrées dans la zone</p>
                <p
                  v-else
                  class="percent-p text-dash-color"
                >{{ `${differenceIn}`}} personnes de moins sont entrées dans la zone</p>
              </b-card>
              <div class="fullscreen-container fullscreen-container1">
                <fullscreen ref="fullscreenEntrance" @change="fullscreenEntranceChange">
                  <b-card no-body class="cardtype1 mb-3 p-2" ref="mobile_entrance_card">
                    <div class="chart-container">
                      <canvas height="200" width="100vh" ref="mobile_in" id="mobile_in"></canvas>
                    </div>
                  </b-card>
                </fullscreen>
                <button type="button" @click="toggleFullscreenEntrance" class="fullscreen-btn mini">
                  <i class="fa fa-expand"></i>
                </button>
              </div>
              <div class="fullscreen-container fullscreen-container2">
                <fullscreen ref="fullscreenEntrance2" @change="fullscreenEntrance2Change">
                  <b-card no-body class="cardtype2 p-2">
                    <canvas
                      height="200"
                      width="100vh"
                      ref="mobile_entrance_2_card"
                      id="mobile_entrance_2_card"
                    ></canvas>
                  </b-card>
                </fullscreen>
                <button
                  type="button"
                  @click="toggleFullscreenEntrance2"
                  class="fullscreen-btn mini"
                >
                  <i class="fa fa-expand"></i>
                </button>
              </div>
            </b-col>
          </b-row>
        </b-col>

        <b-col cols="12" md="4" class="pr-0 pl-2" v-show="!showMobiliteGenerale">
          <b-row class="mb-3">
            <b-col cols="12">
              <b-card
                class="mb-3 flux-mobility"
                :class="{'active':fluxType==2}"
                @click="selectFluxType(2)"
              >
                <h5 class="percent-title">Mobilité sortante</h5>
                <div class="percent flux-out-color">{{percentOut}}%​</div>
                <p
                  v-if="differenceOut>0"
                  class="percent-p text-dash-color"
                >{{differenceOut}} personnes de plus sont sorties de la zone</p>
                <p
                  v-else
                  class="percent-p text-dash-color"
                >{{`${differenceOut}`}} personnes de moins sont sorties de la zone</p>
              </b-card>

              <div class="fullscreen-container fullscreen-container1">
                <fullscreen ref="fullscreenOut" @change="fullscreenOutChange">
                  <b-card no-body class="mb-3 p-2 cardtype1" :ref="`mobile_out_card`">
                    <div class="chart-container">
                      <canvas height="200" width="100vh" ref="mobile_out" id="mobile_out"></canvas>
                    </div>
                  </b-card>
                </fullscreen>
                <button type="button" @click="toggleFullscreenOut" class="fullscreen-btn mini">
                  <i class="fa fa-expand"></i>
                </button>
              </div>

              <div class="fullscreen-container fullscreen-container2">
                <fullscreen ref="fullscreenOut2" @change="fullscreenOut2Change">
                  <b-card no-body class="p-2 cardtype2">
                    <canvas
                      height="200"
                      width="100vh"
                      ref="mobile_out_2_card"
                      id="mobile_out_2_card"
                    ></canvas>
                    <!--
                    <div class="chart-container">
                        <div :ref="`mobile_out_${index}_2`" :id="`mobile_out_${index}_2`"></div>
                    </div>
                    -->
                  </b-card>
                </fullscreen>
                <button type="button" @click="toggleFullscreenOut2" class="fullscreen-btn mini">
                  <i class="fa fa-expand"></i>
                </button>
              </div>
            </b-col>
          </b-row>
        </b-col>
        <b-col cols="12" md="4" class="pr-0 pl-2" v-show="!showMobiliteGenerale">
          <b-card
            class="mb-3 flux-mobility"
            :class="{'active':fluxType==3}"
            @click="selectFluxType(3)"
          >
            <h5 class="percent-title">Présences</h5>
            <div class="percent flux-presence">{{percentPresence}}%​</div>
            <p
              v-if="differencePresence>0"
              class="percent-p text-dash-color"
            >{{differencePresence}} personnes de plus étaient présentes dans la zone</p>
            <p
              v-else
              class="percent-p text-dash-color"
            >{{`${differencePresence}`}} personnes de moins étaient présentes dans la zone</p>
          </b-card>
          <b-card no-body class="mb-3 p-2" ref="mobile_presence_card">
            <div class="chart-container">
              <canvas height="200" width="100vh" ref="mobile_presence" id="mobile_presence"></canvas>
            </div>
          </b-card>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import * as d3 from "d3";
import { mapState, mapMutations } from "vuex";
import { PALETTE, FLUX_LAST_UPDATE } from "../config/env";
import GlobalProvice from "./flux/GLobalProvince";
import { difference } from "@turf/turf";
export default {
  components: {
    GlobalProvice,
  },
  props: {
    flux24Daily: {
      type: Array,
      default: () => [],
    },
    flux24PresenceDaily: {
      type: Array,
      default: () => [],
    },
    flux24PresenceDailyIn: {
      type: Object,
      default: () => ({}),
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
    fluxZoneGlobalIn: {
      type: Array,
      default: () => [],
    },
    fluxZoneGlobalOut: {
      type: Array,
      default: () => [],
    },
    mobiliteGenerale: {
      type: Boolean,
      default: false,
    },
    fluxDataGroupedByDateIn: {
      type: Object,
      default: () => ({}),
    },
    fluxDataGroupedByDateOut: {
      type: Object,
      default: () => ({}),
    },
    fluxDataGroupedByDateGen: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      last_update: new Date(FLUX_LAST_UPDATE),
      flux24DailyInLocal: [],
      flux24DailyOutLocal: [],
      flux24DailyPresenceInLocal: [],
      flux24DailyGeneraleLocal: [],
      configBarChart: {},
      configBarChart2: {},
      configBarChartGen: {},
      barChart: null,
      barChart2: {},
      barChartGen: null,
      palette: PALETTE,
      showMobiliteGenerale: false,
      lineCharts: {},
      percentOut: null,
      percentIn: null,
      percentGenerale: null,
      percentPresence: null,
      differenceIn: null,
      differenceOut: null,
      differenceGenerale: null,
      differencePresence: null,
      targetZone: null,
    };
  },
  computed: {
    ...mapState({
      fluxType: (state) => state.flux.fluxType,
      isProvinceStatSeeing: (state) => state.flux.isProvinceStatSeeing,
      fluxGeoOptions: (state) => state.flux.fluxGeoOptions,
    }),
  },
  watch: {
    flux24DailyIn() {
      this.updateFluxInMobility();
      this.updateGeneralMobilityDaily();
    },
    flux24DailyOut() {
      this.updateFluxOutMobility();
      this.updateGeneralMobilityDaily();
    },
    flux24PresenceDailyIn() {
      this.$nextTick(() => {
        const result = this.fluxInPercent(this.flux24PresenceDailyIn);
        this.percentPresence = result.percent;
        this.differencePresence = this.formatCash(result.difference);
        this.mobileCalc(
          this.flux24PresenceDailyIn,
          `mobile_presence`,
          PALETTE.flux_presence
        );
      });
    },
    fluxDataGroupedByDateIn() {
      const result = this.fluxInPercent(this.fluxDataGroupedByDateIn);
      this.percentIn = result.percent;
      this.differenceIn = this.formatCash(result.difference);
      this.$nextTick(() => {
        this.mobileCalc(
          this.fluxDataGroupedByDateIn,
          `mobile_in`,
          PALETTE.flux_in_color
        );
      });
    },
    fluxDataGroupedByDateGen() {
      const result = this.fluxInPercent(this.fluxDataGroupedByDateGen);
      this.percentGenerale = result.percent;
      this.differenceGenerale = this.formatCash(result.difference);
      this.$nextTick(() => {
        this.mobileCalc(
          this.fluxDataGroupedByDateGen,
          `mobile_generale`,
          PALETTE.flux_in_color
        );
      });
    },
    fluxDataGroupedByDateOut() {
      const result = this.fluxInPercent(this.fluxDataGroupedByDateOut);
      this.percentOut = result.percent;
      this.differenceOut = this.formatCash(result.difference);
      this.$nextTick(() => {
        this.mobileCalc(
          this.fluxDataGroupedByDateOut,
          `mobile_out`,
          PALETTE.flux_out_color
        );
      });
    },
    mobiliteGenerale() {
      this.showMobiliteGenerale = this.mobiliteGenerale;
      if (this.mobiliteGenerale) this.selectFluxType(4);
    },
  },
  mounted() {
    this.showMobiliteGenerale = this.mobiliteGenerale;
    if (this.mobiliteGenerale) {
      this.selectFluxType(4);
    } else {
      this.selectFluxType(1);
    }

    this.updateFluxInMobility();
    this.updateFluxOutMobility();

    this.$nextTick(() => {
      const result = this.fluxInPercent(this.flux24PresenceDailyIn);
      this.percentPresence = result.percent;
      this.differencePresence = this.formatCash(result.difference);
      this.mobileCalc(
        this.flux24PresenceDailyIn,
        `mobile_presence`,
        PALETTE.flux_presence
      );
    });

    this.$nextTick(() => {
      const result = this.fluxInPercent(this.fluxDataGroupedByDateOut);
      this.percentOut = result.percent;
      this.differenceOut = this.formatCash(result.difference);
      this.mobileCalc(
        this.fluxDataGroupedByDateOut,
        `mobile_out`,
        PALETTE.flux_out_color
      );
    });

    this.$nextTick(() => {
      const result = this.fluxInPercent(this.fluxDataGroupedByDateIn);
      this.percentIn = result.percent;
      this.differenceIn = this.formatCash(result.difference);
      this.mobileCalc(
        this.fluxDataGroupedByDateIn,
        `mobile_in`,
        PALETTE.flux_in_color
      );
    });

    // this.$nextTick(() => {
    //   const result = this.fluxInPercent(this.fluxDataGroupedByDateGen);
    //   this.percentGenerale = result.percent;
    //   this.differenceGenerale = this.formatCash(result.difference);
    //   this.mobileCalc(
    //     this.fluxDataGroupedByDateGen,
    //     `mobile_generale`,
    //     PALETTE.flux_in_color
    //   );
    // });
    this.updateGeneralMobilityDaily();
    this.targetZone = this.fluxGeoOptions[0];

    this.$store.watch(
      (state) => state.flux.fluxGeoOptions,
      (value) => {
        this.targetZone = value[0];
      }
    );
  },
  methods: {
    ...mapMutations(["setFluxType", "setIsProvinceStatSeeing"]),
    selectFluxType(value) {
      this.setFluxType(value);
    },
    seeProvinceStat() {
      this.setIsProvinceStatSeeing(!this.isProvinceStatSeeing);
    },
    fluxInPercent({ referencesByDate, observationsByDate }) {
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
      return {
        percent: Math.round((difference / referenceVolume) * 100),
        difference: difference,
      };
    },
    fluxVolumObservation(items) {
      let totalObservation = 0;

      items.map((item) => {
        totalObservation += Number(item.difference);
      });
      return Math.round(totalObservation);
    },
    fluxVolumObservationPresencePercent(items) {
      const itemReference = items.filter((x) => x.isReference);

      const itemOnbservation = items.filter((x) => !x.isReference);

      let totalReference = 0;
      itemReference.map((value) => {
        totalReference += value.volume;
      });

      let totalObservation = 0;
      itemOnbservation.map((value) => {
        totalObservation += value.volume;
      });
      const averageObservation = totalObservation / itemOnbservation.length;
      const averageReference = totalReference / itemReference.length;
      let difference = totalObservation - totalReference;
      return Math.round((difference * 100) / totalReference);
    },
    fluxVolumObservationPresence(items) {
      let totalObservation = 0;

      items.map((item) => {
        totalObservation += Number(item.difference);
      });
      return Math.round(totalObservation / items.length);
    },
    extractFlux23DailyOut() {
      const flux24DailyOutLocal = [];
      if (this.flux24DailyOut.length > 0) {
        this.flux24DailyOut.forEach((item) => {
          let index = flux24DailyOutLocal.findIndex((x) =>
            x.some((y) => y.origin == item.origin)
          );
          if (index == -1) {
            let element = [];
            element.push(Object.assign({}, item));
            flux24DailyOutLocal.push(element);
          } else {
            flux24DailyOutLocal[index].push(Object.assign({}, item));
          }
        });
      }
      return flux24DailyOutLocal;
    },
    extractFlux23DailyIn() {
      let flux24DailyInLocal = [];
      console.log("flux24DailyIn", this.flux24DailyIn);
      if (this.flux24DailyIn.length > 0) {
        this.flux24DailyIn.forEach((item) => {
          let index = flux24DailyInLocal.findIndex((x) =>
            x.find((y) => y.destination == item.destination)
          );
          if (index == -1) {
            let element = [];
            element.push(item);
            flux24DailyInLocal.push(element);
          } else {
            flux24DailyInLocal[index].push(item);
          }
        });
      }
      return flux24DailyInLocal;
    },
    extractFlux23DailyGenerale() {
      let flux24DailyGeneraleLocal = [];
      if (this.flux24DailyGenerale.length > 0) {
        this.flux24DailyGenerale.forEach((item) => {
          let index = flux24DailyGeneraleLocal.findIndex((x) =>
            x.find((y) => y.targetZone == item.targetZone)
          );
          if (index == -1) {
            let element = [];
            element.push(item);
            flux24DailyGeneraleLocal.push(element);
          } else {
            flux24DailyGeneraleLocal[index].push(item);
          }
        });
      }
      return flux24DailyGeneraleLocal;
    },
    extractFlux24PresenceDailyIn() {
      let flux24PresenceDailyInLocal = [];
      if (this.flux24PresenceDailyIn.length > 0) {
        this.flux24PresenceDailyIn.forEach((item) => {
          let index = flux24PresenceDailyInLocal.findIndex((x) =>
            x.find((y) => y.zone == item.zone)
          );
          if (index == -1) {
            let element = [];
            element.push(Object.assign({}, item));
            flux24PresenceDailyInLocal.push(element);
          } else {
            flux24PresenceDailyInLocal[index].push(Object.assign({}, item));
          }
        });
      }
      return flux24PresenceDailyInLocal;
    },
    updateGeneralMobilityZone() {
      this.$nextTick(() => {
        const referencesByDateIn = this.flux24DailyIn.referencesByDate ?? [];
        const observationsByDateIn =
          this.flux24DailyIn.observationsByDate ?? [];

        const referencesByDateOut = this.flux24DailyOut.referencesByDate ?? [];
        const observationsByDateOut =
          this.flux24DailyOut.observationsByDate ?? [];

        const referencesByDate = [];
        const observationsByDate = [];
        [...referencesByDateIn, ...referencesByDateOut].map((item) => {
          const element = referencesByDate.find((x) => x.date == item.date);
          if (element) {
            element.volume += item.volume;
          } else {
            referencesByDate.push({
              volume: item.volume,
              date: item.date,
            });
          }
        });

        [...observationsByDateIn, ...observationsByDateOut].map((item) => {
          const element = observationsByDate.find((x) => x.date == item.date);
          if (element) {
            element.volume += item.volume;
          } else {
            observationsByDate.push({
              volume: item.volume,
              date: item.date,
            });
          }
        });
        const general = {
          referencesByDate,
          observationsByDate,
        };
        const result = this.fluxInPercent(general);
        this.percentGenerale = result.percent;
        this.differenceGenerale = this.formatCash(result.difference);
        this.mobileCalc(general, `mobile_generale`, PALETTE.flux_in_color);
      });
    },
    updateGeneralMobilityDaily() {
      this.$nextTick(() => {
        const referencesByDateIn =
          this.fluxDataGroupedByDateIn.referencesByDate ?? [];
        const observationsByDateIn =
          this.fluxDataGroupedByDateIn.observationsByDate ?? [];

        const referencesByDateOut =
          this.fluxDataGroupedByDateOut.referencesByDate ?? [];
        const observationsByDateOut =
          this.fluxDataGroupedByDateOut.observationsByDate ?? [];

        const referencesByDate = [];
        const observationsByDate = [];
        [...referencesByDateIn, ...referencesByDateOut].map((item) => {
          const element = referencesByDate.find((x) => x.date == item.date);
          if (element) {
            element.volume += item.volume;
          } else {
            referencesByDate.push({
              volume: item.volume,
              date: item.date,
            });
          }
        });

        [...observationsByDateIn, ...observationsByDateOut].map((item) => {
          const element = observationsByDate.find((x) => x.date == item.date);
          if (element) {
            element.volume += item.volume;
          } else {
            observationsByDate.push({
              volume: item.volume,
              date: item.date,
            });
          }
        });
        const general = {
          referencesByDate,
          observationsByDate,
        };
        const result = this.fluxInPercent(general);
        this.percentGenerale = result.percent;
        this.differenceGenerale = this.formatCash(result.difference);
        this.mobileCalc(general, `mobile_generale`, PALETTE.flux_in_color);
      });
    },
    updateFluxInMobility() {
      this.$nextTick(() => {
        this.fluxMobilityFluxZone(
          this.flux24DailyIn,
          "mobile_entrance_2_card",
          "origin"
        );
      });
    },
    updateFluxOutMobility() {
      this.$nextTick(() => {
        this.fluxMobilityFluxZone(
          this.flux24DailyOut,
          "mobile_out_2_card",
          "destination"
        );
      });
    },
    mobileCalc({ referencesByDate, observationsByDate }, ref, color) {
      // set the dimensions and margins of the graph

      if (!referencesByDate || !observationsByDate) {
        return;
      }

      let data = [];
      let DataReference = [];
      let totalReference = 0;
      let referenceAverage = 0;

      data = observationsByDate.map((item) => {
        const references = referencesByDate.filter((x) => x.day == item.day);

        const count = references.length;
        if (count > 0) {
          let referenceVolume = null;
          if (count % 2 == 0) {
            let index = (count + 1) / 2;
            index = parseInt(index);
            const volume1 = references[index].volume;
            const volume2 = references[index - 1].volume;
            referenceVolume = (volume1 + volume2) / 2;
          } else {
            const index = (count + 1) / 2;
            referenceVolume = references[index - 1].volume;
          }
          item.volume_reference = referenceVolume;
          const difference = item.volume - referenceVolume;
          item.difference = difference;
          item.percent = (difference / referenceVolume) * 100;
        } else {
          item.volume_reference = 0;
          item.difference = item.volume;
          item.percent = 0;
        }
        return Object.assign({}, item);
      });

      const max = d3.max(data.map((x) => x.percent));
      const min = d3.min(data.map((x) => x.percent));

      const tempData = {
        type: "line",
        data: {
          labels: data.map((x) => new Date(x.date)),
          datasets: [
            {
              label: "Volume",
              fill: false,
              borderColor: color,
              backgroundColor: "rgb(166,180,205, 0.2)",
              data: data.map((x) => ({ x: new Date(x.date), y: x.percent })),
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            display: false,
          },
          title: {
            display: false,
            text: "",
          },
          plugins: {
            crosshair: {
              line: {
                color: "#F66", // crosshair line color
                width: 1, // crosshair line width
                dashPattern: [5, 5], // crosshair line dash pattern
              },
              zoom: {
                enabled: false,
              },
              sync: {
                enabled: false, // enable trace line syncing with other charts
              },
            },
          },
          tooltips: {
            mode: "interpolate",
            intersect: false,
            callbacks: {
              title: (a, d) => {
                return this.moment(a[0].xLabel).format("DD.MM");
              },
              label: function (i, d) {
                return (
                  d.datasets[i.datasetIndex].label +
                  ": " +
                  Math.round(i.yLabel, 0).toLocaleString(undefined, {
                    minimumFractionDigits: 0,
                  })
                );
              },
            },
          },
          scales: {
            xAxes: [
              {
                display: true,
                gridLines: {
                  display: true,
                },
                scaleLabel: {
                  display: true,
                  labelString: "Période",
                  fontSize: 9,
                },
                type: "time",
                ticks: {
                  fontSize: 9,
                  beginAtZero: true,
                },
                time: {
                  unit: "day",
                  unitStepSize: 1,
                  displayFormats: {
                    day: "DD.MM",
                  },
                },
              },
            ],
            yAxes: [
              {
                display: true,
                ticks: {
                  fontSize: 9,
                  min: min < -100 ? min.toFixed(2) : -100,
                  max: max >= 100 ? max.toFixed(2) : 100,
                  callback: function (value) {
                    return value + "%";
                  },
                },
                scaleLabel: {
                  display: true,
                  labelString: "Pourcentage",
                  fontSize: 9,
                },
              },
            ],
          },
        },
      };
      let reference = this.$refs[ref];
      if (this.lineCharts[ref]) this.lineCharts[ref].destroy();
      this.lineCharts[ref] = new Chart(reference.getContext("2d"), tempData);
    },
    fluxMobilityFluxZone(InputData, ref, key) {
      if (!InputData) {
        return;
      }
      let DataReference = [];
      let totalReference = 0;
      let referenceAverage = 0;
      let localData = [];

      InputData.map(({ references, observations }) => {
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

        localData.push({
          zone: observations[0][key],
          percent: Math.round((difference / referenceVolume) * 100),
          difference: difference,
          volume: observationVolume,
          volume_reference: referenceVolume,
        });
      });

      localData.sort((a, b) => {
        return Number(a.volume ?? 0) < Number(b.volume ?? 0) ? 1 : -1;
      });

      localData.sort((a, b) => {
        return Number(a.percent ?? 0) < Number(b.percent ?? 0) ? 1 : -1;
      });

      localData = localData.slice(0, 10);

      const dataChart = {
        labels: localData.map((d) => d.zone),
        datasets: [
          {
            label: "Référence",
            backgroundColor: "#33ac2e",
            borderColor: "#33ac2e",
            borderWidth: 1,
            data: localData.map((d) => d.volume_reference),
          },
          {
            label: "Observation",
            backgroundColor: PALETTE.flux_out_color,
            borderColor: PALETTE.flux_out_color,
            data: localData.map((d) => d.volume),
          },
        ],
      };

      this.configBarChart2 = {
        type: "horizontalBar",
        data: dataChart,
        options: {
          elements: {
            rectangle: {
              borderWidth: 2,
            },
          },
          responsive: true,
          legend: {
            position: "bottom",
            labels: {
              fontSize: 9,
            },
          },
          title: {
            display: false,
            text: "Rapport des sorties avant et après confinement",
            color: "#6c757d",
          },
          scales: {
            xAxes: [
              {
                ticks: {
                  beginAtZero: true,
                  fontSize: 9,
                },
              },
            ],
            yAxes: [
              {
                ticks: {
                  fontSize: 9,
                },
              },
            ],
          },
          plugins: {
            crosshair: {
              sync: {
                enabled: false, // enable trace line syncing with other charts
              },
            },
          },
        },
      };

      console.log(this.$refs[ref]);
      if (this.barChart2[ref]) this.barChart2[ref].destroy();
      this.barChart2[ref] = new Chart(
        this.$refs[ref].getContext("2d"),
        this.configBarChart2
      );
    },
    mobileEntranceOrigin(data, index) {
      // data=array[{origin,volume,isReference}]
      let localData = [];
      data.forEach((item) => {
        let element = localData.find((x) => x.origin == item.origin);
        if (element) {
          element.volume += item.volume;
          element.volume_reference += item.volume_reference;
          element.difference += item.difference;
          if (element.difference == 0) {
            element.percent = 0;
          } else {
            element.percent =
              (element.difference / element.volume_reference) * 100;
          }
        } else {
          localData.push({
            origin: item.origin,
            volume_reference: item.volume_reference,
            volume: item.volume,
            difference: item.difference,
            percent: item.percent,
          });
        }
      });

      localData = localData.sort((a, b) => {
        return Number(a.volume ?? 0) < Number(b.volume ?? 0) ? 1 : -1;
      });

      localData = localData.sort((a, b) => {
        return Number(a.percent ?? 0) < Number(b.percent ?? 0) ? 1 : -1;
      });

      localData = localData.slice(0, 10);

      const dataChart2 = {
        labels: localData.map((d) => d.origin),
        datasets: [
          {
            label: "Référence",
            backgroundColor: "#33ac2e",
            borderColor: "#33ac2e",
            borderWidth: 1,
            data: localData.map((d) => d.volume_reference),
          },
          {
            label: "Observation",
            backgroundColor: PALETTE.flux_in_color,
            borderColor: PALETTE.flux_in_color,
            data: localData.map((d) => d.volume),
          },
        ],
      };

      const refInput = `mobile_entrance_${index}_2_card`;
      this.configBarChart = {
        type: "horizontalBar",
        data: dataChart2,
        options: {
          elements: {
            rectangle: {
              borderWidth: 2,
            },
          },
          responsive: true,
          legend: {
            position: "bottom",
            labels: {
              fontSize: 9,
            },
          },
          title: {
            display: false,
            text: "Rapport des entrées avant et après confinement",
            color: "#6c757d",
          },
          scales: {
            xAxes: [
              {
                ticks: {
                  beginAtZero: true,
                  fontSize: 9,
                },
              },
            ],
            yAxes: [
              {
                ticks: {
                  fontSize: 9,
                },
              },
            ],
          },
          plugins: {
            crosshair: {
              sync: {
                enabled: false, // enable trace line syncing with other charts
              },
            },
          },
        },
      };
      this.barChart = new Chart(
        this.$refs[refInput][0].getContext("2d"),
        this.configBarChart
      );
    },
    mobileGenerale(data, index) {
      let localData = [];

      data.forEach((item) => {
        let element = localData.find((x) => x.zone == item.zone);
        if (element) {
          element.volume += item.volume;
          element.volume_reference += item.volume_reference;
          element.difference += item.difference;
          if (element.difference == 0) {
            element.percent = 0;
          } else {
            element.percent =
              (element.difference / element.volume_reference) * 100;
          }
        } else {
          localData.push({
            origin: item.origin,
            destination: item.destination,
            zone: item.zone,
            targetZone: item.targetZone,
            volume_reference: item.volume_reference,
            volume: item.volume,
            difference: item.difference,
            percent: item.percent,
          });
        }
      });

      localData = localData.sort((a, b) => {
        return Number(a.percent ?? 0) < Number(b.percent ?? 0) ? 1 : -1;
      });

      localData = localData.slice(0, 10);

      const dataChart2 = {
        labels: localData.map((d) => d.zone),
        datasets: [
          {
            label: "Référence",
            backgroundColor: "#33ac2e",
            borderColor: "#33ac2e",
            borderWidth: 1,
            data: localData.map((d) => d.volume_reference),
          },
          {
            label: "Observation",
            backgroundColor: PALETTE.flux_in_color,
            borderColor: PALETTE.flux_in_color,
            data: localData.map((d) => d.volume),
          },
        ],
      };

      const refInput = `mobile_generale_${index}_2_card`;
      this.configBarChartGen = {
        type: "horizontalBar",
        data: dataChart2,
        options: {
          elements: {
            rectangle: {
              borderWidth: 2,
            },
          },
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            position: "bottom",
            labels: {
              fontSize: 9,
            },
          },
          title: {
            display: false,
            text: "Rapport des entrées-sorties avant et après confinement",
            color: "#6c757d",
          },
          scales: {
            xAxes: [
              {
                ticks: {
                  beginAtZero: true,
                  fontSize: 9,
                },
              },
            ],
            yAxes: [
              {
                ticks: {
                  fontSize: 9,
                },
              },
            ],
          },
          plugins: {
            crosshair: {
              sync: {
                enabled: false, // enable trace line syncing with other charts
              },
            },
          },
        },
      };

      if (this.barChartGen) {
        this.barChartGen.destroy();
      }
      this.barChartGen = new Chart(
        this.$refs[refInput][0].getContext("2d"),
        this.configBarChartGen
      );
    },
    toggleFullscreenEntrance() {
      this.$refs.fullscreenEntrance[0].toggle();
    },
    fullscreenEntranceChange(fullscreen) {
      //this.fullscreen = fullscreen
      if (!fullscreen) {
        this.$refs.mobile_in[0].style.height = "200px";
        this.$refs.mobile_in[0].height = "200px";
      }
    },
    toggleFullscreenEntrance2() {
      this.$refs.fullscreenEntrance2[0].toggle();
    },
    fullscreenEntrance2Change(fullscreen) {
      //this.fullscreen = fullscreen
      if (!fullscreen) {
        this.$refs.mobile_entrance_0_2_card[0].style.height = "400px";
        this.$refs.mobile_entrance_0_2_card[0].height = "400px";

        this.configBarChart.options.legend.labels.fontSize = 9;
        this.configBarChart.options.scales.xAxes[0].ticks.fontSize = 9;
        this.configBarChart.options.scales.yAxes[0].ticks.fontSize = 9;
        this.barChart.update();
      } else {
        this.configBarChart.options.legend.labels.fontSize = 12;
        this.configBarChart.options.scales.xAxes[0].ticks.fontSize = 12;
        this.configBarChart.options.scales.yAxes[0].ticks.fontSize = 12;
        this.barChart.update();
      }
    },
    toggleFullscreenOut() {
      this.$refs.fullscreenOut[0].toggle();
    },
    fullscreenOutChange(fullscreen) {
      //this.fullscreen = fullscreen
      if (!fullscreen) {
        this.$refs.mobile_out[0].style.height = "200px";
        this.$refs.mobile_out[0].height = "200px";
      }
    },
    toggleFullscreenOut2() {
      this.$refs.fullscreenOut2[0].toggle();
    },
    fullscreenOut2Change(fullscreen) {
      //this.fullscreen = fullscreen
      if (!fullscreen) {
        this.$refs.mobile_out_0_2_card[0].style.height = "400px";
        this.$refs.mobile_out_0_2_card[0].height = "400px";

        this.configBarChart2.options.legend.labels.fontSize = 9;
        this.configBarChart2.options.scales.xAxes[0].ticks.fontSize = 9;
        this.configBarChart2.options.scales.yAxes[0].ticks.fontSize = 9;
        this.barChart2.update();
      } else {
        this.configBarChart2.options.legend.labels.fontSize = 12;
        this.configBarChart2.options.scales.xAxes[0].ticks.fontSize = 12;
        this.configBarChart2.options.scales.yAxes[0].ticks.fontSize = 12;
        this.barChart2.update();
      }
    },
    toggleFullscreenGenerale() {
      this.$refs.fullscreenGenerale[0].toggle();
    },
    fullscreenGeneraleChange(fullscreen) {
      if (!fullscreen) {
        this.$refs.mobile_generale[0].style.height = "200px";
        this.$refs.mobile_generale[0].height = "200px";
      }
    },
    toggleFullscreenGenerale2() {
      this.$refs.fullscreenGenerale2[0].toggle();
    },
    fullscreenGenerale2Change(fullscreen) {
      if (!fullscreen) {
        this.$refs.mobile_generale_0_2_card[0].style.height = "400px";
        this.$refs.mobile_generale_0_2_card[0].height = "400px";

        this.configBarChartGen.options.legend.labels.fontSize = 9;
        this.configBarChartGen.options.scales.xAxes[0].ticks.fontSize = 9;
        this.configBarChartGen.options.scales.yAxes[0].ticks.fontSize = 9;
        this.barChartGen.update();
      } else {
        this.configBarChartGen.options.legend.labels.fontSize = 12;
        this.configBarChartGen.options.scales.xAxes[0].ticks.fontSize = 12;
        this.configBarChartGen.options.scales.yAxes[0].ticks.fontSize = 12;
        this.barChartGen.update();
      }
    },
    toggleGlobalMobility() {
      this.showMobiliteGenerale = !this.showMobiliteGenerale;
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
@import "@~/sass/_mixins";

.flux-chart {
  @include card-style;
  .see-province-stat {
    font-size: 1rem;
    cursor: pointer;
  }
}
.return-global {
  cursor: pointer;
}
.flux-mobility {
  cursor: pointer;
  &.active {
    background: #2e5bff14;
  }
}

.legend {
  list-style: none;
  li {
    span {
      display: inline-block;
      width: 20px;
      height: 20px;
      margin-right: 5px;
      &.reference {
        background: #9e9e9e;
      }
      &.observation {
        background: #4caf50;
      }
    }
  }
}
.percent-title {
  font-size: 1rem;
}
.percent {
  font-size: 2.5rem;
  font-weight: bold;
}
.percent-p {
  font-size: 0.7rem;
}
.chart-container {
  div {
    position: relative;
  }
}
.fullscreen-container {
  height: auto;
  display: flex;
}
.fullscreen-container2 .fullscreen {
  align-items: flex-start;
}

.fullscreen-container1 .fullscreen-btn {
  bottom: 25px;
}
.fullscreen {
  display: flex;
  align-items: center;
  justify-content: center;
  .cardtype1 {
    width: 100%;
    height: 50%;
    .chart-container {
      height: 100%;
    }
  }
  .cardtype2 {
    width: 40%;
    height: auto;
    canvas {
      height: 100%;
    }
  }
}
.fullscreen-container1 {
  canvas {
    height: 200px !important;
  }
  .fullscreen canvas {
    height: auto !important;
  }
}
.col-mobilite-generale {
  .cardtype2 {
    height: 100%;
  }
  .fullscreen-container2 {
    canvas {
      height: 400px !important;
    }
    .fullscreen canvas {
      height: 100% !important;
    }
  }
}
.btn-alt-screen {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  margin-left: 5px;
  i {
    font-size: 13px !important;
  }
  &:focus {
    outline: none;
  }
  &:active {
    opacity: 0.4;
  }
}
</style>