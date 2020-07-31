<template>
  <b-container class="p-0" ref="tendanceContainer">
    <b-row no-gutters>
      <b-col cols="12" class="pl-0 pr-2">
        <canvas width="100vh" ref="tendanceChart" id="tendanceChart" />
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import * as d3 from "../../lib/d3.v5.min";
import { DRC_COVID_EVENT } from "../../config/env";
import Chart from "chart.js";
import "chartjs-plugin-annotation";
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
  mounted() {
    if (this.flux24Daily.length > 0) {
      this.$nextTick(() => {
        this.drawChart(this.flux24Daily, this.$refs.tendanceChart);
      });
    }
  },
  methods: {
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
          legend: {
            display: false,
          },
          title: {
            display: false,
            text: "",
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
            annotations: DRC_COVID_EVENT.map(function (item, index) {
              return {
                id: "line" + index,
                type: "line",
                mode: "vertical",
                scaleID: "x-axis-0",
                value: new Date(item.date),
                borderColor: "red",
                borderWidth: item.isImportant ? 5 : 3,
                label: {
                  content: "Confinement",
                  enabled: false,
                  position: "top",
                },
                onMouseenter(e) {
                  console.log("onMouseenter", e, this);
                  this.options.borderColor = "rgba(0,0,255,0.8)";
                  this.options.label.enabled=true;
                  myLineChart2.update();
                },
                onMouseleave(e) {
                  console.log("onMouseleave", e);
                  this.options.borderColor = "red";
                  this.options.label.enabled=false;
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