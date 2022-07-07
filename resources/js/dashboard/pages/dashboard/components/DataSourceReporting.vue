<template>
  <div>
      <b-row>
        <b-col lg="6">
          <label for class="text-dash-color">Source des données :</label>
          <v-select
            v-model="reporting.formId"
            :options="forms"
            :reduce="(item) => item.id"
            label="title"
            placeholder="Sélectionner une source des données"
            class="style-chooser"
            @input="selectedForm"
          />
        </b-col>
        <b-col lg="6">
          <v-select
            :options="axes"
            :reduce="(item) => item.id"
            label="name"
            @input="selectedAxes"
            placeholder="Sélectionner un axe"
            class="style-chooser"
          />
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
        formId: null
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
  methods: {
    ...mapActions(['getFormFields', 'hospitals__townships', 'townships__getAll', 'hospital__getAll', 'getHospitalsData']),
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
    }
  }
}
</script>
