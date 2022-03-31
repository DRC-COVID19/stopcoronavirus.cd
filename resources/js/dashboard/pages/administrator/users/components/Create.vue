<template>
  <b-card>
    <h2 class="h2">{{ title }}</h2>
    <ValidationObserver
      v-slot="{ invalid }"
      ref="form"
      tag="form"
      novalidate
      @submit.prevent="onSubmit"
      @reset.prevent="onReset"
      v-if="show"
      label-class="text-dash-color"
    >
      <label id="input-group-1" class="text-dash-color" for="input-1"
        >Nom d'utilisateur <span class="text-danger">*</span></label
      >
      <FormFieldInput
        v-model="form.username"
        type="text"
        :placeholder="`Entrer le nom d'utilisateur`"
        id="input-1"
        rules="required"
        name="nom d'utilisateur"
        :state="stateForm.username"
        mode="aggressive"
      />
      <b-form-text id="password-help-block" class="mb-4"
        ><span class="text-danger">
          {{ errors.username ? errors.username[0] : null }}</span
        ></b-form-text
      >
      <label id="input-group-2" class="text-dash-color" for="input-2">
        Adresse mail <span class="text-danger">*</span></label
      >
      <FormFieldInput
        v-model="form.email"
        type="email"
        :placeholder="`Entrer l'adresse mail`"
        id="input-2"
        rules="required|email"
        name="adresse mail"
        :state="stateForm.email"
        mode="aggressive"
      />
      <b-form-text id="email-help-block" class="mb-4">
        <span class="text-danger">
          {{
            errors.mail ? errors.email[0] : null || validatedMessage.mail
          }}</span
        >
      </b-form-text>
      <label id="input-group-3" class="text-dash-color" for="input-3">
        Nom <span class="text-danger">*</span></label
      >
      <FormFieldInput
        v-model="form.name"
        type="text"
        :placeholder="`Entrer le nom`"
        id="input-3"
        rules="required"
        name="nom"
        :state="stateForm.name"
        mode="aggressive"
      />
      <b-form-text id="password-help-block" class="mb-4"
        ><span class="text-danger">
          {{ errors.name ? errors.name[0] : null }}</span
        ></b-form-text
      >
      <label id="input-group-4" class="text-dash-color" for="input-4">
        Numéro Téléphone <span class="text-danger">*</span></label
      >
      <FormFieldInput
        v-model="form.phoneNumber"
        type="text"
        :placeholder="`Ex: 0820000000`"
        id="input-4"
        name="numero"
        rules="required|regex"
        :state="stateForm.phoneNumber"
        mode="aggressive"
      />
      <b-form-text id="password-help-block" class="mb-4"
        ><span class="text-danger">
          {{ errors.phone_number ? errors.phone_number[0] : null }}</span
        ></b-form-text
      >
      <FomFieldSelect
        v-model="form.roles"
        :options="roles"
        label="name"
        :reduce="(item) => item.id"
        id="roleId"
        labelText="Rôles"
        name="rôle"
        mode="aggressive"
        :isMultiple="true"
        :isObligated="true"
        rules="required"
      />
      <b-form-text id="password-help-block" class="mb-4"
        ><span class="text-danger"> </span
      ></b-form-text>
      <FomFieldSelect
        v-model="form.hospitals"
        :options="hospitals"
        label="name"
        :reduce="(item) => item.id"
        id="hopitalId"
        labelText="Hopital(CTCO)"
        name="Hopital(CTCO)"
        mode="aggressive"
      />
      <b-form-text id="password-help-block" class="mb-4"
        ><span class="text-danger"> </span
      ></b-form-text>
      <label class="text-dash-color" for="text-password"
        >Mot de passe <span class="text-danger" v-if="!updating">*</span></label
      >
      <FormFieldInput
        v-model="form.password"
        type="password"
        id="text-password"
        vid="pass"
        :rules="`${!updating ? 'required' : ''}`"
        name="mot de passe"
        :state="stateForm.password"
        mode="aggressive"
      />
      <b-form-text id="password-help-block" class="mb-4"
        ><span class="text-danger"></span
      ></b-form-text>
      <label class="text-dash-color" for="text-password-confirm"
        >Confirmation de mot de passe
        <span class="text-danger" v-if="!updating">*</span></label
      >
      <FormFieldInput
        v-model="form.confirmPassword"
        type="password"
        id="text-password-confirm"
        :rules="`${!updating ? 'required|confirmed:pass' : ''}`"
        name="mot de passe confirmé"
        mode="aggressive"
      />
      <b-form-text id="password-help-block" class="mb-4"
        ><span class="text-danger"></span
      ></b-form-text>
      <b-row class="px-3 pt-4 d-flex justify-content-start">
        <b-button
          type="submit"
          variant="primary"
          :disabled="btnTitle === 'Enregistrer' ? invalid : false"
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
          {{ updating ? "Annuler" : "Réinitialiser" }}</b-button
        >
      </b-row>
    </ValidationObserver>
  </b-card>
</template>

<script>
import FormFieldInput from '../../../../components/forms/FormFieldInput'
import FomFieldSelect from '../../../../components/forms/FomFieldSelect'
import { ValidationObserver } from 'vee-validate'

export default {
  components: {
    FormFieldInput,
    FomFieldSelect,
    ValidationObserver
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
      title: 'Nouveau Utilisateur',
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
    async onSubmit () {
      const valid = await this.$refs.form.validate()
      if (valid) {
        this.isLoading = true
        if (this.btnTitle === 'Enregistrer') {
          this.$emit('onCreate', this.form)
        } else {
          this.$emit('onUpdate', this.form)
        }
      }
    },

    onReset () {
      this.$refs.form.reset()
      this.toToCanceled = true
      this.validatedMessage = {}
      this.form = {}

      this.stateForm.email = null
      this.stateForm.confirmPassword = null
      this.stateForm.username = null
      this.stateForm.name = null
      this.stateForm.phoneNumber = null

      this.title = 'Nouveau Utilisateur'
      this.btnTitle = 'Enregistrer'
      this.$emit('onCancelUpdate', {})
    },

    resetForm () {
      this.$refs.form.reset()
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
        this.title = 'Nouveau Utilisateur'
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
      }
      if (this.errors.phone_number) {
        this.stateForm.phoneNumber = false
      }
      if (this.errors.name) {
        this.stateForm.name = false
      }
      if (!this.errors.username && this.form.username) {
        this.stateForm.username = null
      }
      if (!this.errors.phone_number && this.form.phoneNumber) {
        this.stateForm.phoneNumber = null
      }
      if (!this.errors.name && this.form.name) {
        this.stateForm.name = null
      }
    }
  },

  computed: {}
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
.btn-submit[disabled="disabled"] {
  opacity: 0.6;
  cursor: not-allowed;
}
</style>
