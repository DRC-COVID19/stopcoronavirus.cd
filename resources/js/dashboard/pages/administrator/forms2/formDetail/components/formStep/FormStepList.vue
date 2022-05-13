<template>
  <b-row class="w-100">
    <b-col lg="12" class="px-0">
      <b-card lg="12" class="border-0 px-0 w-100form-step-list-title mx-0">
        <div class="d-flex justify-content-between w-100">
          <div class="d-flex justify-content-center align-center">
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
        </div>
      </b-card>
    </b-col>

    <b-col lg="12" class="px-0">
      <b-card
        lg="12"
        class="border-0 px-0 w-100 form-step-list mx-0 px-0"
        v-for="(step, index) in formStepsSorted"
        :key="index"
      >
        <b-nav class="d-block w-100 px-0 mx-0">
          <b-nav-item class="d-block w-100 mx-0">
            <div class="d-flex justify-content-between w-100">
              <h3>{{ step.title }}</h3>

              <b-dropdown
                size="lg"
                variant="link"
                toggle-class="text-decoration-none"
                no-caret
              >
                <template #button-content>
                  <i class="fas fa-ellipsis-v"></i>
                </template>
                <b-dropdown-item-button @click="deleteStep(step.id)"
                  >Supprimer</b-dropdown-item-button
                >
                <b-dropdown-item-button @click="openModalUpdateList(step)"
                  >Modifier</b-dropdown-item-button
                >
              </b-dropdown>
            </div>
          </b-nav-item>
        </b-nav>
      </b-card>
    </b-col>
    <b-modal v-model="isDeleteModalShown" centered>
      Voulez-vous vraiment supprimer cette étape
      <template #modal-footer>
        <b-row class="px-3 pt-4 d-flex justify-content-center">
          <b-button
            size="sm"
            variant="success"
            class="btn-dash-blue mx-2"
            @click="onValidateDelection()"
          >
            Accepter
          </b-button>
          <b-button
            size="sm"
            variant="danger"
            class="mx-2"
            @click="onCancelDelection()"
          >
            Annuler
          </b-button>
        </b-row>
      </template>
    </b-modal>
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
      formStepId: null,
      editModalShow: false,
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

    openModalUpdateList(form) {
      this.$emit("openModalUpdateList", form);
    },
    ShowStepField() {},
  },
};
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";

.form-step-list-title {
  border-bottom: 1px solid #f4f6fc !important;
}
.title {
  font-size: 20px;
  font-weight: 600;
}
.card-body {
  padding: auto 15px;
}
.form-step-list {
  border-radius: 0px;
  h3 {
    font-size: 18px;
    font-weight: 100;
    color: $dash-blue;
  }
  &:hover {
    background-color: #f4f6fc;
  }
  &:active {
    background-color: #f4f6fc;
  }
}
.nav-item {
  a.active {
    background-color: #f4f6fc !important;
  }
}
</style>
