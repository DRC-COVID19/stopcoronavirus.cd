<template>
  <FullScreen id="fullscreen" :link="reference" @change="fullscreenChange">
    <b-container class="global_province_container p-0">
      <b-row>
        <b-col cols="12" class="pr-0">
          <b-card no-body class="p-2 rounded-0">
            <canvas height="600" :ref="reference" class="global_province"></canvas>
          </b-card>
        </b-col>
      </b-row>
    </b-container>
  </FullScreen>
</template>

<script>
import Chart from "chart.js";
import "chartjs-plugin-annotation";
Chart.defaults.global.defaultFontFamily = 'Rubik,sans-serif';
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
          volume: observationVolume,
          volume_reference: referenceVolume,
          percent: Math.round((difference / referenceVolume) * 100),
          difference: difference,
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
            display: !!this.title,
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
                    return this.formatCash(value)
                  }
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
                  }
                },
              },
            ],
          },
          plugins: {
            crosshair: {
              sync: {
                enabled: false, // enable trace line syncing with other charts
              },
              zoom: {
                enabled: false,
              },
            },
          },
        },
      };

      if (this.barChart) this.barChart.destroy();
      this.barChart = new Chart(
        this.$refs[this.reference].getContext("2d"),
        this.configBarChart
      );
    },
    fullscreenChange(fullscreen,ref) {
      const element = this.$refs[ref];
      const parent_2 = element.parentElement.parentElement;
      if (!fullscreen) {

        element.style.height = "400px";
        element.height = "400px";
        element.parentElement.style.width = "auto";
        parent_2.style.display = "";
        parent_2.style.alignItem = "";
        parent_2.style.justifyContent = "";

        this.configBarChart.options.scales.xAxes[0].ticks.fontSize = 9;
        this.configBarChart.options.scales.yAxes[0].ticks.fontSize = 9;
        this.configBarChart.options.title.fontSize = 9;

        this.barChart.update();
      } else {

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
  width: 100% !important;
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
