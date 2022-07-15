<template>
  <b-row>
    <b-col lg="3" class="bg-white pb-5">
      <b-row class="mx-0 h-100 w-100" lg="12">
        <b-col class="mx-0 w-100 mt-4" lg="12">
          <h3>Générateur de graphique</h3>
        </b-col>
        <b-col class="mx-0 w-100 mt-4 mb-4" lg="12">
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
        <hr />
        <b-col class="border-dash rounded pb-4" lg="12">
          <b-row>
            <b-col class="mx-0 w-100 mt-4" lg="12"> </b-col>
            <Questions
              v-model="linesSelected"
              title="Lignes"
              :cloneOptionQuestions="cloneOptionQuestions"
              :except="columnsSelected"
              :isDataSourceSelected='isDataSourceSelected'
              placeholder="Rechercher par Ligne"
              @selectedForm="selectedForm"
            />
            <br />
            <hr />
            <Questions
              v-model="columnsSelected"
              title="Colonnes"
              :cloneOptionQuestions="cloneOptionQuestions"
              :except="linesSelected"
              :isDataSourceSelected='isDataSourceSelected'
               placeholder="Rechercher par Colonne"
              @selectedForm="selectedForm"
            />
          </b-row>
        </b-col>
      </b-row>
    </b-col>
    <b-col lg="9" v-if="showDisplayArray">
       <skeleton-loading v-if="isLoading" class="w-100">
            <square-skeleton
              :boxProperties="{
                width: '100%',
                height: '750px',
              }"
            ></square-skeleton>
          </skeleton-loading>
         
      <vue-pivottable-ui
            :data="arrayAxeValue"
            :rows="linesSelected.map(line=>line.name)"
            :cols="columnsSelected.map(column=>column.name)"
            v-else
          >
        </vue-pivottable-ui>

    </b-col>
  </b-row>
</template>
<script>

import { mapState, mapActions } from 'vuex'
import Questions from './Questions'
import { VuePivottableUi } from 'vue-pivottable'
import 'vue-pivottable/dist/vue-pivottable.css'

