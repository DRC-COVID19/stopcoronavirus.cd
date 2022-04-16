<template>
  <div class="bug__container">
    <b-container class="mt-4 px-lg-5">
      <Loading
        v-if="isLoading"
        class="h-100"
        :message="message"
      />
      <b-row v-else align-h="center" class="px-md-5 px-lg-5">
        <b-col cols="12">
          <b-card class="p-md-5 p-lg-5 bg-dash">
            <b-link :to="backRoute">
              <span class="fa fa-chevron-left"> Retour</span>
            </b-link>
            <h2 class="h2 text-center">{{ title }}</h2>
            <h6 class="mb-4 mt-2 text-center text-label">
              Veuillez fournir des détails sur le problème que vous avez
              rencontré.
            </h6>
            <ValidationObserver
              v-slot="{ invalid }"
              ref="form"
              tag="form"
              novalidate
              @submit.prevent="onSubmit"
              @reset.prevent="onReset"
              label-class="text-dash-color"
            >
              <b-form-group class="border-0 m-0">
                <label id="input-group-3" class="text-dash-color text-label" for="input-3">
                  Nom <span class="text-danger">*</span></label
                >
                <FormFieldInput
                  v-model="form.name"
                  type="text"
                  :placeholder="`Entrer le nom`"
                  id="input-3"
                  rules="required"
                  name="Nom"
                  :state="stateForm.name"
                  mode="aggressive"
                />
                <b-form-text id="password-help-block" class="mb-4"
                  ><span class="text-danger">
                    {{ errors.name ? errors.name[0] : null }}</span
                  ></b-form-text
                >
              </b-form-group>
              <b-form-group class="border-0 m-0">
                <label id="input-group-3" class="text-dash-color text-label" for="input-3">
                  Prénom <span class="text-danger">*</span></label
                >
                <FormFieldInput
                  v-model="form.firstName"
                  type="text"
                  :placeholder="`Entrer le Prénom`"
                  id="input-3"
                  rules="required"
                  name="Prénom"
                  :state="stateForm.firstName"
                  mode="aggressive"
                />
                <b-form-text id="password-help-block" class="mb-4"
                  ><span class="text-danger">
                    {{ errors.firstName ? errors.firstName[0] : null }}</span
                  ></b-form-text
                >
              </b-form-group>
              <b-form-group class="border-0 m-0">
                <label id="input-group-2" class="text-dash-color text-label" for="input-2">
                  Adresse Email <span class="text-danger">*</span></label
                >
                <FormFieldInput
                  v-model="form.email"
                  type="email"
                  :placeholder="`Entrer l'Adresse Email`"
                  id="input-2"
                  rules="required|email"
                  name="Adresse email"
                  :state="stateForm.email"
                  mode="aggressive"
                />
                <b-form-text id="email-help-block" class="mb-4">
                  <span class="text-danger">
                    {{
                      errors.mail
                        ? errors.email[0]
                        : null || validatedMessage.mail
                    }}</span
                  >
                </b-form-text>
              </b-form-group>
              <b-form-group class="border-0 m-0">
              <label id="input-group-4" class="text-dash-color" for="input-4">
                 Numéro Téléphone <span class="text-danger">*</span></label
              >
              <FormFieldInput
                v-model="form.phone"
                type="text"
                :placeholder="`Ex: 0820000000`"
                id="input-4"
                name="Numéro de téléphone"
                rules="required|regex"
                :state="stateForm.phone"
                mode="aggressive"
              />
              <b-form-text id="password-help-block" class="mb-4"
                ><span class="text-danger">
                  {{ errors.phone ? errors.phone[0] : null }}</span
                ></b-form-text
              >
              </b-form-group>
              <b-form-group class="border-0 m-0">
                <FomFieldSelect
                  v-model="form.device"
                  :options="devices"
                  id="deviceId"
                  labelText="Type Appareil "
                  name="Type Appareil"
                  mode="aggressive"
                  :isObligated="true"
                  rules="required"
                  class="text-label"
                />
                <b-form-text id="password-help-block" class="mb-4"
                  ><span class="text-danger"> </span
                ></b-form-text>
              </b-form-group>
                <b-form-group class="border-0 m-0">
                <FomFieldSelect
                  v-model="form.occurence"
                  :options="occurences"
                  id="deviceId"
                  labelText="Combien de fois avez-vous rencontré ce problème ? "
                  name="Nombre de fois"
                  mode="aggressive"
                  :isObligated="true"
                  rules="required"
                  class="text-label"
                />
                <b-form-text id="password-help-block" class="mb-4"
                  ><span class="text-danger"> </span
                ></b-form-text>
              </b-form-group>
                <b-form-group class="border-0 mb-3">
                <FomFieldSelect
                  v-show="canViewAdmin"
                  v-model="form.page"
                  :options="adminPages"
                  id="deviceId"
                  labelText="Sur quelle page avez-vous rencontré ce problème ? "
                  name="Menu"
                  mode="aggressive"
                  :isObligated="true"
                  rules="required"
                  class="text-label"
                />
                <div v-if="!canViewAdmin">
                 <FomFieldSelect
                  v-show="canViewAgent"
                  v-model="form.page"
                  :options="agentPages"
                  id="deviceId"
                  labelText="Sur quelle page avez-vous rencontré ce problème ? "
                  name="Menu"
                  mode="aggressive"
                  :isObligated="true"
                  rules="required"
                  class="text-label"
                />
                </div>
                <b-form-text id="password-help-block" class="mb-2"
                  ><span class="text-danger"> </span
                ></b-form-text>
              </b-form-group>
              <b-form-group class="border-0 m-0">
              <label id="input-group-4" class="text-dash-color" for="input-4">
                 Copier l'URL de la page ( Optionnel )</label
              >
              <FormFieldInput
                v-model="form.pageURL"
                type="url"
                :placeholder="'Ex: https://dashboard.stopcoronavirusrdc.info/hospitals'"
                id="input-4"
                name="URL de la page"
              />
              <b-form-text id="password-help-block" class="mb-4"
                ><span class="text-danger">
                  {{ errors.phone ? errors.phone[0] : null }}</span
                ></b-form-text
              >
              </b-form-group>
             <div class="mb-4">
              <label for="dropzone" class="text-dash-color text-label">Joindre un fichier ( Optionnel )</label>
               <b-progress :value="progress" show-progress animated  variant="success" v-show="progress > 0"></b-progress>
               <vue2Dropzone
                ref="imgDropzone"
                id="dropzone"
                class="border border-1 rounded pe-auto"
                :useCustomSlot="true"
                :options="dropzoneOptions"
                :destroyDropzone="true"
                @vdropzone-success="uploadSuccess"
                @vdropzone-upload-progress="uploadProgress"
              >

                <div class="dropzone-custom-content">
                <i class="fas fa-cloud-upload-alt fa-3x"></i>
                <h4 class="dropzone-custom-title mb-0 mt-3">TELECHARGER UNE IMAGE</h4>
                <h6 class="subtitle text-label">Ajouter plusieurs images si vous le souhaitez</h6>
              </div>
              </vue2Dropzone>
             </div>
              <b-form-group class="border-0 m-0">
                <form-field-text-area
                  v-model="form.description"
                  type="text"
                  rules="required"
                  name="Description du Problème"
                  labelText="Description du Problème "
                  :state="errors.description ? false : null"
                  id="descriptionId"
                  :rows="4"
                  :isObligated="true"
                  class="text-label"
                />
                <b-form-text id="description-help-block"
                  ><span class="text-danger">{{
                    errors.description ? errors.description[0] : null
                  }}</span></b-form-text
                >
              </b-form-group>
              <b-row>
               <b-col class="d-flex justify-content-end align-items-center mt-4">
                  <b-button
                  type="submit"
                  variant="primary"
                  class="rounded btn__bug-tracker"
                  :disabled="invalid ? true : false|| uploading"
                >
                  <span v-if="isLoading"
                    ><b-spinner class="align-middle"></b-spinner>
                    <span>en cours ...</span>
                  </span>
                  <div v-else class="btn-submit">
                    {{ btnTitle }}
                  </div>
                </b-button>
                <b-button
                  type="reset"
                  variant="outline-danger"
                  class="ml-4 btn__bug-tracker"
                  @click="resetForm()"
                >
                  {{ "Réinitialiser" }}</b-button
                >
               </b-col>
              </b-row>
            </ValidationObserver>
          </b-card>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import Loading from '../../components/Loading'
