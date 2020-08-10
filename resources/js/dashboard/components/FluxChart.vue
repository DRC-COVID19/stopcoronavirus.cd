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
      <b-row no-gutters>
        <b-col cols="12" md="4" class="pl-0 pr-2" ref="mobility">
          <b-row v-for="(item,index) in flux24DailyInLocal" :key="index" class="mb-3">
            <b-col cols="12">
              <h3>
                {{item[0].destination}}
                <span
                  v-if="fluxZoneGlobalIn.length>0|| fluxZoneGlobalOut.length>0"
                  class="fa fa-eye see-province-stat"
                  @click="seeProvinceStat"
                ></span>
              </h3>
              <b-card
                class="mb-3 flux-mobility"
                :class="{'active':fluxType==1}"
                @click="selectFluxType(1)"
              >
                <h5 class="percent-title">Mobilité entrante</h5>

                <div class="percent flux-in-color">{{fluxInPercent(item)}}%​</div>
                <p
                  v-if="fluxVolumObservation(item)>0"
                  class="percent-p text-dash-color"
                >{{formatCash(fluxVolumObservation(item))}} personnes de plus sont entrées dans la zone</p>
                <p
                  v-else
                  class="percent-p text-dash-color"
                >{{formatCash(fluxVolumObservation(item)*-1) }} personnes de moins sont entrées dans la zone</p>
              </b-card>
              <b-card no-body class="mb-3 p-2" :ref="`mobile_entrance_${index}_card`">
                <div class="chart-container">
                  <canvas
                    height="200"
                    width="100vh"
                    :ref="`mobile_entrance_${index}`"
                    :id="`mobile_entrance_${index}`"
                  ></canvas>
                </div>
              </b-card>

              <b-card no-body class="p-2">
                <canvas
                  height="200"
                  width="100vh"
                  :ref="`mobile_entrance_${index}_2_card`"
                  :id="`mobile_entrance_${index}_2_card`"
                ></canvas>
              </b-card>
            </b-col>
          </b-row>
        </b-col>
        <b-col cols="12" md="4" class="pr-0 pl-2">
          <b-row v-for="(item,index) in flux24DailyOutLocal" :key="index" class="mb-3">
            <b-col cols="12">
              <h3>&nbsp;</h3>
              <b-card
                class="mb-3 flux-mobility"
                :class="{'active':fluxType==2}"
                @click="selectFluxType(2)"
              >
                <h5 class="percent-title">Mobilité sortante</h5>
                <div class="percent flux-out-color">{{fluxInPercent(item)}}%​</div>
                <p
                  v-if="fluxVolumObservation(item)>0"
                  class="percent-p text-dash-color"
                >{{formatCash(fluxVolumObservation(item))}} personnes de plus sont sorties de la zone</p>
                <p
                  v-else
                  class="percent-p text-dash-color"
                >{{formatCash(fluxVolumObservation(item)*-1)}} personnes de moins sont sorties de la zone</p>
              </b-card>
              <b-card no-body class="mb-3 p-2" :ref="`mobile_out_${index}_card`">
                <div class="chart-container">
                  <canvas
                    height="200"
                    width="100vh"
                    :ref="`mobile_out_${index}`"
                    :id="`mobile_out_${index}`"
                  ></canvas>
                </div>
              </b-card>
              <b-card no-body class="p-2">
                <canvas
                  height="200"
                  width="100vh"
                  :ref="`mobile_out_${index}_2_card`"
                  :id="`mobile_out_${index}_2_card`"
                ></canvas>
                <!--
                <div class="chart-container">
                    <div :ref="`mobile_out_${index}_2`" :id="`mobile_out_${index}_2`"></div>
                </div>
                -->
              </b-card>
            </b-col>
          </b-row>
        </b-col>
        <b-col cols="12" md="4" class="pr-0 pl-2">
          <b-row v-for="(item,index) in flux24DailyPresenceInLocal" :key="index" class="mb-3">
            <b-col cols="12">
              <h5 class="m-0" style="font-size: 19px;">{{moment(last_update).format('Y-MM-DD')}}</h5>
              <span class="small text-muted">Dernière mise à jour</span>
              <b-card
                class="mb-3 flux-mobility"
                :class="{'active':fluxType==3}"
                @click="selectFluxType(3)"
              >
                <h5 class="percent-title">Présences</h5>
                <div class="percent flux-presence">{{fluxInPercent(item)}}%​</div>
                <p
                  v-if="fluxVolumObservation(item)>0"
                  class="percent-p text-dash-color"
                >{{formatCash(fluxVolumObservation(item))}} personnes de plus étaient présentes dans la zone</p>
                <p
                  v-else
                  class="percent-p text-dash-color"
                >{{formatCash(fluxVolumObservation(item)*-1)}} personnes de moins étaient présentes dans la zone</p>
              </b-card>
              <b-card no-body class="mb-3 p-2" :ref="`mobile_presence_${index}_card`">
                <div class="chart-container">
                  <canvas
                    height="200"
                    width="100vh"
                    :ref="`mobile_presence_${index}`"
                    :id="`mobile_presence_${index}`"
                  ></canvas>
                </div>
              </b-card>
            </b-col>
          </b-row>
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
      type: Array,
      default: () => [],
    },
    flux24DailyIn: {
      type: Array,
      default: () => [],
    },
    flux24DailyOut: {
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
  },
  data() {
    return {
      last_update: new Date(FLUX_LAST_UPDATE),
      flux24DailyInLocal: [],
      flux24DailyOutLocal: [],
      flux24DailyPresenceInLocal: [],
      palette: PALETTE,
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
      this.flux24DailyInLocal = this.extractFlux23DailyIn();

      this.$nextTick(() => {
        this.flux24DailyInLocal.forEach((item, index) => {
          this.mobileCalc(
            item,
            `mobile_entrance_${index}`,
            PALETTE.flux_in_color
          );
          this.mobileEntranceOrigin(item, index);
        });
      });
    },
    flux24DailyOut() {
      this.flux24DailyOutLocal = this.extractFlux23DailyOut();

      this.$nextTick(() => {
        this.flux24DailyOutLocal.forEach((item, index) => {
          this.mobileCalc(item, `mobile_out_${index}`, PALETTE.flux_out_color);
          this.mobileOutDestination(item, index);
        });
      });
    },
    flux24PresenceDailyIn() {
      this.flux24DailyPresenceInLocal = this.extractFlux24PresenceDailyIn();
      this.$nextTick(() => {
        this.flux24DailyPresenceInLocal.forEach((item, index) => {
          this.mobileCalc(
            item,
            `mobile_presence_${index}`,
            PALETTE.flux_presence
          );
        });
      });
    },
  },
  mounted() {
    this.flux24DailyInLocal = this.extractFlux23DailyIn();
    this.flux24DailyOutLocal = this.extractFlux23DailyOut();
    this.flux24DailyPresenceInLocal = this.extractFlux24PresenceDailyIn();

    this.$nextTick(() => {
      this.flux24DailyInLocal.forEach((item, index) => {
        this.mobileCalc(
          item,
          `mobile_entrance_${index}`,
          PALETTE.flux_in_color
        );
        this.mobileEntranceOrigin(item, index);
      });
    });
    this.$nextTick(() => {
      this.flux24DailyOutLocal.forEach((item, index) => {
        this.mobileCalc(item, `mobile_out_${index}`, PALETTE.flux_out_color);
        this.mobileOutDestination(item, index);
      });
    });
    this.$nextTick(() => {
      this.flux24DailyPresenceInLocal.forEach((item, index) => {
        this.mobileCalc(
          item,
          `mobile_presence_${index}`,
          PALETTE.flux_presence
        );
      });
    });
  },
  methods: {
    ...mapMutations(["setFluxType", "setIsProvinceStatSeeing"]),
    selectFluxType(value) {
      this.setFluxType(value);
    },
    seeProvinceStat() {
      this.setIsProvinceStatSeeing(!this.isProvinceStatSeeing);
    },
    fluxInPercent(items) {
      let totalDifference = 0;
      let totalReference = 0;
      items.map((item) => {
        totalDifference += item.difference;
        totalReference += item.volume_reference;
      });
      return Math.round((totalDifference / totalReference) * 100);
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
      let flux24DailyOutLocal = [];
      if (this.flux24DailyOut.length > 0) {
        this.flux24DailyOut.forEach((item) => {
          let index = flux24DailyOutLocal.findIndex((x) =>
            x.find((y) => y.origin == item.origin)
          );
          if (index == -1) {
            let element = [];
            element.push(item);
            flux24DailyOutLocal.push(element);
          } else {
            flux24DailyOutLocal[index].push(item);
          }
        });
      }
      return flux24DailyOutLocal;
    },
    extractFlux23DailyIn() {
      let flux24DailyInLocal = [];
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
    mobileCalc(dataPram, ref, color) {
      // set the dimensions and margins of the graph
      let data = [];
      let DataReference = [];
      let totalReference = 0;
      let referenceAverage = 0;

      dataPram.map((item) => {
        let element = data.find((x) => x.date == item.date);
        if (element) {
          element.volume += item.volume;
          element.volume_reference += item.volume_reference;
          element.difference += item.difference;
          element.percent =
            (element.difference / element.volume_reference) * 100;
        } else {
          data.push({
            date: item.date,
            volume: item.volume,
            difference: item.difference,
            volume_reference: item.volume_reference,
            percent: item.percent,
          });
        }
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
      const myLineChart = new Chart(
        this.$refs[ref][0].getContext("2d"),
        tempData
      );
    },
    mobileOutDestination(data, index) {
      // data=array[{origin, destination,volume,isReference}]
      let localData = [];
      data.forEach((item) => {
        let element = localData.find((x) => x.destination == item.destination);
        if (element) {
          element.volume += item.volume;
          element.volume_reference += item.volume_reference;
        } else {
          localData.push({
            destination: item.destination,
            volume_reference: item.volume_reference,
            volume: item.volume,
          });
        }
      });

      localData = localData.sort((a, b) => {
        return Number(a.volume ?? 0) < Number(b.volume ?? 0) ? 1 : -1;
      });

      localData = localData.slice(0, 10);

      const dataChart = {
        labels: localData.map((d) => d.destination),
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

      const refInput = `mobile_out_${index}_2_card`;
      const myBarChart = new Chart(this.$refs[refInput][0].getContext("2d"), {
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
      });
    },
    mobileEntranceOrigin(data, index) {
      // data=array[{origin,volume,isReference}]
      let localData = [];
      data.forEach((item) => {
        let element = localData.find((x) => x.origin == item.origin);
        if (element) {
          element.volume += item.volume;
          element.volume_reference += item.volume_reference;
        } else {
          localData.push({
            origin: item.origin,
            volume_reference: item.volume_reference,
            volume: item.volume,
          });
        }
      });

      localData = localData.sort((a, b) => {
        return Number(a.volume ?? 0) < Number(b.volume ?? 0) ? 1 : -1;
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

      const myBarChart2 = new Chart(this.$refs[refInput][0].getContext("2d"), {
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
      });
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
