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
              <i v-if="showMobiliteGenerale" class="fa fa-exchange-alt"></i>
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
          <b-card class="mb-3 flux-mobility" :class="{'active':fluxType==4}">
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

          <FullScreen
            id="mobile_generale_full"
            link="general_flux"
            @change="fullscreenGeneraleChange"
          >
            <b-card no-body class="cardtype1 mb-3 p-2">
              <div class="chart-container">
                <canvas height="200" width="100vh" ref="general_flux" id="general_flux"></canvas>
              </div>
            </b-card>
          </FullScreen>

          <b-row>
            <b-col cols="12" md="4">
              <FullScreen
                id="general_top_asc"
                link="general_top_asc"
                @change="fullscreenGenerale2Change"
              >
                <b-card no-body class="cardtype2 p-2">
                  <canvas height="200" width="100vh" ref="general_top_asc" id="general_top_asc"></canvas>
                </b-card>
              </FullScreen>
            </b-col>
            <b-col cols="12" md="4">
              <FullScreen
                id="general_top_desc"
                link="general_top_desc"
                @change="fullscreenGenerale2Change"
              >
                <b-card no-body class="cardtype2 p-2">
                  <canvas height="200" width="100vh" ref="general_top_desc" id="general_top_desc"></canvas>
                </b-card>
              </FullScreen>
            </b-col>
            <b-col cols="12" md="4"></b-col>
          </b-row>
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
              <FullScreen
                id="fullscreenEntrance"
                link="mobile_in"
                @change="fullscreenEntranceChange"
              >
                <b-card no-body class="cardtype1 mb-3 p-2" ref="mobile_entrance_card">
                  <div class="chart-container">
                    <canvas height="200" width="100vh" ref="mobile_in" id="mobile_in"></canvas>
                  </div>
                </b-card>
              </FullScreen>

              <FullScreen
                id="fullscreenEntrance2"
                link="mobile_entrance_2_card"
                @change="fullscreenEntrance2Change"
              >
                <b-card no-body class="cardtype2 p-2">
                  <canvas
                    height="200"
                    width="100vh"
                    ref="mobile_entrance_2_card"
                    id="mobile_entrance_2_card"
                  ></canvas>
                </b-card>
              </FullScreen>
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
              <FullScreen id="fullscreenOut" link="mobile_out" @change="fullscreenOutChange">
                <b-card no-body class="mb-3 p-2 cardtype1" :ref="`mobile_out_card`">
                  <div class="chart-container">
                    <canvas height="200" width="100vh" ref="mobile_out" id="mobile_out"></canvas>
                  </div>
                </b-card>
              </FullScreen>
              <FullScreen
                id="fullscreenOut2"
                link="mobile_out_2_card"
                @change="fullscreenOut2Change"
              >
                <b-card no-body class="p-2 cardtype2">
                  <canvas height="200" width="100vh" ref="mobile_out_2_card" id="mobile_out_2_card"></canvas>
                </b-card>
              </FullScreen>
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
          <FullScreen id="mobile_presence_full" link="mobile_presence">
            <b-card no-body class="mb-3 p-2" ref="mobile_presence_card">
              <div class="chart-container">
                <canvas height="200" width="100vh" ref="mobile_presence" id="mobile_presence"></canvas>
              </div>
            </b-card>
          </FullScreen>
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
import { debounce } from "lodash";
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
      this.mobilePresence();
    },
    fluxDataGroupedByDateIn() {
      this.mobileIn();
    },
    fluxDataGroupedByDateOut() {
      this.mobileOut();
    },
    fluxZoneGlobalIn() {
      console.log("in");
      debounce(function (e) {
        this.fluxMobilityFluxGeneralZone(
          this.fluxZoneGlobalIn,
          "general_top_asc",
          "general_top_desc",
          `Top 5 des zones avec une mobilité croissante`,
          "Top 5 des zones avec une mobilité decroissante"
        );
      }, 1000);
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

    this.mobilePresence();

    this.mobileOut();

    this.mobileIn();

    this.fluxMobilityFluxGeneralZone(
      this.fluxZoneGlobalIn,
      "general_top_asc",
      "general_top_desc",
      `Top 5 des zones avec une mobilité croissante`,
      "Top 5 des zones avec une mobilité decroissante"
    );

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
    mobilePresence() {
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
    mobileOut() {
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
    },
    mobileIn() {
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

        this.mobileCalc(general, "general_flux", PALETTE.flux_in_color);
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
        this.mobileCalc(general, `general_flux`, PALETTE.flux_in_color);
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
              borderWidth: 1.5,
              pointRadius: 1,
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
      reference.style.height = 200;
      if (this.lineCharts[ref]) this.lineCharts[ref].destroy();
      this.lineCharts[ref] = new Chart(reference.getContext("2d"), tempData);
      reference.style.height = 200;
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
      localData=localData.filter(x=>x.percent);
      localData.sort((a, b) => {
        return Number(a.volume ?? 0) < Number(b.volume ?? 0) ? 1 : -1;
      });

      localData.sort((a, b) => {
        return Number(a.percent ?? 0) < Number(b.percent ?? 0) ? 1 : -1;
      });

      localData = localData.slice(0, 10);

      this.drawHorizontalChart(
        localData,
        "zone",
        ref,
        key == "origin" ? PALETTE.flux_in_color : PALETTE.flux_out_color
      );
    },
    async fluxMobilityFluxGeneralZone(
      fluxDataIn,
      refAsc,
      refDesc,
      titleAsc,
      titleDesc
    ) {
      const generalData = [...fluxDataIn];

      const processing = new Promise((resolver, reject) => {
        const data = [];
        generalData.map(({ general_reference, general_observation, zone }) => {
          const result = this.formatFluxDataByMedian({
            references: general_reference,
            observations: general_observation,
          });

          data.push({
            zone: zone,
            volume: result.observationVolume,
            percent: result.percent,
            volume_reference: result.referenceVolume,
          });
        });
        resolver(data);
      });

      processing.then((data) => {
        let localData = data.filter(x=>x.percent);
        localData.sort((a, b) => {
          return Number(a.percent ?? 0) > Number(b.percent ?? 0) ? 1 : -1;
        });

        const ascData = localData.slice(0, 5);

        localData.sort((a, b) => {
          return Number(a.percent ?? 0) < Number(b.percent ?? 0) ? 1 : -1;
        });

        const descData = localData.slice(0, 5);

        this.drawHorizontalChart(
          ascData,
          "zone",
          refAsc,
          PALETTE.flux_in_color,
          titleAsc
        );
        this.drawHorizontalChart(
          descData,
          "zone",
          refDesc,
          PALETTE.flux_in_color,
          titleDesc
        );
      });
    },
    drawHorizontalChart(localData, key, ref, color, title = null) {
      const dataChart = {
        labels: localData.map((d) => d[key]),
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
            backgroundColor: color,
            borderColor: color,
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
            display: !!title,
            text: title,
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
                  callback: function (label, index, labels) {
                    return `${label} (${
                      localData.find((x) => x.zone == label).percent
                    }%)`;
                  },
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

      if (this.barChart2[ref]) this.barChart2[ref].destroy();
      this.barChart2[ref] = new Chart(
        this.$refs[ref].getContext("2d"),
        this.configBarChart2
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
    fullscreenGeneraleChange(fullscreen, ref) {
      console.log(this.$refs[ref]);
      if (!fullscreen) {
        this.$refs[ref].style.height = "200px";
      }
    },
    fullscreenGenerale2Change(fullscreen, ref) {
      this.$nextTick(() => {
        if (!fullscreen) {
          //   // ref.style.height = "400px";
          //   this.configBarChartGen.options.legend.labels.fontSize = 9;
          //   this.configBarChartGen.options.scales.xAxes[0].ticks.fontSize = 9;
          //   this.configBarChartGen.options.scales.yAxes[0].ticks.fontSize = 9;
          //   this.barChartGen.update();
          // } else {
          //   this.configBarChartGen.options.legend.labels.fontSize = 12;
          //   this.configBarChartGen.options.scales.xAxes[0].ticks.fontSize = 12;
          //   this.configBarChartGen.options.scales.yAxes[0].ticks.fontSize = 12;
          //   this.barChartGen.update();
        }
      });
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
</style>