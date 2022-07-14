<template>
  <div>
  <b-container class="justify-content-center">
      <!-- <b-row class="content-filter">
        <b-col>
          <DataSourceReporting
          :forms="forms"
          @getPivotTable="getPivotTable"
          />
        </b-col>
      </b-row> -->
      <b-row>
        <b-col>
          <vue-pivottable-ui
            :data="ArrayAxeValue"
            :rows="['date']"
            :cols="['hopital']"
          >
          </vue-pivottable-ui>
        </b-col>
      </b-row>
      <!-- <b-row v-else>
        <b-col class="empty_array">
          <h1>Veuillez sélectionner les lignes et colonnes</h1>
        </b-col>
      </b-row> -->
  </b-container>
  </div>
</template>
<script>
import { mapState, mapActions } from 'vuex'
import { VuePivottableUi, PivotUtilities, Renderer } from 'vue-pivottable'
import 'vue-pivottable/dist/vue-pivottable.css'
// import DataSourceReporting from '../components/DataSourceReporting.vue'

export default {
  components: {
    VuePivottableUi
    // DataSourceReporting
  },
  data () {
    return {
      ArrayAxeValue: [],
      ArrayAxeLineValue: [],
      showArrayPivot: [],
      aggregatorName: 'Sum'
    }
  },
  async mounted () {
    await this.getCompletedFormAll({
      form_id: 10
    })
    this.getForms()
    this.getComlpletedFormAll()
  },
  computed: {
    ...mapState({
      forms: (state) => state.form.forms,
      hospitalsDataAggregated: (state) => state.hospital.hospitalsDataAggregated,
      townshipsCompletedForm: (state) => state.township.townshipsCompletedForm,
      completedFormAll: (state) => state.completedForm.completedFormAll
    })
  },
  methods: {
    ...mapActions(['getForms', 'getHospitalsData', 'getTownshipData', 'getCompletedFormAll']),
    getComlpletedFormAll () {
      this.ArrayAxeValue = this.completedFormAll.map((completedForm) => {
        const data = {
          hopital: completedForm.hospital.name,
          commune: completedForm.hospital.township.name,
          date: completedForm.last_update
        }
        completedForm.completed_form_fields.forEach(completedFormField => {
          data[completedFormField.form_field.name] = completedFormField.value
        })
        return data
      })
    }
    // async getPivotTable (value) {
    //   console.log('valueform', value.formId)
    //   this.showArrayPivot = value.cloneOptionsAxes
    //   await this.getHospitalsData({
    //     form_id: value.formId
    //   })
    //   await this.getTownshipData({
    //     form_id: value.formId
    //   })
    //   if (value.axeId === 'hospital') {
    //     this.ArrayAxeValue = value.cloneOptionsAxes.map((axe) => {
    //       return value.cloneOptionQuestions.map((question) => {
    //         const hospitals = this.hospitalsDataAggregated.find((hospital) => hospital.id === axe.id)
    //         if (hospitals) {
    //           const completedFormField = hospitals.aggregated.find((hospital) => hospital.form_field.id === question.id)
    //           const lastUpdateHospital = hospitals.completed_forms.find((completedForm) => completedForm.completed_form_fields.find((data) => data.form_field.id === completedFormField.form_field.id))
    //           return {
    //             axe: axe.name,
    //             question: question.name,
    //             value: completedFormField?.value || 0,
    //             date: lastUpdateHospital?.last_update || ''
    //           }
    //         } else {
    //           return {
    //             axe: axe.name,
    //             question: question.name,
    //             value: 0,
    //             date: ''
    //           }
    //         }
    //       })
    //     })
    //   }
    //   if (value.axeId === 'township') {
    //     this.ArrayAxeValue = value.cloneOptionsAxes.map((axe) => {
    //       return value.cloneOptionQuestions.map((question) => {
    //         let lastUpdateTownship = []
    //         const townships = this.townshipsCompletedForm.find((township) => township.id === axe.id)
    //         if (townships) {
    //           const completedFormField = townships.aggregated.find((township) => township.form_field.id === question.id)
    //           for (const key in townships.completedForms) {
    //             lastUpdateTownship = [key]
    //           }
    //           return {
    //             axe: axe.name,
    //             question: question.name,
    //             value: completedFormField?.value || 0,
    //             date: lastUpdateTownship
    //           }
    //         } else {
    //           return {
    //             axe: axe.name,
    //             question: question.name,
    //             value: 0,
    //             date: ''
    //           }
    //         }
    //       })
    //     })
    //   }

    //   this.ArrayAxeValue = this.ArrayAxeValue.flatMap((value) => value)
    // }
  }
}
</script>
<style lang="scss" scoped>
  .empty_array{
    position:relative;
    left: 100px;
    top: 150px;
  }
</style>
