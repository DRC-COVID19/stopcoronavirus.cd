<template>
  <div>
    <b-row>
      <b-col>
        <DataSourceReporting
        :forms="forms"
        @getPivotTable="getPivotTable"
        />
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <vue-pivottable-ui
          :data="ArrayAxeValue"
          :rows="['hospital']"
          :cols="['question']"
        >
        </vue-pivottable-ui>
      </b-col>
    </b-row>
  </div>
</template>
<script>
import { mapState, mapActions } from 'vuex'
import { VuePivottableUi } from 'vue-pivottable'
import 'vue-pivottable/dist/vue-pivottable.css'
import DataSourceReporting from '../components/DataSourceReporting.vue'
export default {
  components: {
    VuePivottableUi,
    DataSourceReporting
  },
  data () {
    return {
      ArrayAxeValue: []
    }
  },
  mounted () {
    this.getForms()
  },
  computed: {
    ...mapState({
      forms: (state) => state.form.forms,
      hospitalsDataAggregated: (state) => state.hospital.hospitalsDataAggregated
    })
  },
  methods: {
    ...mapActions(['getForms', 'getHospitalsData']),
    async getPivotTable (value) {
      await this.getHospitalsData({
        form_id: value.formId
      })
      this.ArrayAxeValue = value.cloneOptionsAxes.map((axe) => {
        return value.cloneOptionQuestions.map((question) => {
          const hospitals = this.hospitalsDataAggregated.find((hospital) => hospital.id === axe.id)
          if (hospitals) {
            const completedFormField = hospitals.aggregated.find((question) => question.form_field.id === question.id)
            console.log('hospitals', hospitals, 'completedFormField', completedFormField)
            return {
              hospital: axe.name,
              question: question.name,
              value: completedFormField?.value || 0
            }
          } else {
            return {
              hospital: axe.name,
              question: question.name,
              value: 1
            }
          }
        })
      })

       this.ArrayAxeValue = this.ArrayAxeValue.flatMap((value) => value)

      // return [...this.ArrayAxeValue]
    }

  }
}
</script>
