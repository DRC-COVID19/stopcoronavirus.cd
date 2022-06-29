<template>
  <b-row class="mx-0 h-100 w-100" lg="12">
    <b-col class="mx-0 w-100 mt-4" lg="12">
      <h3>Générateur de graphique</h3>
    </b-col>

    <b-col class="mx-0 w-100 mt-4" lg="12">
      <label for class="text-dash-color">Type de graphique :</label>

      <v-select
        :options="chartType"
        label="type"
        class="style-chooser"
        @input="selectedChartType"
      >
        <template #option="{ type, icon }">
          <div class="d-flex justify-content-between text-align-center w-100">
            <p>{{ type }}</p>
            <p>
              <i :class="icon" style="font-size: 18px" aria-hidden="true"></i>
            </p>
          </div>
        </template> </v-select
    ></b-col>
    <b-col class="mx-0 w-100 mt-4" lg="12">
      <label for class="text-dash-color">Source des données :</label>
      <v-select
        v-model="reporting.formId"
        :options="forms"
        :reduce="(item) => item.id"
        label="title"
        placeholder="Sélectionner une source des données"
        class="style-chooser"
        @input="selectedForm"
    /></b-col>
    <b-col class="mx-0 w-100 mt-4" lg="12">
      <label for class="text-dash-color">Axes :</label>
      <v-select
        :options="axes"
        :reduce="(item) => item.id"
        label="name"
        @input="selectedAxes"
        placeholder="Sélectionner un axe"
        class="style-chooser"
    /></b-col>
    <b-col class="w-100 mt-4 mx-1 py-1 container-axe" lg="11">
      <div
        v-for="(axe, index) in reporting.axeId"
        :key="index"
        class="mt-2 mr-1 w-100"
      >
        <b-badge>{{ axe.name }}</b-badge>
      </div>
    </b-col>
    <b-col class="mx-0 w-100 mt-4" lg="12">
      <label for class="text-dash-color">Valeur :</label>
      <v-select
        v-model="reporting.indicatorId"
        :options="formFields"
        :reduce="(item) => item.id"
        label="name"
        placeholder="Sélectionner une valeur"
        class="style-chooser"
        @input="selectedIndicators"
        multiple
        :disabled="formFields.length === 0"
    /></b-col>
    <b-col class="w-100 mt-4 mx-1 py-1 container-axe" lg="11">
      <div
        v-for="(indicatorId, index) in indicators"
        :key="index"
        class="mt-2 mr-1 w-100"
      >
        <b-badge>{{ indicatorId.name }}</b-badge>
      </div>
    </b-col>
    <b-col lg="12" class="mx-0 w-100 mt-4">
      <label for class="text-dash-color">Date :</label>
      <div class="w-100 d-flex justify-content-between">
        <v-date-picker
          v-model="dateRange"
          opens="center"
          :max-date="new Date()"
          class="d-flex style-picker"
          :mode="mode"
          :is-range="isRanged"
          @input="onRangeDateObservation"
          show-weeknumbers
          :is-expanded="true"
          :attributes="attributes"
          popover.keepVisibleOnInput
        >
          <template v-slot="{ inputEvents }">
            <div
              class="
                w-100
                d-flex
                flex-col
                sm:flex-row
                justify-content-center
                text-center
                item-center
                btn-container-calendar
              "
            >
              <i for="range" class="fas fa-light fa-calendar p-2"></i>
              <input
                id="range"
                class="p-1 w-full"
                :value="
                  isRanged
                    ? `${moment(dateRange.start).format(
                        'YYYY/MM/DD'
                      )}- ${moment(dateRange.end).format('YYYY/MM/DD')}`
                    : moment(dateRange).format('YYYY/MM/DD')
                "
                v-on="isRanged ? inputEvents.end : inputEvents"
                readonly
              />
            </div>
          </template>
          <div
            slot="footer"
            slot-scope=""
            class="d-flex justify-content-between ml-2 mr-2 mb-2 mt-n2"
            style="width: 330px"
          >
            <span
              class="btn-range-date"
              @click="activeStartDate"
              style="cursor: pointer"
              >{{
                isRanged
                  ? moment(dateRange.start).format("YYYY/MM/DD")
                  : "Date début"
              }}<i :class="iconStateDatePicker" class="ml-1"></i>
            </span>
            <span class="btn-range-date">{{
              isRanged
                ? moment(dateRange.end).format("YYYY/MM/DD")
                : moment(dateRange).format("YYYY/MM/DD")
            }}</span>
          </div>
        </v-date-picker>
        <b-button
          @click="clearObservationDate"
          class="btn-clear-observation btn-dash-blue"
        >
          <span class="fa fa-times"></span>
        </b-button>
      </div>
    </b-col>
    <b-col class="d-flex mx-0 w-100 align-item-center text-center mt-4" lg="12">
      <b-button type="submit" class="btn-dash-blue w-100 mr-3" @click="submit"
        ><small>Générer </small>
      </b-button>
      <b-button type="submit" class="btn-dash-blue w-100"
        ><small>Sauvegarder </small>
      </b-button>
    </b-col>
    <b-modal centered ref="my-modal-axes" hide-header hide-footer>
      <b-row class="mx-0 w-100">
        <b-col lg="12" class="justify-content-center">
          <div class="cols-12">
            <h4 class="mt-2">Choisir un ou plusieurs axe (s)</h4>
          </div>
          <b-form-group>
            <template #label>
              <h5 class="mt-4">
                <b-form-checkbox
                  v-model="selectedAll"
                  aria-describedby="optionsAxesSelected"
                  aria-controls="optionsAxesSelected"
                  value-field="id"
                  @change="selectedAllAxesOption"
                >
                  Tous sélectionnés
                </b-form-checkbox>
              </h5>
            </template>

            <template v-slot="{ ariaDescribedby }">
              <div>
                <b-form-checkbox-group
                  id="reportingAxeId"
                  v-model="optionsAxesSelected"
                  :options="optionsAxes"
                  text-field="name"
                  :aria-describedby="ariaDescribedby"
                  value-field="id"
                  name="reportingAxeId"
                  class="mt-2"
                  stacked
                ></b-form-checkbox-group>
              </div>
            </template>
          </b-form-group>
        </b-col>
      </b-row>

      <b-row class="px-3 pt-4 d-flex justify-content-center">
        <b-button
          size="sm"
          variant="success"
          @click="selectedAxesModal"
          class="btn-dash-blue mx-2"
        >
          Accepter
        </b-button>
        <b-button size="sm" variant="danger" @click="hideModal" class="mx-2">
          Annuler
        </b-button>
      </b-row>
    </b-modal>
  </b-row>
