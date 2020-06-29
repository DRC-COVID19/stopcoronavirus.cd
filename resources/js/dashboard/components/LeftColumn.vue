<template>
  <b-container class="column-left col-md-3">
    <b-row class="mb-3">
      <b-col cols="12">
        <b-card>
          <b-form-checkbox class="styled-checkbox" name="covid_case" @change="covidCaseToggle">
            Situations épidemologique
            <b-badge v-if="covidCasesCount">{{covidCasesCount}}</b-badge>
          </b-form-checkbox>
        </b-card>
      </b-col>
    </b-row>
    <b-row class="mb-3">
      <b-col cols="12">
        <b-card>
          <b-form-checkbox
            @change="populationFluxToggle"
            class="styled-checkbox"
            name="has_sondage"
          >Mouvement populations</b-form-checkbox>

          <b-collapse id="populationFluxcollapse">
            <hr />
            <b-form class="flux-form" @submit.prevent="submitFluxForm">
              <h4>Filtres prédefinis</h4>

              <b-form-group>
                  <label for="" class="text-dash-color">Option</label>
                  <v-select @input="fluxPredefinedInputChanged" :options="fluxPredefinedInput" label="name" :reduce="item=>item.id" />
              </b-form-group>

              <h4>Paramètres détailés</h4>
              <div>
                <p>Géographiques</p>
                <b-form-group>
                  <label for="" class="text-dash-color">Granularité</label>
                  <v-select @input="fluxGeoGranularityChange" v-model="fluxForm.fluxGeoGranularity" :options="fluxGeoGranularities" label="name" :reduce="item=>item.id" />
                </b-form-group>
                <b-form-group
                  :invalid-feedback="flux24Errors.fluxGeoOptions ? flux24Errors.fluxGeoOptions[0] : null"
                  :state="flux24Errors.fluxGeoOptions && flux24Errors.fluxGeoOptions.lenght>0"
                >
                  <label for="" class="text-dash-color">Option</label>
                  <v-select v-model="fluxForm.fluxGeoOptions" multiple  :disabled="!fluxForm.fluxGeoGranularity" :options="fluxGeoOptions" label="origin" :reduce="item=>item.origin" />
                </b-form-group>
              <!--  <b-list-group :class="{'disabled':fluxForm.filter!='filter_1'}">
                  <b-list-group-item>
                    <b-form-input placeholder="Filtre" v-model="fluxFilterInput" />
                  </b-list-group-item>
                  <b-list-group-item class="checkbox-zone-group">
                    <b-form-checkbox
                      v-model="allZoneChecked"
                      :indeterminate.sync="allZoneCheckedIndeterminate"
                    >Sélectionnez tout</b-form-checkbox>
                    <hr />
                    <b-form-checkbox-group
                      v-model="fluxForm.filter_zone"
                      :options="fluxZonesArray"
                      value-field="origin"
                      text-field="origin"
                      name="flavour-1"
                      stacked
                      :invalid-feedback="flux24Errors.filter_zone ? flux24Errors.filter_zone[0] : null"
                      :state="flux24Errors.filter_zone && flux24Errors.filter_zone.lenght>0"
                    ></b-form-checkbox-group>
                  </b-list-group-item>
                </b-list-group> -->
              </div>
            <!--    <div class="mt-3">
                <b-form-group
                  :invalid-feedback="flux24Errors.filter_provinces ? flux24Errors.filter_provinces[0] : null"
                  :state="flux24Errors.filter_provinces && flux24Errors.filter_provinces.lenght>0"
                >
                  <b-form-radio
                    name="filter"
                    v-model="fluxForm.filter"
                    value="filter_3"
                  >Selectionnez provinces</b-form-radio>
                </b-form-group>

                <b-list-group :class="{'disabled':fluxForm.filter!='filter_3'}">
                  <b-list-group-item>
                    <b-form-input placeholder="Filtre" v-model="fluxFilterInputProvince" />
                  </b-list-group-item>
                  <b-list-group-item class="checkbox-zone-group">
                    <b-form-checkbox
                      v-model="allProvinceChecked"
                      :indeterminate.sync="allProvincesCheckedIndeterminate"
                    >Sélectionnez tout</b-form-checkbox>
                    <hr />
                    <b-form-checkbox-group
                      v-model="fluxForm.filter_provinces"
                      :options="fluxProvincesArray"
                      value-field="origin"
                      text-field="origin"
                      name="flavour-1"
                      stacked
                      :invalid-feedback="flux24Errors.filter_provinces ? flux24Errors.filter_provinces[0] : null"
                      :state="flux24Errors.filter_provinces && flux24Errors.filter_provinces.lenght>0"
                    ></b-form-checkbox-group>
                  </b-list-group-item>
                </b-list-group>
              </div>
             <div>
                  <b-form-group>
                    <b-form-radio
                      class="mt-3"
                      name="filter"
                      v-model="fluxForm.filter"
                      value="filter_2"
                    >FIltre 2</b-form-radio>
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
              </div>-->
            
              <div class="flux-move">
                
              <!--  <b-form-group
                  class="d-none"
                  :invalid-feedback="flux24Errors.preference_start|| flux24Errors.preference_end ? `${flux24Errors.preference_start? flux24Errors.preference_start[0]:''} ${flux24Errors.preference_end?flux24Errors.preference_end[0]:''}` : null"
                  :state="(flux24Errors.preference_start && flux24Errors.preference_start.lenght>0)|| (flux24Errors.preference_end && flux24Errors.preference_end.lenght>0)"
                >
                  <label>
                    Période de référence
                    <span class="legend-reference"></span>
                  </label>
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
                </b-form-group> -->
                <p>Temporaires</p>
                <b-form-group
                  :invalid-feedback="flux24Errors.observation_start|| flux24Errors.observation_end ? `${flux24Errors.observation_start?flux24Errors.observation_start[0]:''} ${flux24Errors.observation_end?flux24Errors.observation_end[0]:''}` : null"
                  :state="(flux24Errors.observation_start && flux24Errors.observation_start.lenght>0)|| (flux24Errors.observation_end && flux24Errors.observation_end.lenght>0)"
                >
                  <label class="text-dash-color">
                    Période d'observation
                    
                  </label>
                  <date-range-picker
                    ref="picker2"
                    :locale-data="{ 
                        firstDay: 1, 
                      format: 'dd-mm-yyyy', 
                      drops: 'up' }"
                    v-model="dateRangeObservation"
                    :appendToBody="true"
                    opens="right"
                    :min-date="new Date('03/19/2020')"
                    @update="UpdateObservationDate"
                    :calculate-position="dateRangerPosition"
                  >
                    <template
                      v-slot:input="picker"
                    >{{ picker.startDate|date }} - {{ picker.endDate|date }}</template>
                  </date-range-picker>
                  <b-button @click="clearObservationDate" class="btn-dash-blue">
                    <span class="fa fa-times"></span>
                  </b-button>
                </b-form-group>
                <b-form-group>
                  <label for="" class="text-dash-color">Granularité</label>
                  <v-select required v-model="fluxForm.fluxTimeGranularity" :options="fluxTimeGranularities" label="name" :reduce="item=>item.id" />
                </b-form-group>
              </div>
              <b-button type="submit" block  class="mt-2 btn-dash-blue">Filtrer les données</b-button>
            </b-form>
          </b-collapse>
        </b-card>
      </b-col>
    </b-row>

    <b-row class="mb-3">
      <b-col cols="12">
        <b-card>
          <b-form-checkbox class="styled-checkbox" name="list_hospital" @change="hospitalToggle">
            Infrastructure médicales
            <b-badge v-if="hospitalCount">{{hospitalCount}}</b-badge>
          </b-form-checkbox>
        </b-card>
      </b-col>
    </b-row>
    <b-row class="mb-3">
      <b-col cols="12">
        <b-card>
          <b-form-checkbox
            v-model="orientationChecked"
            @change="medicalOrientationToggle"
            class="styled-checkbox"
            name="medical_orientation"
          >
            Cas probable (issu du formulaire d'orientation médical)
            <b-badge v-if="orientationCount">{{orientationCount}}</b-badge>
          </b-form-checkbox>
          <b-collapse id="orientation_result_collapse">
            <hr />
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
          </b-collapse>
        </b-card>
      </b-col>
    </b-row>
    <!--<b-row class="mb-3">
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
    </b-row>-->
  </b-container>
</template>

<script>
import DateRangePicker from "vue2-daterange-picker";
import moment from "moment";
import {mapMutations} from 'vuex';
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
        startDate: new Date("02/18/2020"),
        endDate: new Date("03/18/2020")
      },
      fluxForm: {
        preference_start: "2020-02-18",
        preference_end: "2020-03-18"
      },
      dateRangeObservation: {
        startDate: null,
        endDate: null
      },
      fluxPredefinedInput:[
        {
          id:1,
          name:"Aujourd'hui"
        },
        {
          id:2,
          name:"Semaine en cours"
        },
        {
          id:3,
          name:"Mois en cours"
        },
        {
          id:4,
          name:"Mois passé"
        },
        {
          id:5,
          name:"Depuis le début du confinement"
        }
      ],
      fluxFilterInput: "",
      fluxFilterInputProvince: "",
      fluxZonesArray: [],
      fluxProvincesArray: [],
      fluxGeoGranularity:null,
      fluxGeoGranularities:[
        {
          id:1,
          name:'Provinces'
        },
        {
          id:2,
          name:'Zones des santés'
        }
      ],
      fluxGeoOptions:[],
      fluxTimeGranularities:[
        {
          id:1,
          name:'24h'
        },
        {
          id:2,
          name:"30'"
        },
      ],
      fluxTimeGranularity:null,
      allZoneChecked: false,
      allProvinceChecked: false,
      allZoneCheckedIndeterminate: false,
      allProvincesCheckedIndeterminate: false
    };
  },

  filters: {
    date: val => {
      return val ? moment(val).format("DD.MM.YYYY") : "";
    }
  },
  watch: {
    allZoneChecked() {
      if (this.allZoneChecked) {
        this.fluxForm.filter_zone = this.fluxZones.map(x => x.origin);
      } else {
        this.fluxForm.filter_zone = [];
      }
    },
    allProvinceChecked() {
      if (this.allProvinceChecked) {
        this.fluxForm.filter_provinces = this.fluxProvinces.map(x => x.origin);
      } else {
        this.fluxForm.filter_provinces = [];
      }
    },
    "fluxForm.filter_zone"() {
      if (
        this.fluxForm.filter_zone &&
        this.fluxForm.filter_zone.length > 0 &&
        this.fluxForm.filter_zone.length != this.fluxZones.length
      ) {
        this.allZoneCheckedIndeterminate = true;
      } else {
        this.allZoneCheckedIndeterminate = false;
      }
    },
    "fluxForm.filter_provinces"() {
      if (
        this.fluxForm.filter_provinces &&
        this.fluxForm.filter_provinces.length > 0 &&
        this.fluxForm.filter_provinces.length != this.fluxProvinces.length
      ) {
        this.allProvincesCheckedIndeterminate = true;
      } else {
        this.allProvincesCheckedIndeterminate = false;
      }
    },
    "fluxForm.filter"() {
      this.fluxForm.origin = null;
      this.fluxForm.destination = null;
      this.fluxForm.filter_provinces = [];
      this.fluxFilterInputProvince = "";
      this.fluxForm.filter_zone = [];
      this.fluxFilterInput = "";
    },
    fluxZones() {
      this.fluxZonesArray = this.fluxZones;
    },
    fluxProvinces() {
      this.fluxProvincesArray = this.fluxProvinces;
    },
    fluxFilterInput() {
      this.fluxZonesArray = this.fluxZones.filter(x =>
        x.origin.toUpperCase().startsWith(this.fluxFilterInput.toUpperCase())
      );
    },
    fluxFilterInputProvince() {
      this.fluxProvincesArray = this.fluxProvinces.filter(x =>
        x.origin
          .toUpperCase()
          .startsWith(this.fluxFilterInputProvince.toUpperCase())
      );
    }
  },
  methods: {
    ...mapMutations(['setFluxGeoGranularity']),
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
      this.$emit("populationFluxChecked", checked);
      if (!checked) {
        this.fluxForm.filter_zone = [];
        this.fluxFilterInput = "";
        this.fluxForm.origin = null;
        this.fluxForm.destination = null;
      }
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
    },
    fluxGeoGranularityChange(value){
      this.setFluxGeoGranularity(value);
      this.fluxForm.fluxGeoOptions=[];
      if (value==1) {
        this.fluxGeoOptions=this.fluxProvinces;
      }
      else{
        this.fluxGeoOptions=this.fluxZones;
      }
    },
    fluxPredefinedInputChanged(value){
      this.$emit('flux::predefined::changed',value);
    }
  }
};
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.column-left {
  padding-top: 15px;
  padding-bottom: 15px;
  overflow: auto;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  z-index: 2;
  height: calc(100vh - 56px);
  .flux-move {
    .legend-reference,
    .legend-observation {
      display: inline-block;
      width: 10px;
      height: 10px;
    }
    .legend-observation {
      background: $success;
    }
    .legend-reference {
      background: $reference;
    }
  }
}
</style>