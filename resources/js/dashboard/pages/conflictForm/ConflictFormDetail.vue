<template>
  <b-container class="mx-0 px-4 container-preview" fluid>
    <b-container>
      <Loading
        v-if="isLoading"
        class="h-100"
        message="Chargement du formulaire ..."
      />
      <div v-else class="pb-5">
          <b-row>
            <b-col lg="8" class="d-flex container-preview-back w-100 mb-3">
              <b-link class="d-flex align-items-center" :to="{name: 'admin.conflict.form'}">
                <i class="fas fa-arrow-left mr-3" aria-hidden="true"></i> Revenir aux formulaire
              </b-link>
            </b-col>
          </b-row>
          <b-row>
            <b-col lg="8" class="d-flex justify-content-center container-preview-title-form w-100 mb-3 flex-wrap">
              <h3  class="text-white text-center w-100"> {{ $route.params.form_title.toUpperCase() || 'Formulaire'}} </h3>
              <h4 class="text-white text-align-center-right">Hôpital:{{$route.params.hospital_name}}</h4>
            </b-col>
          </b-row>
          <b-row class="mt-4">
            <b-col lg="8">
              <b-card class="default-card first-card mb-5">
                <b-card-header>
                  <h5 class="text-center conflict-title">Gestion des Conflicts</h5>
                </b-card-header>
                <b-card-body>
                    <b-form-group
                      label-class="text-dash-color"
                      class="mt-4"
                      id="input-group-1"
                      v-slot="{ ariaDescribedby }"
                    >
                      <b-form-radio
                        v-model="form.oldValue"
                        :aria-describedby="ariaDescribedby"
                        name="some-radios"
                        :value="true"
                        class="text-red-keep"
                        @input="keepOldValue"
                        >Conserver la soumission de {{completedFormsHospitalForm ? completedFormsHospitalForm[0].created_manager_name:''}}, Enregistré le {{moment(completedFormsHospitalForm[0].created_at).format('DD/MM/YYYY')}} </b-form-radio
                      >
                      <b-form-radio
                        v-model="form.newValue"
                        :aria-describedby="ariaDescribedby"
                        name="some-radios"
                        :value="false"
                        class="text-blue-keep mt-3"
                        @input="keepNewValue"
                        >Conserver ma soumission,Enregistré le {{moment($route.params.last_update).format('DD/MM/YYYY')}}</b-form-radio
                      >
                  </b-form-group>
                </b-card-body>
              </b-card>
              <b-card class="text-center card-step form-display-conflict">
                <span>{{formSteps[0].form_steps[currentStep - 1].title.toUpperCase()}}</span>
              </b-card>
              <div v-if=" formSteps[0].form_steps[currentStep - 1].form_fields.length > 0">
                <b-card
                  v-for="(field, index) in formSteps[0].form_steps[currentStep - 1].form_fields"
                  :key="index"
                  class="default-card mb-3 meta-info-card"
                >
                  <p>{{field.name}}</p>
                  <b-form-group
                    label-class="text-dash-color"
                    class="mt-4"
                    v-slot="{ ariaDescribedby }"
                  >
                   <b-form-radio
                      v-model="completedForm.completed_form_field[field.id]"
                      :aria-describedby="ariaDescribedby"
                      :name="field.name"
                      :value="getResponse(field.id).value"
                      class="text-red-keep"
                      @input="selectedOneOldValue"
                    >
                     {{getResponse(field.id).value}}
                    </b-form-radio>
                   <b-form-radio
                      v-model="completedForm.completed_form_field[field.id]"
                      :aria-describedby="ariaDescribedby"
                      :name="field.name"
                      :value="getResponseHistories(field.id).value"
                      class="text-blue-keep mt-3"
                      @input="selectedOneNewValue"
                    >
                     {{getResponseHistories(field.id).value}}
                    </b-form-radio>
                  </b-form-group>
                </b-card>
              </div>
            </b-col>
          </b-row>
          <b-row class="mt-4">
            <b-col lg="8" class="px-0 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
              <b-col lg="auto" class="px-0 text-center text-md-left mr-md-3">
                 <b-button
                    :disabled="currentStep === 1"
                    variant="outline-primary"
                    size="sm"
                    type="submit"
                    @click="onPrevStep"
                  >
                    <small>Précédent</small>
                  </b-button>
              </b-col>
              <b-col lg class="d-flex flex-wrap align-items-center justify-content-center my-4 my-md-0">
                <div class="mx-4 my-2 d-flex col align-items-center justify-content-center">
                  <div class="col d-none d-lg-block">
                    <b-progress
                      :value="currentStep"
                      :max="formSteps[0].form_steps.length"
                      class="form-progress"
                      height="8px"
                    >
                    </b-progress>
                  </div>
                  <small class="font-weight-bold">Etape {{ currentStep }} sur {{ formSteps[0].form_steps.length }}</small>
                </div>
                <div class="my-2">
                  <b-pagination
                    v-model="currentStepPaginate"
                    :total-rows="formSteps[0].form_steps.length"
                    :per-page="1"
                    size="sm"
                  ></b-pagination>
                </div>
              </b-col>
              <b-col lg="auto" class="px-0 text-center text-md-right ml-md-3">
                <b-button
                  v-if="!submitStep"
                  variant="primary"
                  size="sm"
                  @click="onNextStep"
                >
                  <small>Suivant</small>
                </b-button>
                  <b-button
                    v-if="submitStep"
                    type="submit"
                    variant="primary"
                    size="sm"
                    @click="onComplete"
                  >
                    <small>Soumettre</small>
                  </b-button>
              </b-col>
            </b-col>
          </b-row>
      </div>
    </b-container>
  </b-container>
