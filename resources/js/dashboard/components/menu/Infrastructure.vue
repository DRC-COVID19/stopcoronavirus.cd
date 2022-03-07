<template>
  <b-card no-body class="rounded-0 p-2">
    <b-form class="flux-form mb-2" @submit.prevent="submit">
      <b-form-row class="d-flex justify-content-between ml-0 mr-0">
        <b-col lg="5" cols="5" md="4" class="col-5 nav-zone pl-3 pr-3">
          <b-form-group>
            <label for class="text-dash-color">Commune</label>
            <v-select
              v-model="form.township"
              :options="townshipList"
              :reduce="(item) => item.id"
              label="name"
              placeholder="Commune"
              class="style-chooser"
              @input="formTownshipChanged"
            />
          </b-form-group>
        </b-col>
        <b-col
          cols="12"
          md="4"
          lg="4"
          class="col-5 nav-zone pl-3 pr-3 justify-content-center"
        >
          <label for class="text-dash-color">Paramètres Temporels</label>
          <div class="d-flex" md="4" lg="4">
            <b-form-group class="col" lg="4">
              <div class="d-flex justify-content-around">
                <!-- <date-range-picker
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
                  :singleDatePicker="checkedRangeDatePicker ? false : true"
                  @update="updateObservationDate"
                  @select="selectObservation"
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
                        <i :class="iconStateDatePicker"></i
                      ></a>
                      <a class="btn btn-sm btn-daterange p-2">{{
                        selectedDate.observation_end
                      }}</a>
                    </div>
                  </div>
                  <template v-slot:input>
                    <span v-if="checkedRangeDatePicker">
                      {{ selectedDate.observation_start | date }} -
                      {{ selectedDate.observation_end | date }}</span
                    >
                    <span v-else>
                      {{ selectedDate.observation_end | date }}
                    </span>
                  </template>
                </date-range-picker> -->
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
                  :select-attributes="attributes"
                  popover.keepVisibleOnInput
                >
                  <template v-slot="{ inputEvents }">
                    <div
                      class="
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
            </b-form-group>
          </div>
        </b-col>

        <b-col
          cols="12"
          md="3"
          lg="3"
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
import { INFRASTRUCTURE_FIRST_UPDATE, DATEFORMAT } from '../../config/env'
import { mapState, mapActions } from 'vuex'

