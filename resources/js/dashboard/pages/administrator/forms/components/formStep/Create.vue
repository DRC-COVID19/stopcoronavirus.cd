<template>
  <b-card>
    <h2 class="h2">{{ title }}</h2>
    <b-form
      @submit.prevent="onSubmit"
      @reset.prevent="onReset"
      v-if="show"
      label-class="text-dash-color"
    >
      <b-form-group
        label-class="text-dash-color"
        id="input-group-1"
        label="Titre de l'Etape *"
        label-for="input-1"
        :invalid-feedback="errors.title ? errors.title[0] : null"
        :state="!errors.title"
      >
        <b-form-input
          class="input-dash"
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
        label="Etape *"
        label-for="input-1"
        :invalid-feedback="errors.step ? errors.step[0] : null"
        :state="!errors.step"
      >
        <b-form-input
          class="input-dash"
          id="input-1"
          v-model="form.step"
          type="number"
          placeholder="Entrer l'étape"
          required
        ></b-form-input>
      </b-form-group>
      <b-row class="px-3 pt-4 d-flex justify-content-start">
          <b-button type="submit" variant="primary" class="btn-dash-sucess">
            <span v-if="isLoading"
            ><b-spinner class="align-middle"></b-spinner>
              <span>en cours ...</span>
            </span>
            <div v-else>
              {{btnTitle }}
            </div>
          </b-button>
        <b-button
          type="reset"
          v-if="updating"
          variant="primary"
          class="ml-4 btn-dash-danger"
          >Annuler</b-button
        >
      </b-row>
    </b-form>
  </b-card>
</template>
<script>
import { mapActions} from 'vuex';
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
      required: true
    },
    errors: {
      type: Object,
      default: () => ({}),
    },
  },
  data(){
     return{
        title: "Creation d'un formulaire",
        btnTitle: "Enregistrer",
        iconClass: "fas fa-plus-square",
        updating: false,
        isLoading: false,
        published:false,
        form: {
          title: "",
          step:  null,
          form_id: null
        },
        show: true,
        showWarning: false,
        toBeCanceled: true,
        formRecurrenceSelected: null,
        formCreated:true,
        formUpdated:true
      }
    },
  watch: {
    rowFormStep(){
      this.form = {...this.rowFormStep}
      this.updating = true
      this.title = "Modification de l'étape";
      this.btnTitle = "Modifier";
    },
  },
    methods: {
      ...mapActions([
        "createFormStep",
        "updateFormStep",

      ]),
    onSubmit() {
      if (this.btnTitle === "Enregistrer") {
      this.errors = {};
      const formStape = {
        ...this.form,
        form_id:this.formId
      }
      this.createFormStep(formStape)
        .then(() => {
          this.$notify({
            group: "alert",
            title: "Nouvelle Etape du Formulaire",
            text: "Ajouter avec succès",
            type: "success",
          });
          this.$emit("created");
          this.onReset()
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
      } else {
       this.updateFormStep(this.form)
        .then(() => {
          this.formStepUpdated = true;
          this.$notify({
            group: "alert",
            title: "Modication d'un Etape du Formulaire",
            text: "Modifier avec succès",
            type: "success",
          });
          this.$emit("updated");
          this.onReset()
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

      }
    },

    onReset() {
      this.toToCanceled = true;
      this.form = {};
      this.title = "Creation d'un étape";
      this.btnTitle = "Enreigistrer";
      this.$emit("onCancelUpdate", {});
    },
  }
}
</script>

<style lang='scss' scoped>
@import "@~/sass/_variables";
.main {
  background-color: white;
  border-radius: 10px;
  h2 {
    margin-bottom: 20px;
  }
}
</style>