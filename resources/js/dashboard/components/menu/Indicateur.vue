<template>
  <b-card no-body class="rounded-0 p-2">
    <b-form class="flux-form mb-2" @submit.prevent="submit">
      <b-form-row>
        <b-col cols="12" md="2" class="nav-zone pl-3 pr-3">
          <b-form-group>
            <label for class="text-dash-color">Filtres prédefinis</label>
            <v-select
              @input="predefinedInputChange"
              v-model="fluxPredefinedControl"
              :options="predefinedInput"
              :reduce="item=>item.id"
              label="name"
              placeholder="Options"
              class="style-chooser"
            />
          </b-form-group>
        </b-col>

        <b-col cols="12" md="3" class="nav-zone pl-3 pr-3">
          <b-row>
            <b-col cols="12" md="6" class="pr-md-1">
              <b-form-group>
                <label for class="text-dash-color">X</label>
                <v-select
                  v-model="form.x"
                  :options="indicateurX"
                  label="name"
                  placeholder="Options"
                  :reduce="item=>item.id"
                  @input="resetFluxPredefinedControl"
                  class="style-chooser"
                />
              </b-form-group>
            </b-col>
            <b-col cols="12" md="6" class="pl-md-1">
              <b-form-group>
                <label for class="text-dash-color">Y</label>
                <v-select
                  v-model="form.y"
                  :options="indicateurY"
                  label="name"
                  placeholder="Options"
                  :reduce="item=>item.id"
                  @input="resetFluxPredefinedControl"
                  class="style-chooser"
                />
              </b-form-group>
            </b-col>
          </b-row>
        </b-col>

        <b-col cols="12" md="2" class="nav-zone pl-3 pr-3">
          <label for class="text-dash-color">Param. Géographiques</label>

          <b-form-group
            :invalid-feedback="formErrors.geoOptions ? formErrors.geoOptions[0] : null"
            :state="formErrors.geoOptions && formErrors.geoOptions.lenght>0"
          >
            <v-select
              v-model="form.geoOptions"
              multiple
              :options="geoOptions"
              placeholder="Localisation"
              label="origin"
              :reduce="item=>item.origin"
              class="style-chooser style-chooser-multiple"
              @input="resetFluxPredefinedControl"
            />
          </b-form-group>
        </b-col>

        <b-col cols="12" md="3" class="nav-zone pl-3 pr-3">
          <label for class="text-dash-color">Paramètres Temporels</label>
          <b-row>
            <b-col cols="12">
              <b-form-group
                :invalid-feedback="flux24Errors.observation_start|| flux24Errors.observation_end ? `${flux24Errors.observation_start?flux24Errors.observation_start[0]:''} ${flux24Errors.observation_end?flux24Errors.observation_end[0]:''}` : null"
                :state="(flux24Errors.observation_start && flux24Errors.observation_start.lenght>0)|| (flux24Errors.observation_end && flux24Errors.observation_end.lenght>0)"
              >
                <div class="d-flex">
                  <date-range-picker
                    ref="picker2"
                    :locale-data="{
                        firstDay: 1,
                      format: 'dd-mm-yyyy',
                      drops: 'up' }"
                    v-model="dateRangeObservation"
                    :appendToBody="true"
                    opens="center"
                    :min-date="new Date('03/19/2020')"
                    :max-date="Observation_max_date"
                    @update="UpdateObservationDate"
                    :calculate-position="dateRangerPosition"
                    class="style-picker"
                  >
                    <template v-slot:input="picker">
                      <span
                        :title="filtredDate(picker.startDate) + ' - ' + filtredDate(picker.endDate)"
                      >{{ picker.startDate|date }} - {{ picker.endDate|date }}</span>
                    </template>
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
          <b-button type="submit" block class="btn-submit mt-2 btn-dash-blue">Filtrer les données</b-button>
        </b-col>
      </b-form-row>
    </b-form>
  </b-card>
</template>