import FormFieldInput from '../../components/forms/FormFieldInput'
import FomFieldSelect from '../../components/forms/FomFieldSelect'
import FormFieldTextArea from '../../components/forms/FormFieldTextArea'
import { ADMIN_HOSPITAL, AGENT_HOSPITAL } from '../../config/env'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import { mapState, mapActions } from 'vuex'
import { ValidationObserver } from 'vee-validate'
import axios from 'axios'
export default {
  components: {
    Loading,
    FomFieldSelect,
    FormFieldInput,
    FormFieldTextArea,
    ValidationObserver,
    vue2Dropzone
  },
  data () {
    const now = new Date()
    return {
      dateFormatted: { day: 'numeric', year: 'numeric', month: 'numeric' },
      btnTitle: 'Enregistrer',
      uploading: false,
      form: {
        name: '',
        firstName: '',
        email: '',
        phone: '',
        device: null,
        description: '',
        images: [],
        occurence: null,
        page: null,
        pageURL: ''
      },
      uploadUrl: 'https://httpbin.org/post',
      toToCanceled: false,
      stateForm: {
        name: null,
        firstName: null,
        email: null,
        phone: null,
        description: null,
        images: null,
        device: null,
        occurence: null,
        pageURL: null
      },
      cloudinaryConfig: {
        preset: 'uzcpaoas',
        apiURL: 'https://api.cloudinary.com/v1_1/www-kinshasadigital-com/image/upload',
        apiKey: '693455967377919'
      },
      validatedMessage: {
        mail: null
      },
      progress: null,
      devices: ['Ordinateur', 'Tablette', 'Téléphone'],
      occurences: ['1 fois', '2 fois', 'Plus de 2 fois'],
      adminPages: [' Admininstration', ' Dashboard', ' CTCOS'],
      agentPages: [' CTCOS', 'Autres'],
      max: now,
      errors: {},
      isLoading: false,
      title: 'Signaler un Problème',
      message: 'Chargement du formulaire',
      dropzoneOptions: {
        url: 'https://httpbin.org/post',
        thumbnailWidth: 150,
        maxFilesize: 5,
        maxFiles: 3,
        addRemoveLinks: true,
        acceptedFiles: '.jpg, .png, .gif',
        parallelUploads: 2,
        dictCancelUpload: 'Annuler',
        dictRemoveFile: 'Supprimer',
        dictRemoveFileConfirmation: 'Etes-vous sûr de supprimer cette image ?',
        dictCancelUploadConfirmation: "Etes-vous sûr d'annuler cette image ?"
      },
      data: {
        approval_status: 'pending',
        assignee_section: '1202084007644818',
        assignee_status: 'upcoming',
        completed: false,
        completed_by: null,
        due_at: null,
        due_on: null,
        html_notes: '',
        name: '',
        projects: [
          '1200603864497962'
        ],
        resource_subtype: 'default_task',
        start_at: null,
        parent: null,
        notes: '',
        followers: [],
        tags: [],
        workspace: '688460071936074'
      },
      attachements: []

    }
  },
  computed: {
    ...mapState({
      user: state => state.auth.user
    }),
    canViewAdmin () {
      return this.userHaveRole(ADMIN_HOSPITAL)
    },
    canViewAgent () {
      if (this.user.hospital) {
        return this.userHaveRole(AGENT_HOSPITAL)
      }
      return ''
    },
    backRoute () {
      // [TODO] fix backRou te
      if (this.user.isHospitalAdmin) {
        return {
          name: 'hospital.admin'
        }
      } else return { name: 'hospital.home' }
    }

  },
  mounted () {
    this.resetForm()
  },
  watch: {
    bugStored () {
      this.resetForm()
    }
  },
  methods: {
    ...mapActions(['formShow', 'bugTracker__addTask', 'bugTracker__addAttachementsToTask']),
    onReset () {
      this.$refs.form.reset()
      this.toToCanceled = true
      this.validatedMessage = {}
      this.form = {}
    },
    resetForm () {
      this.form = {}
      this.$refs.form.reset()
      this.isLoading = false
      this.$refs.imgDropzone.removeAllFiles(true)
    },
    uploadProgress (file, progress, byte) {
      this.uploading = true
      this.progress = progress
    },
    uploadSuccess (file, response) {
      try {
        const formData = new FormData()
        formData.append('file', file)
        formData.append('upload_preset', this.cloudinaryConfig.preset)
        formData.append('api_key', this.cloudinaryConfig.apiKey)
        formData.append('timestamp', (Date.now() / 1000) | 0)

        // cloudinary request API of upload images
        return axios.post(this.cloudinaryConfig.apiURL, formData, {
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        }).then(response => {
          const data = response.data
          this.$bvToast.toast('L\'image a été téléchargé avec succèss!', {
            title: 'Chargement des images',
            appendToast: true,
            variant: 'success',
            solid: true
          })
          this.attachements = []
          this.attachements.push(data)
          this.uploading = false
          this.progress = 0
        })
      } catch (error) {
        this.$bvToast.toast('Une erreur est survenue!', {
          title: 'Chargement image',
          appendToast: true,
          variant: 'danger',
          solid: true
        })
      }
    },
    onSubmit () {
      this.initializeDataForSubmission()
      if (this.form !== 0) {
        return new Promise((resolve, reject) => {
          this.bugTracker__addTask({ task: this.data })
            .then(({ data }) => {
              resolve(data)
              this.form = {}

              if (this.attachements.length !== undefined && this.attachements.length !== 0) {
                this.bugTracker__addAttachementsToTask({ task: data, attachements: this.attachements })
                  .then(({ data }) => {
                    this.isLoading = false
                    this.$bvToast.toast('Le problème a été soumis avec succèss', {
                      title: 'Signaler un Problème',
                      appendToast: true,
                      variant: 'success',
                      solid: true
                    })
                    resolve(data)
                  })
                  .catch((response) => {
                    this.$bvToast.toast('Une erreur est survenue!', {
                      title: 'Signaler un Problème',
                      appendToast: true,
                      variant: 'danger',
                      solid: true
                    })
                    this.isLoading = false
                    reject(response)
                  })
              } else {
                this.isLoading = false
                this.$bvToast.toast('Le problème a été soumis avec succèss', {
                  title: 'Signaler un Problème',
                  appendToast: true,
                  variant: 'success',
                  solid: true
                })
              }
            })
            .catch((response) => {
              this.$bvToast.toast('Une erreur est survenue!', {
                title: 'Signaler un Problème',
                appendToast: true,
                variant: 'danger',
                solid: true
              })
              reject(response)
            })
            .finally(() => {
              this.isLoading = false
            })
        })
      }
    },
    initializeDataForSubmission () {
      this.isLoading = true
      this.message = ' Votre requête est en cours de traitement...'
      this.errors = {}
      this.data.name = `[Bug: ${this.form.page}]: \t\n ${this.form.description.slice(0, 100)} ...`
      this.data.html_notes = this.renderHTMLContents()
    },
    renderHTMLContents () {
      const phone = this.form.phone.split('').slice(1, 10).join('')
      let pageURL = ''
      if (this.form.pageURL && this.form.pageURL !== undefined) {
        pageURL = `URL de la page: <a href="${this.form.pageURL}">${this.form.pageURL}</a>`
      }
      return `
      <body>
  
      Nom : ${this.form.name}
      Prénom : ${this.form.firstName}
      Email  : <a href="mailto:${this.form.email}" data-asana-accessible="true">${this.form.email}</a>
      Phone  : +243 ${phone}
      Type Appareil : ${this.form.device}
      Fréquence du problème : ${this.form.occurence}
      ${pageURL}
      
      <strong>Description du problème :</strong>
      ${this.form.description}.
      </body>`
    }

  }
}
</script>

