<template>
  <div id="step-form">
    <b-card class="my-4">
      <b-card-body class="py-0">
        <div class="d-flex justify-content-between align-items-center">
          <strong class="mb-0"> ÉTAPES </strong>
          <i class="fas fa-list-ol" aria-hidden="true"></i>
        </div>
      </b-card-body>
    </b-card>
    <Create
      :formId="formId"
      :rowFormStep="rowformStep"
      @updated="onUpdatedFormStep"
      @created="onCreatedFormStep"
      @onCancelUpdate="cancelEditMode"
    />
    <div class="hide-waiting" v-if="isCreating"></div>
    <ListFormStep
      :isLoading="isLoading"
      :updating="isCreating"
      :formId="formId"
      :current-page="formStepMeta.currentPage"
      :per-page="formStepMeta.perPage"
      :total-rows="formStepMeta.total"
      class="mt-4"
      @onUpdateStep="toEdit"
    />
  </div>
</template>
<script>
import ListFormStep from '../formStep/FormStepList';
import Create from '../formStep/FormStepCreate.vue';
import { mapActions, mapState } from 'vuex';
export default {
  props: {
    formId: {
      type: Number,
      required: true,
    },
  },

  components: {
    Create,
    ListFormStep,
  },
  data() {
    return {
      isEditingMode: false,
      title: 'Les étapes du Formulaire',
      iconClass: 'fa fa-sliders',
      rowformStep: {},
    };
  },
  mounted() {
    this.getFormSteps({ id: this.formId });
    this.selectDefaultStep();
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
  watch: {
    formSteps() {
      this.selectDefaultStep();
    },
  },
  methods: {
    ...mapActions(['getFormSteps']),

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
    },
    selectDefaultStep() {
      if (!this.$route.params.step_id) {
        const steps = this.formSteps.slice().sort((a, b) => b.step - a.step);
        this.$router.push({
          name: 'administrator.forms.show.creation.step',
          params: { step_id: steps[0].id },
        });
      }
    },
  },
};
</script>
