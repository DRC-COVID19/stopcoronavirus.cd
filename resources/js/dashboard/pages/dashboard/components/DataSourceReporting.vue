<template>
  <div>
      <b-row class="mt-2">
        <b-col lg="4" class="mt-1">
          <v-select
            v-model="reporting.formId"
            :options="forms"
            :reduce="(item) => item.id"
            label="title"
            placeholder="Sélectionner les colonnes"
            class="style-chooser ml-2"
            @input="selectedForm"
          />
        </b-col>
        <b-col lg="4" class="mt-1">
          <v-select
            v-model="reporting.axeId"
            :options="axes"
            :reduce="(item) => item.id"
            label="name"
            @input="selectedAxes"
            placeholder="Sélectionner les lignes"
            class="style-chooser"
          />
        </b-col>
        <b-col lg="4">
          <b-button
          type="submit"
          class="btn-dash-blue p-1"
          :disabled="reporting.axeId?false:true"
          @click="buildPivotTable"
          >
            <small>générer le tableau Pivot</small>
          </b-button>
        </b-col>
      </b-row>
  </div>
</template>
<script>
import { mapState, mapActions } from 'vuex'
export default {
  props: {
    forms: {
      type: Array,
      default: () => {
        return []
      }
    }
  },
  data () {
    return {
      reporting: {
        formId: null,
        axeId: null
      },
      optionsAxes: [],
      cloneOptionsAxes: [],
      cloneOptionQuestions: [],
      axes: [
        { id: 'township', name: 'Commune' },
        { id: 'hospital', name: 'Hôpital' }
      ]
    }
  },
  computed: {
    ...mapState({
      formFields: (state) => state.formField.formFields
    })
  },
  watch: {
    formFields () {
      this.cloneOptionQuestions = this.formFields.slice()
    }
  },
  methods: {
    ...mapActions(['getFormFields', 'townships__getAll', 'hospital__getAll', 'getHospitalsData']),
    selectedForm (value) {
      this.getFormFields({ form_id: value })
    },
    selectedAxes (value) {
      this.optionsAxes = []
      if (value === 'township') {
        this.isLoading = true
        this.townships__getAll().then((data) => {
          this.optionsAxes = data.map((commune) => {
            return { id: commune.id, name: commune.name }
          })
          this.cloneOptionsAxes = this.optionsAxes.slice()
          this.isLoading = false
        })
      }
      if (value === 'hospital') {
        this.isLoading = true
        this.hospital__getAll().then((data) => {
          this.optionsAxes = data.map((hospital) => {
            return { id: hospital.id, name: hospital.name }
          })
          this.cloneOptionsAxes = this.optionsAxes.slice()
          this.isLoading = false
        })
      }
    },
    buildPivotTable () {
      this.$emit('getPivotTable', { cloneOptionsAxes: this.cloneOptionsAxes, cloneOptionQuestions: this.cloneOptionQuestions, formId: this.reporting.formId, axeId: this.reporting.axeId })
    }
  }
}
</script>
<style lang="scss" scoped>
  
</style>
