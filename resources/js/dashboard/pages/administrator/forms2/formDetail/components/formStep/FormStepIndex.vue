<template>
  <b-container class="mx-0 px-0">
    <b-row class="mx-0">
      <FormStepList
        @openModalCreateList="showModalCreatedModal"
        @openModalUpdateList="showModalUpdatedModal"
        :isLoading="isLoading"
        :updating="isCreating"
        :formId="formId"
        class="mt-4"
      />
    </b-row>
    <b-modal ref="modal-creation" hide-footer hide-header centered title="">
      <h2 class="title text-center">
        {{
          isCreatingStep === true
            ? "Création d'une étape"
            : "Modification d'une étape"
        }}
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
import { mapActions, mapState } from 'vuex';

import FormStepList from './FormStepList.vue';
import FormStepCreate from './FormStepCreate.vue';

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
      title: 'Les étapes du Formulaire',
      iconClass: 'fa fa-sliders',
      rowformStep: {},
      isCreatingStep: false,
    };
  },
  mounted() {
    this.getFormSteps({ id: this.formId });
    this.initStepIndex();
  },

  computed: {
    ...mapState({
      formSteps: (state) => state.formStep.formSteps,
      isCreating: (state) => state.formStep.isCreating,
      isLoading: (state) => state.formStep.isLoading,
    }),
  },
  watch: {
    '$route.name'() {
      if (this.$route.name === 'administrator.forms.show.creation') {
        this.initStepIndex();
      }
    },
    formSteps() {
      this.initStepIndex();
    },
  },
  methods: {
    ...mapActions(['getFormSteps']),
    formStepsSorted(formSteps) {
      return formSteps.slice().sort((a, b) => a.step - b.step);
    },
    initStepIndex() {
      if (
        this.formSteps.length !== 0 &&
        this.$route.path !==
          `/administration/forms/${this.formId}/step/${
            this.formStepsSorted(this.formSteps)[0].id
          }`
      ) {
        this.$router.push({
          name: 'administrator.forms.show.creation.step',
          params: {
            step_id: this.formStepsSorted(this.formSteps)[0].id,
          },
        });
      }
      if (
        this.formSteps.length === 0 &&
        this.$route.path !== `/administration/forms/${this.formId}/`
      ) {
        this.$router.push({
          name: 'administrator.forms.show.creation',
        });
      }
    },
    showModalCreatedModal() {
      this.isCreatingStep = true;
      this.rowformStep = {};
      this.$refs['modal-creation'].show();
    },
    showModalUpdatedModal(form) {
      this.isCreatingStep = false;
      this.rowformStep = { ...form };
      this.$refs['modal-creation'].show();
    },
    async onCreatedFormStep() {
      await this.getFormSteps({ id: this.formId });
      this.$refs['modal-creation'].hide();
    },
    async onUpdatedFormStep() {
      await this.getFormSteps({ id: this.formId });
      this.$refs['modal-creation'].hide();
    },

    cancelEditMode() {
      this.isEditingMode = false;
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
