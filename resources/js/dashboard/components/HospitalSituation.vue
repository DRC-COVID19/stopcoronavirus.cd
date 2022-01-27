/* eslint-disable vue/return-in-computed-property */
<template>
  <b-container class="p-0">
    <b-row>
      <b-col cols="12 mb-2">
        <div class="row align-items-center">
          <skeleton-loading v-if="isLoading" class="col-12 col-md-12">
            <square-skeleton
              :boxProperties="{
                width: '30%',
                height: '40px',
              }"
            ></square-skeleton>
          </skeleton-loading>
          <h4
            class="col-12 col-md-6 mb-3 mb-md-0 m-0 d-flex align-items-baseline"
            v-if="!isLoading"
          >
            <span>{{ hospital.name || "Rapport global" }}</span>
            <b-badge v-if="hospitalCount" style="font-size: 12px" class="ml-2">
              {{ hospitalCount }}
              <small>infrastructure(s)</small>
            </b-badge>
          </h4>
          <export-excel :data="hospitalSituationData" name="filename.xls">
            <span style="cursor: pointer"
              >Télécharger les données
              <Icon
                style="font-size: 30px"
                icon="vscode-icons:file-type-excel2"
              />
            </span>
          </export-excel>
          <div
            class="text-right text-black-50 col-12 col-md-6"
            v-if="lastUpdate && !isLoading"
          >
            Mise à jour du {{ moment(lastUpdate).format("DD.MM.Y") }}
          </div>
          <div class="col-12 text-right" v-if="!isLoading">
            <button
              class="btn btn-sm btn-primary"
              style="font-size: 12px"
              @click="backToTotalData()"
              v-if="!isGlobal"
            >
              Retour aux données globales
            </button>
          </div>
        </div>
      </b-col>
    </b-row>
    <b-row no-gutters>
      <b-col cols="12" md="12" class="row no-gutters pr-1">
        <skeleton-loading v-if="isLoading" class="mb-2">
          <square-skeleton
            :boxProperties="{
              width: '100%',
              height: '340px',
            }"
          ></square-skeleton>
        </skeleton-loading>

        <b-card
          class="col-10 default-card mb-2 offset-1"
          v-else
          v-for="(step, index) in hospitalSituationFiltered.length > 0 ? hospitalSituationFiltered: hospitalSituationReduced"
          :key="index"
        >

          <h5 class="bold">{{ step.form_step_title }}</h5>
          <div v-for="(item, key) in step.form_field_values" :key="key">
            <p>
              {{ item.form_field_name }} :
              <strong>{{ item.form_field_value }}</strong>
            </p>
          </div>
        </b-card>

      </b-col>
    </b-row>

    <b-row no-gutters class="mb-2">
      <b-col cols="12" md="6" class="pr-1">
        <div v-if="situationHospitalLoading || isLoading">
          <b-skeleton-wrapper :loading="situationHospitalLoading || isLoading">
            <template #loading>
              <b-card no-body class="default-card card-chart p-2 cardtype1">
                <b-skeleton class="m-auto" width="60%" height="20"></b-skeleton>
                <b-skeleton class="mt-2" width="100%" height="180"></b-skeleton>
              </b-card>
            </template>
          </b-skeleton-wrapper>
        </div>
        <FullScreen
          id="canvasStat1_full"
          link="canvasStat1"
          v-show="!situationHospitalLoading && !isLoading"
        >
          <b-card no-body class="default-card card-chart p-2 cardtype1">
            <b-spinner
              label="Chargement..."
              v-if="situationHospitalLoading"
            ></b-spinner>
            <div class="legend-custom">
              <div class="text-center title general-top-title">
                Evolution d'occupation des respirateurs
              </div>
              <div
                class="
                  d-flex
                  flex-wrap
                  justify-content-center
                  align-items-center
                "
              >
                <div>
                  <span class="legend-color total"></span>
                  <Span>Ligne Totale</Span>
                </div>
                <div>
                  <span class="legend-color respirator"></span>
                  <Span>Respirateurs</Span>
                </div>
                <div>
                  <span class="legend-color interpolation"></span>
                  <Span>Interpolation</Span>
                </div>
              </div>
            </div>
            <div class="chart-container">
              <OccupedRespiratorChart :data='prepareGraphicSituation'/>
            </div>
          </b-card>
        </FullScreen>
      </b-col>

      <b-col cols="12" md="6" class="pl-1">
        <div v-if="situationHospitalLoading || isLoading">
          <b-skeleton-wrapper :loading="situationHospitalLoading || isLoading">
            <template #loading>
              <b-card no-body class="default-card card-chart p-2 cardtype1">
                <b-skeleton class="m-auto" width="60%" height="20"></b-skeleton>
                <b-skeleton class="mt-2" width="100%" height="180"></b-skeleton>
              </b-card>
            </template>
          </b-skeleton-wrapper>
        </div>
        <FullScreen
          id="canvasStat2_full"
          link="canvasStat2"
          v-show="!situationHospitalLoading && !isLoading"
        >
          <b-card no-body class="default-card card-chart p-2 cardtype1">
            <b-spinner
              label="Chargement..."
              v-if="situationHospitalLoading"
            ></b-spinner>
            <div class="legend-custom">
              <div class="text-center title general-top-title">
                Evolution d'occupation des lits de réanimation
              </div>
              <div
                class="
                  d-flex
                  flex-wrap
                  justify-content-center
                  align-items-center
                "
              >
                <div>
                  <span class="legend-color total"></span>
                  <Span>Ligne Totale</Span>
                </div>
                <div>
                  <span class="legend-color respirator"></span>
                  <Span>Respirateurs</Span>
                </div>
                <div>
                  <span class="legend-color interpolation"></span>
                  <Span>Interpolation</Span>
                </div>
              </div>
            </div>
            <div class="chart-container">
              <OccupiedResuscitationBeds :data='prepareGraphicSituation'/>
            </div>
          </b-card>
        </FullScreen>
      </b-col>

      <b-col cols="12" class="mt-2">
        <div v-if="situationHospitalLoading || isLoading">
          <b-skeleton-wrapper :loading="situationHospitalLoading || isLoading">
            <template #loading>
              <b-card no-body class="default-card card-chart p-2 cardtype1">
                <b-skeleton class="m-auto" width="60%" height="20"></b-skeleton>
                <b-skeleton class="mt-2" width="100%" height="180"></b-skeleton>
              </b-card>
            </template>
          </b-skeleton-wrapper>
        </div>
        <FullScreen
          id="canvasStat3_full"
          link="canvasStat3"
          v-show="!situationHospitalLoading && !isLoading"
        >
          <b-card no-body class="default-card card-chart p-2 cardtype1">
            <!-- <b-spinner
              label="Chargement..."
              v-if="situationHospitalLoading"
            ></b-spinner> -->
            <div class="legend-custom">
              <div class="text-center title general-top-title">
                Evolution global du taux d'occupation
              </div>
              <div
                class="
                  d-flex
                  flex-wrap
                  justify-content-center
                  align-items-center
                "
              >
                <div>
                  <span class="legend-color total"></span>
                  <Span>Taux de Lits de réanimation</Span>
                </div>
                <div>
                  <span class="legend-color respirator"></span>
                  <Span>Taux de Respirateurs</Span>
                </div>
              </div>
            </div>
            <div class="chart-container">
              <GlobalSituationChart/>
              <!-- <canvas
                height="400"
                width="100vh"
                ref="canvasStat3"
                id="canvasStat3"
              ></canvas> -->
            </div>
          </b-card>
        </FullScreen>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import { mapState, mapActions, mapMutations } from 'vuex'