export default {
  name: 'HeaderReporting',
  components: {
    Questions,
    VuePivottableUi
  },
  props: {
    forms: {
      type: Array,
      default: () => {
        return []
      }
    },
    hospitals: {
      type: Array,
      default: () => {
        return []
      }
    }
  },
  data () {
    return {
      arrayAxeValue: [],
      chartType: [
        {
          id: 'line',
          type: 'Courbe',
          icon: 'fas fa-chart-line'
        },
        { id: 'bar', type: 'Barres', icon: 'fas fa-chart-bar' },
        { id: 'donut', type: 'Secteur', icon: 'fas fa-chart-pie' }
      ],
      axes: [
        { id: 'township', name: 'Commune' },
        { id: 'hospital', name: 'Hôpital' }
      ],
      mode: 'date',
      isRanged: false,
      isLoading: false,
      modalShow: false,
      modalQuestion: false,
      showDisplayArray: true,
      isDataSourceSelected: false,
      showChartJs: false,
      typeChartReporting: '',
      status: false,
      title: '',
      filterQuestionTitle: '',
      dateRange: this.isRanged
        ? {
            start: new Date(),
            end: new Date()
          }
        : new Date(),
      reporting: {
        formId: null,
        axeId: [],
        axeIdType: '',
        indicatorId: [],
        operationId: null,
        observation_start: null,
        observation_end: null
      },
      optionsAxes: [],
      lineQuestions: [],
      columnQuestions: [],
      cloneOptionsAxes: [],
      cloneOptionQuestions: [],
      completedFormFields: [],
      iconStateDatePicker: 'fas fa-thin fa-plus',
      attributes: [],
      operations: [
        { id: 1, type: 'Somme' },
        { id: 2, type: 'Moyenne' }
      ],
      linesSelected: [],
      columnsSelected: []
    }
  },
  computed: {
    ...mapState({
      formFields: (state) => state.formField.formFields,
      hospitalsDataAggregated: (state) =>
        state.hospital.hospitalsDataAggregated,
      completedFormAll: (state) => state.completedForm.completedFormAll
    })
  },
  mounted () {},
  watch: {
    optionsAxesSelected () {},
    formFields () {
      this.cloneOptionQuestions = this.formFields.slice()
    }
  },
  methods: {
    ...mapActions([
      'getFormFields',
      'hospitals__townships',
      'townships__getAll',
      'hospital__getAll',
      'getHospitalsData',
      'completedForm__getAll'
    ]),
    activeStartDate () {
      this.isRanged = !this.isRanged
      this.mode = this.mode === 'date' ? 'range' : 'date'
      this.iconStateDatePicker =
        this.iconStateDatePicker === 'fas fa-thin fa-plus'
          ? 'fa fa-times'
          : 'fas fa-thin fa-plus'

      if (this.isRanged) {
        this.dateRange.start =
          this.reporting.observation_end == null
            ? new Date()
            : this.reporting.observation_end
        this.dateRange.end = new Date()

        this.reporting.observation_start = this.dateRange.start
        this.reporting.observation_end = new Date()
      } else {
        this.dateRange =
          this.reporting.observation_end == null
            ? new Date()
            : this.reporting.observation_end
        this.reporting.observation_start = null
      }
      this.attributes[0] = {
        key: 'today',
        dates: this.isRanged
          ? { start: this.dateRange.start, end: this.dateRange.end }
          : this.dateRange,
        highlight: true
      }
    },
    getComlpletedFormAll () {
      this.arrayAxeValue = this.completedFormAll.map((completedForm) => {
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
    },
    onRangeDateObservation (inputValueDate) {
      if (this.isRanged) {
        this.reporting.observation_start = moment(inputValueDate.start).format(
          'YYYY-MM-DD'
        )
        this.dateRange.start = inputValueDate.start
        this.reporting.observation_end = moment(inputValueDate.end).format(
          'YYYY-MM-DD'
        )
        this.dateRange.end = inputValueDate.end
      } else {
        this.reporting.observation_start = null
        this.dateRange = inputValueDate
        this.reporting.observation_end =
          moment(inputValueDate).format('YYYY-MM-DD')
      }
      this.attributes[0] = {
        key: 'today',
        dates: this.dateRange,
        highlight: true
      }
      console.log('dateRange', this.dateRange)
    },
    clearObservationDate () {
      this.dateRange = new Date()
      this.isRanged = false
    },
    async selectedForm (value) {
      this.isLoading = true
      const formId = { form_id: value }
      this.getFormFields(formId)
      this.isDataSourceSelected = true
      await this.completedForm__getAll(formId)
      this.getComlpletedFormAll()
      this.isLoading = false
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
    selectedIndicators (value) {
      this.reporting.indicatorId = value
    },
    selectedOperations (value) {
      this.reporting.operationId = value
    },
    selectedChartType (value) {
      this.typeChartReporting = value.type
    },
    async generated () {
      this.completedFormFields = await this.getHospitalsData({
        form_id: this.reporting.formId
      })
    },
    submit () {
      if (!this.reporting.observation_end) {
        this.reporting.observation_end = new Date()
      }
      this.$emit('generatedReport', this.reporting)
    },
    deleteItemAxe (index) {
      this.cloneOptionsAxes = this.cloneOptionsAxes.filter(
        (axe) => axe.id !== index
      )
      this.cloneOptionQuestions = this.cloneOptionQuestions.filter(
        (field) => field.id !== index
      )
    },
    openModalList () {
      this.modalShow = !this.modalShow
    },
    openModalListField () {
      this.modalQuestion = !this.modalQuestion
    },
    closeModalAxe () {
      this.modalShow = false
    },
    closeModalField () {
      this.modalQuestion = false
    },
    arraySelectedOptionAxe (value) {
      this.cloneOptionsAxes = value
    },
    arraySelectedOptionQuestion (value) {
      this.cloneOptionQuestions = value
    },
    displayChart () {
      this.showChartJs = true
      this.showDisplayArray = false
    },
    displayArrayPivot () {
      this.showChartJs = false
      this.showDisplayArray = true
    }
  }
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";

.container-axe {
  height: 100px;
  border: 1px solid #bfcbd9;
  overflow-y: scroll;
  overflow-x: hidden;
  border-radius: 5px 5px 0px 0px;
  &::-webkit-scrollbar {
    width: 0;
    background: transparent;
  }
  .container-axe-child {
    display: inline-block;
    width: auto;
  }
}
.style-chooser {
  width: 100%;
  height: auto !important;
}
.vs__dropdown-toggle {
  border-color: #c2cef5 !important;
}
.btn-clear-observation {
  height: 32px;
  margin-left: 5px;
  display: flex;
  align-items: center;
}

.btn-range-date {
  font-size: 16px;
  padding: 5px;
  text-align: center;
  width: 45%;
  border-radius: 5px;
  border: 1px solid #c3c8ced2;
}
.btn-calendar {
  font-size: 16px;
  padding-right: 10px;
}
.btn-container-calendar {
  border-radius: 5px;
  border: 1px solid #c3c8ced2;
  width: 100%;
  align-items: center;
  background-color: #f4f5fc;

  input {
    border: none !important;
    width: 100%;
    height: 100%;
    font-size: 14px;
    &:focus {
      border: none !important;
      outline: none !important;
    }
  }
  label {
    width: 15%;
    align-self: center;
    align-items: center;
    text-align: center;
  }
  &:hover {
    cursor: pointer;
  }
}
.style-picker {
  width: 80%;
}

.style-chooser[disabled="disabled"] {
  pointer-events: none;
  color: #bfcbd9;
  cursor: not-allowed;
  background-image: none;
  background-color: #eef1f6;
  border-color: #d1dbe5;
}
.close-icon-list {
  font-size: 18px;
  color: white;
  position: relative;
  top: 4px;
  left: 4px;
  cursor: pointer;
}
.text-question {
  max-width: calc(100% - 18px);
  text-overflow: ellipsis;
  display: inline-block;
  overflow: hidden;
}
.btn-generated-rapport {
  position: relative;
  left: 660px;
}
</style>
