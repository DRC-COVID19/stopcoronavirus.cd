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
        @click="formStepFilter(step.id)"
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
            v-for="(item, index) in formFieldSorted"
            :key="index"
            :label="item.name"
            :label-for="item.name"
          >
            <b-row>
              <b-col class="col-sm-9 col-md-9">
                <b-form-group
                  v-slot="{ ariaDescribedby }"
                  v-if="item.form_field_type.name === 'boolean'"
                >
                  <b-form-radio-group
                    :options="requiredOptions"
                    :aria-describedby="ariaDescribedby"
                    id="required"
                  ></b-form-radio-group>
                </b-form-group>
               <b-form-input
                  v-else
                  :type="item.form_field_type.name"
                  :placeholder="`Entrer ${item.name}`"
                ></b-form-input>
              </b-col>
              <b-col class="col-sm-3 col-md-3">
                <template class="action-btn-group">
                  <i
                    @click="deleteField(item)"
                    class="mx-2 my-1 fas fa-trash prim color-red btn"
                    aria-hidden="true"
                  ></i>
                  <i
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
import { mapState, mapActions } from "vuex";

export default {
  name: "FormStepListAccordion",
  props: {
    targetForm: {
      type: Object,
      required: true,
    },
    updateField: {
      type: String,
    }
  },
  components: {
  },
  data() {
    return {
      formFieldFilter: [],
      requiredOptions: [
        { text: "Oui", value: 1 },
        { text: "Non", value: 0 },
      ],
      formStepsField: [],
      isDeleteModalShown: false,
      formFieldToDelete: "",
    };
  },
  computed: {
    ...mapState({
      formSteps: (state) => state.formStep.formSteps,
    }),
    formListSteps() {
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      this.formStepsField = this.formSteps.slice();
      const length = this.formSteps.length;
      // eslint-disable-next-line vue/no-side-effects-in-computed-properties
      this.formStepsField.push({
        id: length,
        title: "Champs affectés à aucune étape",
      });
      return this.formStepsField;
    },
    formFieldSorted() {
      return this.formFieldFilter
        ? this.formFieldFilter
            .slice()
            .sort((a, b) => a.order_field - b.order_field)
        : [];
    },
  },
  mounted() {},
  methods: {
    ...mapActions(["removeFormField"]),
    formStepFilter(id) {
      // eslint-disable-next-line camelcase
      this.formFieldFilter = this.targetForm.form_fields.filter((formField) => {
        return formField.form_step_id === id;
      });
    },
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
            type: "Supprimer avec succès",
          });
          this.isDeleteModalShown = false;
          this.$emit("deleted");
        })
        .catch(() => {
          this.$notify({
            group: "alert",
            title: "Supprimer  l'étape",
            text: "Une erreur est survenus",
            type: "error",
          });
        });
    },
    onCancelDeletion() {
      this.isDeleteModalShown = false;
    },
     updateField (formField) {
      this.$emit('onUpdateFormField', formField)
    }
  },
};
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
