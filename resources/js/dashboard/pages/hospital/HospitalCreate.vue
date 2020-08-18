<template>
  <div>
    <Header />
    <b-container class="mt-4">
      <Loading v-if="isLoading" class="h-100" />
      <b-row v-else align-h="center">
        <b-col cols="12" v-if="errors && errors.last_update">
          <b-alert variant="danger" dismissible show>{{errors.last_update[0]}}</b-alert>
        </b-col>
        <b-col cols="12">
          <b-link :to="{
            name:'hospital.home'
          }">
            <span class="fa fa-chevron-left">Retour</span>
          </b-link>
          <h3 v-if="$route.params.hospital_id" class="mb-4 mt-4">
            Modifier la mise à jour du
            <br />
            {{moment(form.last_update).format("DD.MM.Y")}}
          </h3>
          <form-wizard
            :title="$route.params.hospital_id?'':'FICHE DE COLLECTE DES DONNEES'"
            subtitle
            shape="tab"
            color="#2e5bff"
            nextButtonText="Suivant"
            backButtonText="Précédent"
            finishButtonText="Envoyer"
            @on-complete="onComplete"
            :startIndex="4"
          >
            <tab-content>
              <b-row align-h="center">
                <b-col cols="12" md="6">
                  <h3 class="mb-4">Données épidemologiques</h3>

                  <b-form-group>
                    <label for class="text-dash-color">Confirmés</label>
                    <b-form-input v-model="form.confirmed" v-int type="text" class="input-dash"
                      :disabled="nodata_confirmed"/>
                    <b-form-checkbox class="no-data"
                      v-model="nodata_confirmed"
                      @input="confirmedChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Hospitalisés</label>
                    <b-form-input v-model="form.sick" v-int type="text" class="input-dash"
                      :disabled="nodata_sick"/>
                    <b-form-checkbox class="no-data"
                      v-model="nodata_sick"
                      @input="sickChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Guéris</label>
                    <b-form-input v-model="form.healed" v-int type="text" class="input-dash"
                      :disabled="nodata_healed"/>
                    <b-form-checkbox class="no-data"
                      v-model="nodata_healed"
                      @input="healedChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Décès</label>
                    <b-form-input v-model="form.dead" v-int type="text" class="input-dash"
                      :disabled="nodata_dead"/>
                    <b-form-checkbox class="no-data"
                      v-model="nodata_dead"
                      @input="deadChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <!--
              <tab-content>
              <b-row align-h="center">
                <b-col cols="12" md="4">
                  <h3>Homme</h3>
                  <b-form-group>
                    <label for class="text-dash-color">Confirmés</label>
                    <b-form-input
                      v-model="form.confirmed_male"
                      v-int
                      type="text"
                      class="input-dash"
                    />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Guéris</label>
                    <b-form-input v-model="form.healed_male" v-int type="text" class="input-dash" />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Décès</label>
                    <b-form-input v-model="form.dead_male" v-int type="text" class="input-dash" />
                  </b-form-group>
                </b-col>
              </b-row>
              <hr />
              <b-row align-h="center">
                <b-col cols="12" md="4">
                  <h3>Femme</h3>
                  <b-form-group>
                    <label for class="text-dash-color">Confirmés</label>
                    <b-form-input
                      v-model="form.confirmed_female"
                      v-int
                      type="text"
                      class="input-dash"
                    />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Guéris</label>
                    <b-form-input
                      v-model="form.healed_female"
                      v-int
                      type="text"
                      class="input-dash"
                    />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Décès</label>
                    <b-form-input v-model="form.dead_female" v-int type="text" class="input-dash" />
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content>
              <b-row align-h="center">
                <b-col cols="12" md="4">
                  <h3>Age de 0 à 19 ans</h3>
                  <b-form-group>
                    <label for class="text-dash-color">Confirmés</label>
                    <b-form-input
                      v-model="form.confirmed_0_19"
                      v-int
                      type="text"
                      class="input-dash"
                    />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Guéris</label>
                    <b-form-input v-model="form.healed_0_19" v-int type="text" class="input-dash" />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Décès</label>
                    <b-form-input v-model="form.dead_0_19" v-int type="text" class="input-dash" />
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content>
              <b-row align-h="center">
                <b-col cols="12" md="4">
                  <h3>Age de 20 à 40 ans</h3>
                  <b-form-group>
                    <label for class="text-dash-color">Confirmés</label>
                    <b-form-input
                      v-model="form.confirmed_20_40"
                      v-int
                      type="text"
                      class="input-dash"
                    />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Guéris</label>
                    <b-form-input v-model="form.healed_20_40" v-int type="text" class="input-dash" />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Décès</label>
                    <b-form-input v-model="form.dead_20_40" v-int type="text" class="input-dash" />
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content>
              <b-row align-h="center">
                <b-col cols="12" md="4">
                  <h3>Age de 45 à 50 ans</h3>
                  <b-form-group>
                    <label for class="text-dash-color">Confirmés</label>
                    <b-form-input
                      v-model="form.confirmed_45_50"
                      v-int
                      type="text"
                      class="input-dash"
                    />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Guéris</label>
                    <b-form-input v-model="form.healed_45_50" v-int type="text" class="input-dash" />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Décès</label>
                    <b-form-input v-model="form.dead_45_50" v-int type="text" class="input-dash" />
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content>
              <b-row align-h="center">
                <b-col cols="12" md="4">
                  <h3>Age de 55 à 64 ans</h3>
                  <b-form-group>
                    <label for class="text-dash-color">Confirmés</label>
                    <b-form-input
                      v-model="form.confirmed_55_64"
                      v-int
                      type="text"
                      class="input-dash"
                    />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Guéris</label>
                    <b-form-input v-model="form.healed_55_64" v-int type="text" class="input-dash" />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Décès</label>
                    <b-form-input v-model="form.dead_55_64" v-int type="text" class="input-dash" />
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content>
              <b-row align-h="center">
                <b-col cols="12" md="4">
                  <h3>Age de 65 à 74 ans</h3>
                  <b-form-group>
                    <label for class="text-dash-color">Confirmés</label>
                    <b-form-input
                      v-model="form.confirmed_65_74"
                      v-int
                      type="text"
                      class="input-dash"
                    />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Guéris</label>
                    <b-form-input v-model="form.healed_65_74" v-int type="text" class="input-dash" />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Décès</label>
                    <b-form-input v-model="form.dead_65_74" v-int type="text" class="input-dash" />
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content>
              <b-row align-h="center">
                <b-col cols="12" md="4">
                  <h3>Age de 75 à 84 ans</h3>
                  <b-form-group>
                    <label for class="text-dash-color">Confirmés</label>
                    <b-form-input
                      v-model="form.confirmed_75_84"
                      v-int
                      type="text"
                      class="input-dash"
                    />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Guéris</label>
                    <b-form-input v-model="form.healed_75_84" v-int type="text" class="input-dash" />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Décès</label>
                    <b-form-input v-model="form.dead_75_84" v-int type="text" class="input-dash" />
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content>
              <b-row align-h="center">
                <b-col cols="12" md="4">
                  <h3>Age supérieur à 84 ans</h3>
                  <b-form-group>
                    <label for class="text-dash-color">Confirmés</label>
                    <b-form-input v-model="form.confirmed_85" v-int type="text" class="input-dash" />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Guéris</label>
                    <b-form-input v-model="form.healed_85" v-int type="text" class="input-dash" />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Décès</label>
                    <b-form-input v-model="form.dead_85" v-int type="text" class="input-dash" />
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            -->
            <tab-content>
              <b-row align-h="center">
                <b-col cols="12" md="6">
                  <h3 class="mb-4">Capacité de prise en charge des patiens</h3>

                  <b-form-group>
                    <label for class="text-dash-color">Lits avec mousse occupés</label>
                    <b-form-input
                      v-model="form.occupied_foam_beds"
                      v-int
                      value="0"
                      type="text"
                      class="input-dash"
                      :disabled="nodata_occupied_foam_beds"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="nodata_occupied_foam_beds"
                      @input="occupied_foam_bedsChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Lits de réanimation occupés</label>
                    <b-form-input
                      v-model="form.occupied_resuscitation_beds"
                      v-int
                      type="text"
                      class="input-dash"
                      :disabled="nodata_occupied_resuscitation_beds"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="nodata_occupied_resuscitation_beds"
                      @input="occupied_resuscitation_bedsChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Respirateurs occupés</label>
                    <b-form-input
                      v-model="form.occupied_respirators"
                      v-int
                      type="text"
                      class="input-dash"
                      :disabled="nodata_occupied_respirators"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="nodata_occupied_respirators"
                      @input="occupied_respiratorsChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Ventilateur de réanimation occupés</label>
                    <b-form-input
                      v-model="form.resuscitation_ventilator"
                      v-int
                      type="text"
                      class="input-dash"
                      :disabled="nodata_resuscitation_ventilator"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="nodata_resuscitation_ventilator"
                      @input="resuscitation_ventilatorChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Masques</label>
                    <b-form-input v-model="form.masks" v-int type="text" class="input-dash"
                      :disabled="nodata_masks"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="nodata_masks"
                      @input="masksChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Equipement de protection individuelle</label>
                    <b-form-input
                      v-model="form.individual_protection_equipment"
                      v-int
                      type="text"
                      class="input-dash"
                      :disabled="nodata_individual_protection_equipment"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="nodata_individual_protection_equipment"
                      @input="individual_protection_equipmentChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Oxygénérateur</label>
                    <b-form-input v-model="form.oxygenator" v-int type="text" class="input-dash"
                      :disabled="nodata_oxygenator"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="nodata_oxygenator"
                      @input="oxygenatorChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Dépistage rapide</label>
                    <b-form-input
                      v-model="form.rapid_screening"
                      v-int
                      type="text"
                      class="input-dash"
                      :disabled="nodata_rapid_screening"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="nodata_rapid_screening"
                      @input="rapid_screeningChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Radiographie</label>
                    <b-form-input v-model="form.x_ray" v-int type="text" class="input-dash"
                      :disabled="nodata_x_ray"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="nodata_x_ray"
                      @input="x_rayChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Automate Genexpert</label>
                    <b-form-input
                      v-model="form.automate_genexpert"
                      v-int
                      type="text"
                      class="input-dash"
                      :disabled="nodata_automate_genexpert"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="nodata_automate_genexpert"
                      @input="automate_genexpertChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Gel hydro alcoolique</label>
                    <b-form-input
                      v-model="form.gel_hydro_alcoolique"
                      v-int
                      type="text"
                      class="input-dash"
                      :disabled="nodata_gel_hydro_alcoolique"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="nodata_gel_hydro_alcoolique"
                      @input="gel_hydro_alcooliqueChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Check point</label>
                    <b-form-input v-model="form.check_point" v-int type="text" class="input-dash"
                      :disabled="nodata_check_point"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="nodata_check_point"
                      @input="check_pointChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>

            <tab-content>
              <b-row align-h="center">
                <b-col cols="12" md="6">
                  <h3>Médicaments</h3>
                  <b-form-group>
                    <label for class="text-dash-color">Chloroquine</label>
                    <b-form-input v-model="form.chloroquine" v-int type="text" class="input-dash"
                      :disabled="nodata_chloroquine"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="nodata_chloroquine"
                      @input="chloroquineChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Hydrochloroquine</label>
                    <b-form-input
                      v-model="form.hydrochloroquine"
                      v-int
                      type="text"
                      class="input-dash"
                      :disabled="nodata_hydrochloroquine"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="nodata_hydrochloroquine"
                      @input="hydrochloroquineChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Azytromicine</label>
                    <b-form-input v-model="form.azytromicine" v-int type="text" class="input-dash"
                      :disabled="nodata_azytromicine"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="nodata_azytromicine"
                      @input="azytromicineChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Vitamince c</label>
                    <b-form-input v-model="form.Vitamince_c" v-int type="text" class="input-dash"
                      :disabled="nodata_Vitamince_c"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="nodata_Vitamince_c"
                      @input="Vitamince_cChecked"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content>
              <b-row align-h="center">
                <b-col cols="12" md="6">
                  <h3 class="mb-4">Confirmations les données entrées</h3>

                  <h4 class="mb-4">Données épidemologiques</h4>
                  <ul>
                    <li>Confirmés : {{form.confirmed}}</li>
                    <li>Hospitalisés : {{form.sick}}</li>
                    <li>Guéris : {{form.healed}}</li>
                    <li>Décès : {{form.dead}}</li>
                  </ul>
                  <h4 class="mb-4">Capacité de prise en charge des patiens</h4>
                  <ul>
                    <li>Lits avec mousse occupés: {{form.occupied_foam_beds}}</li>
                    <li>Lits de réanimation occupés : {{form.occupied_resuscitation_beds}}</li>
                    <li>Respirateurs occupés : {{form.occupied_respirators}}</li>
                    <li>Ventilateur de réanimation occupés : {{form.resuscitation_ventilator}}</li>
                    <li>Masques : {{form.masks}}</li>
                    <li>Equipement de protection individuelle : {{form.individual_protection_equipment}}</li>
                    <li>Oxygénérateur : {{form.oxygenator}}</li>
                    <li>Dépistage rapide : {{form.rapid_screening}}</li>
                    <li>Radiographie : {{form.x_ray}}</li>
                    <li>Automate Genexpert : {{form.automate_genexpert}}</li>
                    <li>Gel hydro alcoolique : {{form.gel_hydro_alcoolique}}</li>
                    <li>Check point : {{form.check_point}}</li>
                  </ul>
                  <h4 class="mb-4">Médicaments</h4>
                  <ul>
                    <li>Chloroquine : {{form.chloroquine}}</li>
                    <li>Hydrochloroquine : {{form.hydrochloroquine}}</li>
                    <li>Azytromicine : {{form.azytromicine}}</li>
                    <li>Vitamince c : {{form.Vitamince_c}}</li>
                  </ul>
                  <b-form-group class="no-border">
                    <label for="last_update" class="text-dash-color">Sélectionnez la date</label>
                    <b-form-datepicker

                      v-model="form.last_update"
                      :max="max"
                      required
                      id="last_update"
                      class="mb-2"
                      :disabled="!!$route.params.hospital_id"

                    ></b-form-datepicker>
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
          </form-wizard>
        </b-col>
      </b-row>
    </b-container>
    <ManagerUserName />
  </div>
