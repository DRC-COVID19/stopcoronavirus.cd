<template>
  <FullScreen
    id="fullscreenTendanceChart"
    link="tendanceChart"
    @change="fullscreenChange"
  >
    <b-container
      fluid
      class="p-0 container-tendanceChart"
      ref="tendanceContainer"
    >
      <b-row no-gutters>
        <b-col cols="12" class="pl-0 pr-2">
          <canvas width="100vh" ref="tendanceChart" id="tendanceChart" />
        </b-col>
      </b-row>
    </b-container>
  </FullScreen>
</template>

<script>
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
      fluxTimeGranularity: null,
      configChar: null,
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
      // fluxTimeGranularity: state => state.flux.fluxTimeGranularity,
      fluxGeoOptions: (state) => state.flux.fluxGeoOptions,
    }),
  },
  mounted() {
    this.fluxTimeGranularity = this.$store.state.flux.fluxTimeGranularity;
    this.$store.watch(
      (state) => state.flux.fluxTimeGranularity,
      (value) => {
        this.fluxTimeGranularity = value;
      }
    );
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
      const labels = [];
      const localData = [];
      data.map((x) => {
        if (this.fluxTimeGranularity == 1) {
          // labels.push(new Date(x.date));
          localData.push({ x: moment(x.date), y: x.volume });
        } else {
          x.map((item) => {
            // labels.push(moment(`${item.date} ${item.hour}`));
            localData.push({
              x: moment(`${item.date} ${item.hour}`),
              y: item.volume,
            });
          });
        }
      });
      const maxDate = moment.max(localData.map((item) => item.x));
      const minDate = moment.min(localData.map((item) => item.x));
      this.configChar = {
        type: "line",
        data: {
          // labels: labels,
          datasets: [
            {
              label: "Volume",
              fill: false,
              borderColor: "rgb(51, 172, 46)",
              backgroundColor: "rgb(166,180,205, 0.2)",
              data: localData,
              interpolate: true,
              showLine: true,
              pointRadius: 1,
              borderWidth: 1.5,
              lineTension: 0.3,
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
                // id: "x-axis-0",
                scaleLabel: {
                  display: false,
                  labelString: "Month",
                },
                type: "time",
                time: {
                  unit: this.fluxTimeGranularity == 1 ? "day" : "hour",
                  unitStepSize: 1,
                  displayFormats: {
                    day: "DD.MM",
                    hour: "HH:mm",
                    minute: "HH:mm",
                  },
                },
                ticks: {
                  fontSize: 9,
                  major: {
                    enabled: true,
                    fontStyle: "bold",
                    fontColor: PALETTE.flux_in_color,
                    fontSize: 12,
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
                  fontSize: 9,
                  beginAtZero: false,
                  callback: (value, index, values) => {
                    return this.formatCash(value);
                  },
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
                let titleFormat = this.moment(a[0].xLabel).format("DD.MM.Y");
                if (this.fluxTimeGranularity == 2) {
                  titleFormat = this.moment(a[0].xLabel).format(
                    "DD.MM.Y HH:mm"
                  );
                }
                return titleFormat;
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
                ) &&
                new Date(x.date) >= minDate &&
                new Date(x.date) <= maxDate
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
      this.myLineChart = new Chart(ref.getContext("2d"), this.configChar);
      const myLineChart2 = this.myLineChart;
    },
    fullscreenChange(fullscreen, ref) {
      this.fullscreen = fullscreen;
      if (!fullscreen) {
        const buttonResetZoom = this.myLineChart.crosshair.button;
        if (buttonResetZoom) {
          buttonResetZoom.click();
        }
        this.configChar.options.plugins.crosshair.zoom.enabled = false;
        this.$refs.tendanceChart.style.height = "100%";
        this.$refs.tendanceChart.height = "100%";
        this.myLineChart.update();
      }
      else{
        this.configChar.options.plugins.crosshair.zoom.enabled = true;
        this.myLineChart.update();
      }
    },
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
.container-tendanceChart {
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
  .container-tendanceChart {
    width: 100%;
    height: 65%;
    .row {
      padding: 20px;
    }
  }
}
#tendanceChart {
  height: 100% !important;
}
</style>
