<template>
  <b-card no-body class="rounded-0 p-2">
    <b-form class="flux-form mb-2" @submit.prevent="submit">
      <b-form-row class="d-flex justify-content-between ml-1 mr-5">
        <b-col lg="5" cols="5" md="4" class="col-5 nav-zone pl-3 pr-3">
          <b-form-group cols="5">
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
        <b-col cols="12" md="5" lg="5" class="col-5 nav-zone pl-3 pr-3">
          <label for class="text-dash-color">Paramètres Temporels</label>
          <div class="d-flex">
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
                  @select="SelectObservation"
                  :calculate-position="dateRangerPosition"
                  class="style-picker"
                >
                  <div slot="header" slot-scope="" class="slot p-2">
                    <div
                      style=""
                      class="d-flex justify-content-between mb-2 mt-2"
                    >
                      <a
                        @click="activeStartDate()"
                        class="btn btn-sm btn-daterange p-2"
                        >{{
                          iconStateDatePicker == "fa fa-times"
                            ? selectedDate.observation_start
                            : "Date début"
                        }}
                       <i :class="iconStateDatePicker"></i></a>
                      <a class="btn btn-sm btn-daterange p-2">{{
                        selectedDate.observation_end
                      }}</a>
                    </div>
                  </div>
                  <template v-slot:input>
                    <span v-if="checked">
                      {{ selectedDate.observation_start | date }} -
                      {{ selectedDate.observation_end | date }}</span
                    >
                    <span v-else>
                      {{ selectedDate.observation_end | date}}
                    </span>
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
/* eslint-disable space-before-blocks */
/* eslint-disable no-unneeded-ternary */
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
        observation_start: new Date(),
        township: 0,
      },
      selectedDate: {
        observation_end: moment().format("YYYY-MM-DD"),
        observation_start: moment().format("YYYY-MM-DD"),
      },
      selected: false,
      dateRangeObservation: {
        endDate: moment().format("YYYY-MM-DD"),
        startDate: moment().format("YYYY-MM-DD"),
      },
      min_date: new Date(),
      defaultTownship: [{ id: 0, name: "Tous" }],
      hospitals: [],
      checked: false,
      iconStateDatePicker: "fas fa-thin fa-plus",
      isUpdate: false,
    };
  },
  filters: {
    date: (val) => {
      return val ? moment(val).format("DD.MM.YYYY") : "null";
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
    setDate() {
      console.log("this.dateRangeObservation.observation_end", this.dateRangeObservation.observation_end)
      return !this.dateRangeObservation.observation_end == "null" ? this.selectedDate.observation_end : this.dateRangeObservation.observation_end;
    },
  },
  methods: {
    ...mapActions(["getObservation"]),
    hospitalToggle(checked) {
      this.$emit("hopitalChecked", checked);
    },
    activeStartDate() {
      this.checked = this.checked ? false : true;
      this.iconStateDatePicker =
        this.iconStateDatePicker == "fas fa-thin fa-plus"
          ? "fa fa-times"
          : "fas fa-thin fa-plus";
    },
    SelectObservation({ startDate, endDate }) {
      this.selectedDate.observation_start =
        moment(startDate).format("YYYY-MM-DD");
      this.selectedDate.observation_end = moment(endDate).format("YYYY-MM-DD");
      
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
.btn-daterange {
  background-color: #f4f5fc;
  font-size: 16px;
}
</style>
