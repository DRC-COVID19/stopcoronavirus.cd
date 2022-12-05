<template>
  <div class="indicateurChart">
    <b-row class="pt-2 pb-2">
      <b-col class="pr-1" cols="12" md="6">
        <b-card class="no-body card-chart rounded-0">
          <canvas ref="leftChart" width="100vh" id="leftChart"></canvas>
        </b-card>
      </b-col>

      <b-col class="pl-1" cols="12" md="6">
        <b-card class="no-body card-chart rounded-0">
          <canvas ref="rightChart" width="100vh" id="rightChart"></canvas>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import { INDICATEUR_Y, INDICATEUR_X, PALETTE } from '../config/env';

export default {
  data() {
    return {
      rightChart: null,
      leftChart: null,
    };
  },
  mounted() {
    this.$store.watch(
      (state) => state.indicator.indicatorData,
      (value) => {
        this.computedData(value);
      }
    );
  },
  computed: {
    ...mapState({
      labelAxeX: (state) => state.indicator.labelAxeX,
      labelAxeY: (state) => state.indicator.labelAxeY,
    }),
  },
  methods: {
    computedData(data) {
      // let ecartTypeX = 0;
      // let ecartTypeY = 0;
      // let covariance = 0;
      // let moY = 0;
      // let moX = 0;
      // let totalProdEcart = 0;
      // data.forEach((element) => {
      //   ecartTypeX += element.ecartX2;
      //   ecartTypeY += element.ecartY2;
      //   moY = element.moY;
      //   moX = element.moX;
      //   totalProdEcart += element.prodEcart;
      // });
      // covariance = totalProdEcart / data.length;
      // ecartTypeX = ecartTypeX / data.length;
      // ecartTypeY = ecartTypeY / data.length;
      // ecartTypeX = Math.sqrt(ecartTypeX);
      // ecartTypeY = Math.sqrt(ecartTypeY);
      // let correlation = (covariance / ecartTypeX) * ecartTypeY;
      this.drawLeftChart(data);
      this.drawRightChart(data);
    },
    drawLeftChart(data) {
      let tempData = {
        type: 'scatter',
        data: {
          datasets: [
            {
              fill: true,
              borderColor: PALETTE.dash_green,
              backgroundColor: PALETTE.dash_green,
              pointRadius: 4,
              pointBorderWidth: 2,
              data: data.map((item) => ({ x: item.x, y: item.y })),
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
            text: '',
          },
          tooltips: {
            mode: 'index',
            intersect: false,
          },
          hover: {
            mode: 'nearest',
            intersect: true,
          },
          scales: {
            xAxes: [
              {
                display: true,
                type: 'linear',
                position: 'bottom',
                scaleLabel: {
                  display: true,
                  labelString: INDICATEUR_X.find((x) => x.id == this.labelAxeX)
                    .name,
                },
                ticks: {
                  callback: (value, index, values) => {
                    return this.formatCash(value);
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
                  display: true,
                  labelString: INDICATEUR_Y.find((x) => x.id == this.labelAxeY)
                    .name,
                },
              },
            ],
          },
          plugins: {
            crosshair: {
              sync: {
                enabled: false,
              },
              zoom: {
                enabled: false, // enable zooming
              },
            },
          },
        },
      };
      const ctx = this.$refs.leftChart;

      if (this.leftChart) this.leftChart.destroy();
      this.leftChart = new Chart(ctx, tempData);
    },
    drawRightChart(data) {
      let tempData = {
        type: 'line',
        data: {
          datasets: [
            {
              label: 'Confirmés',
              fill: false,
              borderColor: 'rgb(166,180,205)',
              backgroundColor: 'rgb(166,180,205, 0.2)',
              data: data.map((item) => ({ x: new Date(item.date), y: item.x })),
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
            text: '',
          },
          tooltips: {
            mode: 'index',
            intersect: false,
          },
          hover: {
            mode: 'nearest',
            intersect: true,
          },
          scales: {
            xAxes: [
              {
                display: true,
                type: 'time',
                time: {
                  unit: 'day',
                  unitStepSize: 1,
                  displayFormats: {
                    day: 'DD.MM',
                  },
                },
                position: 'bottom',
              },
            ],
            yAxes: [
              {
                display: true,
                ticks: {
                  beginAtZero: false,
                  callback: (value, index, values) => {
                    return this.formatCash(value);
                  },
                },
                scaleLabel: {
                  display: true,
                  labelString: INDICATEUR_X.find((x) => x.id == this.labelAxeX)
                    .name,
                },
              },
            ],
          },
          plugins: {
            crosshair: {
              sync: {
                enabled: false,
              },
              zoom: {
                enabled: false, // enable zooming
              },
            },
          },
        },
      };
      const ctx = this.$refs.rightChart;
      if (this.rightChart) this.rightChart.destroy();
      this.rightChart = new Chart(ctx, tempData);
    },
  },
};
</script>

<style lang="scss" scoped>
.indicateurChart {
  height: 100%;
  > .row {
    height: 100%;
    .card-chart {
      height: 100%;
    }
  }
  #leftChart,
  #rightChart {
    height: 100%;
  }
}
</style>
