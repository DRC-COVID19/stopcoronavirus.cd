<template>
  <b-container fluid class="p-0" ref="tendanceContainer">
    <b-row no-gutters>
      <b-col cols="12" class="pl-0 pr-2">
        <canvas width="100vh" ref="tendanceChart" id="tendanceChart" />
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import * as d3 from "../../lib/d3.v5.min";
import { DRC_COVID_EVENT, PALETTE } from "../../config/env";
import Chart from "chart.js";
import "chartjs-plugin-annotation";
import { mapState, mapMutations } from "vuex";
export default {
  props: {
    flux24Daily: {
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
    flux24Daily() {
      if (this.flux24Daily.length > 0) {
        this.$nextTick(() => {
          this.drawChart(this.flux24Daily, this.$refs.tendanceChart);
        });
      }
    },
  },
  computed: {
    ...mapState({
      fluxGeoOptions: (state) => state.flux.fluxGeoOptions,
    }),
  },
  mounted() {
    if (this.flux24Daily.length > 0) {
      this.$nextTick(() => {
        this.drawChart(this.flux24Daily, this.$refs.tendanceChart);
      });
    }
  },
  methods: {
    ...mapMutations(["setTendanceChartSelectedValue"]),
    drawChart(data, ref) {
      if (!data) {
        return;
      }
      const tempData = {
        type: "line",
        data: {
          labels: data.map((x) => new Date(x.date)),
          datasets: [
            {
              label: "Volume",
              fill: false,
              borderColor: "rgb(51, 172, 46)",
              backgroundColor: "rgb(166,180,205, 0.2)",
              data: data.map((x) => ({ x: new Date(x.date), y: x.volume })),
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.5,
              xAxisID: "x-axis-0",
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          // events: ["click"],
          onClick: (e, argument) => {
            if (argument.length>0) {
              const firstPoint=argument[0];
              const value =
                myLineChart2.data.datasets[firstPoint._datasetIndex].data[
                  firstPoint._index
                ];
              this.setTendanceChartSelectedValue(value);
            }
          },
          legend: {
            display: false,
          },
          title: {
            display: false,
            text: "",
          },
          hover: {
            mode: "nearest",
            intersect: true,
          },
          scales: {
            xAxes: [
              {
                display: true,
                id: "x-axis-0",
                scaleLabel: {
                  display: false,
                  labelString: "Month",
                },
                type: "time",
                fontSize: 9,
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
                },
              },
            ],
          },
          tooltips: {
            enabled: true,
            mode: "interpolate",
            intersect: false,
            callbacks: {
              title: (a, d) => {
                return this.moment(a[0].xLabel).format("DD.MM.Y");
              },
              label: function (i, d) {
                return (
                  d.datasets[i.datasetIndex].label + ": " + i.yLabel.toFixed(0)
                );
              },
            },
          },
          annotation: {
            events: ["mouseenter", "mouseleave"],
            drawTime: "afterDraw",
            annotations: DRC_COVID_EVENT.filter((x) =>
              x.measures.some((z) =>
                z.zones.some((y) => [...this.fluxGeoOptions, "ALL"].includes(y))
              )
            ).map((item, index) => {
              return {
                id: "line" + index,
                type: "line",
                mode: "vertical",
                scaleID: "x-axis-0",
                value: new Date(item.date),
                borderColor: PALETTE.flux_presence,
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
                  this.options.borderColor = PALETTE.flux_presence;
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
                enabled: false, // enable zooming
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
      var myLineChart2 = this.myLineChart;
    },
  },
};
</script>

<style lang="scss" scoped>
#tendanceChart {
  height: 100%;
}
</style>