<template>
  <b-row class="w-100">
    <b-col lg="12" class="d-flex justify-content-between form-step-list-title">
      <div class="d-flex justify-content-center align-center" align-h="center">
        <h2 class="title">Étape</h2>
      </div>
      <div class="d-flex align-item-center">
        <b-button
          class="btn-dash-blue d-block"
          squared
          @click="openModalCreateList"
        >
          <i class="fas fa-plus"></i>
        </b-button>
      </div>
    </b-col>

    <b-col
      lg="12"
      class="d-flex justify-content-between w-100 px-0 form-step-list"
    >
      <div><h3>Etape</h3></div>
      <b-dropdown
        size="lg"
        variant="link"
        toggle-class="text-decoration-none"
        no-caret
      >
        <template #button-content>
          &#x1f50d;<span class="sr-only">Search</span>
        </template>
        <b-dropdown-item-button href="#">Action</b-dropdown-item-button>
        <b-dropdown-item-button href="#">Another action</b-dropdown-item-button>
        <b-dropdown-item-button href="#"
          >Something else here...</b-dropdown-item-button
        >
      </b-dropdown>
    </b-col>
  </b-row>
</template>
<script>
import { mapState, mapActions } from "vuex";
export default {
  props: {
    formId: {
      type: Number,
      required: true,
    },
    isLoading: {
      type: Boolean,
      default: false,
    },
    perPage: {
      type: Number,
      default: 15,
    },
    totalRows: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      fields: [
        { key: "step", label: "Etape" },
        { key: "title", label: "Titre" },
        "actions",
      ],
      filter: "",
      isDeleteModalShown: false,
      currentForm: {
        id: -1,
        title: "",
      },
      formStepId: null,
      editModalShow: false,
      currentPage: 1,
    };
  },

  mounted() {
    this.getFormSteps({ id: this.formId });
  },
  computed: {
    ...mapState({
      formSteps: (state) => state.formStep.formSteps,
    }),
    formStepsSorted() {
      return this.formSteps.slice().sort((a, b) => a.step - b.step);
    },
    rows() {
      return this.formSteps.length;
    },
  },
  watch: {
    filter() {
      this.search();
    },
  },
  methods: {
    ...mapActions(["getFormSteps", "removeFormStep", "searchFormStep"]),
    search() {
      this.searchFormStep(this.filter.trim()).catch((error) => {
        console.log(error);
      });
    },
    deleteStep(formId) {
      this.isDeleteModalShown = true;
      this.formStepId = formId.id;
    },
    onValidateDelection() {
      this.$bvModal.show("confirmation-box");
      this.removeFormStep(this.formStepId)
        .then(() => {
          this.$notify({
            group: "alert",
            title: "Supprimer l'étape",
            text: "Supprimer avec succès",
            type: "success",
          });
          this.isDeleteModalShown = false;
          this.getFormSteps({ id: this.formId });
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
    onCancelDelection() {
      this.isDeleteModalShown = false;
    },
    updateStep(form) {
      this.$emit("onUpdateStep", form);
    },
    openModalCreateList() {
      this.$emit("openModalCreateList");
    },
  },
};
</script>
<style lang="scss" scoped>
.form-step-list-title {
  border-bottom: 1px solid #f4f6fc !important;
  padding: 0px 7px 7px 7px;
}
.title {
  font-size: 20px;
  font-weight: 600;
}
.form-step-list {
  padding: 0px 7px 7px 7px;
  &:hover {
    background-color: #f4f6fc;
  }
}
</style>
