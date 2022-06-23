<template>
  <b-row class="mx-0 h-100 w-100" lg="12">
    <b-col class="mx-0 w-100 mt-4" lg="12">
      <h3>
        <i class="fas fa-chart-line" aria-hidden="true"></i> &nbsp; Éditeur de
        graphique
      </h3>
    </b-col>

    <b-col class="mx-0 w-100 mt-4" lg="12">
      <label for class="text-dash-color">Type de graphique :</label>

      <v-select
        :options="chartType"
        :reduce="(item) => item.id"
        label="type"
        class="style-chooser"
      >
        <template #option="{ type, icon }">
          <div class="d-flex justify-content-between w-100">
            <p>{{ type }}</p>
            <p><i :class="icon" aria-hidden="true"></i></p>
          </div>
        </template> </v-select
    ></b-col>
    <b-col class="mx-0 w-100 mt-4" lg="12">
      <label for class="text-dash-color">Formulaire :</label>
      <v-select
        v-model="reporting.formId"
        :options="forms"
        :reduce="(item) => item.id"
        label="title"
        placeholder="Sélectionner un formulaire"
        class="style-chooser"
        @input="selectedForm"
    /></b-col>
    <b-col class="mx-0 w-100 mt-4" lg="12">
      <label for class="text-dash-color">Hôpitaux :</label>
      <v-select
        v-model="reporting.hospitalId"
        :options="hospitals"
        :reduce="(item) => item.id"
        label="name"
        @input="selectedHospitals"
        placeholder="Sélectionner des hôpitaux"
        class="style-chooser"
        multiple
        maxHeight="100%"
    /></b-col>
    <b-col class="mx-0 w-100 mt-4" lg="12">
      <label for class="text-dash-color">Indicateurs :</label>
      <v-select
        v-model="reporting.indicatorId"
        :options="formFields"
        :reduce="(item) => item.id"
        label="name"
        placeholder="Sélectionner des indicateurs"
        class="style-chooser"
        @input="selectedIndicators"
        multiple
        :disabled="formFields.length === 0"
    /></b-col>

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
      <b-button type="submit" class="btn-dash-blue w-100" @click="submit"
        ><small>Sauvegarder </small>
      </b-button>
    </b-col>
  </b-row>
</template>
<script>
import { mapState, mapActions } from "vuex";

export default {
  name: "HeaderReporting",
  props: {
    forms: {
      type: Array,
      default: () => {
        return [];
      },
    },
    hospitals: {
      type: Array,
      default: () => {
        return [];
      },
    },
  },
  data() {
    return {
      chartType: [
        {
          id: "",
          type: "Courbe",
          icon: "fas fa-chart-line",
        },
        {
          id: "",
          type: "Colonne",
          icon: "fas fa-chart-column",
        },
        { id: "", type: "Barres", icon: "fas fa-chart-bar" },
        { id: "", type: "Secteur", icon: "fas fa-chart-pie" },
      ],
      mode: "date",
      isRanged: false,
      dateRange: this.isRanged
        ? {
            start: new Date(),
            end: new Date(),
          }
        : new Date(),
      reporting: {
        formId: null,
        hospitalId: [],
        indicatorId: [],
        operationId: null,
        observation_start: null,
        observation_end: null,
      },
      iconStateDatePicker: "fas fa-thin fa-plus",
      attributes: [],
      operations: [
        { id: 1, type: "Somme" },
        { id: 2, type: "Moyenne" },
      ],
    };
  },
  computed: {
    ...mapState({
      formFields: (state) => state.formField.formFields,
    }),
  },
  watch: {},
  methods: {
    ...mapActions(["getFormFields"]),
    activeStartDate() {
      this.isRanged = !this.isRanged;
      this.mode = this.mode === "date" ? "range" : "date";
      this.iconStateDatePicker =
        this.iconStateDatePicker === "fas fa-thin fa-plus"
          ? "fa fa-times"
          : "fas fa-thin fa-plus";

      if (this.isRanged) {
        this.dateRange.start =
          this.reporting.observation_end == null
            ? new Date()
            : this.reporting.observation_end;
        this.dateRange.end = new Date();

        this.reporting.observation_start = this.dateRange.start;
        this.reporting.observation_end = new Date();
      } else {
        this.dateRange =
          this.reporting.observation_end == null
            ? new Date()
            : this.reporting.observation_end;
        this.reporting.observation_start = null;
      }
      this.attributes[0] = {
        key: "today",
        dates: this.isRanged
          ? { start: this.dateRange.start, end: this.dateRange.end }
          : this.dateRange,
        highlight: true,
      };
    },
    onRangeDateObservation(inputValueDate) {
      if (this.isRanged) {
        this.reporting.observation_start = moment(inputValueDate.start).format(
          "YYYY-MM-DD"
        );
        this.dateRange.start = inputValueDate.start;
        this.reporting.observation_end = moment(inputValueDate.end).format(
          "YYYY-MM-DD"
        );
        this.dateRange.end = inputValueDate.end;
      } else {
        this.reporting.observation_start = null;
        this.dateRange = inputValueDate;
        this.reporting.observation_end =
          moment(inputValueDate).format("YYYY-MM-DD");
      }
      this.attributes[0] = {
        key: "today",
        dates: this.dateRange,
        highlight: true,
      };
      console.log("dateRange", this.dateRange);
    },
    clearObservationDate() {
      this.dateRange = new Date();
      this.isRanged = false;
    },
    selectedForm(value) {
      this.getFormFields({ form_id: value });
      console.log("value ->", value);
    },
    selectedHospitals(value) {
      this.reporting.hospitalId = value;
      console.log("value ->", this.reporting.hospitalId);
    },
    selectedIndicators(value) {
      this.reporting.indicatorId = value;
      console.log("value ->", this.reporting.indicatorId);
    },
    selectedOperations(value) {
      this.reporting.operationId = value;
    },
    submit() {
      if (!this.reporting.observation_end) {
        this.reporting.observation_end = new Date();
      }
      this.$emit("generatedReport", this.reporting);
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.style-chooser {
  background-color: #f4f6fc;
  /* text-align: ; */
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
