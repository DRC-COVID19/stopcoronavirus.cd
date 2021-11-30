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
                    class="mx-2 my-1 fas fa-trash prim color-red"
                    aria-hidden="true"
                  ></i>
                  <i
                    class="mx-2 my-1 fas fa-pencil-alt color-green"
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
        <b-button size="sm" variant="success" @click="onValidateDelection()">
          Accepter
        </b-button>
        <b-button size="sm" variant="danger" @click="onCancelDelection()">
          Annuler
        </b-button>
      </template>
    </b-modal>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
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
      filter: "",
      formFieldId: null,
      editModalShow: false
    };
  },
  methods: {
    ...mapActions(["removeFormFields"]),
    deleteField(formId) {
      this.isDeleteModalShown = true;
      this.formFieldId = formId;
    },
    onValidateDelection() {
      this.$bvModal.show("confirmation-box");
      this.removeFormFields(this.formFieldId.id)
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
    onCancelDelection() {
      this.isDeleteModalShown = false;
    }
  }
};
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