<style scoped lang="scss">
@import "@~/sass/_variables";
#dropzone .dz-preview .dz-progress {
    display: none;
}
h2{
      font-size: 1.5rem;
      margin-top: 1rem;
}
.text-label{
   font-size: .85rem;
}
h4 {
   font-size: 1rem;
}
.subtitle{
  margin-top: .5rem;
}

@media screen and($small){
    h2{
      font-size: 1.6rem;
      margin-top: 1rem;
    }
    .btn__bug-tracker{
      width: 8rem;
      font-size: 1rem;
   }
  }
  @media screen and($medium){
    h2{
      font-size: 1.8rem;
      margin-top: 1rem;
    }
    h4 {
      font-size: 1.5rem;
    }
    .text-label{
      font-size: 1rem;
  }
   .btn__bug-tracker{
      width: 8rem;
      font-size: 1.2rem;
   }
   .bug__container {
      overflow-y: hidden;
    }
  }

  @media screen and($large){
    h2{
      font-size: 2.2rem ;
      margin-top: 1rem;
    }
  }
    @media screen and($x-large){
    h2{
      font-size: 2rem ;
      margin-top: 1rem;
    }
  }

.no-data {
  font-size: 12px;
  line-height: 26px;
  margin-top: 5px;
}
.bg-dash {
  box-shadow: -5px 10px 30px -1px rgba(107, 106, 106, 0.1);
  border: 0 !important;
}
fieldset {
  border-bottom: 1px solid rgb(0 0 0 / 0.1);
  padding-bottom: 5px;
}
fieldset.no-border {
  border-bottom: none;
}
.btn-container-calendar {
  border-radius: 5px;
  border: 1px solid #c3c8ced2;
  width: 100%;
  align-items: center;
  background-color: #f4f5fc;
  input {
    border: none !important;
    width: 100%;
    height: 100%;
    font-size: 14px;
    &:focus {
      border: none !important;
      outline: none !important;
    }
  }
  label {
    width: 15%;
    align-self: center;
    align-items: center;
    text-align: center;
  }
  &:hover {
    cursor: pointer;
  }
}
.style-picker {
  width: 80%;
}
 .more {
    display: inline-block;
    margin: 16px;
    border: 3px dashed lightgray;
    width: 200px;
    height: 200px;
    box-sizing: border-box;
    color: lightgray;
    border-radius: 8px;
    font-size: 60px;
    text-align: center;
    line-height: 200px;
    pointer-events: none;
  }
</style>