import { PALETTE } from '../config/env'
import { Icon } from '@iconify/vue2'
import GlobalSituationChart from './GlobalSituationChart.vue'
import OccupedRespiratorChart from './OccupedRespiratorChart.vue'
import OccupiedResuscitationBeds from './OccupiedResuscitationBedsChart.vue'

export default {
  props: ['hospitalSituationAll'],
  components: {
    Icon,
    GlobalSituationChart,
    OccupedRespiratorChart,
    OccupiedResuscitationBeds
  },
  data () {
    return {
      etatGlobal: true,
      dataGlobal: null,
      objetChart: {},
      chartLabels: [
        {
          title: "Evolution du taux d'occupation des respirateurs",
          lableY: 'Nombre de respirateurs'
        },

        {
          title: "Evolution du taux d'occupation des lits de réanimation",
          lableY: 'Nombre de lits'
        },

        {
          title: "Evolution global du taux d'occupation",
          lableY: "Taux d'occupation"
        }
      ]
    }
  },
  mounted () {
    const id = this.selectedHospital ? this.selectedHospital.id : null
    this.getSituationHospital(id)
    this.getFormSteps({ id: 3, page: 1 })
    if (this.filterdHospitalSituation.last_update.length > 0) {
      this.hospitalSituationFiltered()
    }
  },
  computed: {
    ...mapState({
      selectedHospital: (state) => state.hospital.selectedHospital,
      situationHospitalLoading: (state) =>
        state.hospital.situationHospitalLoading,
      hospitalData: (state) => state.hospital.hospitalData,
      situationHospital: (state) => state.hospital.situationHospital,
      hospitalCount: (state) => state.hospital.hospitalCount,
      isLoading: (state) => state.hospital.isLoading,
      formSteps: (state) => state.formStep.formSteps,
      filterdHospitalSituation: (state) => state.hospitalSituation.filterdHospitalSituation
    }),
    hospital () {
      if (this.selectedHospital != null) return this.selectedHospital
      else {
        return this.hospitalTotalData ? this.hospitalTotalData : {}
      }
    },
    isGlobal () {
      return this.selectedHospital == null
    },
    lastUpdate () {
      if (this.selectedHospital != null) {
        return this.selectedHospital.last_update
      } else if (this.dataGlobal) {
        return this.dataGlobal.last_update[
          this.dataGlobal.last_update.length - 1
        ]
      } else return null
    },

    hospitalSituationReduced () {
      return this.createSituationsReduce(this.hospitalSituationAll.allFormFields)
    },

    hospitalSituationFiltered () {
      const arrayFilterd = [].concat.apply([], this.filterdHospitalSituation.form_fields_names)
      return this.createSituationsReduce(arrayFilterd)
    },

    hospitalSituationData () {
      const hospitalSituationAllSlice = this.hospitalSituationAll.allFormFields.slice()
      const monObj = {}
      const hospitalSituationFiltered = []
      for (const hospital of hospitalSituationAllSlice) {
        monObj[hospital.form_field_name] = hospital.form_field_value
      }
      this.objetChart = monObj
      hospitalSituationFiltered.push(monObj)
      return hospitalSituationFiltered
    },
    prepareGraphicSituation () {
      return this.hospitalSituationAll.formFieldsFiltered
    }

  },
  watch: {
    hospitalData () {
      this.selectHospital(null)
      this.getSituationHospital()
    },
    selectedHospital (val) {
      const id = val ? val.id : null
      this.getSituationHospital(id)
    },
    situationHospital (val) {
      this.dataGlobal = val
      this.paintStats(val)
    }
  },
  methods: {
    ...mapActions([
      'getSituationHospital',
      'getFormSteps'
    ]),
    ...mapMutations(['selectHospital']),
    paintStats (data) {
      const lastUpdates = data.last_update
      const occupiedRespirators = data.occupied_respirators
      const occupiedResuscitation_beds = data.occupied_resuscitation_beds
      const unknow = []
      const Respirators = [...occupiedRespirators]
      const Resuscitation_beds = [...occupiedResuscitation_beds]

      const valideIndex = []
      data.occupied_respirators = occupiedRespirators.map((item, index) => {
        if (!item || Number(item) == 0) {
          const y1Array = []
          const y2Array = []

          occupiedRespirators.map((x, i) => {
            if (i < index && x && Number(x) > 0) {
              y1Array.push({
                value: x,
                i
              })
            }
            if (i > index && x && Number(x) > 0) {
              y2Array.push({
                value: x,
                i
              })
            }
          })
          let y1 = null
          let y2 = null
          let x1 = null
          let x2 = null
          if (y1Array && y1Array.length > 0) {
            y1 = y1Array[y1Array.length - 1]
            x1 = lastUpdates[y1.i]
          }
          if (y2Array && y2Array.length > 0) {
            y2 = y2Array[0]
            x2 = lastUpdates[y2.i]
          }
          const x = lastUpdates[index]

          if (y1 && y2 && x1 && x2) {
            const x_x1 = Math.abs(new Date(x) - new Date(x1))
            const x2_x1 = Math.abs(new Date(x2) - new Date(x1))
            const y2_y1 = Number(y2.value) - Number(y1.value)
            const y = Number(y1.value) + (y2_y1 / x2_x1) * x_x1

            return y
          }
        }
        return item
      })

      data.occupied_resuscitation_beds = occupiedResuscitation_beds.map(
        (item, index) => {
          if (!item || Number(item) == 0) {
            const y1Array = []
            const y2Array = []

            occupiedResuscitation_beds.map((x, i) => {
              if (i < index && x && Number(x) > 0) {
                y1Array.push({
                  value: x,
                  i
                })
              }
              if (i > index && x && Number(x) > 0) {
                y2Array.push({
                  value: x,
                  i
                })
              }
            })
            let y1 = null
            let y2 = null
            let x1 = null
            let x2 = null
            if (y1Array && y1Array.length > 0) {
              y1 = y1Array[y1Array.length - 1]
              x1 = lastUpdates[y1.i]
            }
            if (y2Array && y2Array.length > 0) {
              y2 = y2Array[0]
              x2 = lastUpdates[y2.i]
            }
            const x = lastUpdates[index]

            if (y1 && y2 && x1 && x2) {
              const x_x1 = Math.abs(new Date(x) - new Date(x1))
              const x2_x1 = Math.abs(new Date(x2) - new Date(x1))
              const y2_y1 = Number(y2.value) - Number(y1.value)
              const y = Number(y1.value) + (y2_y1 / x2_x1) * x_x1

              return y
            }
          }
          return item
        }
      )

      const totalRescitationBed = Number(
        data.resuscitation_beds[data.resuscitation_beds.length - 1]
      )
      const totalRespirator = Number(
        data.respirators[data.respirators.length - 1]
      )

      for (let i = 0; i < 3; i++) {
        const callbacks = {
          title: (a, d) => {
            return this.moment(a[0].xLabel).format('DD.MM.Y')
          }
        }
        let ticksY = {}
        let datasets = []
        let annotation = {}
        if (i == 0) {
          annotation = {
            drawTime: 'afterDraw',
            annotations: [
              {
                id: 'line' + i,
                type: 'line',
                mode: 'horizontal',
                scaleID: 'y-axis-0',
                value: totalRespirator,
                borderColor: 'magenta',
                label: { content: 'label' },
                borderWidth: 3
              }
            ]
          }

          datasets = [
            {
              label: 'Respirateurs occupés',
              fill: false,
              backgroundColor: PALETTE.dash_green,
              borderColor: PALETTE.dash_green,
              data: Respirators.map((x) => (x == 0 ? null : x)),
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4
            },
            {
              label: 'Interpolation',
              fill: false,
              backgroundColor: PALETTE.dash_red,
              borderColor: PALETTE.dash_red,
              data: data.occupied_respirators.map((x, i) => {
                if (x == 0) return null
                if (
                  !+Respirators[i] ||
                  (!+Respirators[i - 1] && +data.occupied_respirators[i - 1]) ||
                  (!+Respirators[i + 1] && +data.occupied_respirators[i + 1])
                ) {
                  return x
                }

                return null
              }),
              fill: false,
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4
            }
          ]
          const respiratorMax = Math.max(...Respirators.map((x) => Number(x)))
          let tickMax = respiratorMax
          if (totalRespirator > respiratorMax) {
            tickMax = totalRespirator + 1
          }
          ticksY = {
            min: 0,
            max: tickMax,
            precision: 0
          }
        } else if (i == 1) {
          annotation = {
            drawTime: 'afterDraw',
            annotations: [
              {
                id: 'line' + i,
                type: 'line',
                mode: 'horizontal',
                scaleID: 'y-axis-0',
                value: totalRescitationBed,
                borderColor: 'magenta',
                borderWidth: 3,
                label: 'label'
              }
            ]
          }

          datasets = [
            {
              label: 'Lits de réanimation occupés',
              backgroundColor: PALETTE.dash_green,
              borderColor: PALETTE.dash_green,
              data: Resuscitation_beds.map((x) => (x === 0 ? null : x)),
              fill: false,
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4
            },
            {
              label: 'interpolation',
              backgroundColor: PALETTE.dash_red,
              borderColor: PALETTE.dash_red,
              data: data.occupied_resuscitation_beds.map((x, i) => {
                if (x == 0) return null
                if (
                  !+Resuscitation_beds[i] ||
                  (!+Resuscitation_beds[i - 1] &&
                    +data.occupied_resuscitation_beds[i - 1]) ||
                  (!+Resuscitation_beds[i + 1] &&
                    +data.occupied_resuscitation_beds[i + 1])
                ) {
                  return x
                }

                return null
              }),
              fill: false,
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4
            }
          ]

          const resuscitationBedsMax = Math.max(
            ...Resuscitation_beds.map((x) => Number(x))
          )
          let tickMax = resuscitationBedsMax
          if (totalRescitationBed > resuscitationBedsMax) {
            tickMax = totalRescitationBed + 1
          }

          ticksY = {
            min: 0,
            precision: 0,
            max: tickMax
          }
        } else {
          const dataset1 = data.occupied_resuscitation_beds.map((a, i) => {
            // if (a == 0 || data.resuscitation_beds[i] == 0) return null;
            return Math.round(
              (a * 100) /
                data.resuscitation_beds[data.resuscitation_beds.length - 1]
            )
          })

          const dataset2 = data.occupied_respirators.map((a, i) => {
            // if (a == 0 || data.respirators[i] == 0) return null;
            return Math.round(
              (a * 100) / data.respirators[data.respirators.length - 1]
            )
          })

          datasets = [
            {
              label: 'Taux occupation des Réspirateurs',
              backgroundColor: PALETTE.dash_green,
              borderColor: PALETTE.dash_green,
              data: dataset2,
              fill: false,
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4
            },
            {
              label: 'Taux occupation des lits de réanimation',
              backgroundColor: 'magenta',
              borderColor: 'magenta',
              data: dataset1,
              fill: false,
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4
            }
          ]

          callbacks.label = function (tooltipItem, data) {
            let label = data.datasets[tooltipItem.datasetIndex].label || ''
            if (label) label += ': '
            label += tooltipItem.yLabel + '%'
            return label
          }

          ticksY = {
            min: 0,
            callback: function (value, index, values) {
              return value + '%'
            }
          }
        }
        const config = {
          type: 'line',
          data: {
            labels: data.last_update.map((d) => new Date(d)),
            datasets: datasets
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
              display: false
            },
            title: {
              display: false,
              text: this.chartLabels[i].title,
              fontSize: 11
            },
            tooltips: {
              mode: 'index',
              intersect: false,
              callbacks: callbacks
            },
            annotation,
            plugins: {
              crosshair: {
                sync: {
                  enabled: false // enable trace line syncing with other charts
                },
                zoom: {
                  enabled: false
                }
              }
            },
            hover: {
              mode: 'nearest',
              intersect: true
            },
            scales: {
              xAxes: [
                {
                  display: true,
                  type: 'time',
                  distribution: 'series',
                  time: {
                    unit: 'day',
                    unitStepSize: 1,
                    displayFormats: {
                      day: 'DD.MM'
                    }
                  },
                  scaleLabel: {
                    display: true,
                    labelString: 'Periode'
                  },
                  ticks: {
                    fontSize: 9,
                    autoSkip: false,
                    maxRotation: 90,
                    minRotation: 90
                  }
                }
              ],
              yAxes: [
                {
                  display: true,
                  scaleLabel: {
                    display: true,
                    labelString: this.chartLabels[i].lableY
                  },
                  ticks: ticksY
                }
              ]
            }
          }
        }
        const reference = this.$refs[`canvasStat${i + 1}`]
        if (this.lineCharts[i]) this.lineCharts[i].destroy()
        this.lineCharts[i] = new Chart(reference.getContext('2d'), config)
        reference.style.height = '200px'
        reference.style.maxHeight = '200px'
        // this.lineCharts[i].generateLegend();
      }
    },
    createSituationsReduce (array = []) {
      const formIds = []
      if (array.length > 0) {
        array?.slice()
          .sort((prevFormItem, nextFormItem) => prevFormItem.form_step_id - nextFormItem.form_step_id)
          .forEach((item) => {
            if (formIds.every((form) => form.form_step_id !== item.form_step_id)) {
              formIds.push({
                form_step_id: item.form_step_id,
                form_step_title: item.form_step_title
              })
            }
          })
        const formStepsList = formIds.map((form) => {
          const formStep = {
            form_step_id: form.form_step_id,
            form_step_title: form.form_step_title
          }
          formStep.form_field_values = array.filter(
            (arr) => arr.form_step_id == formStep.form_step_id
          )
          return formStep
        })
        return formStepsList
      }
      return []
    },
    backToTotalData () {
      this.selectHospital(null)
    },
    parseData (data) {
      if (data == null) return 'N/A'
      else return data
    }
  }
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.fullscreen {
  .cardtype1 {
    canvas {
      width: calc(100vw - 19px) !important;
      height: 500px !important;
    }
  }
  .cardtype2 {
    canvas {
      width: 700px !important;
      height: calc(100vh - 32px) !important;
    }
  }
}
.card-chart {
  position: relative;
  #canvasStat1,
  #canvasStat2 {
    height: 400px !important ;
  }
  .legend-custom {
    .title {
      font-size: 0.8rem;
    }
    .legend-color {
      display: inline-block;
      width: 10px;
      height: 10px;
      background: red;
      + span {
        margin-right: 5px;
        font-size: 0.6rem;
      }
      &.total {
        background: magenta;
      }
      &.respirator {
        background: $dash_green;
      }
      &.interpolation {
        background: $flux-presence;
      }
    }
  }
  .spinner-border {
    position: absolute;
    top: calc(50% - 20px);
    left: calc(50% - 20px);
  }
}
</style>
