<template>
  <b-container fluid class="p-0" ref="tendanceContainer">
    <b-row no-gutters>
      <b-col cols="12" class="pl-0 pr-2 ">
        <canvas  width="100vh" ref="comparisonChart" id="comparisonChart" />
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import Chart from "chart.js";
import "chartjs-plugin-annotation";
import { groupBy } from "lodash";
export default {
  props: {
    flux24DailyComparison: {
      type: Array,
      default: () => []
    },
    fluxGeoOptions: {
      type: Array,
      default: () => []
    }
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
    }
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
      const groupData = groupBy(data, x => x.origin);
      const datasets = [];
      Object.keys(groupData).map(keys => {
        const item = groupData[keys];
        let borderWidth = 2;
        let borderColor = "rgb(166,180,205)";
        let borderDash = [5];
        if (this.fluxGeoOptions.indexOf(keys) != -1) {
          borderWidth = 2;
          borderColor = "rgb(51, 172, 46)";
          borderDash = [0];
        }
        datasets.push({
          label: keys,
          fill: false,
          borderColor: borderColor,
          backgroundColor: "rgb(166,180,205, 0.2)",
          data: item.map(x => ({ x: new Date(x.date), y: x.volume })),
          interpolate: true,
          showLine: true,
          hoverBorderColor:'rgb(46, 91, 255);',
          pointRadius: 0,
          borderWidth: borderWidth,
          lineTension: 0.5,
          borderDash: borderDash
          //   xAxisID: "x-axis-0"
        });
      });

      const labels = data
        .map(x => x.date)
        .filter((value, index, self) => {
          return self.indexOf(value) === index;
        });

      const tempData = {
        type: "line",
        data: {
          labels: labels,
          datasets: datasets
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            display: false
          },
          title: {
            display: false,
            text: ""
          },
          scales: {
            xAxes: [
              {
                display: true,
                gridLines: {
                  display: true
                },
                id: "x-axis-0",
                scaleLabel: {
                  display: false,
                  labelString: "Month"
                },
                type: "time",
                time: {
                  unit: "day",
                  unitStepSize: 1,
                  displayFormats: {
                    day: "DD.MM"
                  }
                }
              }
            ],
            yAxes: [
              {
                display: true,
                scaleLabel: {
                  display: false,
                  labelString: "Value"
                },
                ticks: {
                  beginAtZero: false
                }
              }
            ]
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
              title: function(tooltipItem, data) {
                let d = new Date(tooltipItem[0].label);
                return d.formatD();
              }
            }
          },
          hover: {
            mode: "nearest",
            intersect: false
          },
          annotation: {
            annotations: [
              {
                type: "line",
                mode: "vertical",
                scaleID: "x-axis-0",
                value: new Date("2020-03-18"),
                borderColor: "red",
                label: {
                  content: "Confinement",
                  enabled: true,
                  position: "top"
                }
              }
            ]
          },
          plugins: {
            crosshair: {
              sync: {
                enabled: false
              },
              zoom: {
                enabled: true, // enable zooming
                zoomboxBackgroundColor: "rgba(66,133,244,0.2)", // background color of zoom box
                zoomboxBorderColor: "#48F", // border color of zoom box
                zoomButtonText: "Reset Zoom", // reset zoom button text
                zoomButtonClass: "reset-zoom" // reset zoom button class
              }
            }
          }
        }
      };

      const myLineChart = new Chart(ref.getContext("2d"), tempData);
    }
  }
};
</script>

<style lang="scss" scoped>
#comparisonChart{
}
</style>