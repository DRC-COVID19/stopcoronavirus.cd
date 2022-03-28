<template>
  <div>
    <b-card
      v-for="(step, index) in formListSteps"
      :key="index"
      class="mb-1"
      role="tab"
    >
      <b-card-header
        b-card-header
        v-b-toggle="'collapse-form-list-step' + step.id"
      >
        <div class="d-flex justify-content-between align-items-center">
          <span class="text-muted">
            {{ step.title }}
          </span>
          <i class="fas fa-chevron-down" aria-hidden="true"></i>
        </div>
      </b-card-header>
      <b-collapse
        :id="'collapse-form-list-step' + step.id"
        class="mt-2"
        accordion="my-accordion"
        role="tabpanel"
      >
        <b-card-body>
          <b-form-group
            v-for="(formField, index) in step.form_fields"
            :key="index"
            :label="formField.name"
            :label-for="formField.name"
          >
            <b-row>
              <b-col class="col-sm-9 col-md-9">
                <FormFieldInput
                  :type="formField.form_field_type.name"
                  :placeholder="`Entrer ${formField.name}`"
                  :id="formField.name"
                  :rules="formField.rules"
                  :name="formField.name"
                />
              </b-col>
              <b-col class="col-sm-3 col-md-3">
                <template class="action-btn-group">
                  <i
                    @click="deleteField(formField)"
                    class="mx-2 my-1 fas fa-trash prim color-red btn"
                    aria-hidden="true"
                  ></i>
                  <i
                  @click="updateField(formField)"
                    class="mx-2 my-1 fas fa-pencil-alt color-green btn"
                    aria-hidden="true"
                  ></i>
                </template>
              </b-col>
            </b-row>
          </b-form-group>
        </b-card-body>
      </b-collapse>
    </b-card>
    <b-modal v-model="isDeleteModalShown">
      Voulez-vous vraiment supprimer ce champ ?
      <template #modal-footer>
        <b-button size="sm" variant="success" @click="onValidateDeletion()">
          Accepter
        </b-button>
        <b-button size="sm" variant="danger" @click="onCancelDeletion()">
          Annuler
        </b-button>
      </template>
    </b-modal>
  </div>
</template>
<script>
import { mapActions } from 'vuex'
import FormFieldInput from '../../../../../components/forms/FormFieldInput'

export default {
  name: 'FormStepListAccordion',
  props: {
    targetForm: {
      type: Object,
      required: true,
    }
  },
  components: {
    FormFieldInput
  },
  data () {
    return {
      isDeleteModalShown: false,
      formFieldToDelete: ''
    }
  },
  computed: {
    formListSteps () {
      return this.targetForm.form_steps.slice().sort((a, b) => a.step - b.step);
    }
  },
  mounted() {
  },
  methods: {
    ...mapActions(['removeFormField']),
    deleteField (formField) {
      this.isDeleteModalShown = true
      this.formFieldToDelete = formField
    },
    onValidateDeletion() {
      this.$bvModal.show("confirmation-box");
      this.removeFormField(this.formFieldToDelete.id)
        .then(() => {
          this.$notify({
            group: 'alert',
            title: 'Supprimer ce champ',
            text: 'Supprimer avec succès',
            type: 'Supprimer avec succès'
          })
          this.isDeleteModalShown = false
          this.$emit('deleted')
        })
        .catch(() => {
          this.$notify({
            group: 'alert',
            title: "Supprimer  l'étape",
            text: 'Une erreur est survenus',
            type: 'error'
          })
        })
    },
    onCancelDeletion () {
      this.isDeleteModalShown = false
    },
    updateField (formField) {
      this.$emit('updateField', formField)
    }
  }
}
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";
.btn {
  cursor: pointer;
  padding: 0.5rem;
  transition: all 0.5 ease-out;
  &:hover {
    background: rgb(170, 175, 184);
    border-radius: 5px;
  }
}
</style>
