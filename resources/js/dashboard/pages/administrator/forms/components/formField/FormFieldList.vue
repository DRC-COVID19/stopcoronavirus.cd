<template>
  <div>
    <b-card>
      <b-card-header v-b-toggle.collapse-form-field-list>
        <div class="d-flex justify-content-between align-items-center">
          <span class="text-muted">
            Liste des champs
          </span>
          <i class="fas fa-chevron-down" aria-hidden="true"></i>
        </div>
      </b-card-header>
      <b-collapse id="collapse-form-field-list" class="mt-2" visible>
        <b-card-body>
           <FormStepListAccordion :targetForm="targetForm"/>
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
import { mapActions } from "vuex";
import FormStepListAccordion from "./FormStepListAccordion.vue";
export default {
  components: {
    FormStepListAccordion,
  },
  props: {
    targetForm: {
      type: Object,
      required: true
    }
  },
  computed: {
    formFieldSorted() {
      return this.targetForm.form_fields
        ? this.targetForm.form_fields
            .slice()
            .sort((a, b) => a.order_field - b.order_field)
        : [];
    }
  },
  data() {
    return {
      requiredOptions: [
        { text: "Oui", value: 1 },
        { text: "Non", value: 0 }
      ],
      isDeleteModalShown: false,
      formFieldToDelete: null,
    };
  },
  methods: {
    ...mapActions(["removeFormField"]),
    deleteField(formField) {
      this.isDeleteModalShown = true;
      this.formFieldToDelete = formField;
    },
    onValidateDeletion() {
      this.$bvModal.show("confirmation-box");
      this.removeFormField(this.formFieldToDelete.id)
        .then(() => {
          this.$notify({
            group: "alert",
            title: "Supprimer ce champ",
            text: "Supprimer avec succès",
            type: "success"
          });
          this.isDeleteModalShown = false;
          this.$emit("deleted");
        })
        .catch(() => {
          this.$notify({
            group: "alert",
            title: "Supprimer  l'étape",
            text: "Une erreur est survenus",
            type: "error"
          });
        });
    },
    onCancelDeletion() {
      this.isDeleteModalShown = false;
    },
     updateField (formField) {
      this.$emit('onUpdateFormField', formField)
    }
  }
}
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";
.fas {
  cursor: pointer;
  padding: 0.5rem;
  transition: all 0.5 ease-out;
  &:hover {
    background: rgb(170, 175, 184);
    border-radius: 5px;
  }
}
</style>
