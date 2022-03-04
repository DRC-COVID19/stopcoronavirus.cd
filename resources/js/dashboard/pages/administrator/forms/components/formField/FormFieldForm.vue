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
          <b-form-group
            label="Mode d'agrégation*"
            v-slot="{ ariaDescribedby }"
            v-show="getTypeCustomField.NUMBER === form.form_field_type_id"
          >
            <b-form-radio-group
              v-model="form.agreggation"
              :options="requireAggregationOptions"
              :aria-describedby="ariaDescribedby"
              id="requiredAggregation"
            ></b-form-radio-group>
          </b-form-group>
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
            id="step-group"
            label="Etape*"
            label-for="step"
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

          <b-form-group
            id="order-field-group"
            label="Ordre du champ (inserer avant ?)"
            label-for="order-field"
            description="Laisser vide pour insérer en dernier"
          >
            <b-form-select
              id="orderField"
              v-model="form.form_field_order"
              :options="formFieldsSorted"
              text-field="name"
              value-field="id"
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
import { TYPE_CUSTOM_FIELD } from '../../../../../config/env'

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
      requireAggregationOptions: [
        { text: 'Addition', value: true },
        { text: 'Moyenne', value: false }
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
    },
    getTypeCustomField () {
      return TYPE_CUSTOM_FIELD
    },
    formFieldsSorted () {
      return this.targetForm.form_fields
        .slice()
        .sort((a, b) => a.order_field - b.order_field)
        .filter(formField => {
          return (!this.rowFormField || !this.rowFormField.id || this.rowFormField.id !== formField.id)
        })
    }
  },
  watch: {
    rowFormField () {
      const formFieldOrder = this.formFieldsSorted.find(formField => formField.order_field > this.rowFormField.order_field)?.id || null
      this.form = {
        ...this.rowFormField,
        form_field_order: formFieldOrder
      }
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
      if (value === TYPE_CUSTOM_FIELD.NUMBER) {
        this.form.agreggation = true
      } else {
        this.form.agreggation = null
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
