<template>
  <b-container fluid>
    <b-row class="flex-md-row-reverse" no-gutters>
      <b-col cols="12" class="mt-3">
        <Create
          :formId="formId"
          :rowFormStep="rowformStep"
          @updated="onUpdatedFormStep"
          @created="onCreatedFormStep"
          @onCancelUpdate="cancelEditMode"
        />
      </b-col>
      <b-col cols="12">
        <Header :title="title" :iconClass="iconClass" />
        <div class="hide-waiting" v-if="isCreating"></div>
        <ListFormStep
          :isLoading="isLoading"
          :updating="isCreating"
          :formId="formId"
          :current-page="formStepMeta.currentPage"
          :per-page="formStepMeta.perPage"
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
      isEditingMode: false,
      title: "Les étapes du Formulaire",
      iconClass: "fa fa-sliders",
      rowformStep:{}
    };
  },
  mounted(){
  this.getFormSteps({id:this.formId})
  },

  computed: {
    ...mapState({
      formSteps:(state)=>state.formStep.formSteps,
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
      "getFormSteps"
      ]),

    onCreatedFormStep() {
         this.getFormSteps({id:this.formId})
    },
    onUpdatedFormStep() {
         this.getFormSteps({id:this.formId})

    },
    toEdit(item) {
      this.isEditingMode = true;
      this.rowformStep = { ...item };
    },
    cancelEditMode() {
      this.isEditingMode = false;
    },
  }

}
</script>