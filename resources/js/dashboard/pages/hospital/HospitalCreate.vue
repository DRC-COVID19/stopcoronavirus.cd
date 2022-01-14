/* eslint-disable space-before-blocks */
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
            <b-alert variant="success" v-if="!!isLoading" show>L'insertion reussi avec success</b-alert>
            <tab-content
                  v-for="(step, index) in targetForm.form_steps"
                  :key="index"
                  v-else
                  >
                  <h3 class="mb-4 text-center">{{step.title}}</h3>
                <b-row align-h="center" >
                <b-col cols="12" md="8">
                 <b-form-group
                  v-for="(item, counter) in formFieldSorted(step.id)"
                  :key="counter"
                  :label="item.roules!==null ? item.name+ ' * ':item.name"
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
                        :type="item.form_field_type.name"
                         v-model="item.default_value"
                        :placeholder="`Entrer ${item.name}`"
                        @change="handelChange(item.id,item.default_value,item.name,step.id)"
                        :id="item.name">
                      </b-form-input>
                    </b-col>
                  </b-row>
              </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content v-if="formFieldNullStepSorted.length > 0">
                  <h3 class="mb-4 text-center">Champs affectés à aucune étape</h3>
                <b-row align-h="center" >
                <b-col cols="12" md="8">
                 <b-form-group
                  v-for="(field, counter) in formFieldNullStepSorted"
                  :key="counter"
                  :label="field.roules!==null ? field.name + ' * ':field.name"
                  :label-for="field.name"
                 >
                  <b-row>
                    <b-col class="col-sm-12 col-md-12">
                      <b-form-group
                        v-slot="{ ariaDescribedby }"
                        v-if="field.form_field_type.name === 'boolean'"
                      >
                        <b-form-radio-group
                          :options="requiredOptions"
                          :aria-describedby="ariaDescribedby"
                          id="required"
                        ></b-form-radio-group>
                      </b-form-group>
                      <b-form-input
                        v-else
                        :type="field.form_field_type.name"
                        v-model="field.default_value"
                        :placeholder="`Entrer ${field.name}`"
                        @change="handelChange(field.id,field.default_value,field.name,step.id)"
                        :id="field.name">
                      </b-form-input>
                    </b-col>
                  </b-row>
              </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content>
              <b-row align-h="center" >
                <b-col
                  v-for="(step, index) in targetForm.form_steps"
                  :key="index"

                  cols="12" md="6" >
                  <h3 class="mb-4">{{step.title}}</h3>

                  <div
                    v-for="(summary, count) in fomSummary"
                    :key="count">
                  <ul v-if="step.id===summary.stepId">
                    <li>{{summary.fieldName}} : {{summary.value}}</li>
                  </ul>
                  </div>
                </b-col>
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
      targetForm: {

      },
      formData: new Map(),
      fomSummary: [],
      formDataFormatted: [],
      form: {
        items: [],
        fields: []
      },
      max: now,
      errors: {},
      isLoading: false
    }
  },
  computed: {
    ...mapState({
      hospitalManagerName: (state) => state.hospital.hospitalManagerName,
      formSteps: (state) => state.formStep.formSteps
    }),
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
      'formShow',
      'createHospitalSituation'
    ]),

    formFieldSorted (id) {
      return this.targetForm.form_fields
        ? this.targetForm.form_fields
          .filter(item => item.form_step_id === id)
        : []
    },

    valuesChanged (values) {
      this.formData = {
        ...this.formData,
        ...values
      }
    },

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
      if (this.createSituation(this.formData)) {
        this.isLoading = false
        this.$router.push('/hospitals')
      }
    },

    createSituation (formData) {
      for (const [key, value] of formData) {
        this.formDataFormatted.push({ form_field_id: key, value })
      }
      if (this.formDataFormatted.length > 0) {
        this.formDataFormatted.forEach(item => {
          this.createHospitalSituation({
            value: item.value,
            form_field_id: item.form_field_id,
            last_update: this.form.last_update
          })
        })
        return true
      }
      return false
    },
    handelChange (key, value, fieldName, stepId) {
      if (value) {
        if (!this.formData.has(key)) {
          this.formData.set(key, value)
          this.fomSummary.push({ value, fieldName, stepId })
        }
      }
    },

    getHospital () {
      this.isLoading = true
      this.form.updated_manager_name = this.hospitalManagerName
      // eslint-disable-next-line no-undef
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
