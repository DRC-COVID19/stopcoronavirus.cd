<template>
  <b-modal id="createResponse" centered hide-footer hide-header>
      <b-card class="border-0">
      <div class="mb-4 p-2">
            <h2 class="lead text-center text-bold">
              Création d'un champs
            </h2>
          </div>
    <ValidationObserver
      v-slot="{ invalid }"
      ref="form"
      tag="form"
      novalidate
      @submit.prevent="onSubmit"
      v-if="show"
      label-class="text-dash-color"
    >
        <b-form
          @submit.prevent="onSubmit"
          v-if="show"
          label-class="text-dash-color"
        >
          <label id="input-group-1" for="input-1" class="text-dash-color"
            >Question <span class="text-danger">*</span></label
          >
          <FormFieldInput
            v-model="form.question"
            type="text"
            id="input-1"
            :placeholder="`Nom`"
            rules="required"
            name="Question"
            mode="aggressive"
          />
          <b-form-text id="title-help-block" class="mb-4"
            ><span class="text-danger"></span
          ></b-form-text>
          <FomFieldSelect
            v-model="form.form_field_type_id"
            :options="formFieldType"
            label="name"
            :reduce="(item) => item.id"
            :isObligated="true"
            rules="required"
            id="form.form_field_type_id"
            labelText="Choix du format "
            name="Choix du format"
            mode="aggressive"
          />
          <label id="input-group-1" for="input-1" class="text-dash-color"
            >Valeur par défaut <span class="text-danger"></span></label
          >
          <FormFieldInput
            v-model="form.default_value"
            type="text"
            id="input-1"
            :placeholder="`entrer une valeur`"
            name="Valeur par défaut"
            mode="aggressive"
            class="mb-4"
          />
          <FomFieldSelect
            v-model="form.order_field"
            :options="formField"
            label="name"
            :reduce="(item) => item.id"
            id="form.order_field"
            labelText="Ordre du champ(insérer avant?)"
            name="Ordre du champ"
            mode="aggressive"
          />
          <b-form-group
            label-class="text-dash-color"
            class="mt-4"
            id="input-group-1"
            label="Obligatoire"
            v-slot="{ ariaDescribedby }"
          >
            <b-form-radio
              v-model="form.require"
              :aria-describedby="ariaDescribedby"
              name="some-radios"
              :value="true"
              >Oui</b-form-radio
            >
            <b-form-radio
              v-model="form.require"
              :aria-describedby="ariaDescribedby"
              name="some-radios"
              :value="false"
              >Non</b-form-radio
            >
          </b-form-group>
          <b-row class="px-3 pt-4 d-flex justify-content-center">
            <b-button
              type="submit"
              variant="primary"
              class="btn-dash-blue"
              :disabled="invalid ? true : false"
            >
              <span v-if="isLoading"
                ><b-spinner class="align-middle"></b-spinner>
                <span>en cours ...</span>
              </span>
              <div v-else>
                Créer
              </div>
            </b-button>
          </b-row>
        </b-form>
    </ValidationObserver>
  </b-card>
  </b-modal>
</template>

<script>
import FormFieldInput from '../../../../../../components/forms/FormFieldInput.vue'
import FomFieldSelect from '../../../../../../components/forms/FomFieldSelect.vue'
import { ValidationObserver } from 'vee-validate'
import { mapState, mapActions } from 'vuex'
export default {
  components: {
    FormFieldInput,
    ValidationObserver,
    FomFieldSelect
  },
  data () {
    return {
      form: {
        question: '',
        form_field_type_id: '',
        default_value_id: null,
        form_recurrence_id: '',
        require: false
      },
      show: true
    }
  },
  async mounted () {
    await this.formFieldTypeIndex()
    await this.getFormFields({ id: this.form_id })
  },
  computed: {
    ...mapState({
      formFieldType: (state) => state.formFieldType.formFieldTypes,
      formField: (state) => state.formField.formFields
    }),
    form_id () {
      return this.$route.params.form_id
    }
  },
  methods: {
    ...mapActions(['formFieldTypeIndex', 'getFormFields', 'formFieldStore']),
    onSubmit () {
      const formField = {
        name: this.form.question,
        order_field: this.form.order_field ? this.form.order_field : 1,
        rules: this.form.require ? 'required' : '',
        form_id: this.form_id,
        form_field_type_id: this.form.form_field_type_id,
        form_step_id: 1,
        default_value: this.form.default_value_id
      }
      this.formFieldStore(formField)
        .then(() => {
          this.$notify({
            group: 'alert',
            title: 'Champs du Formulaire',
            text: 'Ajouter avec succès',
            type: 'success'
          })
          this.$bvModal.hide('createResponse')
        })
        .catch(({ response }) => {
          this.$notify({
            group: 'alert',
            title: 'Champs du Formulaire',
            text: 'Une erreur est survenus',
            type: 'error'
          })
          this.$bvModal.hide('createResponse')
          if (response.status == 422) {
            this.errors = response.data.errors
          }
        })
    }
  }

}
</script>

<style lang="scss" scoped>

</style>
