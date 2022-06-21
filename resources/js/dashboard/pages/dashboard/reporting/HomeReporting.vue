<template>
  <b-container fluid class="px-0 mx-0 containerReporting h-100">
    <b-row class="mx-0 px-0 w-100" lg="12">
      <HeaderReporting
        :forms="forms"
        :hospitals="hospitals"
        @generatedReport="submitGeneratedReport"
        class="d-flex justify-content-center bg-white py-3 w-100"
      />
      <b-row>
        <div class="d-flex justify-content-between">
          <apexchart
            width="800"
            type="bar"
            :options="options"
            :series="series"
          ></apexchart>
        </div>
        <div class="d-flex"></div>
      </b-row>
    </b-row>
    <b-row> </b-row>
    <div>Bonjour</div>
    <div v-show="hospitalsDataAggregated">{{ hospitalsDataAggregated }}</div>
  </b-container>
</template>
<script>
import { mapState, mapActions } from 'vuex'
import VueApexCharts from 'vue-apexcharts'
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
      series: []
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
        state.hospital.hospitalsDataAggregated
    }),
    renderChart () {
      return this.completedFormsAggregated
    }
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
    }
  },
  watch: {
    hospitalsDataAggregated () {
      const categories = []
      const dataSerie = []
      const series = this.hospitalsDataAggregated
        .filter((hospital) => {
          return this.reportingChart.hospitalId.includes(hospital.id)
        })
        .map((form) => {
          categories.push(form.name.replace(/ /g, ""))
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
    }
  }
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.containerReporting {
  background-color: #f4f6fc;
}
</style>
