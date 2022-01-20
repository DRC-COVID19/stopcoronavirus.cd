<template>
  <b-card no-body class="rounded-0 p-2">
    <b-form class="flux-form mb-2" @submit.prevent="submit">
      <b-form-row>
        <b-col cols="12" md="4" class="nav-zone pl-3 pr-3">
          <b-form-group>
            <label for class="text-dash-color">Séléctionner un CTCO</label>
            <v-select
              v-model="form.hospital"
              :options="hospitalList"
              label="name"
              placeholder="CTO"
              :reduce="(item) => item.id"
              class="style-chooser"
            />
          </b-form-group>
        </b-col>

        <b-col cols="12" md="5" lg="4" class="nav-zone pl-3 pr-3">
          <label for class="text-dash-color">Paramètres Temporels</label>
          <b-form-group>
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
                :singleDatePicker="false"
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

        <b-col cols="12" md="3" lg="2" class="pl-3 pr-3 d-flex" :class="{ row: !isSmOrMd }">
          <b-button type="submit" block class="btn-submit mt-2 btn-dash-blue"
            >Filtrer les données</b-button
          >
        </b-col>
      </b-form-row>
    </b-form>
  </b-card>
</template>

<script>
import DateRangePicker from 'vue2-daterange-picker'
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
    },
    hospitals: {
      type: Array,
      default: () => []
    }
  },
  components: {
    DateRangePicker
  },
  data () {
    return {
      form: {
        observation_end: moment().format('YYYY-MM-DD'),
        observation_start: INFRASTRUCTURE_FIRST_UPDATE,
        township: 0,
        hospital: 0
      },
      dateRangeObservation: {
        startDate: new Date(INFRASTRUCTURE_FIRST_UPDATE),
        endDate: new Date()
      },
      min_date: new Date(INFRASTRUCTURE_FIRST_UPDATE),
      defaultTownship: [{ id: 0, name: 'Tous' }],
      defaultHospitals: [{ id: 0, name: 'Tous' }]
    }
  },
  filters: {
    date: (val) => {
      return val ? moment(val).format('DD.MM.YYYY') : ''
    }
  },
  methods: {
    hospitalToggle (checked) {
      this.$emit('hopitalChecked', checked)
    },
    UpdateObservationDate ({ startDate, endDate }) {
      this.form.observation_start = moment(startDate).format('YYYY-MM-DD')
      this.form.observation_end = moment(endDate).format('YYYY-MM-DD')
    },
    dateRangerPosition (dropdownList, component, { width, top, left, right }) {
      dropdownList.style.top = `${top}px`
      dropdownList.style.left = `${left + 180}px`
    },
    clearObservationDate () {
      this.dateRangeObservation = { startDate: null, endDate: null }
      this.form.observation_end = null
      this.form.observation_start = null
    },
    submit () {
      this.$emit('submitInfrastructureForm', this.form)
    }
  },
  computed: {
    townshipList () {
      return [...this.defaultTownship, ...this.townships]
    },
     hospitalList () {
      return [...this.defaultHospitals, ...this.hospitals]
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
</style>
