<template>
  <div class="fullscreen-container">
    <fullscreen ref="fullscreen" @change="fullscreenChange">
      <b-container class="global_province_container p-0">
        <b-row>
          <b-col cols="12">
            <b-card no-body class="p-2 rounded-0">
              <canvas height="600" :ref="reference" class="global_province"></canvas>
            </b-card>
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
  },
  data(){
    return {
      configBarChart : {} ,
      barChart : null
    }
  },
  mounted() {
    this.mobility(this.globalData);
    console.log(this.$refs[this.reference].height)
    console.log(this.$refs[this.reference].width)
  },
  watch: {
    globalData() {
      this.mobility(this.globalData);
    },
  },
  methods: {
    mobility(data) {
      const dataChart = {
        labels: data.map((d) => d.zone),
        datasets: [
          {
            backgroundColor: this.color,
            borderColor: this.color,
            borderWidth: 1,
            data: data.map((d) => d.volume),
          },
        ],
      };

      this.configBarChart =
        {
          type: "horizontalBar",
          data: dataChart,
          options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
              display: false,
              position: "bottom",
              labels: {
                fontSize: 9
              },
            },
            title: {
              display: !!this.title,
              text: this.title,
              color: "#6c757d",
              fontSize: 9
            },
            scales: {
              xAxes: [
                {
                  ticks: {
                    beginAtZero: false,
                    fontSize: 9,
                  },
                },
              ],
              yAxes: [
                {
                  ticks: {
                    beginAtZero: false,
                    fontSize: 9,
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
        }

      if (this.barChart) this.barChart.destroy();
      this.barChart = new Chart(
        this.$refs[this.reference].getContext("2d"), this.configBarChart
      );
    },
    toggleFullscreen() {
      this.$refs['fullscreen'].toggle()
    },
    fullscreenChange (fullscreen) {
      if(!fullscreen){
        this.configBarChart.options.scales.xAxes[0].ticks.fontSize = 9
        this.configBarChart.options.scales.yAxes[0].ticks.fontSize = 9
        this.configBarChart.options.title.fontSize = 9

        this.barChart.update()
      }else{
        this.configBarChart.options.scales.xAxes[0].ticks.fontSize = 12
        this.configBarChart.options.scales.yAxes[0].ticks.fontSize = 12
        this.configBarChart.options.title.fontSize = 12

        this.barChart.update()
      }
    }
  },
};
</script>
<style lang="scss" scoped>

.side-right > .card > .tabs > .tab-content > .card-body > div > div
.global_province_container div .global_province{
  width: 100% !important;
  height: 100% !important;
}
.side-right>.card>.tabs>.tab-content>.card-body>div>div .fullscreen .global_province_container {
    height: 100vh;
}
</style>
