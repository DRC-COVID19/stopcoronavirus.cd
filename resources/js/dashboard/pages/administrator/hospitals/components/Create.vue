<template>
  <b-card>
    <h2 class="h2">{{ title }}</h2>
    <b-form
      @submit.prevent="onSubmit"
      @reset.prevent="onReset"
      v-if="show"
      label-class="text-dash-color"
    >
      <b-form-group
        label-class="text-dash-color"
        id="input-group-1"
        label="Nom de l'hopital *"
        label-for="input-1"
        :invalid-feedback="errors.username ? errors.username[0] : null"
        :state="!errors.username"
      >
        <b-form-input
          class="input-dash"
          id="input-1"
          v-model="form.username"
          type="text"
          placeholder="Entrer le Nom de l'hopital"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group
        label-class="text-dash-color"
        id="input-group-3"
        label="Latitude *"
        label-for="input-3"
      >
        <b-form-input
          id="input-3"
          class="input-dash"
          v-model="form.name"
          placeholder="Entrer la Latitude"
          type="number"
          required
        ></b-form-input>
      </b-form-group>
        <b-form-group
        label-class="text-dash-color"
        id="input-group-3"
        label="Longitude *"
        label-for="input-3"
      >
        <b-form-input
          id="input-3"
          class="input-dash"
          v-model="form.name"
          placeholder="Entrer la Longitude"
          type="number"
          required
        ></b-form-input>
      </b-form-group>
      <label class="text-dash-color" for="check-group-1">Communes *</label>
      <v-select
        v-model="form.roles"
        multiple
        :options="roles"
        label="name"
        :reduce="(item) => item.id"
        :searchable ="false"
      />
      <b-form-group class="mt-3">
        <label class="text-dash-color" for="check-group-1">Selectioner un Agent *</label>
      <v-select
        v-model="form.roles"
        multiple
        :options="roles"
        label="name"
        :reduce="(item) => item.id"
        :searchable ="false"
      />
      </b-form-group>
      <b-row class="px-3 pt-4 d-flex justify-content-start">
          <b-button type="submit" variant="primary" class="btn-dash-sucess">
            <span v-if="isLoading"
            ><b-spinner class="align-middle"></b-spinner>
              <span>en cours ...</span>
            </span>
            <div v-else>
              {{btnTitle }}
            </div>
          </b-button>
        <b-button
          type="reset"
          variant="primary"
          class="ml-4 btn-dash-danger"
          @click="resetForm()"
          > {{ updating ?'Annuler' :'Rénitialiser'}}</b-button
        >
      </b-row>
    </b-form>
  </b-card>
</template>

<script>
export default {
  props: {
    hospitalAdded: {
      type: Boolean,
      required: false,
      default: false
    },
    hospitalUpdated: {
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
      title: "Creation d'un hopital",
      btnTitle: 'Enreigistrer',
      iconClass: 'fas fa-hospital-alt',
      updating: false,
      isLoading: false,
      validateMailMessage: '',
      disablePassword: false,
      form: {
        username: '',
        name: '',
        roles: [],
        hospitals: [],
        email: '',
        password: '',
        confirmPassword: ''
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
      this.isLoading = true
      if (this.btnTitle === 'Enreigistrer') {
        if (
          this.form.password === this.form.confirmPassword
        ) {
          this.$emit('onCreate', this.form)
        } else {
          this.showWarning = true
        }
      } else {
        this.$emit('onUpdate', this.form)
      }
    },

    onReset () {
      this.toToCanceled = true
      this.form = {}
      this.title = "Creation d'un utilisateur"
      this.btnTitle = 'Enreigistrer'
      this.$emit('onCancelUpdate', {})
    },

    validateMail () {
      const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      if (!re.test(String(this.form.email).toLowerCase())) {
        this.validateMailMessage = 'Adresse email incorrecte'
      }
    },

    resetForm () {
      this.updating = false
      this.isLoading = false
      this.disablePassword = false
      if (this.userAdded | this.userUpdated) {
        this.form = {}
        this.btnTitle = 'Enreigistrer'
        this.title = "Creation d'un utilisateur"
      }
    },

    populateForm () {
      this.updating = true
      this.disablePassword = true
      this.form.id = this.formToPopulate.id
      this.form.username = this.formToPopulate.usernmae
      this.form.email = this.formToPopulate.email
      this.form.roles = this.formToPopulate.roles.map(role => role.id)
      this.form.hospitals = this.formToPopulate.hospitals.map(hospital => hospital.id)
      this.form.name = this.formToPopulate.name
      this.title = "Modification de l'hopital"
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

<style lang='scss' scoped>
@import "@~/sass/_variables";
.main {
  background-color: white;
  border-radius: 10px;
  h2 {
    margin-bottom: 20px;
  }
}
</style>
