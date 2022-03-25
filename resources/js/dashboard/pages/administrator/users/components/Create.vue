<template>
  <b-card>
    <h2 class="h2">{{ title }}</h2>
    <b-form
      @submit.prevent="onSubmit"
      @reset.prevent="onReset"
      v-if="show"
      label-class="text-dash-color"
    >
      <label id="input-group-1" class="text-dash-color" for="input-1">Nom d'utilisateur  <span class="text-danger">*</span></label>
      <FormFieldInput
        v-model="form.username"
        type="text"
        :placeholder="`Entrer le nom d'utilisateur`"
        id="input-1"
        :required="true"
        class="input-dash"
        :state="stateForm.username"
        />
           <b-form-text id="password-help-block" class="mb-4"
        ><span class="text-danger">
          {{ errors.username ? errors.username[0] : null }}</span
        ></b-form-text
      >
      <label id="input-group-2" class="text-dash-color" for="input-2">
       Adresse mail  <span class="text-danger">*</span></label>
      <FormFieldInput
        v-model="form.email"
        type="email"
        :placeholder="`Entrer l'adresse mail`"
        id="input-2"
        :required="true"
        class="input-dash"
        :state="stateForm.email"
        @input="validateMail() "
      />
      <b-form-text id="email-help-block" class="mb-4">
        <span class="text-danger"> {{ errors.mail ? errors.email[0] : null || validatedMessage.mail }}</span>
      </b-form-text>
       <label id="input-group-3" class="text-dash-color" for="input-3">
      Nom <span class="text-danger">*</span></label>
         <FormFieldInput
        v-model="form.name"
        type="text"
        :placeholder="`Entrer le nom`"
        id="input-3"
        :required="true"
        class="input-dash"

        :state="stateForm.name"
      />
         <b-form-text id="password-help-block" class="mb-4"
        ><span class="text-danger">
          {{ errors.name ? errors.name[0] : null}}</span
        ></b-form-text
      >
      <label id="input-group-4" class="text-dash-color" for="input-4">
      Numéro Téléphone <span class="text-danger">*</span></label>
         <FormFieldInput
        v-model="form.phoneNumber"
        type="text"
        :placeholder="`Ex: 0820000000`"
        id="input-4"
        :required="true"
        class="input-dash"
        @input="validatePhoneNumber() "
        :state="stateForm.phoneNumber"
      />
      <b-form-text id="phonenumber-help-block" class="mb-4"
        ><span class="text-danger">
          {{ errors.phoneNumber ? errors.phoneNumber[0] : null || validatedMessage.phoneNumber }}</span
        ></b-form-text
      >
      <label class="text-dash-color" for="check-group-1">Roles <span class="text-danger">*</span></label>
      <v-select
        v-model="form.roles"
        multiple
        :options="roles"
        label="name"
        :reduce="(item) => item.id"
        :searchable="false"
      />
        <b-form-text id="password-help-block"  class="mb-4"><span class="text-danger">
          </span
        ></b-form-text>
      <label class="text-dash-color" for="check-group-1">Hopital</label>
      <v-select
        v-model="form.hospitals"
        multiple
        :options="hospitals"
        label="name"
        :reduce="(item) => item.id"
        :searchable="false"
      />
        <b-form-text id="password-help-block"  class="mb-4"><span class="text-danger">
          </span
        ></b-form-text>
      <label class="text-dash-color" for="text-password">Mot de passe <span class="text-danger">*</span></label>
      <FormFieldInput
        v-model="form.password"
        type="password"
        id="text-password"
        :required="true"
        class="input-dash"
        :disabled="disablePassword"
        :state="stateForm.password"
      />
        <b-form-text id="password-help-block"  class="mb-4"><span class="text-danger"></span
        ></b-form-text>
      <label class="text-dash-color" for="text-password-confirm"
        >Confirmation de mot de passe <span class="text-danger">*</span></label
      > <FormFieldInput
        v-model="form.confirmPassword"
        type="password"
        id="text-password-confirm"
        :required="true"
        class="input-dash"
        :disabled="disablePassword"
        :state="stateForm.confirmPassword"
        :@input="warningMissMatch()"
      />
      <b-form-text id="password-help-block"  class="mb-4"><span class="text-danger">
          {{ validatedMessage.password }}</span
        ></b-form-text>
      <b-row class="px-3 pt-4 d-flex justify-content-start">
        <b-button type="submit" variant="primary"  class="btn-dash-sucess">
          <span v-if="isLoading"
            ><b-spinner class="align-middle"></b-spinner>
            <span>en cours ...</span>
          </span>
          <div v-else disabled class="btn-submit">
            {{ btnTitle }}
          </div>
        </b-button>
        <b-button
          type="reset"
          variant="primary"
          class="ml-4 btn-dash-danger"
          @click="resetForm()"
        >
          {{ updating ? "Annuler" : "Rénitialiser" }}</b-button
        >
      </b-row>
    </b-form>
  </b-card>
</template>

<script>
import FormFieldInput from '../../../../components/forms/FormFieldInput'

