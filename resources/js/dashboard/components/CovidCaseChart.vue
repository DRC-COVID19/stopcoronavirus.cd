<template>
  <b-row>
    <b-col cols="12" md="6">
      <h5>Graphique Cumule</h5>
      <canvas ref="CovidCaseChart" id="CovidCaseChart"></canvas>
    </b-col>
    <b-col cols="12" md="6">
      <h5>Graphique Journalier</h5>
      <canvas ref="covidCasesStatDaily" id="covidCasesStatDaily"></canvas>
    </b-col>
  </b-row>
</template>

<script>
import Chart from "chart.js";

export default {
  props: {
    covidCasesStat: {
      type: Object,
      default: null
    },
    covidCasesStatDaily: {
      type: Object,
      default: null
    }
  },
  data() {
    return {};
  },
  mounted() {
    this.show(this.covidCasesStat, this.$refs.CovidCaseChart);
    this.show(this.covidCasesStatDaily, this.$refs.covidCasesStatDaily);
  },
  watch: {
    covidCasesStat() {
      this.$nextTick(() => {
        this.show(this.covidCasesStat, this.$refs.CovidCaseChart);
      });
    },
    covidCasesStatDaily() {
      this.$nextTick(() => {
        this.show(this.covidCasesStatDaily, this.$refs.covidCasesStatDaily);
      });
    }
  },
  methods: {
    async show(data, ref) {
      if (!data) {
        return;
      }
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
              data: data.healed
            },
            {
              label: "Décès",
              fill: true,
              borderColor: "rgba(10,10,10,0.2)",
              backgroundColor: "rgba(10,10,10,1)",
              data: data.dead
            }
          ]
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
          tooltips: {
            mode: "index",
            intersect: false,
            callbacks: {
              title: function(tooltipItem, data) {
                let d = new Date(tooltipItem[0].label);
                return d.formatD();
              }
            }
          },
          hover: {
            mode: "nearest",
            intersect: true
          },
          scales: {
            xAxes: [
              {
                display: true,
                gridLines: {
                  display: true
                },
                scaleLabel: {
                  display: false,
                  labelString: "Month"
                },
                type: "time",
                time: {
                  unit: "day",
                  unitStepSize: 2,
                  displayFormats: {
                    day: "DD.MM"
                  }
                }
              }
            ],
            yAxes: [
              {
                display: true,
                ticks: {
                  beginAtZero: true
                },
                scaleLabel: {
                  display: false,
                  labelString: "Value"
                }
              }
            ]
          },
          plugins: {
            crosshair: {
              sync: {
                enabled: true,
                group: 1
              },
              zoom: {
                enabled: false // enable zooming
              }
            }
          }
        }
      };
      var ctx = ref;
      // Instantiate a new chart
      var myLineChart = new Chart(ctx, tempData);
    }
  }
};
</script>

<style lang="scss" scoped>
#CovidCaseChart,
#covidCasesStatDaily {
  height: 78% !important;
}
</style>