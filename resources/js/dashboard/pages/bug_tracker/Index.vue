<template>
  <div class="bug__container">
    <b-container class="mt-4 px-lg-5">
      <Loading
        v-if="isLoading"
        class="h-100"
        message="Chargement du formulaire ..."
      />
      <b-row v-else align-h="center" class="px-md-5 px-lg-5">
        <b-col cols="12">
          <b-card class="p-md-5 p-lg-5 bg-dash">
            <b-link :to="backRoute">
              <span class="fa fa-chevron-left">Retour</span>
            </b-link>
            <h2 class="h2 text-center">{{ title }}</h2>
            <h6 class="mb-4 mt-2 text-center">
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
                <label id="input-group-3" class="text-dash-color" for="input-3">
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
                <label id="input-group-3" class="text-dash-color" for="input-3">
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
                <label id="input-group-2" class="text-dash-color" for="input-2">
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
                <FomFieldSelect
                  v-model="form.device"
                  :options="devices"
                  id="deviceId"
                  labelText="Type Appareil"
                  name="Type Appareil"
                  mode="aggressive"
                  :isObligated="true"
                  rules="required"
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
                  labelText="Nombre de fois que le problème a été découvert"
                  name="Type Appareil"
                  mode="aggressive"
                  :isObligated="true"
                  rules="required"
                />
                <b-form-text id="password-help-block" class="mb-4"
                  ><span class="text-danger"> </span
                ></b-form-text>
              </b-form-group>
              {{ JSON.stringify(projects) }}
              <!-- <vue2Dropzone
                ref="imgDropzone"
                id="dropzone"
                @vdropzone-upload-progress="uploadProgress"
                :useCustomSlot="true"
                :options="dropzoneOptions"
                @vdropzone-file-added="fileAdded"
                @vdropzone-sending-multiple="sendingFiles"
                @vdropzone-success-multiple="success"
                :destroyDropzone="true"
                @vdropzone-complete="afterComplete"
              >
                <div class="dropzone-custom-content">
                <i class="fas fa-cloud-upload-alt fa-3x"></i>
                <h4 class="dropzone-custom-title mb-0 mt-3">TELECHARGER UNE IMAGE</h4>
                <div class="subtitle">Ajouter plusieurs images si vous le souhaitez</div>
              </div>
              </vue2Dropzone> -->
              <b-form-group class="border-0 m-0">
                <form-field-text-area
                  v-model="form.description"
                  type="text"
                  rules="required"
                  name="Un Message"
                  labelText="Message"
                  :state="errors.description ? false : null"
                  id="descriptionId"
                  :rows="4"
                  :isObligated="true"
                />
                <b-form-text id="description-help-block"
                  ><span class="text-danger">{{
                    errors.description ? errors.description[0] : null
                  }}</span></b-form-text
                >
              </b-form-group>
              <b-row class="pt-lg-4 px-lg-4 pt-sm-2 px-sm-3 d-flex justify-content-lg-end justify-content-sm-between align-items-center">
                <b-button
                  type="submit"
                  variant="primary"
                  class="btn btn-sm"
                  :disabled="invalid ? true : false"
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
                  class="ml-4"
                  @click="resetForm()"
                >
                  {{ "Réinitialiser" }}</b-button
                >
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
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import { mapState, mapActions } from 'vuex'
import { ValidationObserver } from 'vee-validate'
import { ASANA_API_URL, ASANA_TOKEN } from '../../config/env'

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
      form: {
        name: '',
        firstName: '',
        email: '',
        device: null,
        description: '',
        images: []
      },
      toToCanceled: false,
      projects: [],
      stateForm: {
        name: null,
        firstName: null,
        email: null,
        description: null,
        images: null
      },
      validatedMessage: {
        mail: null
      },
      devices: ['Ordinateur', 'Téléphone'],
      occurences: [' Première fois', ' Regulièrement', ' Aucun'],
      max: now,
      errors: {},
      isLoading: false,
      title: 'Signaler un Problème',
      axiosOptions: {
        headers: {
          contentType: 'application/json',
          Accept: 'application/json',
          // 'Access-Control-Allow-Origin': '*',
          Authorization: `Basic ${ASANA_TOKEN}`
        }
      },
      dropzoneOptions: {
        url: 'https://httpbin.org/post',
        thumbnailWidth: 150,
        maxFilesize: 0.5,
        maxFiles: 5,
        addRemoveLinks: true,
        acceptedFiles: '.jpg, .png, .gif',
        parallelUploads: 3,
        dictDefaultMessage:
          "<i class='fas fa-cloud-upload-alt mr-2 text-primary'></i>TELECHARGER  IMAGE"
      }
    }
  },
  computed: {
    ...mapState({
      user: state => state.auth.user
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
  mounted () {
    this.resetForm()
    this.getProjects()
  },
  methods: {
    ...mapActions(['formShow']),
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
    },

    afterComplete (file) {
      try {
        const imageName = new Date().getDate()
        const metaData = {
          contentType: 'image/png'
        }
        this.images.push({ src: file })
        alert(JSON.stringify(file))
        this.$refs.imgdropzone.removeFile(file)
      } catch (error) {
        this.$bvToast.toast('Une erreur est survenue!', {
          title: 'Erreur du chargement des images',
          appendToast: true,
          variant: 'danger',
          solid: true
        })
        this.$el.removeChild(file)
        this.$refs.imgDropzone.removeFile(file)
      }
    },
    handleMoreThumbnail () {
      const dropzone = this.$refs.imgDropzone.dropzone
      dropzone.files.length > 0
        ? dropzone.element.appendChild(this.$refs.more)
        : dropzone.element.removeChild(this.$refs.more)
    },

    onSubmit () {
      this.isLoading = true
      this.errors = {}
      if (this.form !== 0) {
        this.isLoading = false
        alert(JSON.stringify(this.form))
        this.resetForm()
      }
    },
    getProjects () {
      this.isLoading = true
      return new Promise((resolve, reject) => {
        // eslint-disable-next-line no-undef
        axios
          .get(`${ASANA_API_URL}/projects`, this.axiosOptions)
          .then(({ data }) => {
            this.$$set('projects', data)
            this.isLoading = false
            resolve(true)
            alert('esimbi')
          })
          .catch((response) => {
            this.$bvToast.toast('Une erreur est survenue!', {
              title: 'Erreur du chargement des projets',
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
  }
}
</script>

<style scoped lang="scss">
@media screen and(max-width: 768px){
    h2{
      font-size: 1.6rem !important;
      margin-top: 1rem;
    }
  }
.bug__container {
  overflow-y: hidden;
}
.no-data {
  font-size: 12px;
  line-height: 26px;
  margin-top: 5px;
}
.bg-dash {
  box-shadow: -5px 10px 25px -1px rgba(0, 0, 0, 0.1);
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
