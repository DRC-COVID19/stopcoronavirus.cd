<template>
  <b-row class="mx-0 px-0 w-100 " lg="12">
    <b-col class="mx-0 w-100" lg="2">
      <label for class="text-dash-color">Formulaire :</label>
      <v-select
        v-model="chart.form"
        label="name"
        placeholder="Sélectionner un formulaire"
        class="style-chooser"
    /></b-col>
    <b-col class="mx-0 w-100" lg="2">
      <label for class="text-dash-color">Hôpitaux :</label>
      <v-select
        v-model="chart.form"
        label="name"
        placeholder="Sélectionner des hôpitaux"
        class="style-chooser"
    /></b-col>
    <b-col class="mx-0 w-100" lg="2">
      <label for class="text-dash-color">Indicateurs :</label>
      <v-select
        v-model="chart.form"
        label="name"
        placeholder="Sélectionner des indicateurs"
        class="style-chooser"
    /></b-col>
    <b-col class="mx-0 w-100" lg="2">
      <label for class="text-dash-color">Opération :</label>
      <v-select
        v-model="chart.form"
        label="name"
        placeholder="Choisir  une opération"
        class="style-chooser"
    /></b-col>
    <b-col lg="2" class="mx-0 w-100">
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
    <b-col class="d-flex mx-0 w-100 align-item-center h-100" lg="2">
      <b-button type="submit" block class="btn-submit btn-dash-blue"
        ><small>Générer le graphique</small>
      </b-button></b-col
    >
  </b-row>
</template>
<script>
export default {
  name: 'HeaderReporting',
  data () {
    return {
      isRanged: false,
      dateRange: this.isRanged
        ? {
            start: new Date(),
            end: new Date()
          }
        : new Date(),
      chart: {
        form: null
      },
      iconStateDatePicker: 'fas fa-thin fa-plus'
    }
  },
  methods: {
    activeStartDate () {
      this.isRanged = !this.isRanged
      this.mode = this.mode === 'date' ? 'range' : 'date'
      this.iconStateDatePicker =
        this.iconStateDatePicker === 'fas fa-thin fa-plus'
          ? 'fa fa-times'
          : 'fas fa-thin fa-plus'

      if (this.isRanged) {
        this.dateRange.start =
          this.form.observation_end == null
            ? new Date()
            : this.form.observation_end
        this.dateRange.end = new Date()

        this.form.observation_start = this.dateRange.start
        this.form.observation_end = new Date()
      } else {
        this.dateRange =
          this.form.observation_end == null
            ? new Date()
            : this.form.observation_end
        this.form.observation_start = null
      }
      this.attributes[0] = {
        key: 'today',
        dates: this.isRanged
          ? { start: this.dateRange.start, end: this.dateRange.end }
          : this.dateRange,
        highlight: true
      }
    },
    onRangeDateObservation (inputValueDate) {},
    clearObservationDate () {
      this.dateRange = new Date()
      this.isRanged = false
    }
  }
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
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
</style>
