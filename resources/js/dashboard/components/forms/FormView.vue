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
            <b-link class="d-flex align-items-center" :to="{name: backRouteName}">
              <i class="fas fa-arrow-left mr-3" aria-hidden="true"></i> Retour
            </b-link>
          </b-col>
        </b-row>

        <b-row>
          <b-col lg="8" class="d-flex justify-content-center container-preview-title-form w-100 mb-3">
            <h3 v-if="targetForm.title" class="text-white text-center"> {{ targetForm.title.toUpperCase() || 'Formulaire'}} </h3>
          </b-col>
        </b-row>

        <b-row class="mt-4">
          <b-col lg="8" v-if="targetForm.form_steps && targetForm.form_steps.length > 0" class="px-0">
            <b-card class="text-center card-step default-card">
              <span v-if="!submitStep"> {{ targetForm.form_steps[currentStep - 1].title.toUpperCase() }}</span>
              <span v-else> Confirmation </span>
            </b-card>

            <b-card class="default-card mb-3 meta-info-card">
              <strong>*</strong> Champs requis
            </b-card>

            <div v-if="!submitStep && targetForm.form_steps[currentStep - 1].form_fields.length > 0">
              <b-card
                v-for="(formField, counter) in targetForm.form_steps[currentStep - 1].form_fields"
                :key="counter"
                class="default-card mb-3 field-card"
              >
                  <b-form-group
                    :label="
                      formField.rules && formField.rules.match(/required/i)
                        ? formField.name + ' * '
                        : formField.name
                    "
                    :label-for="formField.name"
                  >
                    <b-row>
                      <b-col class="col-sm-12 col-md-12">
                        <FormFieldInput
                          v-model=" completedForm.completed_form_fields[formField.id]"
                          :type="formField.form_field_type.name"
                          :placeholder="`Entrer ${formField.name}`"
                          :id="formField.name"
                          :rules="formField.rules"
                        />
                      </b-col>
                    </b-row>
                  </b-form-group>
              </b-card>
            </div>
            <div v-else-if="submitStep">
              <b-card class="default-card mb-3 field-card">
                <b-alert
                  show
                  variant="warning"
                  v-if="!user.isHospitalAdmin"
                >
                  <p class="text-center">
                    NB: Une soumission ne peut plus être modifiée après 24
                    heures!
                  </p>
                </b-alert>
                <b-form-group class="no-border">
                  <div
                    class="text-center text-danger my-2"
                    v-if="isLastUpdateChecking"
                  >
                    <b-spinner class="align-middle" />
                    <strong>Verification de la date de Mise a jour...</strong>
                  </div>
                  <label for="last_update" class="text-dash-color">Sélectionnez la date *</label>
                  <v-date-picker
                    v-model="completedForm.last_update"
                    opens="center"
                    :max-date="maxDate"
                    class="d-flex style-picker"
                    @input="selectLastUpdate()"
                  >
                    <template v-slot="{ inputEvents, inputValue }">
                      <div class="w-100">
                        <b-form-input
                          :value="
                            inputValue
                              ? moment(completedForm.last_update).format('DD.MM.YYYY')
                              : 'Choisir la date'
                          "
                          :disabled="isUpdateMode"
                          v-on="inputEvents"
                          class="date-picker-input"
                          placeholder="Sélectionner une date"
                          readonly
                        >
                        </b-form-input>
                      </div>
                    </template>
                  </v-date-picker>
                </b-form-group>
              </b-card>
            </div>
            <b-card v-else class="default-card text-muted text-center">Aucun champ créer pour l'instant</b-card>
          </b-col>
          <b-col lg="8" v-else-if="!isLoading">
            <p>Aucune étape n'a été créée pour l'instant</p>
          </b-col>
        </b-row>

        <b-row  class="mt-4">
          <b-col lg="8" class="px-0 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <b-col lg="auto" class="px-0 text-center text-md-left mr-md-3">
              <b-button
                :disabled="currentStep === 1"
                variant="outline-primary"
                size="sm"
                @click="onPrevStep"
              >
                <small>Précédent</small>
              </b-button>
            </b-col>

            <b-col lg class="d-flex flex-wrap align-items-center justify-content-center my-4 my-md-0">
              <div class="mr-4 my-2 d-flex col align-items-center">
                <div class="col">
                  <b-progress
                    :value="currentStep"
                    :max="targetForm.form_steps.length + 1"
                    class="form-progress d-none d-lg-flex"
                    height="8px"
                  >
                  </b-progress>
                </div>
                <small class="font-weight-bold">Etape {{ currentStep }} sur {{ targetForm.form_steps.length + 1 }}</small>
              </div>
              <div class="my-2">
                <b-pagination
                  v-model="currentStep"
                  :total-rows="targetForm.form_steps.length + 1"
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
                variant="primary"
                size="sm"
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
import FormFieldInput from './FormFieldInput.vue'
import Loading from '../Loading'
import { mapState, mapActions } from 'vuex'

export default {
  components: { FormFieldInput, Loading },
  props: {
    preview: { type: Boolean, default: false },
    backRouteName: String
  },
  data () {
    return {
      targetForm: {},
      currentStep: 1,
      completedForm: {
        completed_form_fields: {},
        checkLastUpdate: null
      },
      isLoading: false,
      isLastUpdateChecking: false,
      maxDate: new Date()
    }
  },
  async mounted() {
    this.isLoading = true
    this.targetForm = await this.formShow({ id: this.$route.params.form_id })
    this.isLoading = false
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user
    }),
    submitStep () {
      return this.currentStep === this.targetForm.form_steps.length + 1
    },
    isUpdateMode () {
      return !!this.$route.params.completed_form_id
    }
  },
  methods: {
    ...mapActions([
      'formShow'
    ]),
    onNextStep() {
      if (this.currentStep + 1 <= this.targetForm.form_steps.length + 1) {
        this.currentStep++
      }
    },
    onPrevStep() {
      if (this.currentStep - 1 >= 1) {
        this.currentStep--
      }
    },
    selectLastUpdate() {
      // to implement
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
.container-preview-field-form {
  background-color: white;
  height: 150px;
  border: 1px solid rgba(0, 0, 0, 0.26);
  border-radius: 5px;
  align-items: center;
  align-content: center;
}
.card-step {
  background-color: $dash-blue;
  color: white;
  border-radius: 15px 15px 0px 0px;
  text-transform: uppercase;
  .card-body {
    padding: 5px 20px;
  }
}
.field-card, .meta-info-card {
  border-radius: 15px;
  .card-body {
    padding: 30px;
  }
}
.meta-info-card {
  border-radius: 0px 0px 15px 15px;
}
.date-picker-input {
  &.form-control[readonly]{
    background-color: white;
  }
}
.pagination  {
  margin-bottom: 0px;
}
.form-progress {
  background-color: rgba(0,0,0,.1);
}
</style>
