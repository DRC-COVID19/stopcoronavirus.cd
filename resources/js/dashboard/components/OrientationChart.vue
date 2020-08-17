<template>
  <div>
    <canvas ref="orientationChart" id="orientationChart"></canvas>
  </div>
</template>

<script>
import Chart from "chart.js";

export default {
  props: {
    medicalOrientationsStat: {
      type: Object,
      default: null
    }
  },
  data() {
    return {};
  },

  watch: {
    medicalOrientationsStat() {
      this.show();
    }
  },
  mounted() {
    this.show();
  },
  methods: {
    show() {
      if (!this.medicalOrientationsStat) {
        return;
      }
      let tempData = {
        type: "line",
        data: {
          labels: this.medicalOrientationsStat.labels,
          datasets: [
            {
              label: "Peu probable",
              fill: true,
              borderColor: "rgba(0, 128, 0,0.2)",
              backgroundColor: "rgba(0, 128, 0,1)",
              data: this.medicalOrientationsStat.fin8
            },
            {
              label: "Probables",
              fill: true,
              borderColor: "rgb(255, 165, 0)",
              backgroundColor: "rgb(255, 165, 0, 0.2)",
              data: this.medicalOrientationsStat.fin
            },
            {
              label: "Très probable",
              fill: true,
              backgroundColor: "rgba(255, 0, 0,0.8)",
              borderColor: "rgba(255, 0, 0,1)",
              data: this.medicalOrientationsStat.fin5
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
      var ctx = this.$refs.orientationChart;
      // Instantiate a new chart
      var myLineChart = new Chart(ctx, tempData);
    }
  }
};
</script>

<style lang="scss" scoped>
#orientationChart {
  height: 300px !important;
}
</style>