export default {
  props: {
    hospitalCount: {
      type: Number,
      default: null
    },
    townships: {
      type: Array,
      default: () => []
    }
  },
  data () {
    return {
      form: {
        observation_end: null,
        observation_start: null,
        township: 0
      },
      mode: 'date',
      isRanged: false,
      dateRange: this.isRanged
        ? {
            start: new Date(),
            end: new Date()
          }
        : new Date(),
      attributes: [
        {
          highlight: true,
          dates: {}
        }
      ],
      defaultTownship: [{ id: 0, name: 'Tous' }],
      hospitals: [],
      iconStateDatePicker: 'fas fa-thin fa-plus',
      isUpdate: false
    }
  },
  mounted () {
    this.fillParametersFromUrlParams()
    this.attributes.dates = this.dateRange
  },
  filters: {
    date: (val) => {
      return val ? moment(val).format('DD.MM.YYYY') : ''
    }
  },
  computed: {
    ...mapState({
      observation_start: (state) => state.hospitalSituation.observation_start,
      observation_end: (state) => state.hospitalSituation.observation_end,
      activeMenu: (state) => state.nav.activeMenu
    }),
    townshipList () {
      return [...this.defaultTownship, ...this.townships]
    },
    ...mapState({})
  },
  methods: {
    ...mapActions(['getObservation']),
    hospitalToggle (checked) {
      this.$emit('hopitalChecked', checked)
    },
    activeStartDate () {
      this.isRanged = !this.isRanged
      this.mode = this.mode === 'date' ? 'range' : 'date'
      this.iconStateDatePicker =
        this.iconStateDatePicker == 'fas fa-thin fa-plus'
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
            : (this.form.observation_end)
        this.form.observation_start = null
      }
      this.attributes.dates = this.dateRange
    },
    onRangeDateObservation (inputValueDate) {
      if (this.isRanged) {
        this.form.observation_start = moment(inputValueDate.start).format(
          'YYYY-MM-DD'
        )
        this.dateRange.start = inputValueDate.start
        this.form.observation_end = moment(inputValueDate.end).format(
          'YYYY-MM-DD'
        )
        this.dateRange.end = inputValueDate.end
      } else {
        this.form.observation_start = null
        this.dateRange = inputValueDate
        this.form.observation_end = moment(inputValueDate).format('YYYY-MM-DD')
        console.log('dateRange', this.dateRange)
      }
      this.attributes.dates = this.dateRange
    },
    // dateRangerPosition(dropdownList, component, { width, top, left, right }) {
    //   dropdownList.style.top = `${top}px`;
    //   dropdownList.style.left = `${left + 180}px`;
    // },
    clearObservationDate () {
      this.dateRange = { start: null, end: null }
      this.form.observation_end = null
      this.form.observation_start = null
    },
    submit () {
      this.form.observation_end =
        this.form.observation_end === null
          ? moment().format('YYYY-MM-DD')
          : moment(this.form.observation_end).format('YYYY-MM-DD')
      this.getObservation(this.form)
      console.log(this.form)

      this.$emit('submitInfrastructureForm', this.form)
    },
    addParamToUrlWhenInThisMenu (param, value) {
      if (this.activeMenu == 5) {
        this.addParamToUrl(param, value)
      }
    },
    formTownshipChanged (value) {
      this.addParamToUrlWhenInThisMenu('township', value)
    },
    fillParametersFromUrlParams () {
      const url = new URL(window.location.href)
      const township = url.searchParams.get('township')
      if (township) {
        this.$set(this.form, 'township', +township)
      }

      const checkedRangeDatePicker = url.searchParams.get('range')
      if (checkedRangeDatePicker) {
        this.isRanged =
          checkedRangeDatePicker != 1 ? false : true
        // if (this.checkedRangeDatePicker) {
        //   this.iconStateDatePicker = "fa fa-times";
        // }
      }

      const observationStartDate = url.searchParams.get(
        'observation-start-date'
      )
      const observationEndDate = url.searchParams.get('observation-end-date')
      try {
        console.log('observationStartDate', observationStartDate)
        if (this.isRanged) {
          this.dateRange.start = observationStartDate ? new Date(observationStartDate) : new Date()
          this.dateRange.end = observationEndDate ? new Date(observationEndDate) : this.dateRange.start
        } else {
          this.dateRange = observationEndDate ? new Date(observationEndDate) : new Date()
        }

        // if (this.dateRangeObservation.startDate) {
        //   this.selectedDate.observation_start = moment(
        //     this.dateRangeObservation.startDate
        //   ).format('YYYY-MM-DD')
        // }
        // if (this.dateRangeObservation.endDate) {
        //   this.selectedDate.observation_end = moment(
        //     this.dateRangeObservation.endDate
        //   ).format('YYYY-MM-DD')
        // }

        this.form.observation_start = observationStartDate
        this.form.observation_end = observationEndDate
      } catch (e) {
        console.log(e)
      }
    },
    addDateRangeObservationToUrl () {
      if (this.isRanged) {
        if (this.dateRange.start) {
          this.addParamToUrlWhenInThisMenu(
            'observation-start-date',
            moment(this.dateRange.start).format('YYYY/MM/DD')
          )
        } else {
          this.addParamToUrlWhenInThisMenu('observation-start-date', null)
        }
        if (this.dateRange.end) {
          this.addParamToUrlWhenInThisMenu(
            'observation-end-date',
            moment(this.dateRange.end).format('YYYY/MM/DD')
          )
        } else {
          this.addParamToUrlWhenInThisMenu('observation-end-date', null)
        }
      } else {
        if (this.dateRange) {
          this.addParamToUrlWhenInThisMenu(
            'observation-end-date',
            moment(this.dateRange).format('YYYY/MM/DD')
          )
        } else {
          this.addParamToUrlWhenInThisMenu('observation-end-date', null)
        }
        this.addParamToUrlWhenInThisMenu('observation-start-date', null)
      }
    }
  },
  watch: {
    dateRange () {
      this.addDateRangeObservationToUrl()
    },
    isRanged (value) {
      this.addParamToUrlWhenInThisMenu('range', value ? 1 : 0)
    }
  }
}
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
