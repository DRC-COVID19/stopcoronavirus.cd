<template>
  <b-container class="mx-0 px-0" fluid>
    <b-row class="mx-0">
      <FormStepList
        @openModalCreateList="showModalCreatedModal"
        @openModalUpdateList="showModalUpdatedModal"
        :isLoading="isLoading"
        :updating="isCreating"
        :formId="formId"
        :current-page="formStepMeta.currentPage"
        :per-page="formStepMeta.perPage"
        :total-rows="formStepMeta.total"
        class="mt-4"
        @onUpdateStep="toEdit"
      />
    </b-row>
    <b-modal ref="modal-creation" hide-footer hide-header centered title="">
      <h2 class="title text-center">
        {{ isCreatingStep ? "Création des étapes" : "Modification des étapes" }}
      </h2>
      <FormStepCreate
        :formId="formId"
        :rowFormStep="rowformStep"
        @updated="onUpdatedFormStep"
        @created="onCreatedFormStep"
        @onCancelUpdate="cancelEditMode"
        :isCreatingStepList="isCreatingStep"
      />
    </b-modal>
  </b-container>
</template>
<script>
import { mapActions, mapState } from "vuex";

import FormStepList from "./FormStepList.vue";
import FormStepCreate from "./FormStepCreate.vue";

export default {
  components: {
    FormStepList,
    FormStepCreate,
  },
  props: {
    formId: {
      type: Number,
      required: true,
    },
  },

  data() {
    return {
      isEditingMode: false,
      title: "Les étapes du Formulaire",
      iconClass: "fa fa-sliders",
      rowformStep: {},
      isCreatingStep: false,
    };
  },
  mounted() {
    this.getFormSteps({ id: this.formId });
  },

  computed: {
    ...mapState({
      formSteps: (state) => state.formStep.formSteps,
      isCreating: (state) => state.formStep.isCreating,
      isLoading: (state) => state.formStep.isLoading,
    }),
    formStepData() {
      return this.formSteps.data;
    },
    formStepMeta() {
      return this.formSteps.meta
        ? this.formSteps.meta
        : {
            currentPage: 1,
            perPage: 16,
            total: this.formSteps.length,
          };
    },
  },
  methods: {
    ...mapActions(["getFormSteps"]),
    showModalCreatedModal() {
      this.isCreatingStep = true;
      this.$refs["modal-creation"].show();
    },
    showModalUpdatedModal() {
      this.isCreatingStep = false;
      this.$refs["modal-creation"].show();
    },
    onCreatedFormStep() {
      this.getFormSteps({ id: this.formId });
    },
    onUpdatedFormStep() {
      this.getFormSteps({ id: this.formId });
    },
    toEdit(item) {
      this.isEditingMode = true;
      this.rowformStep = { ...item };
    },
    cancelEditMode() {
      this.isEditingMode = false;
      this.isCreatingStep = true;
    },
  },
};
</script>
<style scoped>
.title {
  font-size: 20px;
  font-weight: 600;
}
</style>
