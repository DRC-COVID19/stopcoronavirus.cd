<template>
  <b-row>
    <b-col cols="12" md="6">
      <FullScreen
        id="CovidCaseChart_full"
        link="CovidCaseChart"
        class="container-full"
      >
        <div class="cardtype1 container-back">
          <div class="chart-container">
            <canvas
              width="100vh"
              ref="CovidCaseChart"
              id="CovidCaseChart"
            ></canvas>
          </div>
        </div>
      </FullScreen>
    </b-col>
    <b-col cols="12" md="6">
      <FullScreen
        id="covidCasesStatDaily_full"
        link="covidCasesStatDaily"
        class="container-full"
      >
        <div class="cardtype1 container-back">
          <div class="chart-container">
            <canvas
              width="100vh"
              ref="covidCasesStatDaily"
              id="covidCasesStatDaily"
            ></canvas>
          </div>
        </div>
      </FullScreen>
    </b-col>
  </b-row>
</template>

<script>
import Chart from "chart.js";

export default {
  props: {
    covidCasesStat: {
      type: Object,
      default: null,
    },
    covidCasesStatDaily: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {};
  },
  mounted() {
    this.show(
      this.covidCasesStat,
      this.$refs.CovidCaseChart,
      "Graphique Cumule"
    );
    this.show(
      this.covidCasesStatDaily,
      this.$refs.covidCasesStatDaily,
      "Graphique Journalier"
    );
  },
  watch: {
    covidCasesStat() {
      this.$nextTick(() => {
        this.show(
          this.covidCasesStat,
          this.$refs.CovidCaseChart,
          "Graphique Cumule"
        );
      });
    },
    covidCasesStatDaily() {
      this.$nextTick(() => {
        this.show(
          this.covidCasesStatDaily,
          this.$refs.covidCasesStatDaily,
          "Graphique Journalier"
        );
      });
    },
  },
  methods: {
    async show(data, ref, title = null) {
      if (!data) {
        return;
      }

      console.log('data',data.labels);

      let tempData = {
        type: "line",
        data: {
          labels: data.labels,
          datasets: [
            {
              label: "Confirmés",
              fill: true,
              borderColor: "rgb(166,180,205)",
              backgroundColor: "rgb(166,180,205, 0.2)",
              data: data.confirmed
            },
            {
              label: "Guéris",
              fill: true,
              borderColor: "rgba(0,176,101,1)",
              backgroundColor: "rgba(0,176,101,0.8)",
              data: data.healed,
            },
            {
              label: "Décès",
              fill: true,
              borderColor: "rgba(10,10,10,0.2)",
              backgroundColor: "rgba(10,10,10,1)",
              data: data.dead,
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
          tooltips: {
            mode: "index",
            intersect: false,
            callbacks: {
              title: function (tooltipItem, data) {
                let d = new Date(tooltipItem[0].label);
                return d.formatD();
              },
            },
          },
          hover: {
            mode: "nearest",
            intersect: true,
          },
          scales: {
            xAxes: [
              {
                display: true,
                gridLines: {
                  display: true,
                },
                scaleLabel: {
                  display: false,
                  labelString: "Month",
                },
                type: "time",
                time: {
                  unit: "day",
                  unitStepSize: 2,
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
                  beginAtZero: true,
                  callback: (value, index, values) => {
                    return this.formatCash(value);
                  },
                },
                scaleLabel: {
                  display: false,
                  labelString: "Value",
                },
              },
            ],
          },
          plugins: {
            crosshair: {
              sync: {
                enabled: true,
                group: 1,
              },
              zoom: {
                enabled: false, // enable zooming
              },
            },
          },
        },
      };
      var ctx = ref;
      // Instantiate a new chart
      var myLineChart = new Chart(ctx, tempData);
    },
  },
};
</script>

<style lang="scss" scoped>
// #CovidCaseChart,
// #covidCasesStatDaily {
//   height: 78% !important;
// }
.container-full {
  .container-back {
    height: inherit;
    .chart-container {
      height: inherit;
    }
  }
}

.fullscreen {
  .cardtype1 {
    canvas {
      width: calc(100vw - 19px) !important;
      height: 500px !important;
    }
  }
  .container-back {
    background: white;
    height: unset;
  }
  .cardtype2 {
    canvas {
      width: 700px !important;
      height: calc(100vh - 32px) !important;
    }
  }
}
</style>
