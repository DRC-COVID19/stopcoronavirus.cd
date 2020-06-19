<template>
  <div>
    <canvas ref="CovidCaseChart" id="CovidCaseChart"></canvas>
  </div>
</template>

<script>
import Chart from "chart.js";

export default {
  props: {
    covidCasesStat: {
      type: Object,
      default: null
    }
  },
  data() {
    return {};
  },
  mounted(){

    this.show();
  },
  watch: {
    covidCasesStat() {

      this.show();
    }
  },
  methods: {
   async show() {
      await this.sleep(1000);
      if (!this.covidCasesStat) {
        return;
      }
      let tempData = {
        type: "line",
        data: {
          labels: this.covidCasesStat.labels,
          datasets: [
            {
              label: "Confirmés",
              fill: true,
              borderColor: "rgb(166,180,205)",
              backgroundColor: "rgb(166,180,205, 0.2)",
              data: this.covidCasesStat.confirmed
            },
            {
              label: "Guéris",
              fill: true,
              borderColor: "rgba(0,176,101,1)",
              backgroundColor: "rgba(0,176,101,0.8)",
              data: this.covidCasesStat.healed
            },
            {
              label: "Décès",
              fill: true,
              borderColor: "rgba(10,10,10,0.2)",
              backgroundColor: "rgba(10,10,10,1)",
              data: this.covidCasesStat.dead
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
          }
        }
      };
      var ctx = this.$refs.CovidCaseChart;
      // Instantiate a new chart
      var myLineChart = new Chart(ctx, tempData);
    }
  }
};
</script>

<style lang="scss" scoped>
#CovidCaseChart {
  height: 300px !important;
}
</style>