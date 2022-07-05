<template>
  <b-row>
  <b-col lg="3" class="bg-white">
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
        <label for class="text-dash-color">Lignes :</label>
        <v-select
          :options="axes"
          :reduce="(item) => item.id"
          label="name"
          @input="selectedAxes"
          placeholder="Sélectionner un axe"
          class="style-chooser"
      /></b-col>
      <b-col v-if="!isLoading" class="w-100 mt-4 mx-1 py-1 container-axe" lg="11" >
          <div
            v-for="(axe, index) in cloneOptionsAxes"
            :key="index"
            class="mt-2 mr-1 container-axe-child"
          >
            <b-badge class="p-2">{{ axe.name }}<i class="fas fa-times-circle close-icon-list fa-xs"  aria-hidden="true" @click="deleteItemAxe(axe.id)"></i></b-badge>
          </div>
      </b-col>
      <b-col v-if="!isLoading" class="mt-2" lg="12">
        <b-button
        type="submit"
        class="btn-sm"
        variant="outline-secondary"
        @click="openModalList()"
        >
        <small>Ajouter</small>
        </b-button>
      </b-col>
      <skeleton-loading v-else class="w-100 mt-3">
              <square-skeleton
                :boxProperties="{
                  width: '100%',
                  height: '150px',
                }"
              ></square-skeleton>
      </skeleton-loading>
      <b-col class="mx-0 w-100 mt-4" lg="12">
        <label for class="text-dash-color">colonnes :</label>
      </b-col>
      <b-col  class="w-100  mx-1 py-1 container-axe" lg="11">
        <div
          v-for="(formField, index) in cloneOptionQuestions"
          :key="index"
          class="mt-2 mr-1 w-100"
        >
          <b-badge class="p-2 w-100 d-flex justify-content-between"><span class="text-question"> {{ formField.name}}</span><i class="fas fa-times-circle close-icon-list fa-xs"  aria-hidden="true" @click="deleteItemAxe(formField.id)"></i></b-badge>
        </div>
      </b-col>
      <b-col v-if="!isLoading" class="mt-2" lg="12">
        <b-button
        type="submit"
        class="btn-sm"
        variant="outline-secondary"
        @click="openModalListField()"
        >
        <small>Ajouter</small>
        </b-button>
      </b-col>
      <skeleton-loading v-else class="w-100 mt-3">
              <square-skeleton
                :boxProperties="{
                  width: '100%',
                  height: '150px',
                }"
              ></square-skeleton>
      </skeleton-loading>
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
        <b-button type="submit" class="btn-dash-blue w-100 mr-3" @click="generated"
          ><small>Générer le tableau pivot </small>
        </b-button>
        <b-button type="submit" class="btn-dash-blue w-100"
          ><small>Sauvegarder </small>
        </b-button>
      </b-col>
      <AxeModal
      :optionsAxes="optionsAxes"
      :cloneOptionsAxes="cloneOptionsAxes"
      :modalShow="modalShow"
      @closedModal="closeModalAxe"
      @arraySelectedOptionAxe="arraySelectedOptionAxe"
      />
      <AxeModal
      :optionsAxes="formFields"
      :cloneOptionsAxes="cloneOptionQuestions"
      :modalShow="modalQuestion"
      @closedModal="closeModalField"
      @arraySelectedOptionAxe="arraySelectedOptionQuestion"
      />
    </b-row>
  </b-col>
  <b-col lg="9" v-if="showDisplayArray">
    <ArrayPivot
    :cloneOptionsAxes="cloneOptionsAxes"
    :cloneOptionQuestions="cloneOptionQuestions"
    :completedFormFields="hospitalsDataAggregated"
    />
     <b-button
      type="submit"
      class="btn-dash-blue btn-generated-rapport"
      @click="displayChart"
      >
        <small>générer le graphique </small>
       </b-button>
  </b-col>
  <b-col lg="9" v-if="showChartJs">
      <ChartReporting
        :typeChart="typeChartReporting"
        :cloneOptionsAxes="cloneOptionsAxes"
        :cloneOptionQuestions="cloneOptionQuestions"
        :completedFormFields="hospitalsDataAggregated"
      />
      <b-button
      type="submit"
      class="btn-dash-blue btn-generated-rapport"
      @click="displayArrayPivot"
      >
    <small>retour sur le tableau pivot</small>
    </b-button>
  </b-col>
  </b-row>
</template>
<script>
import AxeModal from './AxeModal.vue'
import ArrayPivot from './ArrayPivot.vue'
import ChartReporting from './ChartReporting.vue'
import { mapState, mapActions } from 'vuex'

export default {
  name: 'HeaderReporting',
  components: {
    AxeModal,
    ArrayPivot,
    ChartReporting
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
      showChartJs: false,
      typeChartReporting: '',
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
      cloneOptionsAxes: [],
      cloneOptionQuestions: [],
      completedFormFields: [],
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
      formFields: (state) => state.formField.formFields,
      hospitalsDataAggregated: (state) => state.hospital.hospitalsDataAggregated
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
    ...mapActions(['getFormFields', 'hospitals__townships', 'townships__getAll', 'hospital__getAll', 'getHospitalsData']),
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
      this.cloneOptionsAxes = this.cloneOptionsAxes.filter((axe) => axe.id !== index)
      this.cloneOptionQuestions = this.cloneOptionQuestions.filter((field) => field.id !== index)
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
  .container-axe-child{
    display:inline-block;
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
.close-icon-list{
  font-size: 18px;
  color:white;
  position: relative;
  top: 4px;
  left:4px;
  cursor: pointer;
}
.text-question{
  max-width: calc(100% - 18px);
  text-overflow: ellipsis;
  display: inline-block;
  overflow: hidden;
}
.btn-generated-rapport{
  position:relative;
  left: 660px;
}
</style>
