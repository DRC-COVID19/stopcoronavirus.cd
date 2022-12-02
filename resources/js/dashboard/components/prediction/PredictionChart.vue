<template>
  <b-card no-body class="text-center pt-3 px-2">
    <div v-if="formattedPredictedData?.length">
      <ApexCharts
        type="line"
        height="350"
        :options="chartOptions"
        :series="chartSeries"
      ></ApexCharts>
      <div class="d-flex justify-content-center align-items-center mb-3">
        <div class="d-flex justify-content-center align-items-center">
          <div class="circle-indicator"></div>
          <div class="indicator-label">Valeur modifié (en local)</div>
        </div>

        <div class="d-flex justify-content-center align-items-center ml-3">
          <div class="circle-indicator add"></div>
          <div class="indicator-label">Valeur modifié</div>
        </div>

        <div class="d-flex justify-content-center align-items-center ml-3">
          <div class="square-indicator"></div>
          <div class="indicator-label">Zone de surcharge</div>
        </div>
      </div>
      <div class="d-flex justify-content-end mb-2 pt-2 border-top">
        <b-button
          size="sm"
          variant="danger"
          class="modal-btn mr-3"
          @click="handleResetAll"
          v-if="canRecalculatePrediction && !isPredictionLoading"
        >
          Tout réinitialiser
        </b-button>
        <b-spinner
          variant="primary"
          class="mr-3"
          v-if="canRecalculatePrediction && isPredictionLoading"
        ></b-spinner>
        <b-button
          size="sm"
          variant="success"
          class="modal-btn mr-3"
          @click="handleRecalculatePrediction"
          v-if="canRecalculatePrediction && !isPredictionLoading"
        >
          Recalculer la prediction
        </b-button>
        <b-button
          size="sm"
          variant="primary"
          @click="handleOpenAddValueModal"
          class="modal-btn"
        >
          Ajouter une valeur
        </b-button>
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

    <PredictionModal
      @submit="handleSubmitModalData"
      :modalData="modalPredictionData"
    />
  </b-card>
</template>

<script>
import ApexCharts from 'vue-apexcharts';
import { mapActions, mapState, mapGetters } from 'vuex';
import { getFormattedDate } from '../../functions/formatDateRange';
import PredictionModal from './PredictionModal';