<script>
import DateRangePicker from "vue2-daterange-picker";
import {
  FLUX_PREDEFINED_INPUT,
  GEO_GRANULARITIES,
  TEMP_GRANULARITIES,
  INDICATEUR_Y,
  INDICATEUR_X,
  INDICATEUR_PREDEFINED_INPUT,
  FLUX_LAST_UPDATE,
  OBSERVATION_START,
  OBSERVATION_END,
  DATEFORMAT,
} from "../../config/env";
import { mapActions, mapState } from "vuex";
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
      predefinedInput: INDICATEUR_PREDEFINED_INPUT,
      geoGranularities: GEO_GRANULARITIES,
      tempGranularities: TEMP_GRANULARITIES,
      indicateurY: INDICATEUR_Y,
      indicateurX: INDICATEUR_X,
      geoOptions: [],
      form: {
        observation_end: OBSERVATION_END,
        observation_start: OBSERVATION_START,
      },
      fluxPredefinedControl: null,
      dateRangeObservation: {
        startDate: new Date(OBSERVATION_START),
        endDate: new Date(OBSERVATION_END),
      },
      Observation_max_date: new Date(FLUX_LAST_UPDATE),
    };
  },
  filters: {
    date: (val) => {
      return val ? moment(val).format("DD.MM.YYYY") : "";
    },
  },
  computed: {
    ...mapState({
      formErrors: (state) => state.indicator.formErrors,
    }),
  },
  watch: {
    fluxZones() {
      this.form.geoGranularity = 2;
      this.geoGranularityChange(2);
    },
  },
  mounted() {
    this.form.geoGranularity = 2;
    this.geoGranularityChange(2);
  },
  methods: {
    ...mapActions(["submitFilters"]),
    submit() {
      this.submitFilters(this.form);
    },
    predefinedInputChange(value) {
      if (!value) return;

      let observation_end = null,
        observation_start = null,
        x = null,
        y = null,
        geoGranularity = null;
      let geoOptions = ["Gombe"];

      switch (value) {
        case 1:
          observation_end = "2020-03-28";
          observation_start = "2020-03-19";
          x = 1;
          y = 1;
          geoGranularity = 2;
          break;
        case 2:
          observation_end = this.moment().format(DATEFORMAT);
          observation_start = "2020-03-19";
          x = 1;
          y = 1;
          geoGranularity = 2;
          break;
        default:
          break;
      }
      this.geoGranularityChange(geoGranularity);
      this.form = {
        geoOptions,
        observation_end,
        observation_start,
        x,
        y,
        geoGranularity,
      };
      this.dateRangeObservation = {
        startDate: new Date(this.form.observation_start),
        endDate: new Date(this.form.observation_end),
      };
      this.submitFilters(this.form);
    },
    geoGranularityChange(value) {
      // this.setFluxGeoGranularity(value);
      if (value != 2) this.resetFluxPredefinedControl();

      this.form.geoOptions = [];
      if (value == 1) {
        this.geoOptions = this.fluxProvinces;
      } else {
        this.geoOptions = this.fluxZones;
      }
    },
    UpdateObservationDate({ startDate, endDate }) {
      this.form.observation_start = moment(startDate).format("YYYY/MM/DD");
      this.form.observation_end = moment(endDate).format("YYYY/MM/DD");
      this.resetFluxPredefinedControl();
    },
    clearObservationDate() {
      this.dateRangeObservation = { startDate: null, endDate: null };
      this.form.observation_start = null;
      this.form.observation_end = null;
      this.resetFluxPredefinedControl();
    },
    dateRangerPosition(dropdownList, component, { width, top, left, right }) {
      dropdownList.style.top = `${top}px`;
      dropdownList.style.left = `${left}px`;
    },
    resetFluxPredefinedControl() {
      this.fluxPredefinedControl = null;
    },
    filtredDate(value) {
      return this.$options.filters.date(value);
    },
  },
};
</script>

<style lang="scss" scoped>
.btn-submit {
  font-size: 14px;
}
.btn-clear-observation {
  height: 32px;
  margin-left: 5px;
  display: flex;
  align-items: center;
}
</style>
