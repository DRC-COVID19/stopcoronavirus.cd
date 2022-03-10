<template>
  <b-card class="bg-custom">
    <h2 class="h2">{{ title }}</h2>
     userCreated: {{ hospitalCreated }}
      userUpdated: {{ hospitalUpdated }}
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
        :invalid-feedback="errors.name ? errors.name[0] : null"
        :state="!errors.name"
      >
        <b-form-input
          class="input-dash"
          id="input-1"
          v-model="form.name"
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
          v-model="form.latitude"
          placeholder="Entrer la Latitude"
          type="number"
          step="any"
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
          v-model="form.longitude"
          placeholder="Entrer la Longitude"
          type="number"
          step="any"
        ></b-form-input>
      </b-form-group>
      <label class="text-dash-color" for="check-group-1">Communes *</label>
      <v-select
        v-model="form.township"
        :options="townships"
        label="name"
        :reduce="(item) => item.id"
        :searchable ="false"
      />
      <b-form-group class="mt-3">
        <label class="text-dash-color" for="check-group-1">Selectioner un Agent *</label>
      <v-select
        v-model="form.agent"
        :options="users"
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
    hospitalCreated: {
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
    townships: {
      type: Array,
      default: () => {
        return []
      }
    },
    users: {
      type: Array,
      default: () => {
        return []
      }
    },
    errors: {
      type: Object,
      default: () => ({})
    },
    isLoading: {
      type: Boolean,
      default: false,
      required: false
    },
    updating: {
      type: Boolean,
      default: false,
      required: false
    }
  },
  data () {
    return {
      title: "Creation d'un hopital",
      btnTitle: 'Enregistrer',
      iconClass: 'fas fa-hospital-alt',
      disablePassword: false,
      form: {
        name: '',
        agent: {},
        township: {},
        longitude: 0.0,
        latitude: 0.0
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
    hospitalAdded () {
      this.resetForm()
    },
    hospitalUpdated () {
      this.resetForm()
    },
    formToPopulate () {
      this.populateForm()
    }
  },
  methods: {
    onSubmit () {
      if (this.btnTitle === 'Enregistrer') {
        this.$emit('onCreate', this.form)
      } else {
        this.$emit('onUpdate', this.form)
      }
    },

    onReset () {
      this.toToCanceled = true
      this.form = {}
      this.title = "Creation d'un hopital"
      this.btnTitle = 'Enregistrer'
      this.$emit('onCancelUpdate', {})
    },

    resetForm () {
      if (this.hospitalCreated | this.hospitalUpdated) {
        this.form = {}
        this.btnTitle = 'Enregistrer'
        this.title = "Creation d'un hopital"
        alert('c bon')
      }
    },

    populateForm () {
      this.title = `Modifié ${this.formToPopulate.name}`
      this.btnTitle = 'Modifier'
      this.form.id = this.formToPopulate.id
      this.form.name = this.formToPopulate.name
      this.form.longitude = this.formToPopulate.longitude
      this.form.latitude = this.formToPopulate.latitude
      this.form.agent = this.formToPopulate.agent ? this.formToPopulate.agent.id : this.formToPopulate.agent
      this.form.township = this.formToPopulate.township ? this.formToPopulate.township.id : this.formToPopulate.township
    }

  },

  computed: {
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
  .bg-custom{
     background-color: rgb(165, 167, 180);
  }
}
</style>
