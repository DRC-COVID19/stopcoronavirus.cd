<template>
  <b-container fluid class="px-0 mx-0 containerReporting h-100">
    <b-row class="d-flex mx-0">
      <b-col lg="3" class="d-flex mx-0 px-0 bg-white py-3 w-100 h-100">
        <HeaderReporting
          :forms="forms"
          :hospitals="hospitals"
          @generatedReport="submitGeneratedReport"
          @selectedChartType="onSelectedChartType"
          class="w-100 h-100"
        />
      </b-col>

      <b-col
        class="d-flex w-100 h-100 justify-content-center container-action mx-0"
        lg="8"
      >
        <b-col lg="8" md="6" class="w-100 mx-0">
          <div v-if="!isHospitalsDataAggregated" class="w-100 bg-white">
            <ApexChart :type="typeChart" :options="options" :series="series" />
          </div>
          <skeleton-loading v-else class="w-100">
            <square-skeleton
              :boxProperties="{
                width: '100%',
                height: '540px',
              }"
            ></square-skeleton>
          </skeleton-loading>
        </b-col>
        <b-col
          lg="4"
          class="w-100 d-flex justify-content-center bg-white bookmark"
        >
        </b-col>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import { mapState, mapActions } from 'vuex'
import HeaderReporting from './components/HeaderReporting'
import ApexChart from './components/ApexChart'
export default {
  name: 'Reporting',
  components: {
    HeaderReporting,
    ApexChart
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
          }
        }
      },
      series: [],
      operationId: null,
      operations: [
        { id: 1, type: 'Somme' },
        { id: 2, type: 'Moyenne' }
      ],
      typeChart: ''
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
    submitGeneratedReport (reporting) {
      this.reportingChart = reporting
      this.getHospitalsData({
        form_id: reporting.formId,
        observation_start: reporting.observation_start,
        observation_end: reporting.observation_end
      })
    },
    updateAxis (data) {
      this.options = {
        ...this.options,
        xaxis: {
          categories: [...data]
        },
        title: {
          text: 'Forecast',
          align: 'left',
          style: {
            fontSize: '16px',
            color: '#666'
          }
        }
      }
    },
    onSelectedChartType (value) {
      this.typeChart = value.id
    },
    renderAxesSelected () {
      this.reportingChart.axeId = this.reportingChart.axeId.map(
        (axe) => axe.id
      )
      const categories = []
      const hospitalData = this.hospitalsDataAggregated
        .filter((hospital) => {
          return this.reportingChart.axeId.includes(
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
    selectedOperations (value) {
      this.reporting.operationId = value
    },
    renderChart () {
      if (this.typeChart === 'line') {
        this.renderChartLine()
      } else {
        this.renderChartBar()
      }
    }
  },
  watch: {
    hospitalsDataAggregated () {
      this.renderChart()
    }
    // typeChart () {
    //   this.renderChart()
    // }
  }
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.containerReporting {
  background-color: #f4f6fc;
  height: 100vh;
}
.bookmark {
  background-color: #f4f6fc;
  height: 540px;
}
.container-action {
  border-radius: 7px;
}
</style>
