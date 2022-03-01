<template>
  <b-card>
    <b-card-header v-b-toggle.collapse-form-field>
      <div class="d-flex justify-content-between align-items-center">
        <span class="text-muted">
          {{ title }}
        </span>
        <i class="fas fa-chevron-down" aria-hidden="true"></i>
      </div>
    </b-card-header>
    <b-collapse id="collapse-form-field" class="mt-2" visible>
      <b-card-body>
        <b-form @submit.prevent="onSubmit" @reset="onReset">
          <b-form-group
            id="name-group"
            label="Nom*"
            label-for="name"
          >
            <b-form-input
              id="name"
              v-model="form.name"
              type="text"
              placeholder="Entrer l'intitulé du champ"
              required
            ></b-form-input>
          </b-form-group>

           <b-form-group
            id="form-field-type-group"
            label="Type*"
            label-for="form-field-type"
          >
            <b-form-select
              id="form-field-type"
              v-model="form.form_field_type_id"
              :options="formFieldTypes"
              text-field="name"
              value-field="id"
              required
              @change="onChange"
            ></b-form-select>
          </b-form-group>
          <b-form-group label="Mode d'agréggation ?" v-slot="{ ariaDescribedby }" v-if="isAgreggated">
            <b-form-radio-group
              v-model="isAgreggated"
              :options="requireAgreggationOptions"
              :aria-describedby="ariaDescribedby"
              id="require"
            ></b-form-radio-group>
          </b-form-group>
          <br>
          <b-form-group
            id="default-value-group"
            label="Valeur par défaut"
            label-for="default-value"
          >
            <b-form-input
              id="defaultValue"
              v-model="form.default_value"
              type="text"
              placeholder="Entrer une valeur par défaut"
            ></b-form-input>
          </b-form-group>

          <b-form-group
            id="order-field-group"
            label="Ordre du champ (inserer avant ?)"
            label-for="order-field"
            description="Laisser vide pour insérer en dernier"
          >
            <b-form-select
              id="orderField"
              v-model="form.form_field_order"
              :options="targetForm.form_fields"
              text-field="name"
              value-field="id"
            ></b-form-select>
          </b-form-group>

          <b-form-group
            id="step-group"
            label="Etape"
            label-for="step"
            description="Laisser vide si le formulaire n'a pas d'étape"
          >
            <b-form-select
              id="step"
              v-model="form.form_step_id"
              :options="formStepsSorted"
              text-field="title"
              value-field="id"
              required
            ></b-form-select>
          </b-form-group>

          <b-form-group label="Obligatoire ?" v-slot="{ ariaDescribedby }">
            <b-form-radio-group
              v-model="fieldWillBeRequired"
              :options="requiredOptions"
              :aria-describedby="ariaDescribedby"
              id="required"
            ></b-form-radio-group>
          </b-form-group>

          <br>

          <b-button type="submit" variant="primary" size="sm" class="btn-dash-sucess">
            <small>{{ btnSubmitTitle }}</small>
          </b-button>
          <b-button  variant="danger" size="sm" class="btn-dash-danger" @click="onReset">
            <small>Annuler</small>
          </b-button>
        </b-form>
      </b-card-body>
    </b-collapse>
  </b-card>
</template>

<script>
import { mapActions, mapState } from 'vuex'

export default {
  props: {
    targetForm: {
      type: Object,
      required: true
    },
    rowFormField: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },
  data () {
    return {
      form: {},
      isAgreggated: false,
      requireAgreggationOptions: [
        { text: 'Faire l\'addition', value: 1 },
        { text: 'Faire la moyenne', value: 0 }
      ],

      requiredOptions: [
        { text: 'Oui', value: 1 },
        { text: 'Non', value: 0 }
      ],
      fieldWillBeRequired: false,
      updating: false,
      btnSubmitTitle: 'Enregistrer',
      title: 'Ajouter un nouveau champ'
    }
  },
  mounted () {
    this.loadInitData()
    this.initForm()
  },
  computed: {
    ...mapState({
      formFieldTypes: state => state.formFieldType.formFieldTypes,
      formSteps: (state) => state.formStep.formSteps
    }),
    orderFields () {
      return [1]
    },
    formStepsSorted () {
      return this.formSteps.slice().sort((a, b) => a.step - b.step)
    }

  },
  watch: {

    rowFormField () {
      this.form = { ...this.rowFormField }
      this.updating = true
      this.btnSubmitTitle = 'Modifier'
      this.title = 'Modifier un champ'
    }

  },
  methods: {
    ...mapActions([
      'formFieldTypeIndex',
      'formFieldStore',
      'updateFormField'
    ]),
    onSubmit () {
      this.form.rules = this.fieldWillBeRequired ? 'required' : ''
      this.form.form_id = this.targetForm.id
      this.form.agreggation = this.isAgreggated
      if (!this.form.form_field_order) {
        const MaxValue = this.targetForm.form_fields.flatMap(x => x.order_field)
        this.form.order_field = MaxValue.length && MaxValue.length > 0 ? Math.max(...MaxValue) + 1 : 1
      }
      if (!this.updating) {
        this.formFieldStore(this.form)
          .then(() => {
            this.initForm()
            this.$notify({
              group: 'alert',
              title: 'Champ rajouté avec succès',
              type: 'success'
            })
            this.$emit('created')
          })
          .catch(() => {
            this.$notify({
              group: 'alert',
              title: 'Une erreur est survenu',
              type: 'error'
            })
          })
      } else {
        this.updateFormField(this.form)
          .then(() => {
            this.initForm()
            this.$notify({
              group: 'alert',
              title: 'Champ modifié avec succès',
              type: 'success'
            })
            this.$emit('updated')
            this.onReset()
          })
          .catch(() => {
            this.$notify({
              group: 'alert',
              title: 'Une erreur est survenu',
              type: 'error'
            })
          })
      }
    },
    onChange (value) {
      this.isAgreggated = false
      if (value === 2) {
        this.isAgreggated = true
      }
    },
    onReset () {
      this.initForm()
    },
    initForm () {
      this.form = {
        form_id: this.targetForm.id
      }
      this.updating = false
      this.btnSubmitTitle = 'Enregistrer'
      this.title = 'Ajouter un champ'
    },
    loadInitData () {
      this.formFieldTypeIndex()
    }
  }
}
</script>
