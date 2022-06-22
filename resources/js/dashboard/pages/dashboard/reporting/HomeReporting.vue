<template>
  <b-container fluid class="px-0 mx-0 containerReporting h-100">
    <b-row class="mx-0 px-0 w-100" lg="12">
      <HeaderReporting
        :forms="forms"
        :hospitals="hospitals"
        @generatedReport="submitGeneratedReport"
        class="d-flex justify-content-center bg-white py-3 w-100"
      />
    </b-row>
    <b-row no-gutters class="mt-5">
      <b-col cols="6" md="6" class="row no-gutters">
        <div v-if="!isHospitalsDataAggregated" class="w-100 bg-white">
          <apexchart
            width="100%"
            type="bar"
            :options="options"
            :series="series"
          ></apexchart>
        </div>
        <skeleton-loading v-else lg="12" class="w-100">
          <square-skeleton
            :boxProperties="{
              width: '100%',
              height: '540px',
            }"
          ></square-skeleton>
        </skeleton-loading>
      </b-col>
      <b-col
        class="d-flex w-100 h-100 justify-content-center mx-2 container-action"
        lg="4"
      >
        <b-row no-gutters class="w-100">
          <b-col lg="12" class="w-100 px-3 mb-4 py-3 bg-white">
            <label for class="text-dash-color">Opération :</label>
            <v-select
              v-model="operationId"
              :options="operations"
              :reduce="(item) => item.id"
              label="type"
              placeholder="Choisir  une opération"
              class="style-chooser"
              @input="selectedOperations"
            />
          </b-col>
          <hr />
          <b-col lg="12" class="w-100">
            <b-button type="submit" block class="btn-dash-blue w-100"
              ><small>Sauvegarder </small>
            </b-button>
          </b-col>

          <b-col
            lg="12"
            class="w-100d-flex justify-content-center bg-white bookmark"
          >
          </b-col>
        </b-row>
      </b-col>
    </b-row>
    <b-row> </b-row>
  </b-container>
</template>
<script>
import { mapState, mapActions } from 'vuex'
import HeaderReporting from './components/HeaderReporting'
export default {
  name: 'Reporting',
  components: {
    HeaderReporting
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
      ]
    }
  },
  mounted () {
    this.getForms()
    this.hospital__getAll()
    console.log('forms ->', this.forms)
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
        }
      }
    },
    renderChart () {
      const categories = []
      const dataSerie = []
      const series = this.hospitalsDataAggregated
        .filter((hospital) => {
          return this.reportingChart.hospitalId.includes(hospital.id)
        })
        .map((form) => {
          categories.push(form.name.replace(/ /g, '').toUpperCase())
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
        .forEach((formField, index, arr) => {
          if (dataSerie.every((data) => data.name !== formField.name)) {
            dataSerie.push({
              name: formField.name,
              data: arr
                .filter((data) => data.name === formField.name)
                .map((data) => {
                  return data.x
                })
            })
          }
        })
      this.updateAxis(categories)

      this.series = [...dataSerie]

      console.log('series ->', this.series)
      console.log('this.options.xaxis.categories ->', categories)
    },
    selectedOperations (value) {
      this.reporting.operationId = value
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
}
.bookmark {
  background-color: #f4f6fc;
  height: 540px;
}
.container-action {
  border-radius: 7px;
}
</style>
