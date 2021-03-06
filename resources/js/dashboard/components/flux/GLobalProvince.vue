<template>
  <FullScreen id="fullscreen" :link="reference" @change="fullscreenChange">
    <b-row no-gutters class="global_province_container">
      <b-col cols="12" class="pr-0">
        <b-card no-body class="p-2 rounded-0 cardtype2">
          <div class="general-top-title">{{ title }}</div>
          <canvas
            height="600"
            :ref="reference"
            class="global_province"
          ></canvas>
        </b-card>
      </b-col>
    </b-row>
  </FullScreen>
</template>

<script>
import Chart from "chart.js";
import "chartjs-plugin-annotation";
Chart.defaults.global.defaultFontFamily = "Rubik,sans-serif";
import { PALETTE } from "../../config/env";
export default {
  props: {
    globalData: {
      type: Array,
      default: () => [],
    },
    reference: {
      type: String,
      default: null,
      required: true,
    },
    color: {
      type: String,
      default: "33ac2e",
    },
    title: {
      type: String,
      default: null,
    },
    isProvince: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      configBarChart: {},
      barChart: null,
    };
  },
  mounted() {
    this.mobility(this.globalData);
  },
  watch: {
    globalData() {
      this.mobility(this.globalData);
    },
  },
  methods: {
    mobility(data) {
      let localData = [];

      data.map((item) => {
        const referencesByDate = item.references;
        const observationsByDate = item.observations;

        if (!referencesByDate || !observationsByDate) {
          return;
        }

        const result = this.formatFluxDataByMedian({
          references: referencesByDate,
          observations: observationsByDate,
        });

        let zone = null;
        if (observationsByDate[0]) {
          zone = observationsByDate[0].zone;
        } else if (referencesByDate[0]) {
          zone = referencesByDate[0].zone;
        }
        if (!zone) {
          return;
        }

        localData.push({
          zone: zone,
          volume: result.observationVolume,
          volume_reference: result.referenceVolume,
          percent: result.percent,
          difference: result.difference,
        });

      });


      localData.sort((a, b) => {
        return Number(a.percent ?? 0) > Number(b.percent ?? 0) ? 1 : -1;
      });

      const dataChart = {
        labels: localData.map((d) => d.zone),
        datasets: [
          // {
          //   label: "Référence",
          //   backgroundColor: PALETTE.dash_green,
          //   borderColor: PALETTE.dash_green,
          //   borderWidth: 1,
          //   data: localData.map((d) => d.volume_reference),
          // },
          {
            label: "Observation",
            backgroundColor: this.color,
            borderColor: this.color,
            barThickness: 12,
            borderWidth: 1,
            data: localData.map((d) => d.percent),
          },
        ],
      };

      this.configBarChart = {
        type: "horizontalBar",
        data: dataChart,
        options: {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            display: true,
            position: "bottom",
            labels: {
              fontSize: 9,
            },
          },
          title: {
            display: false,
            text: this.title,
            color: "#6c757d",
            fontSize: 9,
          },
          scales: {
            xAxes: [
              {
                ticks: {
                  beginAtZero: false,
                  fontSize: 9,
                  callback: (value, index, values) => {
                    const sign = value < 0 ? "-" : "";
                    return `${sign}${this.formatCash(value)}`;
                  },
                },
              },
            ],
            yAxes: [
              {
                ticks: {
                  beginAtZero: false,
                  fontSize: 9,
                  callback: function (label, index, labels) {
                    const value = localData.find((x) => x.zone == label);
                    if (value && value.percent) {
                      return `${label} (${value.percent}%)`;
                    } else {
                      return label;
                    }
                  },
                },
              },
            ],
          },
          plugins: {
            crosshair: false,
          },
        },
      };

      if (this.barChart) this.barChart.destroy();
      this.barChart = new Chart(
        this.$refs[this.reference].getContext("2d"),
        this.configBarChart
      );
      if (localData && localData.length <= 5) {
        this.configBarChart.height = "200px";
        this.$refs[this.reference].style.height = "200px";
        this.$refs[this.reference].style.maxHeight = "200px";
      } else {
        this.configBarChart.height = "600px";
        this.$refs[this.reference].style.height = "600px";
        this.$refs[this.reference].style.maxHeight = "600px";
      }
    },
    fullscreenChange(fullscreen, ref) {
      const element = this.$refs[ref];
      const parent_2 = element.parentElement.parentElement;
      if (!fullscreen) {
        element.style.height = "400px";
        element.height = "400px";
        element.style.width = "700px";
        element.parentElement.style.width = "auto";
        parent_2.style.display = "";
        parent_2.style.alignItem = "";
        parent_2.style.justifyContent = "";

        this.configBarChart.options.scales.xAxes[0].ticks.fontSize = 9;
        this.configBarChart.options.scales.yAxes[0].ticks.fontSize = 9;
        this.configBarChart.options.title.fontSize = 9;

        this.barChart.update();
      } else {
        element.style.width = "700px";
        element.parentElement.style.width = "100%";
        parent_2.style.display = "flex";
        parent_2.style.alignItems = "center";
        parent_2.style.justifyContent = "center";

        this.configBarChart.options.scales.xAxes[0].ticks.fontSize = 12;
        this.configBarChart.options.scales.yAxes[0].ticks.fontSize = 12;
        this.configBarChart.options.title.fontSize = 12;

        this.barChart.update();
      }
    },
  },
};
</script>
<style lang="scss" scoped>
.side-right
  > .card
  > .tabs
  > .tab-content
  > .card-body
  > div
  > div
  .global_province_container
  div
  .global_province {
  height: 100% !important;
}
.side-right
  > .card
  > .tabs
  > .tab-content
  > .card-body
  > div
  > div
  .fullscreen
  .global_province_container {
  height: 100vh;
}
</style>
