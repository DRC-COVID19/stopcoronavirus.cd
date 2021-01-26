<template>
  <div>
    <!-- <b-container v-if="isLoading"> </b-container> -->
    <b-container class="p-0 flux-chart">
      <b-row class="mb-2">
        <b-col cols="12" md="6">
          <h3 class="d-flex align-items-center mb-0">
            <span class="ml-2 mr-2">{{
              targetZone ? targetZone[0] : null
            }}</span>
          </h3>
        </b-col>
        <b-col cols="12" md="6" class="d-flex justify-content-end">
          <div>
            <b-skeleton-wrapper :loading="isLoading">
              <template #loading>
                <b-skeleton width="171" height="20"></b-skeleton>
                <b-skeleton width="150" height="20"></b-skeleton>
              </template>
              <p class="small m-0 text-muted">
                Données fournies par
                <b>Africell</b>
              </p>
              <p class="small m-0">
                <span class="text-muted">Mise à jour du</span>
                <b>{{ moment(last_update).format("Y-MM-DD") }}</b>
              </p>
            </b-skeleton-wrapper>
          </div>
          <div>
            <div class="logoPartenaire" v-if="isLoading">
              <b-skeleton-img
                width="35"
                height="38"

              ></b-skeleton-img>
            </div>

            <b-img
              v-show="!isLoading"
              width="38"
              height="38"
              src="/img/africell_logo.jpg"
              class="logoPartenaire"
              alt="orange logo"
            />
          </div>
        </b-col>
      </b-row>
      <b-row no-gutters v-if="fluxAfricellDaily.length == 0 && !isLoading">
        <b-col cols="12" md="12" class="pr-1 pl-1">
          <b-card class="mb-3 flux-mobility active">
            <p class="text-muted">Données non disponibles</p>
          </b-card>
        </b-col>
      </b-row>
      <b-row no-gutters v-else>
        <b-col cols="12" md="12" class="pr-1 pl-1">
          <b-skeleton-wrapper :loading="isLoading" v-if="isStartEnd">
            <template #loading>
              <b-card class="mb-3 flux-mobility">
                <b-skeleton width="90%" height="20"></b-skeleton>
                <b-skeleton width="30%" height="60"></b-skeleton>
              </b-card>
            </template>

            <b-card
              class="mb-3 flux-mobility"
              :class="{ active: afriFluxType == 3 }"
              @click="selectFluxType(3)"
            >
              <h5 class="percent-title">
                Pourcentage de changement de la présence par rapport à la
                référence
              </h5>

              <div class="percent flux-presence">
                {{ volume ? volume.toFixed(2) : "NAN" }}%​
              </div>
            </b-card>
          </b-skeleton-wrapper>

          <b-skeleton-wrapper
            :loading="isLoading"
            v-if="!isStartEnd && isLoading"
          >
            <template #loading>
              <b-card no-body class="mb-3 p-2 cardtype1">
                <b-skeleton class="m-auto" width="60%" height="20"></b-skeleton>
                <b-skeleton class="mt-2" width="100%" height="180"></b-skeleton>
              </b-card>
            </template>
          </b-skeleton-wrapper>
          <FullScreen
            id="fullscreenOut"
            link="africell_prensence"
            @change="fullscreenMobileDaily"
            v-show="!isStartEnd && !isLoading"
          >
            <b-card
              no-body
              class="mb-3 p-2 cardtype1"
              :ref="`africell_prensence_card`"
            >
              <div class="text-center general-top-title">
                Evolution de la présence par rapport à la période de référence
              </div>
              <div class="chart-container">
                <canvas
                  height="200"
                  width="100vh"
                  ref="africell_prensence"
                  id="africell_prensence"
                ></canvas>
              </div>
            </b-card>
          </FullScreen>
        </b-col>
        <b-col cols="12" md="4" class="pr-1 pl-0">
          <b-skeleton-wrapper :loading="isLoading" v-if="isStartEnd">
            <template #loading>
              <b-card class="mb-3 flux-mobility">
                <b-skeleton width="90%" height="20"></b-skeleton>
                <b-skeleton width="60%" height="60"></b-skeleton>
              </b-card>
            </template>

            <b-card
              class="mb-3 flux-mobility"
              :class="{ active: afriFluxType == 1 }"
              @click="selectFluxType(1)"
            >
              <h5 class="percent-title">% de changement du nombre d'entrées</h5>

              <div class="percent flux-in-color">
                {{ flow_in ? flow_in.toFixed(2) : "NAN" }}%​
              </div>
            </b-card>
          </b-skeleton-wrapper>

          <b-skeleton-wrapper
            :loading="isLoading"
            v-if="!isStartEnd && isLoading"
          >
            <template #loading>
              <b-card no-body class="mb-3 p-2 cardtype1">
                <b-skeleton class="m-auto" width="60%" height="20"></b-skeleton>
                <b-skeleton class="mt-2" width="100%" height="190"></b-skeleton>
              </b-card>
            </template>
          </b-skeleton-wrapper>
          <FullScreen
            id="fullscreenOut"
            link="mobile_in"
            @change="fullscreenMobileDaily"
            v-show="!isStartEnd && !isLoading"
          >
            <b-card
              no-body
              class="mb-3 p-2 cardtype1"
              :ref="`mobile_out_in_tot_card`"
            >
              <div class="text-center general-top-title">
                Evolution du nombre d'entrées
              </div>
              <div class="chart-container">
                <canvas
                  height="200"
                  width="100vh"
                  ref="mobile_in"
                  id="mobile_in"
                ></canvas>
              </div>
            </b-card>
          </FullScreen>
          <div v-if="isStartEnd && isLoading">
            <b-skeleton-wrapper :loading="isLoading">
              <template #loading>
                <b-card no-body class="p-2 cardtype2">
                  <b-skeleton
                    class="m-auto"
                    width="60%"
                    height="20"
                  ></b-skeleton>
                  <b-skeleton
                    class="mt-2"
                    width="100%"
                    height="380"
                  ></b-skeleton>
                </b-card>
              </template>
            </b-skeleton-wrapper>
          </div>
          <FullScreen
            id="fullscreenIn"
            link="affricel_mobile_in"
            @change="fullscreenFluxInOut"
            v-show="isStartEnd && !isLoading"
          >
            <b-card no-body class="p-2 cardtype2">
              <div class="text-center general-top-title">
                % de changement du nombre d'entrées par origine
              </div>
              <div class="chart-container">
                <canvas
                  height="400"
                  width="100vh"
                  ref="affricel_mobile_in"
                  id="affricel_mobile_in"
                ></canvas>
              </div>
            </b-card>
          </FullScreen>
        </b-col>
        <b-col cols="12" md="4" class="pr-1 pl-0">
          <b-skeleton-wrapper :loading="isLoading" v-if="isStartEnd">
            <template #loading>
              <b-card class="mb-3 flux-mobility">
                <b-skeleton width="90%" height="20"></b-skeleton>
                <b-skeleton width="60%" height="60"></b-skeleton>
              </b-card>
            </template>

            <b-card
              class="mb-3 flux-mobility"
              :class="{ active: afriFluxType == 2 }"
              @click="selectFluxType(2)"
            >
              <h5 class="percent-title">
                % de changement du nombre de sorties
              </h5>

              <div class="percent flux-out-color">
                {{ flow_out ? flow_out.toFixed(2) : "NAN" }}%​
              </div>
            </b-card>
          </b-skeleton-wrapper>
          <b-skeleton-wrapper
            :loading="isLoading"
            v-if="!isStartEnd && isLoading"
          >
            <template #loading>
              <b-card no-body class="p-2 cardtype1">
                <b-skeleton class="m-auto" width="60%" height="20"></b-skeleton>
                <b-skeleton class="mt-2" width="100%" height="190"></b-skeleton>
              </b-card>
            </template>
          </b-skeleton-wrapper>
          <FullScreen
            id="fullscreenOut"
            link="mobile_out"
            @change="fullscreenMobileDaily"
            v-show="!isStartEnd && !isLoading"
          >
            <b-card
              no-body
              class="mb-3 p-2 cardtype1"
              :ref="`mobile_out_in_tot_card`"
            >
              <div class="text-center general-top-title">
                Evolution du nombre de sorties
              </div>
              <div class="chart-container">
                <canvas
                  height="200"
                  width="100vh"
                  ref="mobile_out"
                  id="mobile_out"
                ></canvas>
              </div>
            </b-card>
          </FullScreen>
          <div v-if="isStartEnd && isLoading">
            <b-skeleton-wrapper :loading="isLoading">
              <template #loading>
                <b-card no-body class="p-2 cardtype2">
                  <b-skeleton
                    class="m-auto"
                    width="60%"
                    height="20"
                  ></b-skeleton>
                  <b-skeleton
                    class="mt-2"
                    width="100%"
                    height="380"
                  ></b-skeleton>
                </b-card>
              </template>
            </b-skeleton-wrapper>
          </div>

          <FullScreen
            id="fullscreenOut"
            link="affricel_mobile_out"
            @change="fullscreenFluxInOut"
            v-show="isStartEnd && !isLoading"
          >
            <b-card no-body class="p-2 cardtype2">
              <div class="text-center general-top-title">
                % de changement du nombre de sorties par destination
              </div>
              <div class="chart-container">
                <canvas
                  height="400"
                  width="100vh"
                  ref="affricel_mobile_out"
                  id="affricel_mobile_out"
                ></canvas>
              </div>
            </b-card>
          </FullScreen>
        </b-col>
        <b-col cols="12" md="4" class="pr-1 pl-0">
          <b-skeleton-wrapper :loading="isLoading" v-if="isStartEnd">
            <template #loading>
              <b-card class="mb-3 flux-mobility">
                <b-skeleton width="90%" height="20"></b-skeleton>
                <b-skeleton width="60%" height="60"></b-skeleton>
              </b-card>
            </template>

            <b-card
              class="mb-3 flux-mobility"
              :class="{ active: afriFluxType == 4 }"
              @click="selectFluxType(4)"
            >
              <h5 class="percent-title">
                % de changement du nombre d'entrées-sorties
              </h5>

              <div class="percent dash-green">
                {{ flow_tot ? flow_tot.toFixed(2) : "NAN" }}%​
              </div>
            </b-card>
          </b-skeleton-wrapper>
          <b-skeleton-wrapper
            :loading="isLoading"
            v-if="!isStartEnd && isLoading"
          >
            <template #loading>
              <b-card no-body class="p-2 cardtype1">
                <b-skeleton class="m-auto" width="60%" height="20"></b-skeleton>
                <b-skeleton class="mt-2" width="100%" height="190"></b-skeleton>
              </b-card>
            </template>
          </b-skeleton-wrapper>
          <FullScreen
            id="fullscreenOut"
            link="mobile_out_in_tot"
            @change="fullscreenMobileDaily"
            v-show="!isStartEnd && !isLoading"
          >
            <b-card
              no-body
              class="mb-3 p-2 cardtype1"
              :ref="`mobile_out_in_tot_card`"
            >
              <div class="text-center general-top-title">
                Evolution du nombre d'entrées-sorties
              </div>
              <div class="chart-container">
                <canvas
                  height="200"
                  width="100vh"
                  ref="mobile_out_in_tot"
                  id="mobile_out_in_tot"
                ></canvas>
              </div>
            </b-card>
          </FullScreen>

          <div v-if="isStartEnd && isLoading">
            <b-skeleton-wrapper :loading="isLoading">
              <template #loading>
                <b-card no-body class="p-2 cardtype2">
                  <b-skeleton
                    class="m-auto"
                    width="60%"
                    height="20"
                  ></b-skeleton>
                  <b-skeleton
                    class="mt-2"
                    width="100%"
                    height="380"
                  ></b-skeleton>
                </b-card>
              </template>
            </b-skeleton-wrapper>
          </div>

          <FullScreen
            id="fullscreenIn"
            link="affricel_mobile_tot"
            @change="fullscreenFluxInOut"
            v-show="isStartEnd && !isLoading"
          >
            <b-card no-body class="p-2 cardtype2">
              <div class="text-center general-top-title">
                % de changement du nombre d'entrées-sorties par zone
              </div>
              <div class="chart-container">
                <canvas
                  height="400"
                  width="100vh"
                  ref="affricel_mobile_tot"
                  id="affricel_mobile_tot"
                ></canvas>
              </div>
            </b-card>
          </FullScreen>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import { PALETTE, AFRICELL_LAST_UPDATE } from "../../config/env";
