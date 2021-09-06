<template>
  <b-card>
    <b-card-header v-b-toggle.collapse-form-field>
      <div class="d-flex justify-content-between align-items-center">
        <span class="text-muted">
          Ajouter un nouveau champ
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
            ></b-form-select>
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
            id="order-field-group"
            label="Ordre du champ (inserer avant ?)"
            label-for="order-field"
            description="Laiser vide pour insérer en dernier"
          >
            <b-form-select
              id="orderField"
              v-model="form.order_field"
              :options="orderFields"
            ></b-form-select>
          </b-form-group>

          <b-form-group
            id="step-group"
            label="Etape"
            label-for="step"
            description="Laiser vide si le formulaire n'a pas d'étape"
          >
            <b-form-select
              id="step"
              v-model="form.form_step_id"
              :options="targetForm.form_steps"
              text-field="title"
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
            <small>Enregistrer</small>
          </b-button>
          <b-button type="reset" variant="danger" size="sm" class="btn-dash-danger">
            <small>Réinitialiser</small>
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
    }
  },
  data () {
    return {
      form: {},
      requiredOptions: [
        { text: 'Oui', value: 1 },
        { text: 'Non', value: 0 }
      ],
      fieldWillBeRequired: false
    }
  },
  mounted () {
    this.loadInitData()
    this.initForm()
  },
  computed: {
    ...mapState({
      formFieldTypes: state => state.formFieldType.formFieldTypes
    }),
    orderFields () {
      return [1]
    }
  },
  methods: {
    ...mapActions([
      'formFieldTypeIndex',
      'formFieldStore'
    ]),
    onSubmit () {
      this.form.rules = this.fieldWillBeRequired ? 'required' : ''
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
    },
    onReset () {
      // to implement
      this.initForm()
    },
    initForm () {
      this.form = {
        form_id: this.targetForm.id
      }
    },
    loadInitData () {
      this.formFieldTypeIndex()
    }
  }

}
</script>
