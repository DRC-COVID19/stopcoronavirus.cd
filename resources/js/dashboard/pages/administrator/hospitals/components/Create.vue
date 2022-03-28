<template>
  <b-card>
    <h2 class="h2 mb-4">{{ title }}</h2>
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
     <label id="input-group-1" class="text-dash-color" for="input-1">
        Nom du CTCO <span class="text-danger">*</span></label
      >
    <FormFieldInput
        v-model="form.name"
        type="text"
        :placeholder="`Entrer le nom`"
        id="input-1"
        rules="required"
        name="nom"
        mode="aggressive"

      />
      <b-form-text id="password-help-block" class="mb-4"
        ><span class="text-danger">
          {{ errors.name ? errors.name[0] : null }}</span
        ></b-form-text
      >
      <label id="input-group-2" class="text-dash-color" for="input-2">
        Latitude <span class="text-danger">*</span></label
      >
    <FormFieldInput
        v-model="form.latitude"
         type="number"
        :placeholder="`Entrer la Latitude`"
        id="input-2"
        rules="required"
        name="latitude"
        mode="aggressive"

      />
      <b-form-text id="password-help-block" class="mb-4"
        ><span class="text-danger">
          {{ errors.name ? errors.name[0] : null }}</span
        ></b-form-text
      >
         <label id="input-group-3" class="text-dash-color" for="input-3">
        Longitude <span class="text-danger">*</span></label
      >
    <FormFieldInput
        v-model="form.longitude"
         type="number"
        :placeholder="`Entrer la longitude`"
        id="input-3"
        rules="required"
        name="longitude"
        mode="aggressive"

      />
      <b-form-text id="password-help-block" class="mb-4"
        ><span class="text-danger">
          {{ errors.name ? errors.name[0] : null }}</span
        ></b-form-text
      >
      <label class="text-dash-color" for="check-group-1">Communes <span class="text-danger">*</span></label>
      <b-form-select
          v-model="form.township_id"
          :options="townships"
          class="mb-3"
          value-field="id"
          text-field="name"
          disabled-field="notEnabled"
        />
      <b-form-group class="mt-3">
        <label class="text-dash-color" for="check-group-1">Agent titré <span class="text-danger">*</span></label>
        <b-form-select
          v-model="form.agent_id"
          :options="users"
          class="mb-3"
          value-field="id"
          text-field="name"
          disabled-field="notEnabled"
          :searchable ="true"
        />
      </b-form-group>
      <b-row class="px-3 pt-4 d-flex justify-content-start">
          <b-button type="submit" variant="primary" class="btn-dash-blue">
            <span v-if="isLoading"
            ><b-spinner class="align-middle"></b-spinner>
              <span>en cours ...</span>
            </span>
            <div v-else :disabled="btnTitle === 'Enregistrer' ?invalid:false" class="btn-submit">
              {{btnTitle }}
            </div>
          </b-button>
        <b-button
          type="reset"
          variant="primary"
          class="btn-dash-danger ml-4"
          @click="resetForm()"
          > {{ updating ?'Annuler' :'Rénitialiser'}}</b-button
        >
      </b-row>
        </ValidationObserver>
  </b-card>
</template>

<script>
import FormFieldInput from '../../../../components/forms/FormFieldInput'
import { ValidationObserver } from 'vee-validate'

export default {
  components: {
    FormFieldInput,
    ValidationObserver
  },
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
      title: 'Nouveau CTCO',
      btnTitle: 'Enregistrer',
      iconClass: 'fas fa-hospital-alt',
      disablePassword: false,
      form: {
        name: '',
        agent_id: null,
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
      if (this.btnTitle === 'Enregistrer') {
        this.$emit('onCreate', this.form)
      } else {
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
      if (this.hospitalCreated | this.hospitalUpdated) {
        this.form = {}
        this.btnTitle = 'Enregistrer'
        this.title = 'Nouveau CTCO'
      }
    },

    populateForm () {
      this.title = 'Modification du CTCO '
      this.btnTitle = 'Modifier'
      this.form.id = this.formToPopulate.id
      this.form.name = this.formToPopulate.name
      this.form.longitude = this.formToPopulate.longitude
      this.form.latitude = this.formToPopulate.latitude
      this.form.agent_id = this.formToPopulate.agent && this.formToPopulate.agent.id ? this.formToPopulate.agent.id : 0
      this.form.township_id = this.formToPopulate.township && this.formToPopulate.township.id ? this.formToPopulate.township.id : 0
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
.btn-submit[disabled="disabled"] {
  opacity: 0.6;
  cursor: not-allowed;
}
</style>
