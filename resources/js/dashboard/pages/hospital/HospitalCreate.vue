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
                  <h3 class="mb-4">Données epidemiologiques</h3>

                  <b-form-group v-for="(question, i) in questions.epidemiologicalData" :key="i">
                    <label for class="text-dash-color"> {{ question.text }} </label>
                    <b-form-input
                      v-model="form[question.column]"
                      :disabled="noData[question.column]"
                      :type="question.type"
                      :v-int="question.type === 'number'"
                      class="input-dash"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="noData[question.column]"
                      @input="noDataChecked($event, question)"
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
                  <h3 class="mb-4">Capacité de prise en charge</h3>

                  <b-form-group v-for="(question, i) in questions.patientCareCapacity" :key="i">
                    <label for class="text-dash-color"> {{ question.text }} </label>
                    <b-form-input
                      v-model="form[question.column]"
                      :disabled="noData[question.column]"
                      :type="question.type"
                      :v-int="question.type === 'number'"
                      class="input-dash"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="noData[question.column]"
                      @input="noDataChecked($event, question)"
                    >
                      Donnée non disponible
                    </b-form-checkbox>
                  </b-form-group>

                  <b-form-group v-for="(question, i) in questions.medications" :key="i">
                    <label for class="text-dash-color"> {{ question.text }} </label>
                    <b-form-input
                      v-model="form[question.column]"
                      :disabled="noData[question.column]"
                      :type="question.type"
                      :v-int="question.type === 'number'"
                      class="input-dash"
                    />
                    <b-form-checkbox class="no-data"
                      v-model="noData[question.column]"
                      @input="noDataChecked($event, question)"
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
                  <h3 class="mb-4">Confirmation des données entrées</h3>

                  <h4 class="mb-4">Données epidemiologiques</h4>
                  <ul>
                    <li v-for="(question, i) in questions.epidemiologicalData" :key="i">
                      {{ question.text }} : {{ form[question.column] }}
                    </li>
                  </ul>
                  <h4 class="mb-4">Capacité de prise en charge</h4>
                  <ul>
                    <li v-for="(question, i) in questions.patientCareCapacity" :key="i">
                      {{ question.text }} : {{ form[question.column] }}
                    </li>
                    <li v-for="(question, i) in questions.medications" :key="i">
                      {{ question.text }} : {{ form[question.column] }}
                    </li>
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
import Questions from "../../config/questions";
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
      questions: Questions,
      noData: [],
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
    })
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
    noDataChecked (checked, question) {
      console.log(checked, question.column);
      if(checked) this.$set(this.form, question.column, '')
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