import { mapMutations, mapState } from "vuex";
export default {
  components: {},
  props: {
    isLoading: {
      type: Boolean,
      default: false,
    },
    fluxAfricellDaily: {
      type: Array,
      default: () => [],
    },
    fluxAfricelPresence: {
      type: Array,
      default: () => [],
    },
    fluxAfricelInOut: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      // targetZone: null,
      mobilityTypes: [
        {
          lbl: "Inter zone",
          val: 1,
        },
        {
          lbl: "Hors zone",
          val: 2,
        },
        {
          lbl: "Général",
          val: 3,
        },
      ],
      selectedMobilityType: 1,
      lineCharts: [],
      configBarChart: {},

      barChart: [],
      flow_tot: null,
      flow_in: null,
      flow_out: null,
      volume: null,
      last_update: AFRICELL_LAST_UPDATE,
    };
  },
  mounted() {
    this.$nextTick(() => {
      this.mobileCalc(
        this.fluxAfricellDaily,
        "mobile_out_in_tot",
        PALETTE.dash_green,
        "flow_tot"
      );
    });
    this.$nextTick(() => {
      this.mobileCalc(
        this.fluxAfricellDaily,
        "mobile_in",
        PALETTE.flux_in_color,
        "flow_in"
      );
    });
    this.$nextTick(() => {
      this.mobileCalc(
        this.fluxAfricellDaily,
        "mobile_out",
        PALETTE.flux_out_color,
        "flow_out"
      );
    });
    this.$nextTick(() => {
      this.mobileCalc(
        this.fluxAfricelPresence,
        "africell_prensence",
        PALETTE.flux_presence,
        "volume"
      );
    });
    this.$nextTick(() => {
      this.africellDataInOut(this.fluxAfricelInOut);
    });
  },
  watch: {
    fluxAfricellDaily(newVal) {
      this.$nextTick(() => {
        this.mobileCalc(
          this.fluxAfricellDaily,
          "mobile_out_in_tot",
          PALETTE.dash_green,
          "flow_tot"
        );
      });
      this.$nextTick(() => {
        this.mobileCalc(
          this.fluxAfricellDaily,
          "mobile_in",
          PALETTE.flux_in_color,
          "flow_in"
        );
      });
      this.$nextTick(() => {
        this.mobileCalc(
          this.fluxAfricellDaily,
          "mobile_out",
          PALETTE.flux_out_color,
          "flow_out"
        );
      });
    },
    fluxAfricelPresence(newVal) {
      this.$nextTick(() => {
        this.mobileCalc(
          this.fluxAfricelPresence,
          "africell_prensence",
          PALETTE.flux_presence,
          "volume"
        );
      });
    },
    fluxAfricelInOut(newVal) {
      this.$nextTick(() => {
        this.africellDataInOut(newVal);
      });
    },
  },
  computed: {
    ...mapState({
      afriFluxType: (state) => state.flux.afriFluxType,
      targetZone: (state) => state.flux.fluxGeoOptions,
      observationDate: (state) => state.flux.observationDate,
    }),
    isStartEnd() {
      return this.observationDate.start == this.observationDate.end;
    },
  },
  methods: {
    ...mapMutations(["setAfriFluxType"]),
    africellDataInOut(data) {
      if (!this.isStartEnd || data.length == 0) {
        return;
      }
      const inData = data.filter((x) => x.zoneB == this.targetZone[0]);
      const outData = data.filter((x) => x.zoneA == this.targetZone[0]);

      this.drawHorizontalChart(
        inData,
        "affricel_mobile_in",
        "zoneA",
        "flow_AB",
        PALETTE.flux_in_color,
        "flow_tot"
      );
      this.drawHorizontalChart(
        outData,
        "affricel_mobile_out",
        "zoneB",
        "flow_AB",
        PALETTE.flux_out_color,
        "flow_tot"
      );
      this.drawHorizontalChart(
        outData,
        "affricel_mobile_tot",
        "zoneB",
        "flow_tot",
        PALETTE.dash_green,
        "flow_tot"
      );
    },
    selectFluxType(value) {
      this.setAfriFluxType(value);
    },
    mobileCalc(data, ref, color, attribut, title = null) {
      // const max = d3.max(data.map((x) => x.percent));
      // const min = d3.min(data.map((x) => x.percent));
      if (data.length == 0) {
        return;
      }
      if (data.length > 0) {
        this[attribut] = Number(data[0][attribut]);
      }
      this.configBarChart[ref] = {
        type: "line",
        data: {
          // labels: data.map((x) => new Date(x.date)),
          datasets: [
            {
              label: "Volume",
              fill: false,
              borderColor: color,
              backgroundColor: "rgb(166,180,205, 0.2)",
              data: data.map((x) => ({ x: new Date(x.date), y: x[attribut] })),
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
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
            display: !!title,
            text: title,
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
            enabled: true,
            mode: "interpolate",
            intersect: false,
            callbacks: {
              title: (a, d) => {
                return this.moment(a[0].xLabel).format("DD.MM");
              },
              label: (i, d) => {
                const element = data.find(
                  (x) => x.date == i.xLabel.format("YYYY-MM-DD")
                );
                if (!element) {
                  return;
                }
                return [
                  `volume: ${element[attribut].toFixed(2)}`,
                  // `Médiane: ${this.formatCash(element.volume_reference)}`,
                  // `Vol. en %: ${Math.round(element.percent)}`,
                ];
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
                  major: {
                    enabled: true,
                    fontStyle: "bold",
                    // fontColor: PALETTE.flux_in_color,
                    fontSize: 10,
                  },
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
                  // min: min < -100 ? (min + 10).toFixed(0) : -100,
                  // max: max >= 100 ? (max + 10).toFixed(0) : 100,
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
      this.lineCharts[ref] = new Chart(
        reference.getContext("2d"),
        this.configBarChart[ref]
      );
      reference.style.height = "200px";
      reference.style.maxHeight = "200px";
    },
    drawHorizontalChart(data, ref, YKey, XKey, color, title = null) {
      const localData = data.map((d) => ({ x: d[XKey], y: d[YKey] }));
      this.configBarChart[ref] = {
        type: "horizontalBar",
        data: {
          labels: localData.map((d) => d.y),
          datasets: [
            {
              label: "Observation",
              backgroundColor: color,
              borderColor: color,
              data: localData,
            },
          ],
        },
        options: {
          elements: {
            rectangle: {
              borderWidth: 2,
            },
          },
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            display: false,
            position: "bottom",
            labels: {
              fontSize: 9,
            },
          },
          title: {
            display: false,
            text: title,
            fontSize: 15,
          },
          scales: {
            xAxes: [
              {
                ticks: {
                  beginAtZero: true,
                  fontSize: 9,
                  // callback: (value, index, values) => {
                  //   return value;
                  // },
                },
              },
            ],
            yAxes: [
              {
                ticks: {
                  fontSize: 9,
                  callback: function (label, index, labels) {
                    const value = localData.find((x) => x.y == label);
                    if (value && value.x) {
                      return `${label} (${value.x.toFixed(1)}%)`;
                    } else {
                      return label;
                    }
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
      const reference = this.$refs[ref];
      if (this.barChart[ref]) this.barChart[ref].destroy();
      this.barChart[ref] = new Chart(
        reference.getContext("2d"),
        this.configBarChart[ref]
      );
      reference.style.height = "400px";
      reference.style.maxHeight = "400px";
    },
    fullscreenMobileDaily(fullscreen, ref) {
      //this.fullscreen = fullscreen
      if (!fullscreen) {
        const buttonResetZoom = this.lineCharts[ref].crosshair.button;
        if (buttonResetZoom) {
          buttonResetZoom.click();
        }

        this.configBarChart[ref].options.plugins.crosshair.zoom.enabled = false;
        this.$refs[ref].style.height = "200px";
        this.$refs[ref].style.MaxHeight = "200px";
        this.$refs[ref].height = "200px";

        this.lineCharts[ref].update();
      } else {
        this.configBarChart[ref].options.plugins.crosshair.zoom.enabled = true;
        this.$refs[ref].style.height = "400px";
        this.$refs[ref].height = "400px";

        this.lineCharts[ref].update();
      }
    },
    fullscreenFluxInOut(fullscreen, ref) {
      //this.fullscreen = fullscreen
      const element = this.$refs[ref];
      const parent_2 = element.parentElement.parentElement;
      if (!fullscreen) {
        element.style.height = "400px";
        element.height = "400px";
        element.parentElement.style.width = "";
        parent_2.style.display = "";
        parent_2.style.alignItem = "";
        parent_2.style.justifyContent = "";
        this.configBarChart[ref].options.legend.labels.fontSize = 9;
        this.configBarChart[ref].options.scales.xAxes[0].ticks.fontSize = 9;
        this.configBarChart[ref].options.scales.yAxes[0].ticks.fontSize = 9;
        this.barChart[ref].update();
      } else {
        // element.parentElement.style.width = "80%";
        // parent_2.style.display = "flex";
        // parent_2.style.alignItems = "center";
        // parent_2.style.justifyContent = "center";

        this.configBarChart[ref].options.legend.labels.fontSize = 12;
        this.configBarChart[ref].options.scales.xAxes[0].ticks.fontSize = 12;
        this.configBarChart[ref].options.scales.yAxes[0].ticks.fontSize = 12;
        this.barChart[ref].update();
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
@import "@~/sass/_mixins";
.logoPartenaire {
  height: 38px;
  width: auto;
  margin-left: 5px;
}
.fullscreen {
  .cardtype1 {
    canvas {
      width: calc(100vw - 19px) !important;
      height: 500px !important;
    }
  }
  .cardtype2 {
    canvas {
      width: 700px !important;
      height: calc(100vh - 32px) !important;
    }
  }
}
</style>
