<template>
  <div class="fullscreen-container">
    <fullscreen ref="fullscreen" @change="fullscreenChange">
      <b-container fluid class="p-0 container-tendanceChart" ref="tendanceContainer">
        <b-row no-gutters>
          <b-col cols="12" class="pl-0 pr-2">
            <canvas width="100vh" ref="tendanceChart" id="tendanceChart" />
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
      const labels=[];
      const localData=[];
      data.map(x=>{
          labels.push(new Date(x.date));
          localData.push({ x: new Date(x.date), y: x.volume })
      });
      const maxDate = moment.max(data.map((x) => moment(x.date)));
      const tempData = {
        type: "line",
        data: {
          labels:labels,
          datasets: [
            {
              label: "Volume",
              fill: false,
              borderColor: "rgb(51, 172, 46)",
              backgroundColor: "rgb(166,180,205, 0.2)",
              data: localData,
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
            if (argument.length > 0) {
              const firstPoint = argument[0];
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
            display: true,
            text: "Flux de tendance" + this.getZone,
            fontSize: 9,
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
                  callback: (value, index, values) => {
                    return this.formatCash(value)  ;
                  }
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
                borderColor:item.isImportant?PALETTE.flux_presence:PALETTE.flux_out_color,
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
                  this.options.borderColor = item.isImportant?PALETTE.flux_presence:PALETTE.flux_out_color;
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
      const myLineChart2 = this.myLineChart;
    },

    toggleFullscreen() {
      this.$refs['fullscreen'].toggle()
    },
    fullscreenChange (fullscreen) {
      this.fullscreen = fullscreen
      if(!fullscreen){
        this.$refs.tendanceChart.style.height = "100%"
        this.$refs.tendanceChart.height = "100%"
      }
    }
  },
  computed: {
    ...mapState({
      fluxGeoOptions: (state) => state.flux.fluxGeoOptions,
    }),
    getZone() {
      if (this.fluxGeoOptions && this.fluxGeoOptions.length > 0)
        return " à " + this.fluxGeoOptions[0];
      else return "";
    },
  },
};
</script>

<style lang="scss" scoped>
.container-tendanceChart{
  height: 100%;
  background-color: white;
  .row{
    height: 100%;
  }
}
.fullscreen{
  display: flex;
  align-items: center;
  justify-content: center;
  .container-tendanceChart{
    width: 100%;
    height: 65% ;
    .row{
      padding: 20px;
    }
  }
}
#tendanceChart {
  height : 100% !important
}
</style>