export default {
  components: {
    FormFieldInput
  },
  props: {
    userAdded: {
      type: Boolean,
      required: false,
      default: false
    },
    userUpdated: {
      type: Boolean,
      required: false,
      default: false
    },
    formToPopulate: {
      type: Object,
      required: false,
      default: () => {
        return {}
      }
    },
    roles: {
      type: Array,
      default: () => {
        return []
      }
    },
    hospitals: {
      type: Array,
      default: () => {
        return []
      }
    },
    errors: {
      type: Object,
      default: () => ({})
    }
  },
  data () {
    return {
      title: 'Nouveau utilisateur',
      btnTitle: 'Enregistrer',
      iconClass: 'fas fa-plus-square',
      updating: false,
      isLoading: false,
      validatedMessage: {
        mail: null,
        phoneNumber: null,
        password: null
      },
      disablePassword: false,
      stateForm: {
        username: null,
        name: null,
        hospitals: null,
        email: null,
        password: null,
        confirmPassword: null,
        phoneNumber: null
      },
      form: {
        username: '',
        name: '',
        roles: [],
        hospitals: [],
        email: '',
        password: '',
        confirmPassword: '',
        phoneNumber: ''
      },
      show: true,
      showWarning: false,
      toBeCanceled: true
    }
  },
  mounted () {
    this.resetForm()
  },
  watch: {
    userAdded () {
      this.resetForm()
    },
    userUpdated () {
      this.resetForm()
    },
    formToPopulate () {
      this.resetForm()
      this.populateForm()
    },
    errors () {
      this.errorForm()
    }
  },
  methods: {
    onSubmit () {
      console.log('form', this.form)
      if (!this.validatedMessage.phoneNumber && !this.validatedMessage.mail) {
        this.isLoading = true
        if (this.btnTitle === 'Enregistrer') {
          if (this.form.password === this.form.confirmPassword) {
            this.$emit('onCreate', this.form)
          } else {
            this.showWarning = true
          }
        } else {
          this.$emit('onUpdate', this.form)
        }
      }
    },

    onReset () {
      this.toToCanceled = true
      this.validatedMessage = {}
      this.form = {}

      this.stateForm.email = null
      this.stateForm.confirmPassword = null
      this.stateForm.username = null
      this.stateForm.name = null
      this.stateForm.phoneNumber = null

      this.title = 'Nouveau utilisateur'
      this.btnTitle = 'Enregistrer'
      this.$emit('onCancelUpdate', {})
    },

    validateMail () {
      const re =
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      console.log(' this.validatedMessage.mail', this.form.email)

      if (!this.form.email) {
        this.stateForm.email = null
        this.validatedMessage.mail = ''
      } else if (!re.test(String(this.form.email).toLowerCase())) {
        this.stateForm.email = false
        this.validatedMessage.mail = 'Adresse email incorrecte'
      } else if (re.test(String(this.form.email).toLowerCase())) {
        this.stateForm.email = true
        this.validatedMessage.mail = ''
      }
    },
    validatePhoneNumber () {
      const regexPhoneNumber = /^0[8-9][0-9]{8}$/
      console.log(' this.regexPhoneNumber', regexPhoneNumber.test(this.form.phoneNumber))

      if (!this.form.phoneNumber) {
        this.stateForm.phoneNumber = null
        this.validatedMessage.phoneNumber = ''
      } else if (!regexPhoneNumber.test(this.form.phoneNumber)) {
        this.validatedMessage.phoneNumber = 'Numéro de téléphone incorrect'
        this.stateForm.phoneNumber = false
      } else if (regexPhoneNumber.test(this.form.phoneNumber)) {
        this.validatedMessage.phoneNumber = ''
        this.stateForm.phoneNumber = true
      }
    },

    resetForm () {
      this.updating = false
      this.isLoading = false
      this.disablePassword = false

      this.validatedMessage = {}

      this.stateForm.email = null
      this.stateForm.confirmPassword = null
      this.stateForm.phoneNumber = null
      this.stateForm.username = null
      this.stateForm.name = null
      this.form = {}
      if (this.userAdded | this.userUpdated) {
        this.btnTitle = 'Enregistrer'
        this.title = 'Nouveau utilisateur'
      }
      this.$emit('onReset')
    },

    populateForm () {
      this.updating = true
      this.disablePassword = true
      this.form.id = this.formToPopulate.id
      this.form.username = this.formToPopulate.usernmae
      this.form.email = this.formToPopulate.email
      this.form.phoneNumber = this.formToPopulate.phone_number
      this.form.roles = this.formToPopulate.roles.map((role) => role.id)
      this.form.hospitals = this.formToPopulate.hospitals.map(
        (hospital) => hospital.id
      )
      this.form.name = this.formToPopulate.name
      this.title = "Modification de l'utilisateur"
      this.btnTitle = 'Modifier'
    },
    errorForm () {
      if (this.errors.username) {
        this.stateForm.username = false
      } if (this.errors.phoneNumber) {
        this.stateForm.phoneNumber = false
      }
      if (this.errors.name) {
        this.stateForm.name = false
      }
      if (!this.errors.username && this.form.username) {
        this.stateForm.username = true
      } if (!this.errors.phoneNumber && this.form.phoneNumber) {
        this.stateForm.phoneNumber = true
      }
      if (!this.errors.name && this.form.name) {
        this.stateForm.name = true
      }
      if (!this.errors.username && !this.form.username) {
        this.stateForm.username = null
      } if (!this.errors.phoneNumber && !this.form.phoneNumber) {
        this.stateForm.phoneNumber = null
      }
      if (!this.errors.name && !this.form.name) {
        this.stateForm.name = null
      }
    },
    warningMissMatch () {
      if (!this.form.confirmPassword && !this.form.password) {
        this.validatedMessage.password = ''
        this.stateForm.confirmPassword = null
      } else if (this.form.password !== this.form.confirmPassword) {
        this.stateForm.confirmPassword = false
        this.validatedMessage.password = 'Le mot de passes ne correspond pas'
      } else if (this.form.password === this.form.confirmPassword) {
        this.validatedMessage.password = ''
        this.stateForm.confirmPassword = true
      }
    }
  },

  computed: {

  }
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.main {
  background-color: white;
  border-radius: 10px;
  h2 {
    margin-bottom: 20px;
  }
}
.btn-submit[disabled='disabled'] {
  opacity: 0.6;
  cursor: not-allowed;
}
</style>
