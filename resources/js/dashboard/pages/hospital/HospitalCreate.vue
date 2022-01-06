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
            :title="$route.params.hospital_id?'':targetForm.title"
            subtitle

            shape="tab"
            color="#2e5bff"
            nextButtonText="Suivant"
            backButtonText="Précédent"
            finishButtonText="Envoyer"
            @on-complete="onComplete"
            :startIndex="1"
          >
            <tab-content
                  v-for="(step, index) in targetForm.form_steps"
                  :key="index"
                  >
                  <h3 class="mb-4 text-center">{{step.title}}</h3>
                <b-row align-h="center" >
                <b-col cols="12" md="8">
                 <b-form-group
                  v-for="(item, index) in formFieldSorted(step.id)"
                  :key="index"
                  :label="item.roules==null ? item.name:item.name + ' * '"
                  :label-for="item.name"
                 >
                  <b-row>
                    <b-col class="col-sm-12 col-md-12">
                      <b-form-group
                        v-slot="{ ariaDescribedby }"
                        v-if="item.form_field_type.name === 'boolean'"
                      >
                        <b-form-radio-group
                          :options="requiredOptions"
                          :aria-describedby="ariaDescribedby"
                          id="required"
                        ></b-form-radio-group>
                      </b-form-group>
                      <b-form-input
                        v-else
                        :v-model="item.form_field_type.name"
                        :type="item.form_field_type.name"
                        :value="item.default_value"
                        :placeholder="`Entrer ${item.name}`"
                        :id="item.name">
                      </b-form-input>
                    </b-col>
                  </b-row>
              </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content>
                  <h3 class="mb-4 text-center">Champs affectés à aucune étape</h3>
                <b-row align-h="center" >
                <b-col cols="12" md="8">
                 <b-form-group
                  v-for="(item, index) in formFieldNullStepSorted"
                  :key="index"
                  :label="item.roules==null ? item.name:item.name + ' * '"
                  :label-for="item.name"
                 >
                  <b-row>
                    <b-col class="col-sm-12 col-md-12">
                      <b-form-group
                        v-slot="{ ariaDescribedby }"
                        v-if="item.form_field_type.name === 'boolean'"
                      >
                        <b-form-radio-group
                          :options="requiredOptions"
                          :aria-describedby="ariaDescribedby"
                          id="required"
                        ></b-form-radio-group>
                      </b-form-group>
                      <b-form-input
                        v-else
                        :v-model="item.form_field_type.name"
                        :type="item.form_field_type.name"
                        :value="item.default_value"
                        :placeholder="`Entrer ${item.name}`"
                        :id="item.name">
                      </b-form-input>
                    </b-col>
                  </b-row>
              </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content>
              <b-row align-h="center" >
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
import { FormWizard, TabContent } from 'vue-form-wizard'
import Header from '../../components/hospital/Header'
import Loading from '../../components/Loading'
import ManagerUserName from '../../components/hospital/ManagerUserName'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import { mapState, mapActions } from 'vuex'
export default {
  components: {
    FormWizard,
    TabContent,
    Header,
    ManagerUserName,
    Loading
  },
  data () {
    const now = new Date()
    return {
      targetForm: {},
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
      nodata_confirmed: false,
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
      formStepsField: []
    }
  },
  computed: {
    ...mapState({
      hospitalManagerName: (state) => state.hospital.hospitalManagerName,
      formSteps: (state) => state.formStep.formSteps
    }),

    formFieldSorted: (app) => (id) => {
      return app.targetForm.form_fields
        ? app.targetForm.form_fields
          .slice()
          .sort((a, b) => a.order_field - b.order_field)
          .filter(item => item.form_step_id === +id)
        : []
    },
    formFieldNullStepSorted () {
      return this.targetForm.form_fields
        ? this.targetForm.form_fields
          .slice()
          .sort((a, b) => a.order_field - b.order_field)
          .filter(item => item.form_step_id === null)
        : []
    }
  },

  mounted () {
    this.getForm()
    if (this.$route.params.hospital_id) {
      this.getHospital()
    }
    if (!this.hospitalManagerName) {
      this.$bvModal.show('nameModal')
    }
  },
  methods: {
    ...mapActions([
      'formShow'
    ]),

    async getForm () {
      this.targetForm = await this.formShow({ id: this.$route.params.form_id })
    },
    onComplete () {
      this.isLoading = true
      this.errors = {}

      const url = this.$route.params.hospital_id
        ? `/api/dashboard/hospital-situations/${this.$route.params.hospital_id}`
        : '/api/dashboard/hospital-situations'

      if (this.$route.params.hospital_id) {
        this.form._method = 'PUT'
        this.form.updated_manager_name = this.hospitalManagerName
      } else {
        this.form.created_manager_name = this.hospitalManagerName
      }
      axios
        .post(url, this.form)
        .then(({ data }) => {
          this.form = {}
          this.isLoading = false
          this.$router.push({
            name: 'hospital.home'
          })
        })
        .catch(({ response }) => {
          this.isLoading = false
          this.errors = response.data.errors
        })
    },
    getHospital () {
      this.isLoading = true
      this.form.updated_manager_name = this.hospitalManagerName
      axios
        .get(
          `/api/dashboard/hospital-situations/${this.$route.params.hospital_id}`
        )
        .then(({ data }) => {
          this.form = data
        })
        .catch((response) => {})
        .finally(() => {
          this.isLoading = false
        })
    },
    confirmedChecked (checked) {
      if (checked) this.$set(this.form, 'confirmed', '')
    },
    sickChecked (checked) {
      if (checked) this.$set(this.form, 'sick', '')
    },
    healedChecked (checked) {
      if (checked) this.$set(this.form, 'healed', '')
    },
    deadChecked (checked) {
      if (checked) this.$set(this.form, 'dead', '')
    },
    occupied_foam_bedsChecked (checked) {
      if (checked) this.$set(this.form, 'occupied_foam_beds', '')
    },
    occupied_resuscitation_bedsChecked (checked) {
      if (checked) this.$set(this.form, 'occupied_resuscitation_beds', '')
    },
    occupied_respiratorsChecked (checked) {
      if (checked) this.$set(this.form, 'occupied_respirators', '')
    },
    resuscitation_ventilatorChecked (checked) {
      if (checked) this.$set(this.form, 'resuscitation_ventilator', '')
    },
    masksChecked (checked) {
      if (checked) this.$set(this.form, 'masks', '')
    },
    individual_protection_equipmentChecked (checked) {
      if (checked) this.$set(this.form, 'individual_protection_equipment', '')
    },
    oxygenatorChecked (checked) {
      if (checked) this.$set(this.form, 'oxygenator', '')
    },
    rapid_screeningChecked (checked) {
      if (checked) this.$set(this.form, 'rapid_screening', '')
    },
    x_rayChecked (checked) {
      if (checked) this.$set(this.form, 'x_ray', '')
    },
    automate_genexpertChecked (checked) {
      if (checked) this.$set(this.form, 'automate_genexpert', '')
    },
    gel_hydro_alcooliqueChecked (checked) {
      if (checked) this.$set(this.form, 'gel_hydro_alcoolique', '')
    },
    check_pointChecked (checked) {
      if (checked) this.$set(this.form, 'check_point', '')
    },
    chloroquineChecked (checked) {
      if (checked) this.$set(this.form, 'chloroquine', '')
    },
    hydrochloroquineChecked (checked) {
      if (checked) this.$set(this.form, 'hydrochloroquine', '')
    },
    azytromicineChecked (checked) {
      if (checked) this.$set(this.form, 'azytromicine', '')
    },
    Vitamince_cChecked (checked) {
      if (checked) this.$set(this.form, 'Vitamince_c', '')
    }
  }
}
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
