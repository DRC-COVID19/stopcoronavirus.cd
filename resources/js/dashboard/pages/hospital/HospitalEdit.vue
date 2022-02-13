/* eslint-disable space-before-blocks */
<template>
  <div>
    <Header />
    <b-container class="mt-4">
      <Loading v-if="isLoading" class="h-100" />
      <b-row v-else align-h="center">

        <b-col cols="12">
          <b-link
            :to="backRoute"
          >
            <span class="fa fa-chevron-left">Retour</span>
          </b-link>
          <h3 v-if="$route.params.update_id" class="mb-4 mt-4">
            Modifier la mise à jour du
            <br />
            {{ moment($route.params.update_id).format("DD/MM/Y") }}
          </h3>

          <form-wizard
            title="FORMULAIRE"
            subtitle
            shape="tab"
            color="#2e5bff"
            nextButtonText="Suivant"
            backButtonText="Précédent"
            finishButtonText="Modifier"
            @on-complete="onComplete"
            :startIndex="0"
          >
            <b-alert variant="success" v-if="!!isLoading" show
              >L'insertion reussi avec success</b-alert
            >
            <tab-content
              v-for="(step, index) in targetForm.form_steps"
              :key="index"
              v-else
            >
              <h3 class="mb-4 text-center">{{ step.title }}</h3>
              <b-row align-h="center">
                <b-col cols="12" md="8">
                  <b-form-group
                    v-for="(item, counter) in formFieldSorted(step.id)"
                    :key="counter"
                    :label="
                      item.roules !== null
                        ? item.form_field_name + ' * '
                        : item.form_field_name
                    "
                    :label-for="item.form_field_name"
                  >
                    <b-row>
                      <b-col class="col-sm-12 col-md-12">
                        <b-form-group
                          v-slot="{ ariaDescribedby }"
                          v-if="item.form_field_type_name === 'boolean'"
                        >
                          <b-form-radio-group
                            :options="requiredOptions"
                            :aria-describedby="ariaDescribedby"
                            id="required"
                          ></b-form-radio-group>
                        </b-form-group>
                        <b-form-input
                          v-else
                          :type="item.form_field_type_name"
                          v-model="item.form_field_value"
                          :placeholder="`Entrer ${item.form_field_name}`"
                          required
                          @change="
                            handelChange(
                              item.form_field_id,
                              item.form_field_value,
                              item.form_field_name,
                              step.id
                            )
                          "
                          :id="item.form_field_name"
                        >
                        </b-form-input>
                      </b-col>
                    </b-row>
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content v-if="formFieldNullStepSorted.length > 0">
              <h3 class="mb-4 text-center">Champs affectés à aucune étape</h3>
              <b-row align-h="center">
                <b-col cols="12" md="8">
                  <b-form-group
                    v-for="(field, counter) in formFieldNullStepSorted"
                    :key="counter"
                    :label="
                      field.roules !== null
                        ? field.form_field_name + ' * '
                        : field.form_field_name
                    "
                    :label-for="field.form_field_name"
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
                          v-model="field.form_field_value"
                          :placeholder="`Entrer ${field.form_field_name}`"
                          @change="
                            handelChange(
                                field.form_field_id,
                              field.form_field_value,
                              field.form_field_name,
                              step.id
                            )
                          "
                          :id="field.form_field_name"
                        >
                        </b-form-input>
                      </b-col>
                    </b-row>
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content>
              <b-row align-h="center">
                <b-col
                  v-for="(step, index) in targetForm.form_steps"
                  :key="index"
                  cols="12"
                  md="6"
                >
                  <h3 class="mb-4">{{ step.title }}</h3>

                  <div v-for="(summary, count) in editionData" :key="count">
                    <ul v-if="step.id === summary.form_step_id">
                      <li>{{ summary.form_field_name }} : {{ summary.form_field_value }}</li>
                    </ul>
                  </div>
                </b-col>
                <b-col class="col-md-12">
                  <b-alert show variant="warning">
                    <p class="text-center">
                      NB: Une soumission ne peut plus être modifiée après 24
                      heures.
                    </p>
                  </b-alert>
                </b-col>
                <b-form-group class="no-border">
                  <label for="last_update" class="text-dash-color"
                    >Sélectionnez la date</label
                  >
                  <b-form-datepicker
                    v-model="editionData[0].last_update"
                    :max="max"
                    required
                    id="last_update"
                    class="mb-2"
                    :disabled="!!$route.params.update_id"
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
      formData: new Map(),
      formSummary: [],
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
      user: state => state.auth.user,
      targetForm: state => state.form.forms,
      hospitalManagerName: state => state.hospital.hospitalManagerName,
      formSteps: state => state.formStep.formSteps,
      editionData: state => state.hospitalSituation.hospitalSituationDetail,
      isHospitalSituationLoading: state => state.hospitalSituation.isLoading
    }),
    formFieldNullStepSorted () {
      return this.targetForm.form_fields
        ? this.targetForm.form_fields
          .slice()
          .sort((a, b) => a.order_field - b.order_field)
          .filter(item => item.form_step_id === null)
        : []
    },
    backRoute () {
      if (this.user.isHospitalAdmin) {
        return {
          name: 'hospital.admin.data',
          params: { hospital_id: this.$route.params.hospital_id }
        }
      } else return { name: 'hospital.home' }
    },
  },

  mounted () {
    this.getForm()
    if (this.$route.params.update_id) {
      this.getHospitalSituations()
    }
    if (!this.hospitalManagerName) {
      this.$bvModal.show('nameModal')
    }
  },
  methods: {
    ...mapActions([
      'formShow',
      'updateHospitalSituation',
      'getHospitalSituationsDetail'
    ]),
    getHospitalSituations () {
      this.getHospitalSituationsDetail({
        isLoading: true,
        update_id: this.$route.params.update_id,
        hospital_id: this.$route.params.hospital_id
      })
    },
    formFieldSorted (id) {
      return this.editionData
        ? this.editionData.filter(item => item.form_step_id === id)
        : []
    },

    async getForm () {
      await this.formShow({ id: this.$route.params.form_id })
    },

    onComplete () {
      this.isLoading = false
      this.errors = {}

      if (this.$route.params.update_id) {
        this.form._method = 'PUT'
        this.form.updated_manager_name = this.hospitalManagerName
        this.form.hospital_id = this.$route.params.hospital_id
        this.form.last_update = this.$route.params.update_id
        if (this.updateSituation(this.formData)) {
          this.isLoading = true
          if (this.user.isHospitalAdmin) {
            this.$router.push(`/admin/hospitals/${this.$route.params.hospital_id}`)
          } else {
            this.$router.push('/hospitals')
          }
        }
      }
    },

    updateSituation (formData) {
      for (const [key, value] of formData) {
        this.formDataFormatted.push({
          form_field_id: key,
          value,
          last_update: this.form.last_update,
          updated_manager_name: this.form.updated_manager_name,
          hospital_id: this.form.hospital_id
        })
      }

      if (this.formDataFormatted.length > 0) {
        this.formDataFormatted.forEach(item => {
          this.updateHospitalSituation({
            value: item.value,
            form_field_id: item.form_field_id,
            last_update: item.last_update,
            updated_manager_name: item.updated_manager_name,
            hospital_id: item.hospital_id
          })
        })
        return true
      }

      return false
    },
    handelChange (key, value, fieldName, stepId) {
      this.editionData.forEach(item => {
        if (item.form_field_id === key) {
          item.form_field_value = value
          this.formData.set(key, value)
        }
      })
    }
  }
}
</script>

<style scoped lang="scss">
.no-data {
  font-size: 12px;
  line-height: 26px;
  margin-top: 5px;
}
fieldset {
  border-bottom: 1px solid rgb(0 0 0 / 0.1);
  padding-bottom: 5px;
}
fieldset.no-border {
  border-bottom: none;
}
</style>
