<template>
  <b-container fluid class="px-0 mx-0 containerReporting h-100">
    <b-row class="d-flex mx-0">
      <div>
        <b-button
          v-b-toggle.sidebar-header-reporting
          class="btn-dash-blue btn-sidebar"
          ><i class="fas fa-chart-line"></i
        ></b-button>
        <b-sidebar id="sidebar-header-reporting" right shadow>
          <HeaderReporting
            :forms="forms"
            :hospitals="hospitals"
            @generatedReport="submitGeneratedReport"
            @selectedChartType="onSelectedChartType"
            class="w-100 h-100"
          />
        </b-sidebar>
      </div>
      <b-col
        lg="3"
        class="mx-0 px-0 bg-white header-responsive py-3 w-100 h-100"
      >
        <HeaderReporting
          :forms="forms"
          :hospitals="hospitals"
          @generatedReport="submitGeneratedReport"
          @selectedChartType="onSelectedChartType"
          class="w-100 h-100"
        />
      </b-col>

      <b-col class="d-md-flex w-100 h-100 container-action mx-0" lg="8" md="12">
        <b-col lg="12" md="12" class="w-100 h-100 mx-0">
          <div
            v-if="!isHospitalsDataAggregated"
            lg="12"
            md="12"
            class="w-100 h-100 bg-white"
          >
            <ApexChart
              :type="typeChart"
              :options="options"
              :series="series"
              class="w-100 h-100"
            />
          </div>
          <skeleton-loading v-else class="w-100">
            <square-skeleton
              :boxProperties="{
                width: '100%',
                height: '750px',
              }"
            ></square-skeleton>
          </skeleton-loading>
        </b-col>
        <!-- <b-col
          lg="4"
          md="12"
          class="w-100 d-flex justify-content-center bg-white bookmark"
        >
        </b-col> -->
      </b-col>
    </b-row>
    <b-modal centered ref="my-modal-title" hide-header hide-footer>
      <b-container class="w-100">
        <b-row class="w-100">
          <b-col lg="12" class="px-3 pt-4 w-100">
            <b-col lg="12" class="px-3 justify-content-center w-100">
              <label class="text-dash-color w-100"> Titre graphique : </label>
              <form-field-input
                v-model="titleChart"
                type="text"
                :placeholder="`Donner un titre à votre graphique`"
                id="input-1"
                name="Titre graphique"
                rules="required"
                class="w-100"
              />
            </b-col>

            <b-col
              lg="12"
              class="px-3 pt-4 d-flex justify-content-center w-100"
            >
              <b-button
                size="sm"
                variant="success"
                @click.prevent="managerTitleChart"
                class="btn-dash-blue btn-title"
                :disabled="titleChart.length === 0"
              >
                <small> Enregistrer</small>
              </b-button>
            </b-col>
          </b-col>
        </b-row>
      </b-container>
    </b-modal>
  </b-container>
