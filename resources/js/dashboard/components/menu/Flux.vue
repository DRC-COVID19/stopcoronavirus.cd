<template>
  <b-card no-body class="rounded-0 p-2 pb-3">
    <b-form class="flux-form" @submit.prevent="submitFluxForm">
      <b-form-row>
        <b-col cols="12" md="6" lg="2" class="nav-zone pl-3 pr-3 mb-2 mb-lg-0">
          <b-form-group>
            <label for class="text-dash-color">Sources</label>
            <v-select
              @input="selectedFluxSourceChanged"
              v-model="fluxForm.selectedFluxSource"
              :options="fluxSource"
              label="name"
              placeholder="Option"
              :reduce="(item) => item.id"
              class="style-chooser"
            />
          </b-form-group>
        </b-col>
        <b-col cols="12" md="6" lg="3" class="nav-zone pl-3 pr-3">
          <label for class="text-dash-color">Paramètres Géographiques</label>
          <b-row>
            <b-col cols="12" md="6" class="mb-2 mb-lg-0">
              <b-form-group>
                <v-select
                  :disabled="fluxForm.selectedFluxSource == 2"
                  @input="fluxGeoGranularityChange"
                  v-model="fluxForm.fluxGeoGranularity"
                  :options="fluxGeoGranularities"
                  label="name"
                  placeholder="Granularité"
                  :reduce="(item) => item.id"
                  class="style-chooser"
                />
              </b-form-group>
            </b-col>
            <b-col cols="12" md="6" class="mb-2 mb-lg-0">
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
                  :disabled="!fluxForm.fluxGeoGranularity"
                  :options="fluxGeoOptions"
                  placeholder="Localisation"
                  label="origin"
                  :selectable="(item) => !item.isTitle"
                  :reduce="(item) => item.origin"
                  @input="fluxGeoOptionsChange"
                  class="style-chooser"
                  :class="{ 'zone-has-error': IsGeoOptionEmpty }"
                >
                  <template v-slot:option="option">
                    <div v-if="option.isTitle" class="v-select-group">
                      {{ option.origin }}
                    </div>
                    <div v-else>{{ option.origin }}</div>
                  </template>
                </v-select>
                <span v-if="IsGeoOptionEmpty" class="range-lbl text-danger"
                  >{{ messaGeoOptionsNull }}
                </span>
              </b-form-group>
            </b-col>
          </b-row>
        </b-col>
        <b-col cols="12" md="12" lg="5" class="nav-zone pl-3 pr-3">
          <label for class="text-dash-color">Paramètres Temporels</label>
          <b-row>
            <b-col cols="12" md="3" class="mb-2 mb-lg-0">
              <b-form-group>
                <v-select
                  :disabled="isDesibledFluxTimeGranularity"
                  required
                  v-model="fluxForm.fluxTimeGranularity"
                  :options="fluxTimeGranularities"
                  label="name"
                  placeholder="Granularité"
                  :reduce="(item) => item.id"
                  @input="fluxTimeGranularityChange"
                  class="style-chooser"
                />
              </b-form-group>
            </b-col>
            <b-col cols="12" md="9">
              <b-form-group>
                <div class="d-flex">
                  <div class="mr-2 picker-container">
                    <date-range-picker
                      :disabled="fluxForm.selectedFluxSource == 2"
                      ref="picker1"
                      id="picker1"
                      :locale-data="rangeData"
                      v-model="dateRangePreference"
                      :appendToBody="true"
                      opens="center"
                      :timePicker24Hour="isHotspot"
                      :min-date="reference_min_date"
                      :max-date="Observation_max_date"
                      @update="UpdatePreferenceDate"
                      :calculate-position="dateRangerPosition"
                      class="style-picker"
                      :class="{ 'style-picker-has-error': referenceHasError }"
                    >
                      <template v-slot:input="picker">
                        {{ picker.startDate | date }} - {{ picker.endDate | date }}
                      </template
                      >
                    </date-range-picker>
                    <span
                      class="range-lbl"
                      :class="{ 'text-danger': referenceHasError }"
                      >Période de référence
                    </span>
                    <span
                      v-if="referenceHasError"
                      v-b-tooltip.hover
                      :title="referenceErrorMessage"
                      class="fa fa-info-circle text-danger text-right range-lbl"
                    ></span>
                  </div>
                  <div class="picker-container">
                    <date-range-picker
                      id="picker2"
                      ref="picker2"
                      :locale-data="rangeData"
                      v-model="dateRangeObservation"
                      :appendToBody="true"
                      opens="center"

                      :singleDatePicker="singleDatePicker"
                      :timePicker24Hour="isHotspot"
                      :min-date="dateRangePreference.endDate"
                      :max-date="Observation_max_date"
                      @update="UpdateObservationDate"
                      :calculate-position="dateRangerPosition"
                      class="style-picker"
                    >
                      <template v-slot:input="picker">
                        <span></span> {{ picker.startDate | date
                        }}<span v-if="!singleDatePicker">
                          - {{ picker.endDate | date }}</span
                        >
                      </template>
                    </date-range-picker>
                    <span class="range-lbl">Période d'observation</span>
                  </div>
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
        <b-col
          cols="12"
          md="3"
          lg="2"
          class="pl-3 pr-3"
          :class="{ row: !isSmOrMd }"
        >
          <b-button
            type="submit"
            :disabled="!isButtonEnabled"
            block
            class="btn-submit mt-2 btn-dash-blue"
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
  GEO_GRANULARITIES,
  HOTSPOT_PREFERENCE_START,
  HOTSPOT_PREFERENCE_END,
  HOTSPOT_OBSERVATION_START,
  HOTSPOT_OBSERVATION_END,
  OBSERVATION_START,
  OBSERVATION_END,
  AFRICELL_PREFERENCE_START,
  AFRICELL_PREFERENCE_END,
  AFRICELL_OBSERVATION_START,
  AFRICELL_OBSERVATION_END,
  HOTSPOT_TYPE,
  OBSERVATION_END_PROVINCE,
} from "../../config/env";
import { mapMutations, mapState, mapActions } from "vuex";
import moment from "moment";
import "vue2-daterange-picker/dist/vue2-daterange-picker.css";
export default {
  components: {
    DateRangePicker,
  },
  props: {
    fluxZones: {
      type: Array,
      default: () => [],
    },
    fluxProvinces: {
      type: Array,
      default: () => [],
    },
    flux24Errors: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      dateRangePreference: {
        startDate: new Date(`${PREFERENCE_START} 06:00`),
        endDate: new Date(`${PREFERENCE_END} 23:30`),
      },
      Observation_max_date: new Date(FLUX_LAST_UPDATE),
      reference_min_date: moment(PREFERENCE_START)
        .subtract(1, "days")
        .format("YYYY-MM-DD"),
      fluxForm: {
        preference_start: PREFERENCE_START,
        preference_end: PREFERENCE_END,
        observation_start: "2020-03-19",
        observation_end: "2020-08-12",
        fluxGeoGranularity: 1,
        fluxTimeGranularity: 1,
        time_start: "06:00",
        time_end: "23:30",
        selectedFluxSource: 1,
      },
      dateRangeObservation: {
        startDate: new Date(`${OBSERVATION_START} 06:00`),
        endDate: new Date(`${OBSERVATION_END} 23:30`),
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
          name: "24h",
        },
        {
          id: 2,
          name: "30'",
        },
      ],
      fluxTimeGranularity: null,
      allZoneChecked: false,
      allProvinceChecked: false,
      allZoneCheckedIndeterminate: false,
      allProvincesCheckedIndeterminate: false,
      IsfluxParameterCollapse: false,
      fluxPredefinedControl: null,
      isHotspot: false,
      referenceThrowError: false,
      referenceErrorMessage: null,
      fluxSource: [
        {
          id: 1,
          name: "Orange",
        },
        {
          id: 2,
          name: "Africell",
        },
      ],
      fluxFormCached: {},
    };
  },
  filters: {
    date: (val) => {
      return val ? moment(val).format("DD.MM.YYYY") : "";
    },
  },
  mounted() {
    this.fillParametersFromUrlParams()
    this.$store.watch(
      (state) => state.flux.fluxGeoOptions,
      (value) => {
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
      (state) => state.flux.fluxHotspotClicked,
      (value) => {
        if (value) {
          this.fluxFormCached.fluxGeoOptions = [value];
          this.fluxForm = this.fluxFormCached;
          this.setFluxGeoOptions(this.fluxFormCached.fluxGeoOptions);
          this.$emit("submitFluxForm", this.fluxFormCached);
        }
      }
    );

    this.$store.watch(
      (state) => state.flux.tendanceChartSelectedValue,
      (value) => {
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
  },
  computed: {
    ...mapState({
      fluxHotSpot: (state) => state.app.fluxHotSpot,
      activeMenu: (state) => state.nav.activeMenu
    }),
    isDesibledFluxTimeGranularity() {
      return !(
        this.fluxForm.fluxGeoGranularity ==
        GEO_GRANULARITIES.find((x) => x.id == 3).id
      );
    },
    singleDatePicker() {
      let value = false;
      if (
        this.fluxForm.fluxGeoGranularity ==
          GEO_GRANULARITIES.find((x) => x.id == 3).id &&
        this.fluxForm.fluxTimeGranularity == 2
      ) {
        value = true;
      }
      return value;
    },
    isButtonEnabled() {
      return (
        this.fluxForm.fluxGeoGranularity &&
        this.fluxForm.fluxGeoOptions &&
        this.fluxForm.fluxGeoOptions.length > 0 &&
        this.dateRangeObservation.startDate &&
        this.dateRangeObservation.endDate &&
        !this.referenceHasError
      );
    },
    rangeData() {
      return {
        firstDay: 1,
        format: this.isHotspot ? "dd-mm-yyyy HH:mm" : "dd-mm-yyyy",
        drops: "up",
      };
    },
    referenceHasError() {
      return this.referenceThrowError;
    },
    messaGeoOptionsNull() {
      let geoGanularity = "une province";
      switch (this.fluxForm.fluxGeoGranularity) {
        case 2:
          geoGanularity = "une zone";
          break;
        case 3:
          geoGanularity = "un hotspot";
          break;
      }
      return `Sélectionnez ${geoGanularity}`;
    },
    IsGeoOptionEmpty() {
      return (
        !this.fluxForm.fluxGeoOptions ||
        (this.fluxForm.fluxGeoOptions &&
          this.fluxForm.fluxGeoOptions.length == 0)
      );
    },
  },
  watch: {
    fluxProvinces() {
      if (this.fluxForm.fluxGeoGranularity === 1) {
        this.fluxGeoGranularityChange(1, false);
      }
    },
    dateRangePreference() {
      this.addDateRangeReferenceToUrl();
    },
    dateRangeObservation() {
      this.addDateRangeObservationToUrl();
    }
  },
  methods: {
    ...mapMutations([
      "setFluxGeoGranularity",
      "setFluxGeoOptions",
      "setFluxEnabled",
      "setFluxGeoOptionsTmp",
      "setFluxGeoGranularityTemp",
      "setFluxTimeGranularity",
      "setSelectedSource",
      "setFluxHotspotType",
      "setFluxHotspotClicked",
    ]),
    ...mapActions(["resetState"]),
    fillParametersFromUrlParams () {
      const url = new URL(window.location.href);
      const fluxSource = url.searchParams.get('source');
      if (fluxSource) {
        this.$set(this.fluxForm, 'selectedFluxSource', +fluxSource)
      }

      const fluxGeoGranularity = url.searchParams.get('geo-granularity');
      if (fluxGeoGranularity) {
        this.$set(this.fluxForm, 'fluxGeoGranularity', +fluxGeoGranularity)
        this.fluxGeoGranularityChange(+fluxGeoGranularity)
      } else {
        this.fluxGeoGranularityChange(1);
      }

      const fluxGeoOptions = url.searchParams.get('geo-options');
      if (fluxGeoOptions) {
        try {
          this.$set(this.fluxForm, 'fluxGeoOptions', JSON.parse(fluxGeoOptions))
        } catch (e) {
          console.log( e)
        }
      }

      const fluxTimeGranularity = url.searchParams.get('time-granularity');
      if (fluxTimeGranularity) {
        this.$set(this.fluxForm, 'fluxTimeGranularity', +fluxTimeGranularity)
        this.addParamToUrlWhenInThisMenu('time-granularity', this.fluxForm.fluxTimeGranularity)
      }

      const referenceStartDate = url.searchParams.get('reference-start-date');
      const referenceEndDate = url.searchParams.get('reference-end-date');
      try{
        this.dateRangePreference = {
          startDate: referenceStartDate ? new Date(`${referenceStartDate} 06:00`) : null,
          endDate: referenceEndDate ? new Date(`${referenceEndDate} 23:30`) : null,
        }
        this.fluxForm.preference_start = referenceStartDate
        this.fluxForm.preference_end = referenceEndDate
      } catch (e) {
        console.log(e)
      }

      const observationStartDate = url.searchParams.get('observation-start-date');
      const observationEndDate = url.searchParams.get('observation-end-date');
      try{
        this.dateRangeObservation = {
          startDate: observationStartDate ? new Date(`${observationStartDate} 06:00`) : null,
          endDate: observationEndDate ? new Date(`${observationEndDate} 23:30`) : null,
        }
        this.fluxForm.observation_start = observationStartDate
        this.fluxForm.observation_end = observationEndDate
      } catch (e) {
        console.log(e)
      }
    },
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
      const localStartDate = moment(startDate);
      const localEndDate = moment(endDate);
      const dateDiff = localEndDate.diff(localStartDate, "days");
      this.referenceThrowError = false;
      this.referenceErrorMessage = null;
      if (dateDiff + 1 < 7) {
        this.referenceThrowError = true;
        this.referenceErrorMessage = "La plage doit avoir au moins 7 jours";
      }
      this.fluxForm.preference_start = localStartDate.format("YYYY/MM/DD");
      this.fluxForm.preference_end = localEndDate.format("YYYY/MM/DD");
      this.dateRangeObservation = { startDate: null, endDate: null };
      this.fluxForm.observation_start = null;
      this.fluxForm.observation_end = null;
      this.resetFluxPredefinedControl();
    },
    addDateRangeReferenceToUrl() {
      if (this.dateRangePreference.startDate) {
        this.addParamToUrlWhenInThisMenu(
          'reference-start-date',
          moment(this.dateRangePreference.startDate).format("YYYY/MM/DD")
        )
      }
      if (this.dateRangePreference.endDate) {
        this.addParamToUrlWhenInThisMenu(
          'reference-end-date',
          moment(this.dateRangePreference.endDate).format("YYYY/MM/DD")
        )
      }
    },
    UpdateObservationDate({ startDate, endDate }) {
      this.fluxForm.observation_start = moment(startDate).format("YYYY-MM-DD");
      this.fluxForm.observation_end = moment(endDate).format("YYYY-MM-DD");
      this.fluxForm.time_start = moment(startDate).format("HH:mm");
      this.fluxForm.time_end = moment(endDate).format("HH:mm");
      this.resetFluxPredefinedControl();
    },
    addDateRangeObservationToUrl() {
      if (this.dateRangeObservation.startDate) {
        this.addParamToUrlWhenInThisMenu(
          'observation-start-date',
          moment(this.dateRangeObservation.startDate).format("YYYY/MM/DD")
        )
      }
      if (this.dateRangeObservation.endDate) {
        this.addParamToUrlWhenInThisMenu(
          'observation-end-date',
          moment(this.dateRangeObservation.endDate).format("YYYY/MM/DD")
        )
      }
    },
    submitFluxForm() {

      if ( this.fluxForm.fluxGeoGranularity ==
          GEO_GRANULARITIES.find((x) => x.id == 3).id && this.fluxForm.observation_start == this.fluxForm.observation_end) {
        this.$set(this.fluxForm, "fluxTimeGranularity", 2);
      }

      const fluxForm = { ...this.fluxForm };
      this.setSelectedSource(fluxForm.selectedFluxSource);
      this.fluxFormCached = fluxForm;

      this.$emit("submitFluxForm", fluxForm);
      this.setFluxGeoOptions(fluxForm.fluxGeoOptions);
      this.setFluxGeoGranularityTemp(fluxForm.fluxGeoGranularity);
      this.setFluxTimeGranularity(fluxForm.fluxTimeGranularity);
      this.setFluxHotspotClicked(null);
    },
    dateRangerPosition(dropdownList, component, { width, top, left, right }) {
      dropdownList.style.top = `${top}px`;
      if (component.$attrs.id == "picker1") {
        dropdownList.style.left = `${
          Number(left) + Number(this.isSmOrMd ? 110 : 0)
        }px`;
      } else {
        dropdownList.style.left = `${left}px`;
      }
    },
    clearPrefenceDate() {
      this.dateRangePreference = { startDate: null, endDate: null };
      this.fluxForm.preference_start = null;
      this.fluxForm.preference_end = null;
    },
    clearObservationDate() {
      this.dateRangeObservation = { startDate: null, endDate: null };
      this.dateRangePreference = { startDate: null, endDate: null };
      this.fluxForm.observation_start = null;
      this.fluxForm.observation_end = null;
      this.fluxForm.preference_start = null;
      this.fluxForm.preference_end = null;
      this.referenceThrowError = false;
      this.referenceErrorMessage = null;
      this.resetFluxPredefinedControl();
    },
    changeCalendarLimit(OBSERVATION_END) {
      this.dateRangePreference = {
        startDate: new Date(
          `${
            this.fluxForm.selectedFluxSource == 1
              ? PREFERENCE_START
              : AFRICELL_PREFERENCE_START
          } 06:00`
        ),
        endDate: new Date(
          `${
            this.fluxForm.selectedFluxSource == 1
              ? PREFERENCE_END
              : AFRICELL_PREFERENCE_END
          } 23:30`
        ),
      };
      this.dateRangeObservation = {
        startDate: new Date(
          `${
            this.fluxForm.selectedFluxSource == 1
              ? OBSERVATION_START
              : AFRICELL_OBSERVATION_START
          } 06:00`
        ),
        endDate: new Date(
          `${
            this.fluxForm.selectedFluxSource == 1
              ? OBSERVATION_END
              : AFRICELL_OBSERVATION_END
          } 23:30`
        ),
      };
      this.reference_min_date = moment(
        this.fluxForm.selectedFluxSource == 1
          ? PREFERENCE_END
          : AFRICELL_PREFERENCE_END
      )
        .subtract(1, "days")
        .format("YYYY-MM-DD");
      this.fluxForm.preference_start =
        this.fluxForm.selectedFluxSource == 1
          ? PREFERENCE_START
          : AFRICELL_PREFERENCE_START;
      this.fluxForm.preference_end =
        this.fluxForm.selectedFluxSource == 1
          ? PREFERENCE_END
          : AFRICELL_PREFERENCE_END;
      this.fluxForm.observation_start =
        this.fluxForm.selectedFluxSource == 1
          ? OBSERVATION_START
          : AFRICELL_OBSERVATION_START;
      this.fluxForm.observation_end =
        this.fluxForm.selectedFluxSource == 1
          ? OBSERVATION_END
          : AFRICELL_OBSERVATION_END;
    },
    fluxGeoGranularityChange(value, triggerChangeCalendarLimit = true) {
      this.resetFluxPredefinedControl();
      this.setFluxGeoGranularity(value);
      this.addParamToUrlWhenInThisMenu('geo-granularity', value)
      this.$set(this.fluxForm, "fluxGeoOptions", []);
      this.$set(this.fluxForm, "fluxTimeGranularity", 1);
      this.isHotspot = false;
      this.referenceThrowError = false;
      this.referenceErrorMessage = null;
      switch (value) {
        case 1:
          this.fluxGeoOptions = this.fluxProvinces;
          if (triggerChangeCalendarLimit) {
            this.changeCalendarLimit(OBSERVATION_END);
          }
          break;
        case 2:
          this.fluxGeoOptions = this.fluxZones;
          this.changeCalendarLimit(OBSERVATION_END);
          break;
        case 3:
          this.clearObservationDate();
          this.fluxHostpotSwitchPeriode(
            HOTSPOT_PREFERENCE_START,
            HOTSPOT_PREFERENCE_END,
            HOTSPOT_OBSERVATION_START,
            HOTSPOT_OBSERVATION_END,
            true
          );
          this.isHotspot = true;
          const geoOptions = [
            { origin: "Tout", id: "0" },
            { isTitle: true, origin: "Type Hotspot" },
          ];
          geoOptions.push(
            ...HOTSPOT_TYPE.map((x) => ({ origin: x.pseudo, id: x.id }))
          );
          geoOptions.push({ isTitle: true, origin: "Hotspot" });
          geoOptions.push(
            ...this.fluxHotSpot
              .filter((x) => x.name != "ZoneGlobale")
              .map((x) => ({ origin: x.name, id: x.id }))
          );
          this.fluxGeoOptions = geoOptions;
          this.$set(this.fluxForm, "fluxGeoOptions", ["Tout"]);
          this.$set(this.fluxForm, "fluxTimeGranularity", 2);
          break;
        default:
          break;
      }
      this.addParamToUrlWhenInThisMenu('time-granularity', this.fluxForm.fluxTimeGranularity)
    },
    fluxTimeGranularityChange(value) {
      this.addParamToUrlWhenInThisMenu('time-granularity', value)
      if (
        this.fluxForm.fluxGeoGranularity ==
        GEO_GRANULARITIES.find((x) => x.id == 3).id
      ) {
        this.fluxGeoOptionsChange(this.fluxForm.fluxGeoOptions[0]);
      }
    },
    fluxHostpotSwitchPeriode(
      preferenceStart,
      preferenceEnd,
      observationStart,
      observationEnd,
      isSingle = false
    ) {
      let localPreferenceEnd = preferenceEnd;
      let localObservationEnd = observationEnd;
      if (isSingle) {
        localObservationEnd = observationStart;
      }
      this.dateRangePreference = {
        startDate: new Date(`${preferenceStart} 06:00`),
        endDate: new Date(`${localPreferenceEnd} 23:30`),
      };
      this.dateRangeObservation = {
        startDate: new Date(`${observationStart} 06:00`),
        endDate: new Date(`${localObservationEnd} 23:30`),
      };
      this.reference_min_date = moment(preferenceStart)
        .subtract(1, "days")
        .format("YYYY-MM-DD");
      this.fluxForm.preference_start = preferenceStart;
      this.fluxForm.preference_end = localPreferenceEnd;
      this.fluxForm.observation_start = observationStart;
      this.fluxForm.observation_end = localObservationEnd;
    },
    fluxGeoOptionsChange(value) {
      if (this.fluxForm.fluxGeoGranularity == 3) {
        const hotspot = this.fluxHotSpot.find((x) => x.name == value);
        if (hotspot) {
          this.clearObservationDate();
          const referenceStart = hotspot.min_date;
          const referenceEnd = moment(referenceStart)
            .add(7, "days")
            .format("YYYY-MM-DD");
          const observationStart = moment(referenceStart)
            .add(8, "days")
            .format("YYYY-MM-DD");

          this.fluxHostpotSwitchPeriode(
            referenceStart,
            referenceEnd,
            observationStart,
            HOTSPOT_OBSERVATION_END
          );
        } else {
          this.fluxHostpotSwitchPeriode(
            HOTSPOT_PREFERENCE_START,
            HOTSPOT_PREFERENCE_END,
            HOTSPOT_OBSERVATION_START,
            HOTSPOT_OBSERVATION_END
          );
        }
      }
      const newVal = value === null ? [] : [value];
      this.$set(this.fluxForm, "fluxGeoOptions", newVal);
      this.addParamToUrlWhenInThisMenu('geo-options', JSON.stringify(newVal))
      this.resetFluxPredefinedControl();
      this.setFluxGeoOptionsTmp(newVal);
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
          observation_start = this.moment().startOf("week").format(DATEFORMAT);
          observation_end = this.moment().endOf("week").format(DATEFORMAT);
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
        fluxGeoGranularity: 2,
      };

      this.dateRangeObservation = {
        startDate: new Date(observation_start),
        endDate: new Date(observation_end),
      };
      this.dateRangeObservation = {
        startDate: new Date(preference_start),
        endDate: new Date(preference_end),
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
    },
    selectedFluxSourceChanged(value) {
      // this.setSelectedSource(value);
      this.addParamToUrlWhenInThisMenu('source', value)
      if (value == 2) {
        // source africell only support geo-granularity "zone des santés"
        this.$set(this.fluxForm, "fluxGeoGranularity", 2);
      }
      this.fluxGeoGranularityChange(this.fluxForm.fluxGeoGranularity);
    },
    addParamToUrlWhenInThisMenu(param, value) {
      if (this.activeMenu == 1) {
        this.addParamToUrl(param, value)
      }
    }
  },
};
</script>
<style lang="scss">
.vs__dropdown-option--disabled {
  background: #ededed !important;
  color: #a6a6a6 !important;
  cursor: text;
  pointer-events: none;
  font-size: 1.2rem;
  font-weight: bold;
  padding-top: 10px;
  padding-bottom: 10px;
  &:hover {
    cursor: inherit;
  }
}
</style>
<style lang="scss" scoped>
@import "@~/sass/_variables";
.flux-form {
  margin: 0;
  .nav-zone {
    border-right: 1px solid $dash-blue-8;
  }
}
.range-lbl {
  font-size: 0.7rem;
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
.picker-container {
  width: 40%;
}
@media screen and (min-width: 1300px) {
  .picker-container {
    width: 100%;
  }
}
</style>
