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
      <b-form
        @submit.prevent="onSubmit"
        @reset.prevent="onReset"
        v-if="show"
        label-class="text-dash-color"
      >
        <label id="input-group-1" for="input-1" class="text-dash-color"
          >Titre du Formulaire <span class="text-danger">*</span></label
        >
        <FormFieldInput
          v-model="form.title"
          type="text"
          id="input-1"
          :placeholder="`Entrer le titre du formulaire`"
          rules="required"
          name="titre du formulaire"
          mode="aggressive"
        />
        <b-form-text id="title-help-block" class="mb-4"
          ><span class="text-danger"></span
        ></b-form-text>
        <FomFieldSelect
          v-model="form.form_recurrence_id"
            :options="formRecurrences"
            label="name"
            :reduce="(item) => item.id"
            :isObligated="true"
            rules="required"
            id="form.form_recurrence_id"
            labelText="Recurrence du formulaire "
             name="recurrence du formulaire"
            mode="aggressive"
            />
        <b-form-group
          v-if="formRecurrenceSelected && formRecurrenceSelected.required_value"
          label-class="text-dash-color"
          id="input-group-1"
          label="Valeur de la recurrence"
          label-for="input-1"
        >
          <b-form-input
            class="input-dash"
            id="input-1"
            v-model="form.form_recurrence_value"
            type="text"
            placeholder="Entrer la valeur de la recurrence"
          ></b-form-input>
        </b-form-group>
        <b-form-group
          label-class="text-dash-color"
          class="mt-4"
          id="input-group-1"
          label="Publié"
          v-slot="{ ariaDescribedby }"
        >
          <b-form-radio
            v-model="form.publish"
            :aria-describedby="ariaDescribedby"
            name="some-radios"
            :value="true"
            >Oui</b-form-radio
          >
          <b-form-radio
            v-model="form.publish"
            :aria-describedby="ariaDescribedby"
            name="some-radios"
            :value="false"
            >Non</b-form-radio
          >
        </b-form-group>
        <b-row class="px-3 pt-4 d-flex justify-content-start">
          <b-button
            type="submit"
            variant="primary"
            class="btn-dash-blue"
            :disabled="btnTitle === 'Enregistrer' ? invalid : false"
          >
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
            v-if="updating"
            variant="primary"
            class="ml-4 btn-dash-danger"
            >Annuler</b-button
          >
        </b-row>
      </b-form>
    </ValidationObserver>
  </b-card>
</template>

<script>
import FormFieldInput from '../../../../components/forms/FormFieldInput'
import FomFieldSelect from '../../../../components/forms/FomFieldSelect.vue'
import { ValidationObserver } from 'vee-validate'

export default {
  components: {
    FormFieldInput,
    ValidationObserver,
    FomFieldSelect
  },
  props: {
    formAdded: {
      type: Boolean,
      required: false,
      default: false
    },
    formUpdated: {
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
    formRecurrences: {
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
      title: 'Nouveau Formulaire',
      btnTitle: 'Enregistrer',
      iconClass: 'fas fa-plus-square',
      updating: false,
      isLoading: false,
      validateMailMessage: '',
      published: false,
      form: {
        title: '',
        form_recurrence_value: null,
        form_recurrence_id: '',
        publish: false
      },
      show: true,
      showWarning: false,
      toBeCanceled: true,
      formRecurrenceSelected: null
    }
  },
  mounted () {
    this.resetForm()
  },
  watch: {
    formAdded () {
      this.resetForm()
    },
    formUpdated () {
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
        this.$emit('onUpdate', this.form)
      }
    },

    onReset () {
      this.$refs.form.reset()

      this.toToCanceled = true
      this.form = {}
      this.title = 'Nouveau Formulaire'
      this.btnTitle = 'Enregistrer'
      this.$emit('onCancelUpdate', {})
    },

    resetForm () {
      this.$refs.form.reset()

      this.updating = false
      this.isLoading = false
      if (this.formAdded || this.formUpdated) {
        this.form = {
          title: '',
          form_recurrence_value: null,
          form_recurrence_id: '',
          publish: false
        }
        this.btnTitle = 'Enregistrer'
        this.title = 'Nouveau Formulaire'
      }
    },

    populateForm () {
      this.updating = true
      this.form.id = this.formToPopulate.id
      this.form.title = this.formToPopulate.title
      this.form.form_recurrence_value =
        this.formToPopulate.form_recurrence_value
      this.form.form_recurrence_id = this.formToPopulate.form_recurrence_id
      this.form.publish = this.formToPopulate.publish
      this.title = 'Modification du formulaire'
      this.btnTitle = 'Modifier'
    },

    onFormRecurrenceChange (formRecurrenceId) {
      this.form.form_recurrence_value = null
      this.formRecurrenceSelected = this.formRecurrences.find(
        (formRecurrence) => formRecurrence.id === formRecurrenceId
      )
      console.log(this.formRecurrenceSelected.name)
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