</template>

<script>
import { FormWizard, TabContent } from "vue-form-wizard";
import Header from "../../components/hospital/Header";
import Loading from "../../components/Loading";
import ManagerUserName from "../../components/hospital/ManagerUserName";
import "vue-form-wizard/dist/vue-form-wizard.min.css";
import { mapState } from "vuex";
export default {
  components: {
    FormWizard,
    TabContent,
    Header,
    ManagerUserName,
    Loading,
  },
  data() {
    const now = new Date();
    return {
      form: {
        confirmed: null,
        sick: null,
        healed: null,
        dead: null,
        occupied_foam_beds: null,
        occupied_resuscitation_beds: null,
        occupied_respirators: null,
        resuscitation_ventilator: null,
        masks: null,
        individual_protection_equipment: null,
        oxygenator: null,
        rapid_screening: null,
        x_ray: null,
        automate_genexpert: null,
        gel_hydro_alcoolique: null,
        check_point: null,
        chloroquine: null,
        hydrochloroquine: null,
        azytromicine: null,
        Vitamince_c: null
      },
      nodata_confirmed : false,
      nodata_sick: false,
      nodata_healed: false,
      nodata_dead: null,
      nodata_occupied_foam_beds: false,
      nodata_occupied_resuscitation_beds: false,
      nodata_occupied_respirators: false,
      nodata_resuscitation_ventilator: false,
      nodata_masks: false,
      nodata_individual_protection_equipment: false,
      nodata_oxygenator: false,
      nodata_rapid_screening: false,
      nodata_x_ray: false,
      nodata_automate_genexpert: false,
      nodata_gel_hydro_alcoolique: false,
      nodata_check_point: false,
      nodata_chloroquine: false,
      nodata_hydrochloroquine: false,
      nodata_azytromicine: false,
      nodata_Vitamince_c: false,
      max: now,
      errors: {},
      isLoading: false,
    };
  },
  computed: {
    ...mapState({
      hospitalManagerName: (state) => state.hospital.hospitalManagerName,
    }),
  },
  mounted() {
    if (this.$route.params.hospital_id) {
      this.getHospital();
    }
    if (!this.hospitalManagerName) {
      this.$bvModal.show("nameModal");
    }
  },
  methods: {
    onComplete() {
      this.isLoading = true;
      this.errors = {};

      let url = this.$route.params.hospital_id
        ? `/api/dashboard/hospital-situations/${this.$route.params.hospital_id}`
        : "/api/dashboard/hospital-situations";

      if (this.$route.params.hospital_id) {
        this.form._method = "PUT";
        this.form.updated_manager_name = this.hospitalManagerName;
      }else{
        this.form.created_manager_name = this.hospitalManagerName;
      }
      axios
        .post(url, this.form)
        .then(({ data }) => {
          this.form = {};
          this.isLoading = false;
          this.$router.push({
            name: "hospital.home",
          });
        })
        .catch(({ response }) => {
          this.isLoading = false;
          this.errors = response.data.errors;
        });
    },
    getHospital() {
      this.isLoading = true;
      this.form.updated_manager_name = this.hospitalManagerName;
      axios
        .get(
          `/api/dashboard/hospital-situations/${this.$route.params.hospital_id}`
        )
        .then(({ data }) => {
          this.form = data;
        })
        .catch((response) => {})
        .finally(() => {
          this.isLoading = false;
        });
    },
    confirmedChecked(checked){
      if(checked) this.$set(this.form, 'confirmed', '')
    },
    sickChecked(checked){
      if(checked) this.$set(this.form, 'sick', '')
    },
    healedChecked(checked){
      if(checked) this.$set(this.form, 'healed', '')
    },
    deadChecked(checked){
      if(checked) this.$set(this.form, 'dead', '')
    },
    occupied_foam_bedsChecked(checked){
      if(checked) this.$set(this.form, 'occupied_foam_beds', '')
    },
    occupied_resuscitation_bedsChecked(checked){
      if(checked) this.$set(this.form, 'occupied_resuscitation_beds', '')
    },
    occupied_respiratorsChecked(checked){
      if(checked) this.$set(this.form, 'occupied_respirators', '')
    },
    resuscitation_ventilatorChecked(checked){
      if(checked) this.$set(this.form, 'resuscitation_ventilator', '')
    },
    masksChecked(checked){
      if(checked) this.$set(this.form, 'masks', '')
    },
    individual_protection_equipmentChecked(checked){
      if(checked) this.$set(this.form, 'individual_protection_equipment', '')
    },
    oxygenatorChecked(checked){
      if(checked) this.$set(this.form, 'oxygenator', '')
    },
    rapid_screeningChecked(checked){
      if(checked) this.$set(this.form, 'rapid_screening', '')
    },
    x_rayChecked(checked){
      if(checked) this.$set(this.form, 'x_ray', '')
    },
    automate_genexpertChecked(checked){
      if(checked) this.$set(this.form, 'automate_genexpert', '')
    },
    gel_hydro_alcooliqueChecked(checked){
      if(checked) this.$set(this.form, 'gel_hydro_alcoolique', '')
    },
    check_pointChecked(checked){
      if(checked) this.$set(this.form, 'check_point', '')
    },
    chloroquineChecked(checked){
      if(checked) this.$set(this.form, 'chloroquine', '')
    },
    hydrochloroquineChecked(checked){
      if(checked) this.$set(this.form, 'hydrochloroquine', '')
    },
    azytromicineChecked(checked){
      if(checked) this.$set(this.form, 'azytromicine', '')
    },
    Vitamince_cChecked(checked){
      if(checked) this.$set(this.form, 'Vitamince_c', '')
    }
  },
};
</script>

<style scoped lang="scss">
  .no-data{
    font-size: 12px;
    line-height: 26px;
    margin-top: 5px;
  }
  fieldset{
    border-bottom: 1px solid rgb(0 0 0 / .1);
    padding-bottom: 5px;
  }
  fieldset.no-border{
    border-bottom: none;
  }
</style>
