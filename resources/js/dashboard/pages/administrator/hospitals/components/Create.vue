<template>
  <b-card>
    <h2 class="h2 mb-4">{{ title }}</h2>
    <b-form
      @submit.prevent="onSubmit"
      @reset.prevent="onReset"
      v-if="show"
      label-class="text-dash-color"
    >
      <b-form-group
        label-class="text-dash-color mt-3"
        id="input-group-1"
        label-for="input-1"
        :invalid-feedback="errors.name ? errors.name[0] : null"
        :state="!errors.name"
      >
      <label for="input-1" class="text-dash-color">Nom du CTCO <span class="text-danger">*</span></label>
        <b-form-input
          class="input-dash"
          id="input-1"
          v-model="form.name"
          type="text"
          placeholder="Entrer le Nom du CTCO"
          required
        ></b-form-input>
      </b-form-group>

      <b-form-group
        label-class="text-dash-color"
        id="input-group-3 mt-3"
        label-for="input-3"
      >
       <label for="input-3" class="text-dash-color">Latitude <span class="text-danger">*</span></label>
        <b-form-input
          id="input-3"
          class="input-das"
          v-model="form.latitude"
          placeholder="Entrer la Latitude"
          type="number"
          step="any"
        ></b-form-input>
      </b-form-group>
        <b-form-group
        label-class="text-dash-color mt-3"
        id="input-group-4"
        label-for="input-4"
      >
      <label for="input-3" class="text-dash-color">Longitude <span class="text-danger">*</span></label>
        <b-form-input
          id="input-4"
          class="input-dash"
          v-model="form.longitude"
          placeholder="Entrer la Longitude"
          type="number"
          step="any"
          required
        ></b-form-input>
      </b-form-group>
      <b-form-group class="mt-3">
      <label class="text-dash-color" for="check-group-1">Commune <span class="text-danger">*</span></label>
      <v-select
          v-model="form.township_id"
          :options="townships"
          label="name"
          :reduce="(item) => item.id"
          id="input-4"
        />
      </b-form-group>
      <b-form-group class="mt-3">
      <label class="text-dash-color" for="check-group-1">Agent Attitré</label>
        <v-select
        v-model="form.agent"
          multiple
          :options="users"
          label="name"
          :reduce="(item) => item.id"
          :searchable ="false"
          @input="handleSelect"
          id="input-4"
        ><span slot="no-options">Aucun agent attitré disponible</span></v-select>
      </b-form-group>
      <b-row class="px-3 pt-4 d-flex justify-content-start">
          <b-button type="submit" variant="primary" class="btn-dash-blue" :disabled="isLoading">
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
          variant="outline-danger"
          class="ml-4"
          @click="resetForm()"
          > {{ updating ?'Annuler' :'Réinitialiser'}}</b-button
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
    affected: {
      type: Boolean,
      default: null,
      required: false
    }
  },
  data () {
    return {
      title: 'Nouveau CTCO',
      btnTitle: 'Enregistrer',
      iconClass: 'fas fa-hospital-alt',
      disablePassword: false,
      updating: false,
      isLoading: false,
      form: {
        name: '',
        agent: null,
        deAssignedAgent: null,
        affected: this.affected,
        township_id: null,
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
      this.isLoading = true
      if (this.btnTitle === 'Enregistrer') {
        this.$emit('onCreate', this.form)
      } else {
        if (this.form.agent.length === 0) {
          this.form.affected = false
        } else {
          this.form.affected = true
        }
        this.form.deAssignedAgent = (this.formToPopulate.agent && this.formToPopulate.agent.id) ?? 0
        this.$emit('onUpdate', this.form)
      }
    },

    onReset () {
      this.toToCanceled = true
      this.form = {}
      this.title = 'Nouveau CTCO'
      this.btnTitle = 'Enregistrer'
      this.$emit('onCancelUpdate', {})
    },

    resetForm () {
      this.updating = false
      this.isLoading = false
      this.toToCanceled = true
      if (this.hospitalAdded | this.hospitalUpdated) {
        this.form = {}
        this.btnTitle = 'Enregistrer'
        this.title = 'Nouveau CTCO'
      }
    },

    populateForm () {
      this.updating = true
      this.title = 'Modification du CTCO '
      this.btnTitle = 'Modifier'
      this.form.id = this.formToPopulate.id
      this.form.name = this.formToPopulate.name
      this.form.longitude = this.formToPopulate.longitude
      this.form.latitude = this.formToPopulate.latitude
      this.form.agent = this.formToPopulate.agent
      this.form.township_id = this.formToPopulate.township && this.formToPopulate.township.id ? this.formToPopulate.township.id : 0
    },
    handleSelect (value) {
      if (value.length > 1) {
        value.shift()
      }
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
  .form-select{
    outline: none !important;
  }
}
</style>
