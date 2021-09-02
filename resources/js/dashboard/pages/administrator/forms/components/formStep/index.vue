<template>
  <b-container fluid>
    <b-row class="flex-md-row-reverse" no-gutters>
      <b-col cols="12" md="4" class="mt-3">
        <Create
          @onUpdate="submitUpdatingFormStep"
          @onCreate="submitCreateFormStep"
          @onCancelUpdate="cancelEditMode"
          :rowFormStep="rowformStep"
          :errors="errors"
        />
      </b-col>
      <b-col cols="12" md="8">
        <Header :title="title" :iconClass="iconClass" />
        <div class="hide-waiting" v-if="isCreating"></div>
        <ListFormStep
          :formSteps="formSteps"
          :isLoading="isLoading"
          :updating="isCreating"
          :current-page="formStepMeta.currentPage"
          :per-page="formStepMeta.perPage"
          @onSearch="search"
          @onDeleteStep="remove"
          @onUpdateStep="toEdit"
        />
        <b-col cols="12" class="d-flex justify-content-end">
          <b-pagination
            v-model="formStepMeta.currentPage"
            :per-page="formStepMeta.perPage"
            :total-rows="formStepMeta.total"
            :disabled="isCreating"
            page-class="text-blue-dash"
            @change="getFormSteps"
          ></b-pagination>
        </b-col>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import Header from "../../../components/Header";
import ListFormStep from "../formStep/ListFormStep";
import Create from "../formStep/Create.vue";
import { mapActions, mapState } from 'vuex';
export default {
  props: {
      formId: {
      type: Number,
      required: true
    },
    },

  components: {
    Header,
    Create,
    ListFormStep,
  },
  data() {
    return {
      filter:null,
      errors: {},
      isEditingMode: false,
      itemToRemove: {},
      title: "Les étapes du Formulaire",
      iconClass: "fa fa-sliders",
      formStepUpdated: false,
      formStepAdded: false,
      showSuccess: false,
      isFormDeleted: false,
      timeOut: 3,
      rowformStep:{}
    };
  },
  mounted(){
    this.getFormSteps()
    this.getForms()
  },

   watch: {
    filter () {
      this.search()
    }
  },

  computed: {
    ...mapState({
      formSteps:(state)=>state.formStep.formSteps,
      forms:(state)=>state.form.forms,
      isCreating: (state) => state.formStep.isCreating,
      isLoading: (state) => state.formStep.isLoading
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
    }
  },
  methods:{
    ...mapActions([
      "getFormSteps",
      "createFormStep",
      "updateFormStep",
      "removeFormStep",
      "searchFormStep",
      "getForms"]),
    submit_form() {
      if (this.isEditingMode) {
        this.submitUpdatingFormStep();
      } else {
        this.submitCreateFormStep();
      }
    },
    submitCreateFormStep(form) {
      this.errors = {};
      const formStape = {
        ...form,
        form_id:this.formId
      }
      this.createFormStep(formStape)
        .then(() => {
          this.isEditingMode = false;
          this.$notify({
            group: "alert",
            title: "Nouvelle Etape du Formulaire",
            text: "Ajouter avec succès",
            type: "success",
          });
         this.getFormSteps()
        })
        .catch(({ response }) => {
          this.$notify({
            group: "alert",
            title: "Nouvelle Etape du Formulaire",
            text: "Une erreur est survenus",
            type: "error",
          });
          if (response.status == 422) {
            this.errors = response.data.errors;
          }
        });
    },
    submitUpdatingFormStep(form) {
      this.errors = {};
      this.formStepUpdated = false;
      this.updateFormStep(form)
        .then(() => {
          this.formStepUpdated = true;
          this.isEditingMode = false;
          this.$notify({
            group: "alert",
            title: "Modication d'un Etape du Formulaire",
            text: "Modifier avec succès",
            type: "success",
          });
        })
        .catch(({ response }) => {
          this.$notify({
            group: "alert",
            title: "Modifer log",
            text: "Une erreur est surveni",
            type: "error",
          });
          if (response.status == 422) {
            this.errors = response.data.errors;
          }
        });
    },
    toEdit(item) {
      this.isEditingMode = true;
      this.rowformStep = { ...item };
    },
    cancelEditMode() {
      this.isEditingMode = false;
    },
     search () {
      this.searchFormStep(this.filter)
        .catch((error) => {
          console.log(error);
        })
    },
    remove(item) {
      this.itemToRemove = item;
      this.$bvModal.show("confirmation-box");
           this.removeFormStep(this.itemToRemove)
        .then(() => {
          this.$notify({
            group: "alert",
            title: "Supprimer l'étape",
            text: "Supprimer avec succès",
            type: "success",
          });
          this.getFormSteps()
        })
        .catch(() => {
          this.$notify({
            group: "alert",
            title: "Supprimer  l'étape",
            text: "Une erreur est survenus",
            type: "error",
          });
        });
    }

  }

}
</script>