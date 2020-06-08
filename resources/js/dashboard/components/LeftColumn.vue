<template>
  <b-container class="column-left col-md-3">
    <b-row class="mb-3">
      <b-col cols="12">
        <b-card no-body>
          <b-card-header>
            <b-form-checkbox class="styled-checkbox" name="covid_case" @change="covidCaseToggle">
              Cas covid-19
              <b-badge v-if="covidCasesCount">{{covidCasesCount}}</b-badge>
            </b-form-checkbox>
          </b-card-header>
        </b-card>
      </b-col>
    </b-row>

    <b-row class="mb-3">
      <b-col cols="12">
        <b-card>
          <b-form-checkbox class="styled-checkbox" name="list_hospital" @change="hospitalToggle">
            Liste hôpitaux
            <b-badge v-if="hospitalCount">{{hospitalCount}}</b-badge>
          </b-form-checkbox>
        </b-card>
      </b-col>
    </b-row>
    <b-row class="mb-3">
      <b-col cols="12">
        <b-card no-body>
          <b-card-header>
            <b-form-checkbox
              v-model="orientationChecked"
              @change="medicalOrientationToggle"
              class="styled-checkbox"
              name="medical_orientation"
            >
              Cas probable (issu du formulaire d'orientation médical)
              <b-badge v-if="orientationCount">{{orientationCount}}</b-badge>
            </b-form-checkbox>
          </b-card-header>
          <b-collapse id="orientation_result_collapse">
            <b-card-body>
              <v-select
                name="orientation_result"
                v-model="orientationSelected"
                :disable="orientationChecked"
                :options="OrientationLIst"
                label="name"
                :reduce="item=>item.id"
                @input="orientationChange"
              />
              <h4>Legende</h4>
              <div class="legende">
                <div>
                  <span class="fin-8 legende-color"></span>
                  <span>Peu probale</span>
                  <b-badge v-if="fin8Count">{{fin8Count}}</b-badge>
                </div>
                <div>
                  <span class="fin legende-color"></span>
                  <span>Probable</span>
                  <b-badge v-if="finCount">{{finCount}}</b-badge>
                </div>
                <div>
                  <span class="fin-5 legende-color"></span>
                  <span>Très probable</span>
                  <b-badge v-if="fin5Count">{{fin5Count}}</b-badge>
                </div>
                <div class="d-block text-right">
                  <a href="#" target="_blank">Voir formulaire</a>
                </div>
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
      </b-col>
    </b-row>
    <b-row class="mb-3">
      <b-col cols="12">
        <b-card no-body>
          <b-card-header>
            <b-form-checkbox @change="hasSondageToggle" class="styled-checkbox" name="has_sondage">
              Sondages
              <span></span>
            </b-form-checkbox>
          </b-card-header>
          <b-collapse id="has_sondage_collapse">
            <b-card-body id="sondage-item">
              <div>
                <span>Legendes réponses</span>
                <ul class="sondage-ul">
                  <li>
                    <div class="sondage-yes"></div>
                    <span>Oui</span>
                  </li>
                  <li>
                    <div class="sondage-no"></div>
                    <span>Non</span>
                  </li>
                </ul>
              </div>
              <b-form-checkbox
                class="styled-checkbox mb-2"
                name="worried"
                id="worried"
                @change="worriedToggle"
              >A quel point cela vous inquiète ?</b-form-checkbox>
              <b-form-checkbox
                class="styled-checkbox mb-2"
                name="catch_virus"
                id="catch_virus"
                @change="catchVirusToggle"
              >Est-ce que vous pensez que vous pourriez attraper le virus ?</b-form-checkbox>
              <b-form-checkbox
                class="styled-checkbox mb-3"
                name="price_increase"
                id="price_increase"
                @change="price_increaseToggle"
              >Constatent une augmentation des prix des denrées essentielles</b-form-checkbox>
              <div class="group-control mb-3">
                <label>Quels sont les denrées que vous avez du mal à trouver?</label>
              </div>
              <b-form-checkbox
                class="styled-checkbox mb-2"
                name="mask"
                id="mask"
                @change="maskToggle"
              >Masque</b-form-checkbox>

              <b-form-checkbox
                class="styled-checkbox mb-2"
                name="makala"
                id="makala"
                @change="makalaToggle"
              >Makala</b-form-checkbox>
              <b-form-checkbox
                class="styled-checkbox mb-2"
                name="flour"
                id="flour"
                @change="flourToggle"
              >Farine</b-form-checkbox>
              <b-form-checkbox
                class="styled-checkbox mb-2"
                name="antibacterial_gel"
                id="antibacterial_gel"
                @change="antibacterial_gelToggle"
              >Gel antibactérien</b-form-checkbox>
            </b-card-body>
          </b-collapse>
        </b-card>
      </b-col>
    </b-row>
    <b-row>
      <b-col cols="12">
        <b-card no-body>
          <b-card-header>
            <b-form-checkbox
              @change="populationFluxToggle"
              class="styled-checkbox"
              name="has_sondage"
            >Mouvement populations</b-form-checkbox>
          </b-card-header>
          <b-collapse id="populationFluxcollapse">
            <b-card-body>
              <b-form class="flux-form">
                <h4>Selectionnez zones</h4>
                <div>
                  <b-form-group>
                    <b-form-radio name="filter" v-model="fluxForm.filter" value="filter_1">FIltre 1</b-form-radio>
                  </b-form-group>
                  <b-list-group :class="{'disabled':fluxForm.filter!='filter_1'}">
                    <b-list-group-item>
                      <b-form-input placeholder="Filtre" />
                    </b-list-group-item>
                    <b-list-group-item class="checkbox-zone-group">
                      
                      <b-form-checkbox-group
                        v-model="fluxForm.filter_zone"
                        :options="fluxZones"
                        value-field="origin"
                        text-field="origin"
                        name="flavour-1"
                        stacked
                        :invalid-feedback="flux24Errors.filter_zone ? flux24Errors.filter_zone[0] : null"
                        :state="flux24Errors.filter_zone && flux24Errors.filter_zone.lenght>0"
                      ></b-form-checkbox-group>
                    </b-list-group-item>
                  </b-list-group>
                </div>
                <div>
                  <b-form-group>
                    <b-form-radio class="mt-2" name="filter" v-model="fluxForm.filter" value="filter_2">FIltre 2</b-form-radio>
                  </b-form-group>
                  <b-list-group :class="{'disabled':fluxForm.filter!='filter_2'}">
                    <b-list-group-item>
                      <b-form-group
                        :invalid-feedback="flux24Errors.origin ? flux24Errors.origin[0] : null"
                        :state="flux24Errors.origin && flux24Errors.origin.lenght>0"
                      >
                        <label for="origine">
                          Origine
                          <div class="legend-origin"></div>
                        </label>
                        <v-select
                          multiple
                          name="origine"
                          v-model="fluxForm.origin"
                          :options="fluxZones"
                          label="origin"
                          :reduce="item=>item.origin"
                        />
                      </b-form-group>
                      <b-form-group
                        :invalid-feedback="flux24Errors.destination ? flux24Errors.destination[0] : null"
                        :state="flux24Errors.destination && flux24Errors.destination.lenght>0"
                      >
                        <label for="destination">
                          Destination
                          <div class="legend-destination"></div>
                        </label>
                        <v-select
                          name="destination"
                          multiple
                          v-model="fluxForm.destination"
                          :options="fluxZones"
                          label="origin"
                          :reduce="item=>item.origin"
                        />
                      </b-form-group>
                    </b-list-group-item>
                  </b-list-group>
                </div>
                <hr />
                <div>
                  <h4>Choix périodes</h4>
                  <b-form-group
                    :invalid-feedback="flux24Errors.preference_start|| flux24Errors.preference_end ? `${flux24Errors.preference_start? flux24Errors.preference_start[0]:''} ${flux24Errors.preference_end?flux24Errors.preference_end[0]:''}` : null"
                    :state="(flux24Errors.preference_start && flux24Errors.preference_start.lenght>0)|| (flux24Errors.preference_end && flux24Errors.preference_end.lenght>0)"
                  >
                    <label>Période de référence</label>
                    <date-range-picker
                      ref="picker"
                      :locale-data="{ firstDay: 1, format: 'dd-mm-yyyy' }"
                      v-model="dateRangePreference"
                      :appendToBody="true"
                      opens="right"
                      :min-date="new Date('02/01/2020')"
                      @update="UpdatePreferenceDate"
                      :calculate-position="dateRangerPosition"
                    >
                      <template
                        v-slot:input="picker"
                      >{{ picker.startDate|date }} - {{ picker.endDate|date }}</template>
                    </date-range-picker>
                    <b-button @click="clearPrefenceDate">
                      <span class="fa fa-times"></span>
                    </b-button>
                  </b-form-group>
                  <b-form-group
                    :invalid-feedback="flux24Errors.observation_start|| flux24Errors.observation_end ? `${flux24Errors.observation_start?flux24Errors.observation_start[0]:''} ${flux24Errors.observation_end?flux24Errors.observation_end[0]:''}` : null"
                    :state="(flux24Errors.observation_start && flux24Errors.observation_start.lenght>0)|| (flux24Errors.observation_end && flux24Errors.observation_end.lenght>0)"
                  >
                    <label>Période d'observation</label>
                    <date-range-picker
                      ref="picker2"
                      :locale-data="{ 
                        firstDay: 1, 
                      format: 'dd-mm-yyyy', 
                      drops: 'up' }"
                      v-model="dateRangeObservation"
                      :appendToBody="true"
                      opens="right"
                      @update="UpdateObservationDate"
                      :calculate-position="dateRangerPosition"
                    >
                      <template
                        v-slot:input="picker"
                      >{{ picker.startDate|date }} - {{ picker.endDate|date }}</template>
                    </date-range-picker>
                    <b-button @click="clearObservationDate">
                      <span class="fa fa-times"></span>
                    </b-button>
                  </b-form-group>
                </div>
                <b-button @click="submitFluxForm" class="mt-2">Envoyer</b-button>
              </b-form>
            </b-card-body>
          </b-collapse>
        </b-card>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import DateRangePicker from "vue2-daterange-picker";
