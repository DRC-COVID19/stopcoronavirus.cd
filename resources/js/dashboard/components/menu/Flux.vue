<template>
  <b-card no-body class="rounded-0 p-2 pb-3">
    <b-form class="flux-form" @submit.prevent="submitFluxForm">
      <b-form-row>
        <b-col cols="12" md="2" class="nav-zone pl-3 pr-3">
          <b-form-group>
            <label for class="text-dash-color">Rapports prédefinis</label>
            <v-select
              @input="fluxPredefinedInputChanged"
              v-model="fluxPredefinedControl"
              :options="fluxPredefinedInput"
              label="name"
              placeholder="Option"
              :reduce="item => item.id"
              class="style-chooser"
            />
          </b-form-group>
        </b-col>
        <b-col cols="12" md="4" class="nav-zone pl-3 pr-3">
          <label for class="text-dash-color">Paramètres Géographiques</label>
          <b-row>
            <b-col cols="12" md="6">
              <b-form-group>
                <v-select
                  @input="fluxGeoGranularityChange"
                  v-model="fluxForm.fluxGeoGranularity"
                  :options="fluxGeoGranularities"
                  label="name"
                  placeholder="Granularité"
                  :reduce="item => item.id"
                  class="style-chooser"
                />
              </b-form-group>
            </b-col>
            <b-col cols="12" md="6">
              <b-form-group
                :invalid-feedback="
                  flux24Errors.fluxGeoOptions
                    ? flux24Errors.fluxGeoOptions[0]
                    : null
                "
                :state="
                  flux24Errors.fluxGeoOptions &&
                    flux24Errors.fluxGeoOptions.lenght > 0
                "
              >
                <v-select
                  v-model="fluxForm.fluxGeoOptions"
                  multiple
                  :disabled="!fluxForm.fluxGeoGranularity"
                  :options="fluxGeoOptions"
                  placeholder="Localisation"
                  label="origin"
                  :reduce="item => item.origin"
                  @input="fluxGeoOptionsChange"
                  class="style-chooser style-chooser-multiple"
                />
              </b-form-group>
            </b-col>
          </b-row>
        </b-col>
        <b-col cols="12" md="4" class="nav-zone pl-3 pr-3">
          <label for class="text-dash-color">Paramètres Temporels</label>
          <b-row>
            <b-col cols="12" md="4">
              <b-form-group>
                <v-select
                  :disabled="true"
                  required
                  v-model="fluxForm.fluxTimeGranularity"
                  :options="fluxTimeGranularities"
                  label="name"
                  placeholder="Granularité"
                  :reduce="item => item.id"
                  @input="resetFluxPredefinedControl"
                  class="style-chooser"
                />
              </b-form-group>
            </b-col>
            <b-col cols="12" md="8">
              <b-form-group
                :invalid-feedback="
                  flux24Errors.observation_start || flux24Errors.observation_end
                    ? `${
                        flux24Errors.observation_start
                          ? flux24Errors.observation_start[0]
                          : ''
                      } ${
                        flux24Errors.observation_end
                          ? flux24Errors.observation_end[0]
                          : ''
                      }`
                    : null
                "
                :state="
                  (flux24Errors.observation_start &&
                    flux24Errors.observation_start.lenght > 0) ||
                    (flux24Errors.observation_end &&
                      flux24Errors.observation_end.lenght > 0)
                "
              >
                <div class="d-flex">
                  <date-range-picker
                    ref="picker2"
                    :locale-data="rangeData"
                    v-model="dateRangeObservation"
                    :appendToBody="true"
                    opens="center"
                    :timePicker="isHotspot"
                    :timePicker24Hour="isHotspot"
                    :min-date="new Date('03/19/2020')"
                    :max-date="Observation_max_date"
                    @update="UpdateObservationDate"
                    :calculate-position="dateRangerPosition"
                    class="style-picker"
                  >
                    <template v-slot:input="picker"
                      >{{ picker.startDate | date }} -
                      {{ picker.endDate | date }}</template
                    >
                  </date-range-picker>

                  <b-button
                    @click="clearObservationDate"
                    class="btn-clear-observation btn-dash-blue"
                  >
                    <span class="fa fa-times"></span>
                  </b-button>
                </div>
              </b-form-group>
            </b-col>
          </b-row>
        </b-col>
        <b-col cols="12" md="2" class="row pl-3 pr-3">
          <b-button type="submit" :disabled="!isButtonEnabled" block class="btn-submit mt-2 btn-dash-blue"
            >Filtrer les données</b-button
          >
        </b-col>
      </b-form-row>
    </b-form>
  </b-card>
</template>

