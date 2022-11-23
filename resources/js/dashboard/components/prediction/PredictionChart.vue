<template>
  <b-card no-body class="text-center pt-3 px-2">
    <div v-if="predictedData?.length">
      <ApexCharts
        type="line"
        height="350"
        :options="chartOptions"
        :series="chartSeries"
      ></ApexCharts>
      <div class="d-flex justify-content-center align-items-center mb-3">
        <div class="d-flex justify-content-center align-items-center">
          <div class="circle-indicator"></div>
          <div class="indicator-label">Valeur modifié</div>
        </div>

        <div class="d-flex justify-content-center align-items-center ml-3">
          <div class="square-indicator"></div>
          <div class="indicator-label">Zone de surcharge</div>
        </div>
      </div>
    </div>
    <div
      v-else
      class="d-flex justify-content-center align-items-center"
      style="height: 350px"
    >
      <p>
        <img alt="" src="/img/no-data.png" class="img-fluid" />
      </p>
    </div>
  </b-card>
</template>

<script>
import ApexCharts from 'vue-apexcharts';
import { mapActions, mapState, mapGetters } from 'vuex';

export default {
  components: {
    ApexCharts,
  },
  data() {
    return {};
  },
  computed: {
    ...mapState({
      predictedData: (state) => state.prediction.predictedData,
      predictionFilter: (state) => state.prediction.predictionFilter,
    }),

    chartOptions() {
      return {
        chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false,
          },
          events: {
            click: function (event, chartContext, config) {
              console.log('event', event);
              console.log('chartContext', chartContext);
              console.log('config', config);
              // The last parameter config contains additional information like `seriesIndex` and `dataPointIndex` for cartesian charts
            },
          },
        },
        dataLabels: {
          enabled: false,
        },
        title: {
          text: 'Résultat de la prediction',
          align: 'left',
        },
        stroke: {
          curve: 'smooth',
        },
        annotations: {
          xaxis: [
            {
              x: new Date('2022-11-30').getTime(),
              strokeDashArray: 2,
              borderColor: '#444',
              label: {
                borderColor: '#444',
                style: {
                  color: '#fff',
                  background: '#444',
                },
                textAnchor: 'middle',
                text: 'Données prédite',
              },
            },
            {
              x: new Date('2022-12-4').getTime(),
              x2: new Date('2022-12-6').getTime(),
              fillColor: '#EEE',
              opacity: 0.4,
              label: {
                borderColor: '#EEE',
                style: {
                  fontSize: '10px',
                  color: '#fff',
                  background: 'tomato',
                },
                offsetY: -10,
                text: 'Surcharge',
              },
            },
          ],
          points: [
            {
              x: new Date('2022-12-2').getTime(),
              y: 11,
              marker: {
                size: 8,
                fillColor: '#fff',
                strokeColor: 'red',
                radius: 2,
                cssClass: 'apexcharts-custom-class',
              },
              label: {
                borderColor: '#FF4560',
                offsetY: 0,
                style: {
                  color: '#fff',
                  background: '#FF4560',
                },

                text: 'Modifié',
              },
            },
          ],
        },

        forecastDataPoints: {
          count: 8,
          dashArray: 2,
          fillOpacity: 0.5,
        },

        legend: {
          tooltipHoverFormatter: function (val, opts) {
            return (
              val +
              ' - ' +
              opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] +
              ''
            );
          },
        },
        markers: {
          size: 0,
          hover: {
            sizeOffset: 6,
          },
        },
        xaxis: {
          type: 'datetime',
          categories: this.predictedData.map((data) => data['date']),
        },

        grid: {
          borderColor: '#f1f1f1',
        },
      };
    },
    chartSeries() {
      const fields = ['lit_dispo', 'cas_conf', 'lit_occ'];
      return fields.map((field) => {
        return {
          name: field,
          data: this.predictedData.map((data) => data[field]),
        };
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.img-fluid {
  width: 200px;
  height: auto;
}
.circle-indicator {
  width: 15px;
  height: 15px;
  border: 2px solid rgb(255, 69, 96);
  border-radius: 15px;
}

.square-indicator {
  width: 15px;
  height: 20px;
  border-left: 1px solid rgb(220, 218, 218);
  border-right: 1px solid rgb(220, 218, 218);
  background-color: rgb(245, 245, 245);
}

.indicator-label {
  color: rgb(55, 61, 63);
  font-size: 12px;
  font-weight: 400;
  font-family: Helvetica, Arial, sans-serif;
  padding-left: 8px;
}
</style>
