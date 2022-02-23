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
            {{ moment($route.params.update_id).format("DD/MM/Y") }}
          </h3>
          <form-wizard
            :finishButtonText="isUpdateMode ? 'Modifier' : 'Envoyer'"
            :startIndex="0"
            title="FORMULAIRE"
            subtitle
            shape="tab"
            color="#2e5bff"
            nextButtonText="Suivant"
            backButtonText="Précédent"
            @on-complete="onComplete"
          >

            <tab-content
              v-for="(formStep, index) in targetForm.form_steps"
              :key="index"
            >
              <h3 class="mb-4 text-center">{{ formStep.title }}</h3>

              <b-row align-h="center">
                <b-col cols="12" md="8">
                  <b-form-group
                    v-for="(formField, counter) in formStep.form_fields"
                    :key="counter"
                    :label="!!formField.rules.match(/required/i)? formField.name + ' * ' : formField.name"
                    :label-for="formField.name"
                  >

                    <b-row>
                      <b-col class="col-sm-12 col-md-12">
                        <FormFieldInput
                          v-model="completedForm.completed_form_fields[formField.id]"
                          :type="formField.form_field_type.name"
                          :placeholder="`Entrer ${formField.name}`"
                          :id="formField.name"
                          :rules="formField.rules"
                        />
                      </b-col>
                    </b-row>
                  </b-form-group>
                </b-col>
              </b-row>
            </tab-content>
            <tab-content>
              <b-row align-h="center">
                <b-col
                  v-for="(formStep, index) in targetForm.form_steps"
                  :key="index"
                  cols="12"
                  md="6"
                >
                  <h3 class="mb-4">{{ formStep.title }}</h3>
                  <div>
                    <div v-for="(formField, count) in formStep.form_fields" :key="count">
                    <ul>
                      <li>{{ formField.name }} : {{ completedForm.completed_form_fields[formField.id] }}</li>
                    </ul>
                  </div>
                  </div>
                </b-col>
              <b-col class="col-md-12">
                <b-alert show variant="warning" v-if="!user.isHospitalAdmin">
                <p class="text-center">NB: Une soumission ne peut plus être modifiée après 24 heures!</p>
              </b-alert>
              </b-col>
                <b-form-group class="no-border">
                  <label for="last_update" class="text-dash-color"
                    >Sélectionnez la date</label
                  >
                  <b-form-datepicker
                    v-model="completedForm.last_update"
                    :max="max"
                    required
                    id="last_update"
                    class="mb-2"
                    :disabled="isUpdateMode"
                  >
                  </b-form-datepicker>
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
import Header from '../../components/hospital/Header'
import Loading from '../../components/Loading'
import ManagerUserName from '../../components/hospital/ManagerUserName'
import FormFieldInput from '../../components/forms/FormFieldInput'
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import { mapState, mapActions } from 'vuex'

export default {
  components: {
    Header,
    ManagerUserName,
    Loading,
    FormWizard,
    TabContent,
    FormFieldInput
  },
  data () {
    const now = new Date()
    return {
      formSummary: [],
      completedForm: {
        completed_form_fields: {}
      },
      max: now,
      errors: {},
      isLoading: false,
      targetForm: {}
    }
  },
  computed: {
    ...mapState({
      user: state => state.auth.user,
      hospitalManagerName: state => state.hospital.hospitalManagerName,
      formSteps: state => state.formStep.formSteps,
      editionData: state => state.hospitalSituation.hospitalSituationDetail,
      isHospitalSituationLoading: state => state.hospitalSituation.isLoading,
      isUpdateMode () {
        return !!this.$route.params.update_id
      }
    }),

    backRoute () {
      // [TODO] fix backRou te
      if (this.user.isHospitalAdmin) {
        return {
          name: 'hospital.admin.data',
          params: { hospital_id: this.$route.params.hospital_id }
        }
      } else return { name: 'hospital.home' }
    }
  },

  async mounted () {
    this.targetForm = await this.formShow({ id: this.$route.params.form_id })
    if (this.isUpdateMode) {
      this.getHospitalSituations()
      console.log('completedForm:', this.editiondataMethod())
    }
    if (!this.hospitalManagerName) {
      this.$bvModal.show('nameModal')
    }
  },
  methods: {
    ...mapActions([
      'formShow',
      'createHospitalSituation',
      'updateHospitalSituation',
      'getHospitalSituationsDetail',
      'completedFormStore',
      'completedFormUpdate'
    ]),
    editiondataMethod () {
      this.targetForm.form_fields.forEach(item => {
        this.editionData.forEach(edit => {
          if (item.id === edit.id) {
            item.default_value = edit.default_value
          }
        })
      })
    },
    getHospitalSituations () {
      this.getHospitalSituationsDetail({
        isLoading: true,
        update_id: this.$route.params.update_id,
        hospital_id: this.$route.params.hospital_id
      })
    },

    onComplete () {
      this.isLoading = true
      this.errors = {}
      if (this.isUpdateMode) {
        this.completedForm._method = 'PUT'
        this.completedForm.updated_manager_name = this.hospitalManagerName
      } else {
        this.completedForm.created_manager_name = this.hospitalManagerName
      }

      this.submitCompletedForm(this.isUpdateMode ? this.completedFormUpdate : this.completedFormStore)
        .then(() => {
          if (this.user.isHospitalAdmin) {
            const additionalRoute = this.isUpdateMode ? `/${this.$route.params.hospital_id}` : ''
            this.$router.push(`/admin/hospitals${additionalRoute}`)
          } else {
            this.$router.push('/hospitals')
          }
        })
        .finally(() => {
          this.isLoading = false
        })
    },

    submitCompletedForm (method) {
      return new Promise((resolve, reject) => {
        this.completedForm.hospital_id = this.$route.params.hospital_id ? this.$route.params.hospital_id : this.user.hospital.id
        this.completedForm.form_id = this.targetForm.id
        method(this.completedForm)
          .then(() => {
            this.$notify({
              group: 'alert',
              title: 'Formulaire soumis avec succès',
              type: 'success'
            })
            resolve()
          })
          .catch((err) => {
            reject(err)
            this.$notify({
              group: 'alert',
              title: 'Une erreur est survenu',
              type: 'error'
            })
          })
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