import moment from "moment";
import "vue2-daterange-picker/dist/vue2-daterange-picker.css";
export default {
  components: {
    DateRangePicker
  },
  props: {
    covidCasesCount: {
      type: Number,
      default: null
    },
    hospitalCount: {
      type: Number,
      default: null
    },
    orientationCount: {
      type: Number,
      default: null
    },
    finCount: {
      type: Number,
      default: null
    },
    fin8Count: {
      type: Number,
      default: null
    },
    fin5Count: {
      type: Number,
      default: null
    },
    fluxZones: {
      type: Array,
      default: []
    },
    flux24Errors: {
      type: Object,
      default: () => ({})
    }
  },
  data() {
    return {
      OrientationLIst: [
        {
          id: "ALL",
          name: "Tout"
        },
        {
          id: "FIN",
          name: "Probable"
        },
        {
          id: "FIN8",
          name: "Peu probable"
        },
        {
          id: "FIN5",
          name: "Très probable"
        }
      ],
      orientationChecked: false,
      orientationSelected: "ALL",
      dateRangePreference: {
        startDate: null,
        endDate: null
      },
      fluxForm: {},
      dateRangeObservation: {
        startDate: null,
        endDate: null
      }
    };
  },
  filters: {
    date: val => {
      return val ? moment(val).format("DD.MM.YYYY") : "";
    }
  },
  methods: {
    covidCaseToggle(checked) {
      this.$emit("covidCaseChecked", checked);
    },
    hospitalToggle(checked) {
      this.$emit("hopitalChecked", checked);
    },
    medicalOrientationToggle(checked) {
      this.$root.$emit("bv::toggle::collapse", "orientation_result_collapse");
      if (checked) {
        this.orientationSelected = "ALL";
      }
      this.$emit("medicalOrientationChecked", checked);
    },
    orientationChange(item) {
      this.$emit("medicalOrientationChanged", item);
    },
    hasSondageToggle(checked) {
      this.$root.$emit("bv::toggle::collapse", "has_sondage_collapse");
      this.$emit("hasSondageChecked", checked);
    },
    worriedToggle(checked) {
      this.$emit("worriedChecked", checked);
    },
    catchVirusToggle(checked) {
      this.$emit("catchVirusChecked", checked);
    },
    price_increaseToggle(checked) {
      this.$emit("priceIncreaseChecked", checked);
    },
    maskToggle(checked) {
      this.$emit("maskChecked", checked);
    },
    makalaToggle(checked) {
      this.$emit("makalaChecked", checked);
    },
    flourToggle(checked) {
      this.$emit("flourChecked", checked);
    },
    antibacterial_gelToggle(checked) {
      this.$emit("antiBacterialGelChecked", checked);
    },
    populationFluxToggle(checked) {
      this.$root.$emit("bv::toggle::collapse", "populationFluxcollapse");
    },
    UpdatePreferenceDate({ startDate, endDate }) {
      this.fluxForm.preference_start = moment(startDate).format("YYYY/MM/DD");
      this.fluxForm.preference_end = moment(endDate).format("YYYY/MM/DD");
    },
    UpdateObservationDate({ startDate, endDate }) {
      this.fluxForm.observation_start = moment(startDate).format("YYYY/MM/DD");
      this.fluxForm.observation_end = moment(endDate).format("YYYY/MM/DD");
    },
    submitFluxForm() {
      this.$emit("submitFluxForm", this.fluxForm);
    },
    dateRangerPosition(dropdownList, component, { width, top, left, right }) {
      dropdownList.style.top = `${top - 305}px`;
      dropdownList.style.left = `${210 + left}px`;
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
    }
  }
};
</script>

<style lang="scss" scoped>
.column-left {
  background: #14244f;
  padding-top: 15px;
  padding-bottom: 15px;
  overflow: auto;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  z-index: 2;
}
</style>