</template>
<script>
import Loading from '../../components/Loading.vue'
import { mapActions } from 'vuex'
export default {
  components: {
    Loading
  },
  data () {
    return {
      isLoading: false,
      currentStep: 1,
      currentStepPaginate: 1,
      completedFormsHospitalForm: [],
      formSteps: [],
      maxStepReached: 1,
      form: {},
      completedForm: {
        completed_form_field: {}
      },
      containerToScroll: document.querySelector('.ctco-container-body')
    }
  },
  mounted () {
    this.completedFormByFormAndHospital()
    this.completedFormConflict()
  },
  computed: {
    submitStep () {
      return this.currentStep === this.formSteps[0].form_steps.length
    }
  },
  watch: {
    currentStep (value) {
      this.currentStepPaginate = value
      if (value > this.maxStepReached) {
        this.maxStepReached = value
      }
      this.containerToScroll.scrollTo({ top: 0, behavior: 'smooth' })
    }
  },
  methods: {
    ...mapActions(['getCompletedFormByHospital', 'getCompletedFormConflict', 'completedFormHistoryStore']),
    async completedFormByFormAndHospital () {
      this.isLoading = true
      this.completedFormsHospitalForm = await this.getCompletedFormByHospital({
        form_id: this.$route.params.form_id,
        hospital_id: this.$route.params.hospital_id,
        last_update: this.$route.params.last_update
      })
      this.isLoading = false
    },
    async completedFormConflict () {
      this.isLoading = true
      this.formSteps = await this.getCompletedFormConflict({
        form_id: this.$route.params.form_id
      })
      this.isLoading = false
    },
    getResponse (formFieldId) {
      return this.completedFormsHospitalForm[0].completed_form_fields.find(field => field.form_field_id === formFieldId)
    },
    getResponseHistories (formFieldId) {
      return this.$route.params.field_histories.find(field => field.form_field_id === formFieldId)
    },
    onNextStep () {
      if (this.currentStep + 1 <= this.formSteps[0].form_steps.length) {
        this.currentStep++
      }
    },
    onPrevStep () {
      if (this.currentStep - 1 >= 1 && this.currentStep === this.maxStepReached) {
        this.currentStep--
      }
    },
    keepOldValue () {
      this.formSteps[0].form_steps.forEach(step => {
        step.form_fields.forEach(field => {
          if (this.getResponse(field.id)) {
            this.completedForm.completed_form_field[field.id] = this.getResponse(field.id).value
          }
        })
      })
      this.completedForm = { ...this.completedForm }
    },
    keepNewValue () {
      this.formSteps[0].form_steps.forEach(step => {
        step.form_fields.forEach(field => {
          if (this.getResponseHistories(field.id)) {
            this.completedForm.completed_form_field[field.id] = this.getResponseHistories(field.id).value
          }
        })
      })
      this.completedForm = { ...this.completedForm }
    },
    // selectedOneOldValue () {
    //   this.form.newValue = null
    // },
    // selectedOneNewValue () {
    //   this.form.oldValue = null
    // },
    onComplete () {
      this.completedFormHistoryStore({
        form_id: this.$route.params.form_id,
        hospital_id: this.$route.params.hospital_id,
        completed_form_fields: this.completedForm.completed_form_field,
        completed_form_id: this.completedFormsHospitalForm[0].id,
        completed_form_history_id: this.$route.params.id,
        created_manager_name: this.completedFormsHospitalForm[0].created_manager_name,
        created_manager_first_name: this.completedFormsHospitalForm[0].created_manager_first_name,
        last_update: this.completedFormsHospitalForm[0].last_update
      })
        .then(() => {
          this.$notify({
            group: 'alert',
            title: 'Statut de la soumission',
            text: 'Conflict résolus avec succès',
            type: 'success'
          })
          this.$router.push({ name: 'admin.conflict.form' })
        })
        .catch(err => {
          this.$notify({
            group: 'alert',
            title: 'Une erreur s\'est produite, veuillez contacter l\'administrateur !',
            text: 'Impossible de soumettre vos réponses',
            type: 'error',
            duration: 10000
          })
          console.log(err)
        })
    }
  }
}
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";
.container-preview {
  padding-top: 3%;
  background: #f4f6fc;
  min-height: 100vh;
}
.container-preview-back {
  i {
    color: $dash-blue;
    font-size: 20px;
  }
}
.container-preview-title-form {
  background-color: $dash-blue;
  height: 150px;
  align-items: center;
  align-content: center;
}
.first-card{
  border-radius: 15px 15px 0px 0px;
}
.conflict-title{
  font-weight: bold;
}
.text-red-keep{
  color: red;
}
.text-blue-keep{
  color: blue;
}
.card-step{
  border-radius: 15px 15px 0px 0px;
  background-color: $dash-blue;
  color: white;
  font-size: 20px;
  padding: 10px;
}
</style>
