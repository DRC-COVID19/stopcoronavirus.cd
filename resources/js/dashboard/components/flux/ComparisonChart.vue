<template>
  <div class="fullscreen-container">
    <fullscreen ref="fullscreen" @change="fullscreenChange">
      <b-container fluid class="p-0 container-comparisonChart" ref="tendanceContainer">
        <b-row no-gutters>
          <b-col cols="12" class="pl-0 pr-2">
            <canvas width="100vh" ref="comparisonChart" id="comparisonChart" />
          </b-col>
        </b-row>
      </b-container>
    </fullscreen>
    <button type="button" @click="toggleFullscreen" class="fullscreen-btn mini">
      <i class="fa fa-expand"></i>
    </button>
  </div>
</template>

<script>
import Chart from "chart.js";
import "chartjs-plugin-annotation";
import { groupBy } from "lodash";
import { DRC_COVID_EVENT, PALETTE } from "../../config/env";
export default {
  props: {
    flux24DailyComparison: {
      type: Array,
      default: () => [],
    },
    fluxGeoOptions: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      myLineChart: null,
    };
  },
  watch: {
    flux24DailyComparison() {
      if (this.flux24DailyComparison.length > 0) {
        this.sleep(2000);
        this.$nextTick(() => {
          this.drawChart(
            this.flux24DailyComparison,
            this.$refs.comparisonChart
          );
        });
      }
    },
  },
  mounted() {
    if (this.flux24DailyComparison.length > 0) {
      this.sleep(2000);
      this.$nextTick(() => {
        this.drawChart(this.flux24DailyComparison, this.$refs.comparisonChart);
      });
    }
  },
  methods: {
    drawChart(data, ref) {
      if (!data) {
        return;
      }
      const process = new Promise((resolver, reject) => {
        const groupData = groupBy(data, (x) => x.origin);
        const datasets = [];
        Object.keys(groupData).map((keys) => {
          const item = groupData[keys];
          let borderWidth = 2;
          let borderColor = "rgb(166,180,205)";
          let borderDash = [5];
          let order = 1;
          if (this.fluxGeoOptions.indexOf(keys) != -1) {
            borderWidth = 2;
            borderColor = "rgb(51, 172, 46)";
            borderDash = [0];
            order = 0;
          }
          datasets.push({
            label: keys,
            fill: false,
            borderColor: borderColor,
            backgroundColor: "rgb(166,180,205, 0.2)",
            data: item.map((x) => ({ x: new Date(x.date), y: x.volume })),
            interpolate: true,
            showLine: true,
            hoverBorderColor: "rgb(46, 91, 255);",
            pointRadius: 0,
            borderWidth: borderWidth,
            lineTension: 0.5,
            order: order,
            borderDash: borderDash,
            //   xAxisID: "x-axis-0"
          });
        });

        const labels = data
          .map((x) => x.date)
          .filter((value, index, self) => {
            return self.indexOf(value) === index;
          });

        const maxDate = moment.max(data.map((x) => moment(x.date)));

        resolver({ datasets, labels, maxDate });
      });

      console.log(new Date().toTimeString());
      process.then(({ datasets, labels, maxDate }) => {
        console.log(new Date().toTimeString());
        const tempData = {
          type: "line",
          data: {
            labels: labels,
            datasets: datasets,
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
              display: false,
            },
            title: {
              display: true,
              text: "Flux de comparaison" + this.getZone,
              fontSize: 9,
            },
            scales: {
              xAxes: [
                {
                  display: true,
                  gridLines: {
                    display: true,
                  },
                  id: "x-axis-0",
                  scaleLabel: {
                    display: false,
                    labelString: "Month",
                  },
                  type: "time",
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
                  scaleLabel: {
                    display: false,
                    labelString: "Value",
                  },
                  ticks: {
                    beginAtZero: false,
                    callback: (value, index, values) => {
                      return this.formatCash(value);
                    },
                  },
                },
              ],
            },
            //   tooltips: {
            //     enabled: true,
            //     mode: "single",
            //     intersect: false,
            //     callbacks: {
            //       title: (a, d) => {
            //         return this.moment(a[0].xLabel).format("DD.MM.Y");
            //       },
            //       label: function(i, d) {
            //         return (
            //           d.datasets[i.datasetIndex].label + ": " + i.yLabel.toFixed(2)
            //         );
            //       }
            //     }
            //   },
            tooltips: {
              enabled: true,
              mode: "nearest",
              intersect: true,
              callbacks: {
                title: function (tooltipItem, data) {
                  let d = new Date(tooltipItem[0].label);
                  return d.formatD();
                },
              },
            },
            hover: {
              mode: "nearest",
              intersect: false,
            },
            annotation: {
              events: ["mouseenter", "mouseleave"],
              drawTime: "afterDraw",
              annotations: DRC_COVID_EVENT.filter(
                (x) =>
                  x.measures.some((z) =>
                    z.zones.some((y) =>
                      [...this.fluxGeoOptions, "ALL"].includes(y)
                    )
                  ) && new Date(x.date) <= maxDate
              ).map((item, index) => {
                return {
                  id: "line" + index,
                  type: "line",
                  mode: "vertical",
                  scaleID: "x-axis-0",
                  value: new Date(item.date),
                  borderColor: item.isImportant
                    ? PALETTE.flux_presence
                    : PALETTE.flux_out_color,
                  borderWidth: item.isImportant ? 3 : 2,
                  label: {
                    content: item.measures
                      .filter((x) =>
                        x.zones.some((y) =>
                          [...this.fluxGeoOptions, "ALL"].includes(y)
                        )
                      )
                      .map((x) => x.item),
                    enabled: false,
                    position: "top",
                  },
                  onMouseenter(e) {
                    this.options.borderColor = PALETTE.flux_in_color;
                    this.options.label.enabled = true;
                    myLineChart2.update();
                  },
                  onMouseleave(e) {
                    this.options.borderColor = item.isImportant
                      ? PALETTE.flux_presence
                      : PALETTE.flux_out_color;
                    this.options.label.enabled = false;
                    myLineChart2.update();
                  },
                };
              }),
            },
            plugins: {
              crosshair: {
                sync: {
                  enabled: false,
                },
                zoom: {
                  enabled: true, // enable zooming
                  zoomboxBackgroundColor: "rgba(66,133,244,0.2)", // background color of zoom box
                  zoomboxBorderColor: "#48F", // border color of zoom box
                  zoomButtonText: "Reset Zoom", // reset zoom button text
                  zoomButtonClass: "reset-zoom", // reset zoom button class
                },
              },
            },
          },
        };
        if (this.myLineChart) this.myLineChart.destroy();
        this.myLineChart = new Chart(ref.getContext("2d"), tempData);
        const myLineChart2 = this.myLineChart;
        console.log(new Date().toTimeString());
      });
    },
    toggleFullscreen() {
      this.$refs["fullscreen"].toggle();
    },
    fullscreenChange(fullscreen) {
      this.fullscreen = fullscreen;
      if (!fullscreen) {
        this.$refs.comparisonChart.style.height = "100%";
        this.$refs.comparisonChart.height = "100%";
      }
    },
  },
  computed: {
    getZone() {
      if (this.fluxGeoOptions && this.fluxGeoOptions.length > 0)
        return " par rapport à " + this.fluxGeoOptions[0];
      else return "";
    },
  },
};
</script>

<style lang="scss" scoped>
.container-comparisonChart {
  background-color: white;
  height: 100%;
  background-color: white;
  .row {
    height: 100%;
  }
}
.fullscreen {
  display: flex;
  align-items: center;
  justify-content: center;
  .container-comparisonChart {
    width: 100%;
    height: 80%;
    .row {
      padding: 20px;
    }
  }
}
#comparisonChart {
  height: 100% !important;
}
</style>
