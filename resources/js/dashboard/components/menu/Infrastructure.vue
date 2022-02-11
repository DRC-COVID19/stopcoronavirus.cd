<template>
  <b-card no-body class="rounded-0 p-2">
    <b-form class="flux-form mb-2" @submit.prevent="submit">
      <b-form-row class="d-flex justify-content-between ml-1 mr-5">
        <b-col cols="12" md="4" class="nav-zone pl-3 pr-3">
          <b-form-group>
            <label for class="text-dash-color">Commune</label>
            <v-select
              v-model="form.township"
              :options="townshipList"
              label="name"
              placeholder="Commune"
              :reduce="(item) => item.id"
              class="style-chooser"
            />
          </b-form-group>
        </b-col>
        <b-col cols="12" md="5" lg="4" class="nav-zone pl-3 pr-3">
          <label for class="text-dash-color">Paramètres Temporels</label>
          <div class=" d-flex ">
            <b-form-group class="col-auto" v-slot="{ ariaDescribedby }">
              <b-form-checkbox
                v-model="checked"
                class="text-dash-color"
                :aria-describedby="ariaDescribedby"
                :value="stateCheckedButton"
                >Plage de date</b-form-checkbox
              >
            </b-form-group>
            <b-form-group class="col">
              <div class="d-flex">
                <date-range-picker
                  ref="picker2"
                  :locale-data="{
                    firstDay: 1,
                    format: 'dd-mm-yyyy',
                    drops: 'up',
                  }"
                  v-model="dateRangeObservation"
                  :appendToBody="true"
                  opens="center"
                  :max-date="new Date()"
                  :singleDatePicker="checked ? false : true"
                  @update="UpdateObservationDate"
                  :calculate-position="dateRangerPosition"
                  class="style-picker"
                >
                  <template v-slot:input="picker">
                    <span>
                      {{ picker.startDate | date }} -
                      {{ picker.endDate | date }}</span
                    >
                  </template>
                  <template #date="data">
                    <span class="small">{{ data.date | dateCell }}</span>
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
          </div>
        </b-col>

        <b-col
          cols="12"
          md="3"
          lg="2"
          class="pl-3 pr-3 d-flex text-right justify-content-end"
          style="border"
          :class="{ row: !isSmOrMd }"
        >
          <b-button type="submit" block class="btn-submit mt-2 btn-dash-blue"
            >Filtrer les données</b-button
          >
        </b-col>
      </b-form-row>
    </b-form>
  </b-card>
</template>

<script>
import DateRangePicker from "vue2-daterange-picker";
import { INFRASTRUCTURE_FIRST_UPDATE, DATEFORMAT } from "../../config/env";
import { mapState, mapActions } from "vuex";
export default {
  props: {
    hospitalCount: {
      type: Number,
      default: null,
    },
    townships: {
      type: Array,
      default: () => [],
    },
  },
  components: {
    DateRangePicker,
  },
  data() {
    return {
      form: {
        observation_end: moment().format("YYYY-MM-DD"),
        observation_start: null,
        township: 0,
      },
      selected: false,
      dateRangeObservation: {
        startDate: null,
        endDate: new Date(),
      },
      min_date: null,
      defaultTownship: [{ id: 0, name: "Tous" }],
      hospitals: [],
      checked: false,
    };
  },
  filters: {
    date: (val) => {
      return val ? moment(val).format("DD.MM.YYYY") : "";
    },
  },
  computed: {
    ...mapState({
      observation_start: (state) => state.hospitalSituation.observation_start,
      observation_end: (state) => state.hospitalSituation.observation_end,
    }),
    townshipList() {
      return [...this.defaultTownship, ...this.townships];
    },
    stateCheckedButton() {
      return this.checked ? false : true;
    },
  },
  methods: {
    ...mapActions(["getObservation"]),
    hospitalToggle(checked) {
      this.$emit("hopitalChecked", checked);
    },
    UpdateObservationDate({ startDate, endDate }) {
      if (!this.checked) {
        this.form.observation_start = null;
        this.form.observation_end = moment(endDate).format("YYYY-MM-DD");
      } else {
        this.form.observation_start = moment(startDate).format("YYYY-MM-DD");
        this.form.observation_end = moment(endDate).format("YYYY-MM-DD");
      }
    },
    dateRangerPosition(dropdownList, component, { width, top, left, right }) {
      dropdownList.style.top = `${top}px`;
      dropdownList.style.left = `${left + 180}px`;
    },
    clearObservationDate() {
      this.dateRangeObservation = { startDate: null, endDate: null };
      this.form.observation_end = null;
      this.form.observation_start = null;
    },
    submit() {
      const observations = {
        observation_start: this.form.observation_start,
        observation_end: this.form.observation_end,
      };
      this.getObservation(observations);

      console.log("observation_end", this.observation_end);
      console.log("observation_start", this.observation_start);

      this.$emit("submitInfrastructureForm", this.form);
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
