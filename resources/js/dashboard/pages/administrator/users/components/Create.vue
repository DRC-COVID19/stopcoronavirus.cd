<template>
  <b-card>
    <h2 class="h2">{{ title }}</h2>
    <b-form
      @submit.prevent="onSubmit"
      @reset.prevent="onReset"
      v-if="show"
      label-class="text-dash-color"
    >
      <InputGroup
        inputGroupId="input-group-1"
        label="Nom d'utilisateur *"
        labelFor="input-1"
        :invalidFeedback="errors.username ? errors.username[0] : null"
        labelClass="text-dash-color"
        :errors="!errors.username"
      />
      <Input
        v-model="form.username"
        placeholder="Entrer le nom d'utilisateur"
        type="text"
        :required="true"
        inputId="input-1"
        class="input-dash"
        :state="null"
      />
      <InputGroup
        inputGroupId="input-group-2"
        label="Adresse mail *"
        labelFor="input-2"
        :invalidFeedback="errors.mail ? errors.email[0] : null"
        labelClass="text-dash-color"
        :errors="!errors.email"
      />
      <FormFieldInput
        v-model="form.email"
        type="email"
        :placeholder="`Entrer l'adresse mail`"
        id="input-2"
        :required="true"
        class="input-dash"
        @input="validateMail"
      />
      <b-form-text id="password-help-block">
        <span class="text-danger"> {{ validateMailMessage }}</span>
      </b-form-text>
      <b-form-group
        label-class="text-dash-color"
        id="input-group-3"
        label="Nom *"
        label-for="input-3"
      >
        <b-form-input
          id="input-3"
          class="input-dash"
          v-model="form.name"
          placeholder="Entrer le nom"
          required
        ></b-form-input>
      </b-form-group>
      <InputGroup
        inputGroupId="input-group-4"
        label="Numéro Téléphone*"
        labelFor="input-4"
        :invalidFeedback="errors.mail ? errors.email[0] : null"
        labelClass="text-dash-color"
        :errors="!errors.email"
      />
      <Input
        v-model="form.phoneNumber"
        placeholder="Ex: 0820000000 "
        :required="true"
        inputId="input-4"
        class="input-dash"
        :state="
          !errors.mail
            ? null
            : errors.mail || validateMailMessage
            ? true
            : false
        "
        @blur="validatePhoneNumber()"
      />
      <!-- <b-form-group
        label-class="text-dash-color"
        id="input-group-4"
        label="Numéro Téléphone*"
        label-for="input-4"
      >
        <b-form-input
          id="input-4"
          class="input-dash"
          v-model="form.phoneNumber"
          placeholder="Ex: 0823493378"
          @blur="validatePhoneNumber()"
          required
        ></b-form-input>
      </b-form-group> -->
      <b-form-text id="password-help-block"
        ><span class="text-danger">
          {{ validatePhoneNumberMessage }}</span
        ></b-form-text
      >
      <label class="text-dash-color" for="check-group-1">Roles *</label>
      <v-select
        v-model="form.roles"
        multiple
        :options="roles"
        label="name"
        :reduce="(item) => item.id"
        :searchable="false"
      />
      <label class="text-dash-color" for="check-group-1">Hopital *</label>
      <v-select
        v-model="form.hospitals"
        multiple
        :options="hospitals"
        label="name"
        :reduce="(item) => item.id"
        :searchable="false"
      />
      <label class="text-dash-color" for="text-password">Mot de passe *</label>
      <b-form-input
        class="input-dash"
        type="password"
        id="text-password"
        aria-describedby="password-help-block"
        v-model="form.password"
      ></b-form-input>
      <label class="text-dash-color" for="text-password-confirm"
        >Confirmation de mot de passe *</label
      >
      <b-form-input
        class="input-dash"
        type="password"
        id="text-password-confirm"
        aria-describedby="password-help-block"
        v-model="form.confirmPassword"
      ></b-form-input>
      <b-form-text id="password-help-block">{{ warningMissMatch }}</b-form-text>
      <b-row class="px-3 pt-4 d-flex justify-content-start">
        <b-button type="submit" variant="primary" class="btn-dash-sucess">
          <span v-if="isLoading"
            ><b-spinner class="align-middle"></b-spinner>
            <span>en cours ...</span>
          </span>
          <div v-else>
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
import Input from '../../../../components/input/Input.vue'
import InputGroup from '../../../../components/inputGroup/InputGroup.vue'
import FormFieldInput from '../../../../components/forms/FormFieldInput'

export default {
  components: {
    Input,
    InputGroup,
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
      title: "Creation d'un utilisateur",
      btnTitle: 'Enregistrer',
      iconClass: 'fas fa-plus-square',
      updating: false,
      isLoading: false,
      validateMailMessage: null,
      validatePhoneNumberMessage: null,
      disablePassword: false,
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
      this.populateForm()
    }
  },
  methods: {
    onSubmit () {
      if (!this.validatePhoneNumberMessage && !this.validateMailMessage) {
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
      this.validatePhoneNumberMessage = ''
      this.form = {}
      this.title = "Creation d'un utilisateur"
      this.btnTitle = 'Enregistrer'
      this.$emit('onCancelUpdate', {})
    },

    validateMail (value) {
      const re =
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      this.validateMailMessage = ''
      console.log(' this.validateMailMessage', this.form.email)

      if (!re.test(String(this.form.email).toLowerCase())) {
        this.validateMailMessage = 'Adresse email incorrecte'
      } else {
        this.validateMailMessage = ''
      }
    },
    validatePhoneNumber () {
      const regexPhoneNumber = /^0+[8,9]+[0-9]{8}$/im
      console.log(' this.regexPhoneNumber', this.form.phoneNumber)

      if (!regexPhoneNumber.test(this.form.phoneNumber)) {
        this.validatePhoneNumberMessage = 'Numéro de téléphone incorrect'
      } else {
        this.validatePhoneNumberMessage = ''
      }
    },

    resetForm () {
      this.updating = false
      this.isLoading = false
      this.disablePassword = false
      if (this.userAdded | this.userUpdated) {
        this.form = {}
        this.btnTitle = 'Enregistrer'
        this.title = "Creation d'un utilisateur"
      }
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
    }
  },

  computed: {
    warningMissMatch () {
      return this.form.password === this.form.confirmPassword
        ? ''
        : 'Les mot de passes ne correspondent pas'
    }
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
</style>
