<template>
  <div>
    <Header />
    <b-container class="mt-4">
      <b-row>
        <b-col>
          <form-wizard
            title="FICHE COLLECTE DES DONNEES"
            subtitle
            shape="tab"
            color="#2e5bff"
            nextButtonText="Suivant"
            backButtonText="Précédent"
            finishButtonText="Envoyer"
            @on-complete="onComplete"
          >
            <tab-content>
              <b-row align-h="center">
                <b-col cols="12" md="4">
                  <b-form-group>
                    <label for class="text-dash-color">Confirmés</label>
                    <b-form-input v-model="form.confirmed" v-int type="text" class="input-dash" />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Guéris</label>
                    <b-form-input v-model="form.healed" v-int type="text" class="input-dash" />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Décès</label>
                    <b-form-input v-model="form.dead" v-int type="text" class="input-dash" />
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
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
            <tab-content>
              <b-row align-h="center">
                <b-col cols="12" md="4">
                  <h3>Capacité de prise en charge des patiens du COVID</h3>
                  <b-form-group>
                    <label for class="text-dash-color">Lits avec mousse occupés</label>
                    <b-form-input
                      v-model="form.occupied_foam_beds"
                      v-int
                      type="text"
                      class="input-dash"
                    />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Lits de réanimation occupés</label>
                    <b-form-input
                      v-model="form.occupied_resuscitation_beds"
                      v-int
                      type="text"
                      class="input-dash"
                    />
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Respirateurs occupés</label>
                    <b-form-input
                      v-model="form.occupied_respirators"
                      v-int
                      type="text"
                      class="input-dash"
                    />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Ventilateur de réanimation occupés</label>
                    <b-form-input
                      v-model="form.resuscitation_ventilator"
                      v-int
                      type="text"
                      class="input-dash"
                    />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Masques</label>
                    <b-form-input v-model="form.masks" v-int type="text" class="input-dash" />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Equipement de protection individuelle</label>
                    <b-form-input
                      v-model="form.individual_protection_equipment"
                      v-int
                      type="text"
                      class="input-dash"
                    />
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Oxygénérateur</label>
                    <b-form-input v-model="form.oxygenator" v-int type="text" class="input-dash" />
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Dépistage rapide</label>
                    <b-form-input
                      v-model="form.rapid_screening"
                      v-int
                      type="text"
                      class="input-dash"
                    />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Radiographie</label>
                    <b-form-input v-model="form.x_ray" v-int type="text" class="input-dash" />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Automate Genexpert</label>
                    <b-form-input
                      v-model="form.automate_genexpert"
                      v-int
                      type="text"
                      class="input-dash"
                    />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Gel hydro alcoolique</label>
                    <b-form-input
                      v-model="form.gel_hydro_alcoolique"
                      v-int
                      type="text"
                      class="input-dash"
                    />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Check point</label>
                    <b-form-input v-model="form.check_point" v-int type="text" class="input-dash" />
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content>
              <b-row align-h="center">
                <b-col cols="12" md="4">
                  <h3>Médicaments</h3>
                  <b-form-group>
                    <label for class="text-dash-color">Chloroquine</label>
                    <b-form-input v-model="form.chloroquine" v-int type="text" class="input-dash" />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">Hydrochloroquine</label>
                    <b-form-input
                      v-model="form.hydrochloroquine"
                      v-int
                      type="text"
                      class="input-dash"
                    />
                  </b-form-group>
                  <b-form-group>
                    <label for class="text-dash-color">azytromicine</label>
                    <b-form-input v-model="form.azytromicine" v-int type="text" class="input-dash" />
                  </b-form-group>

                  <b-form-group>
                    <label for class="text-dash-color">Vitamince c</label>
                    <b-form-input v-model="form.Vitamince_c" v-int type="text" class="input-dash" />
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content>
              <b-row align-h="center">
                <b-col cols="12" md="4">
                  <h3>Confirmations</h3>
                  <b-form-group>
                    <label for class="text-dash-color">Date</label>
                    <b-calendar v-model="form.last_update" class="input-dash" />
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
          </form-wizard>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import { FormWizard, TabContent } from "vue-form-wizard";
import Header from "../../components/hospital/Header";
import "vue-form-wizard/dist/vue-form-wizard.min.css";
export default {
  components: {
    FormWizard,
    TabContent,
    Header
  },
  data() {
    return {
      form: {},
      errors: {}
    };
  },
  methods: {
    onComplete() {
      axios
        .post("/api/dashboard/hospital-situations", this.form)
        .then(({ data }) => {
          this.form = {};
        })
        .catch(({ data }) => {
          this.errors = data;
        });
    }
  }
};
</script>

<style>
</style>