export default {
  components: {
    ApexCharts,
    PredictionModal,
  },
  data() {
    return {
      modalPredictionData: null,
      formattedPredictedData: [],
    };
  },
  watch: {
    predictedData() {
      this.formattedPredictedData =
        this.prediction__GetFormattedData()?.map((d) => {
          const newFields = {};
          this.fields.forEach((f) => {
            newFields[f] = {
              value: parseInt(d[f]?.value),
              recalculate: d[f]?.updated,
            };
          });
          return { ...d, ...newFields };
        }) || [];
    },
  },
  computed: {
    ...mapState({
      predictedData: (state) => state.prediction.predictedData,
      predictionFilter: (state) => state.prediction.predictionFilter,
      isPredictionLoading: (state) => state.prediction.isLoading,
    }),

    fields() {
      return this.predictedData.map((d) => d.form_field_name);
    },

    canRecalculatePrediction() {
      return this.formattedPredictedData.some((d) => {
        let canRecalculatePrediction = false;
        this.fields.forEach((f) => {
          if (d[f]?.updated || d[f]?.added) canRecalculatePrediction = true;
        });
        return canRecalculatePrediction;
      });
    },

    annotationPoints() {
      const annotationPoints = [];
      this.formattedPredictedData.forEach((d) => {
        this.fields.forEach((f) => {
          if (d[f]?.updated || d[f]?.recalculate) {
            annotationPoints.push({
              x: new Date(d.date).getTime(),
              y: d[f].value,
              marker: {
                size: 7,
                fillColor: '#fff',
                strokeColor: d[f].updated ? '#FF4560' : '#3868fa',
                radius: 2,
                cssClass: 'apexcharts-custom-class',
              },
            });
          }
        });
      });
      return annotationPoints;
    },

    chartOptions() {
      return {
        chart: {
          id: 'predictionChart',
          height: 350,
          type: 'line',
          zoom: {
            enabled: true,
          },
          events: {
            click: (event, chartContext, config) => {
              if (config.dataPointIndex > -1) {
                const date =
                  this.formattedPredictedData[config.dataPointIndex]['date'];
                const fields = this.chartSeries.map((s) => ({
                  name: s.name,
                  ...this.formattedPredictedData[config.dataPointIndex][s.name],
                }));
                this.modalPredictionData = { date, type: 'update', fields };
                this.$bvModal.show('prediction-modal');
              }
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
              x: new Date(this.predictedData[0]?.predicted[1]?.date).getTime(),
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
            /* {
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
            }, */
          ],

          points: this.annotationPoints,
        },
        forecastDataPoints: {
          count: this.predictedData[0]?.predicted?.length - 2,
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
          categories: this.formattedPredictedData.map((data) => data?.date),
        },
        grid: {
          borderColor: '#f1f1f1',
        },
      };
    },
    chartSeries() {
      return this.fields.map((field) => {
        return {
          name: field,
          data: this.formattedPredictedData.map((data) => data[field]?.value),
        };
      });
    },
  },
  methods: {
    ...mapActions(['prediction__GetPredictedData']),
    ...mapGetters(['prediction__GetFormattedData']),
    handleResetAll() {
      this.$bvModal
        .msgBoxConfirm(
          'Toute vos modification et ajout seront perdu, êtes vous sur ?',
          {
            title: 'Réinitialisation des données',
            size: 'sm',
            buttonSize: 'sm',
            okVariant: 'success',
            okTitle: 'OUI',
            cancelTitle: 'NON',
            cancelVariant: 'danger',
            footerClass: 'p-2 confirm-btn text-sm',
            hideHeaderClose: true,
            centered: true,
          }
        )
        .then((value) => {
          if (!!value) {
            const newFormattedPredictedData = this.formattedPredictedData
              .map((d) => {
                const newValue = {};
                this.fields.forEach((f) => {
                  if (d[f].updated) {
                    newValue[f] = {
                      ...d[f],
                      value: d[f].oldValue,
                      updated: false,
                    };
                  }
                });
                return { ...d, ...newValue };
              })
              .filter((d) => !this.fields.some((f) => d[f].added));
            this.formattedPredictedData = newFormattedPredictedData;
          }
        })
        .catch((err) => {});
    },
    handleOpenAddValueModal() {
      const fields = this.fields.map((f) => ({
        name: f,
        value: 0,
        updated: false,
      }));

      const minDate = new Date(this.formattedPredictedData.slice(-1)[0]?.date);
      minDate.setDate(minDate.getDate() + 1);
      this.modalPredictionData = {
        date: null,
        minDate,
        type: 'add',
        fields,
      };
      this.$bvModal.show('prediction-modal');
    },
    handleSubmitModalData(data) {
      if (data.type === 'update') {
        const newFormattedPredictedData = this.formattedPredictedData.map(
          (d) => {
            if (d.date === data.date) {
              const newValue = {};
              data.fields.forEach((f) => {
                const value = parseInt(f.value);
                if (value !== parseInt(d[f.name].value)) {
                  newValue[f.name] = {
                    ...d[f.name],
                    value,
                    oldValue: parseInt(d[f.name].value),
                    updated: true,
                  };
                }
                if (value === parseInt(d[f.name].oldValue)) {
                  newValue[f.name] = { ...d[f.name], value, updated: false };
                }
              });
              return { ...d, ...newValue };
            }
            return d;
          }
        );
        this.formattedPredictedData = newFormattedPredictedData;
      } else {
        const newData = { date: data.date };
        data.fields.forEach((f) => {
          const value = parseInt(f.value);
          newData[f.name] = { value, added: true };
        });
        this.formattedPredictedData = [...this.formattedPredictedData, newData];
      }
      this.$bvModal.hide('prediction-modal');
    },
    async handleRecalculatePrediction() {
      if (this.isPredictionLoading || !this.predictionFilter) return;

      const changedObservations = [];
      this.formattedPredictedData.forEach((d) => {
        this.fields.forEach((f) => {
          if (d[f].updated) {
            changedObservations.push({
              date: getFormattedDate(d.date),
              value: d[f].value,
              form_field_id: this.predictedData?.find(
                (p) => p.form_field_name === f
              )?.form_field_id,
            });
          }
        });
      });

      const predictionFilter = {
        ...this.predictionFilter,
        changed_observations: changedObservations,
      };
      console.log('predictionFilter', predictionFilter);
      await this.prediction__GetPredictedData(predictionFilter);
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
  &.add {
    border: 2px solid rgb(56, 104, 250);
  }
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

.modal-btn {
  font-size: 13px;
}

.confirm-btn {
  .btn {
    font-size: 13px !important;
  }
}
</style>