</template>
<script>
import { mapState, mapActions } from 'vuex'

export default {
  name: 'HeaderReporting',
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
      indicators: [],
      mode: 'date',
      isRanged: false,
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
      selectedAll: false,
      optionsAxesSelected: [],
      iconStateDatePicker: 'fas fa-thin fa-plus',
      attributes: [],
      operations: [
        { id: 1, type: 'Somme' },
        { id: 2, type: 'Moyenne' }
      ]
    }
  },
  computed: {
    ...mapState({
      formFields: (state) => state.formField.formFields
    })
  },
  mounted () {},
  watch: {
    optionsAxesSelected () {}
  },
  methods: {
    ...mapActions(['getFormFields', 'hospitals__townships']),
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
    selectedForm (value) {
      this.getFormFields({ form_id: value })
      console.log('value ->', value)
    },
    selectedAxes (value) {
      this.optionsAxes = []
      this.hospitals__townships().then((data) => {
        if (value === 'township') {
          this.optionsAxes = data.map((hospital) => {
            return { id: hospital.township.id, name: hospital.township.name }
          })
          this.$refs['my-modal-axes'].show()
        }
        if (value === 'hospital') {
          this.optionsAxes = data.map((hospital) => {
            return { id: hospital.id, name: hospital.name }
          })
          this.$refs['my-modal-axes'].show()
        }
        if (value) {
          this.$refs['my-modal-axes'].show()
          this.reporting.axeIdType = value
          // this.selectedAllAxesOption(true)
        }
      })
      console.log('value ->', value)
    },
    selectedIndicators (value) {
      this.reporting.indicatorId = value
      this.indicators = this.formFields.filter((formField) => value.includes(formField.id))
      console.log('value ->', this.reporting.indicatorId)
    },
    selectedOperations (value) {
      this.reporting.operationId = value
    },
    selectedChartType (value) {
      this.$emit('selectedChartType', value)
    },
    hideModal () {
      this.$refs['my-modal-axes'].hide()
    },
    selectedAllAxesOption (checked) {
      console.log('checked ->', checked)
      this.optionsAxesSelected = checked
        ? this.optionsAxes.slice().map((axe) => axe.id)
        : []
      console.log('checked ->', this.optionsAxesSelected)
    },
    selectedAxesModal () {
      this.reporting.axeId = this.optionsAxes
        .slice()
        .filter((axe) => this.optionsAxesSelected.includes(axe.id))
      this.$refs['my-modal-axes'].hide()
    },
    submit () {
      if (!this.reporting.observation_end) {
        this.reporting.observation_end = new Date()
      }
      this.$emit('generatedReport', this.reporting)
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
  border-radius: 5px;
  &::-webkit-scrollbar {
    width: 0;
    background: transparent;
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
</style>