</template>
<script>
import { mapState, mapActions } from 'vuex'
import HeaderReporting from './components/HeaderReporting'
import ApexChart from './components/ApexChart'
import FormFieldInput from '../../../components/forms/FormFieldInput.vue'
export default {
  name: 'Reporting',
  components: {
    HeaderReporting,
    ApexChart,
    FormFieldInput
  },

  data () {
    return {
      reportingChart: {},
      options: {
        chart: {
          id: 'vuechart-example'
        },

        plotOptions: {
          bar: {
            horizontal: true
          },
          pie: {
            donut: {
              size: '100%'
            },
            customScale: 1
          }
        },
        labels: []
      },
      series: [],
      operationId: null,
      operations: [
        { id: 1, type: 'Somme' },
        { id: 2, type: 'Moyenne' }
      ],
      typeChart: '',
      titleChart: ''

    }
  },
  mounted () {
    this.getForms()
    this.hospital__getAll()
  },
  computed: {
    ...mapState({
      forms: (state) => state.form.forms,
      hospitals: (state) => state.hospital.allHospitals,
      hospitalsDataAggregated: (state) =>
        state.hospital.hospitalsDataAggregated,
      isHospitalsDataAggregated: (state) =>
        state.hospital.isHospitalsDataAggregated
    })
  },
  methods: {
    ...mapActions(['getForms', 'hospital__getAll', 'getHospitalsData']),
    managerTitleChart () {
      this.options = {
        ...this.options,
        title: {
          text: this.titleChart,
          align: 'center',
          style: {
            fontSize: '16px',
            color: '#666'
          }
        }
      }
      this.hideModal()
    },
    hideModal () {
      this.$refs['my-modal-title'].hide()
    },
    submitGeneratedReport (reporting) {
      this.reportingChart = { ...reporting }

      this.getHospitalsData({
        form_id: reporting.formId,
        observation_start: reporting.observation_start,
        observation_end: reporting.observation_end
      })
      this.$refs['my-modal-title'].show()
    },
    updateAxis (data) {
      this.options = {
        ...this.options,
        xaxis: {
          categories: [...data]
        }
      }
    },
    onSelectedChartType (value) {
      this.typeChart = value.id
    },
    renderAxesSelected () {
      const axes = this.reportingChart.axeId.map(
        (axe) => axe.id
      )
      const categories = []
      const hospitalData = this.hospitalsDataAggregated
        .filter((hospital) => {
          return axes.includes(
            this.reportingChart.axeIdType === 'township'
              ? hospital.township_id
              : hospital.id
          )
        })
        .map((form) => {
          categories.push(
            this.reportingChart.axeIdType === 'township'
              ? form.township.name.replace(/ /g, '').toUpperCase()
              : form.name.replace(/ /g, '').toUpperCase()
          )
          return form
        })

      this.updateAxis(categories)
      console.log('this.options.xaxis.categories ->', categories)

      return hospitalData
    },
    groupDataApex (data) {
      const dataSerie = []
      data.forEach((formField, index, arr) => {
        if (dataSerie.every((data) => data.name !== formField.name)) {
          dataSerie.push({
            name: formField.name,
            data: arr
              .filter((data) => data.name === formField.name)
              .map((data) => {
                return this.typeChart === 'line'
                  ? { x: data.x, y: data.y }
                  : data.x
              })
          })
        }
      })
      return dataSerie
    },
    renderChartBar () {
      const data = this.renderAxesSelected()
        .map((form) => {
          const dataSeries = form.aggregated
            .filter((aggregate) =>
              this.reportingChart.indicatorId.includes(aggregate.form_field.id)
            )
            .map((aggregate) => {
              return {
                name: aggregate.form_field.name,
                x: aggregate.value,
                y: [form.id]
              }
            })
          return dataSeries
        })
        .flatMap((formField) => formField)

      this.series = [...this.groupDataApex(data)]
      return this.series
    },
    renderChartLine () {
      const data = this.renderAxesSelected()
        .map((form) => {
          return form.completed_forms
            .map((completedForm) => {
              return completedForm.completed_form_fields
                .filter((completedFormField) => {
                  return this.reportingChart.indicatorId.includes(
                    completedFormField.form_field_id
                  )
                })
                .map((completedFormField) => {
                  return {
                    x: completedForm.last_update,
                    y: [completedFormField.value],
                    name: completedFormField.form_field.name
                  }
                })
            })
            .flatMap((completedFormField) => completedFormField)
        })
        .flatMap((form) => form)

      this.series = [...this.groupDataApex(data)]
    },
    renderChartDonut () {
      const donutLabel = []
      this.series = this.renderChartBar().map((data) => {
        donutLabel.push(data.name)
        return data.data[0]
      })

      this.options = { labels: [...donutLabel] }
    },
    selectedOperations (value) {
      this.reporting.operationId = value
    },
    renderChart () {
      if (this.typeChart === 'line') {
        this.renderChartLine()
      }
      if (this.typeChart === 'donut') {
        this.renderChartDonut()
      }
      if (this.typeChart === 'bar') {
        this.renderChartBar()
      }
    }
  },
  watch: {
    hospitalsDataAggregated () {
      this.renderChart()
    }
  }
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.containerReporting {
  background-color: #f4f6fc;
  height: 100vh;
  overflow-y: scroll;
}
.bookmark {
  background-color: #f4f6fc;
  height: 540px;
}
.container-action {
  border-radius: 7px;
}
.btn-sidebar {
  display: none;
}
.btn-title[disabled="disabled"] {
  pointer-events: none;
  color: #bfcbd9;
  cursor: not-allowed;
  opacity: 0.3;
}
.header-responsive {
  display: flex;
}
@media (max-width: $max-width) {
  .btn-sidebar {
    display: block;
    top: 90%;
    left: 90%;
    position: fixed;
    z-index: 100;
  }
  .header-responsive {
    display: none;
  }
}
</style>