<script>
import DateRangePicker from "vue2-daterange-picker";
import {
  PREFERENCE_START,
  PREFERENCE_END,
  DATEFORMAT,
  FLUX_LAST_UPDATE,
  FLUX_PREDEFINED_INPUT,
  GEO_GRANULARITIES
} from "../../config/env";
import { mapMutations, mapState, mapActions } from "vuex";
import moment from "moment";
import "vue2-daterange-picker/dist/vue2-daterange-picker.css";
export default {
  components: {
    DateRangePicker
  },
  props: {
    fluxZones: {
      type: Array,
      default: () => []
    },
    fluxProvinces: {
      type: Array,
      default: () => []
    },
    flux24Errors: {
      type: Object,
      default: () => ({})
    }
  },
  data() {
    return {
      dateRangePreference: {
        startDate: new Date(PREFERENCE_START),
        endDate: new Date(PREFERENCE_END)
      },
      Observation_max_date: new Date(FLUX_LAST_UPDATE),
      fluxForm: {
        preference_start: PREFERENCE_START,
        preference_end: PREFERENCE_END,
        observation_start: "2020-03-19",
        observation_end: "2020-08-12",
        fluxGeoGranularity: 2,
        fluxTimeGranularity: 1,
        time_start: "06:00",
        time_end: "23:30"
      },
      dateRangeObservation: {
        startDate: new Date("03/19/2020 06:00"),
        endDate: new Date("12/08/2020 23:30:")
      },
      fluxPredefinedInput: FLUX_PREDEFINED_INPUT,
      fluxFilterInput: "",
      fluxFilterInputProvince: "",
      fluxZonesArray: [],
      fluxProvincesArray: [],
      fluxGeoGranularity: null,
      fluxGeoGranularities: GEO_GRANULARITIES,
      fluxGeoOptions: [],
      fluxTimeGranularities: [
        {
          id: 1,
          name: "24h"
        },
        {
          id: 2,
          name: "30'"
        }
      ],
      fluxTimeGranularity: null,
      allZoneChecked: false,
      allProvinceChecked: false,
      allZoneCheckedIndeterminate: false,
      allProvincesCheckedIndeterminate: false,
      IsfluxParameterCollapse: false,
      fluxPredefinedControl: null,
      isHotspot: false
    };
  },
  filters: {
    date: val => {
      return val ? moment(val).format("DD.MM.YYYY") : "";
    }
  },
  mounted() {
    this.$store.watch(
      state => state.flux.fluxGeoOptions,
      value => {
        this.$set(this.fluxForm, "fluxGeoOptions", value);
        if (
          this.fluxForm.observation_start &&
          this.fluxForm.observation_end &&
          this.fluxForm.fluxTimeGranularity
        ) {
          this.$emit("submitFluxForm", this.fluxForm);
        }
      }
    );
    this.$store.watch(
      state => state.flux.tendanceChartSelectedValue,
      value => {
        const date = new Date(value.x);
        this.fluxForm.preference_end = this.moment(
          date.setDate(date.getDate() - 1)
        ).format(DATEFORMAT);
        this.fluxForm.observation_start = this.moment(value.x).format(
          DATEFORMAT
        );
        this.$set(this.dateRangeObservation, "startDate", value.x);
        this.submitFluxForm();
      }
    );
    this.fluxGeoGranularityChange(2);
  },
  computed: {
    ...mapState({
      fluxHotSpot: state => state.app.fluxHotSpot
    }),
    isButtonEnabled(){
      return this.fluxForm.fluxGeoGranularity && this.fluxForm.fluxGeoOptions 
      && this.fluxForm.fluxGeoOptions.length>0 
       && this.dateRangeObservation.startDate && this.dateRangeObservation.endDate
    },
    rangeData() {
      return {
        firstDay: 1,
        format: this.isHotspot ? "dd-mm-yyyy HH:mm" : "dd-mm-yyyy",
        drops: "up"
      };
    }
  },
  watch: {
    fluxZones() {
      this.fluxGeoGranularityChange(2);
    }
  },
  methods: {
    ...mapMutations([
      "setFluxGeoGranularity",
      "setFluxGeoOptions",
      "setFluxEnabled",
      "setFluxGeoOptionsTmp",
      "setFluxGeoGranularityTemp",
      "setFluxTimeGranularity"
    ]),
    ...mapActions(["resetState"]),
    populationFluxToggle(checked) {
      this.$root.$emit("bv::toggle::collapse", "populationFluxcollapse");
      this.$emit("populationFluxChecked", checked);
      if (!checked) {
        this.fluxForm.filter_zone = [];
        this.fluxFilterInput = "";
        this.fluxForm.origin = null;
        this.fluxForm.destination = null;
        this.IsfluxParameterCollapse = false;
        this.resetState();
      } else {
        this.setFluxEnabled(checked);
      }
    },
    UpdatePreferenceDate({ startDate, endDate }) {
      this.fluxForm.preference_start = moment(startDate).format("YYYY/MM/DD");
      this.fluxForm.preference_end = moment(endDate).format("YYYY/MM/DD");
    },
    UpdateObservationDate({ startDate, endDate }) {
      console.log("data", { startDate, endDate });
      this.fluxForm.observation_start = moment(startDate).format("YYYY/MM/DD");
      this.fluxForm.observation_end = moment(endDate).format("YYYY/MM/DD");
      this.fluxForm.time_start = moment(startDate).format("HH:mm");
      this.fluxForm.time_end = moment(endDate).format("HH:mm");
      this.resetFluxPredefinedControl();
    },
    submitFluxForm() {
      this.$emit("submitFluxForm", this.fluxForm);
      this.setFluxGeoOptions(this.fluxForm.fluxGeoOptions);
      this.setFluxGeoGranularityTemp(this.fluxForm.fluxGeoGranularity);
      this.setFluxTimeGranularity(this.fluxForm.fluxTimeGranularity);
    },
    dateRangerPosition(dropdownList, component, { width, top, left, right }) {
      dropdownList.style.top = `${top}px`;
      dropdownList.style.left = `${left}px`;
    },
    clearPrefenceDate() {
      this.dateRangePreference = { startDate: null, endDate: null };
      this.fluxForm.preference_start = null;
      this.fluxForm.preference_end = null;
    },
    clearObservationDate() {
      this.dateRangeObservation = { startDate: null, endDate: null };
      this.fluxForm.observation_start = null;
      this.fluxForm.observation_end = null;
      this.resetFluxPredefinedControl();
    },
    fluxGeoGranularityChange(value) {
      this.resetFluxPredefinedControl();
      this.setFluxGeoGranularity(value);
      this.$set(this.fluxForm, "fluxGeoOptions", []);
      this.$set(this.fluxForm, "fluxTimeGranularity", 1);
      this.isHotspot = false;
      switch (value) {
        case 1:
          this.fluxGeoOptions = this.fluxProvinces;
          break;
        case 2:
          this.fluxGeoOptions = this.fluxZones;
          break;
        case 3:
          this.isHotspot = true;
          this.fluxGeoOptions = this.fluxHotSpot
            .filter(x => x.name != "ZoneGlobale")
            .map(x => ({ origin: x.name, id: x.id }));
          this.fluxGeoOptions.unshift({ origin: "Tout", id: "-1" });
          this.$set(this.fluxForm, "fluxGeoOptions", ["Tout"]);
          this.$set(this.fluxForm, "fluxTimeGranularity", 2);
          break;
        default:
          break;
      }
    },
    fluxGeoOptionsChange(value) {
      this.resetFluxPredefinedControl();
      this.setFluxGeoOptionsTmp(value);
    },
    fluxPredefinedInputChanged(value) {
      if (!value) {
        return;
      }
      let preference_start = PREFERENCE_START;
      let preference_end = PREFERENCE_END;
      let observation_start = null;
      let observation_end = null;
      let fluxGeoOptions = ["Gombe"];
       this.fluxGeoGranularityChange(2);

      // if (value != 7) this.$emit("toggleShowMobiliteGenerale", false);

      switch (value) {
        case 1:
          observation_start = this.moment().format(DATEFORMAT);
          observation_end = this.moment().format(DATEFORMAT);
          break;
        case 2:
          observation_start = this.moment()
            .startOf("week")
            .format(DATEFORMAT);
          observation_end = this.moment()
            .endOf("week")
            .format(DATEFORMAT);
          break;
        case 3:
          observation_start = this.moment(new Date())
            .startOf("month")
            .format(DATEFORMAT);
          observation_end = this.moment(new Date())
            .endOf("month")
            .format(DATEFORMAT);
          break;
        case 4:
          observation_start = this.moment()
            .subtract(1, "months")
            .startOf("month")
            .format(DATEFORMAT);
          observation_end = this.moment()
            .subtract(1, "months")
            .endOf("month")
            .format(DATEFORMAT);
          break;
        case 5:
          observation_start = "2020-03-19";
          observation_end = this.moment().format(DATEFORMAT);
          break;
        case 6:
          observation_start = "2020-03-19";
          observation_end = "2020-03-28";
          break;
        case 7:
          observation_start = "2020-03-19";
          observation_end = this.moment().format(DATEFORMAT);
          // this.$emit("toggleShowMobiliteGenerale", true);
          break;
      }

      this.fluxForm = {
        fluxGeoOptions,
        preference_start,
        preference_end,
        observation_start,
        observation_end,
        fluxTimeGranularity: 1,
        fluxGeoGranularity: 2
      };

      this.dateRangeObservation = {
        startDate: new Date(observation_start),
        endDate: new Date(observation_end)
      };
      this.setFluxGeoOptions(this.fluxForm.fluxGeoOptions);
      this.setFluxGeoGranularity(this.fluxForm.fluxGeoGranularity);
      this.setFluxGeoOptionsTmp(this.fluxForm.fluxGeoOptions);
      this.setFluxGeoGranularityTemp(this.fluxForm.fluxGeoGranularity);
      this.setFluxTimeGranularity(this.fluxForm.fluxTimeGranularity);
      this.$emit("submitFluxForm", this.fluxForm);
    },
    mobilityDetailToggle() {
      this.$root.$emit("bv::toggle::collapse", "mobilityDetail");
      this.IsfluxParameterCollapse = !this.IsfluxParameterCollapse;
    },
    resetFluxPredefinedControl() {
      this.fluxPredefinedControl = null;
    }
  }
};
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";
.flux-form {
  margin: 0;
  .nav-zone {
    border-right: 1px solid $dash-blue-8;
  }
}

.btn-clear-observation {
  height: 32px;
  margin-left: 5px;
  display: flex;
  align-items: center;
}
.btn-submit {
  font-size: 14px;
}
</style>
