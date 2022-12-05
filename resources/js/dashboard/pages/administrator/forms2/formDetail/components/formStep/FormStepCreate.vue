<template>
  <b-card class="border-0 pt-0">
    <b-card-body>
      <b-form
        @submit.prevent="onSubmit"
        @reset.prevent="onReset"
        v-if="show"
        label-class="text-dash-color"
      >
        <b-form-group
          label-class="text-dash-color"
          id="input-group-1"
          :invalid-feedback="errors.title ? errors.title[0] : null"
          :state="!errors.title"
          ><label for="input-1"
            >Titre de l'Etape<span class="text-danger">*</span></label
          >
          <b-form-input
            id="input-1"
            v-model="form.title"
            type="text"
            placeholder="Entrer le titre"
            required
          ></b-form-input>
        </b-form-group>
        <b-form-group
          label-class="text-dash-color"
          id="input-group-1"
          :invalid-feedback="errors.step ? errors.step[0] : null"
          :state="!errors.step"
          ><label for="input-2">Etape<span class="text-danger">*</span></label>
          <b-form-input
            id="input-2"
            v-model="form.step"
            type="number"
            placeholder="Entrer l'étape"
            required
          ></b-form-input>
        </b-form-group>
        <b-row class="px-3 pt-4 d-flex justify-content-center">
          <b-button
            type="submit"
            variant="primary"
            class="btn-dash-dash mx-2"
            size="lg"
          >
            <span v-if="isLoading"
              ><b-spinner class="align-middle"></b-spinner>
              <span>en cours ...</span>
            </span>
            <div v-else>
              <small>{{
                isCreatingStepList ? 'Enregistrer' : 'Modifier'
              }}</small>
            </div>
          </b-button>
          <b-button
            v-if="!isCreatingStepList"
            type="reset"
            variant="danger"
            class="mx-2"
            size="lg"
          >
            <small>Annuler</small>
          </b-button>
        </b-row>
      </b-form>
    </b-card-body>
  </b-card>
</template>
<script>
import { mapActions } from 'vuex';
export default {
  props: {
    rowFormStep: {
      type: Object,
      default: () => {
        return {};
      },
    },
    formId: {
      type: Number,
      required: true,
    },
    errors: {
      type: Object,
      default: () => ({}),
    },
    isCreatingStepList: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      title: "Creation d'un formulaire",
      btnTitle: 'Enregistrer',
      iconClass: 'fas fa-plus-square',
      updating: false,
      isLoading: false,
      published: false,
      form: {
        title: '',
        step: null,
        form_id: null,
      },
      show: true,
      showWarning: false,
      toBeCanceled: true,
      formRecurrenceSelected: null,
    };
  },
  mounted() {
    this.onUpdateRowFormStep();
  },
  watch: {},
  methods: {
    ...mapActions(['createFormStep', 'updateFormStep']),
    onSubmit() {
      if (this.isCreatingStepList === true) {
        const formStep = {
          ...this.form,
          form_id: this.formId,
        };
        this.createFormStep(formStep)
          .then(() => {
            this.$notify({
              group: 'alert',
              title: 'Nouvelle Etape du Formulaire',
              text: 'Ajouter avec succès',
              type: 'success',
            });
            this.$emit('created');
            this.onReset();
          })
          .catch(({ response }) => {
            this.$notify({
              group: 'alert',
              title: 'Nouvelle Etape du Formulaire',
              text: 'Une erreur est survenus',
              type: 'error',
            });
            if (response.status == 422) {
              this.errors = response.data.errors;
            }
          });
      } else {
        this.updateFormStep(this.form)
          .then(() => {
            this.formStepUpdated = true;
            this.$notify({
              group: 'alert',
              title: "Modication d'un Etape du Formulaire",
              text: 'Modifier avec succès',
              type: 'success',
            });
            this.$emit('updated');
            // this.onReset();
          })
          .catch(({ response }) => {
            this.$notify({
              group: 'alert',
              title: 'Modifer log',
              text: 'Une erreur est surveni',
              type: 'error',
            });
            if (response.status == 422) {
              this.errors = response.data.errors;
            }
          });
      }
    },
    onUpdateRowFormStep() {
      this.form = {
        title: '',
        step: null,
        form_id: null,
      };
      if (Object.keys(this.rowFormStep) !== 0) {
        this.form = { ...this.rowFormStep };
      }
    },
    onReset() {
      this.toToCanceled = true;
      this.form = { title: '', step: null, form_id: null };
      this.$emit('onCancelUpdate', {});
    },
  },
};
</script>

<style lang="scss" scoped>
@import '@~/sass/_variables';
.main {
  background-color: white;
  border-radius: 10px;
  h2 {
    margin-bottom: 20px;
  }
}
</style>
