<template>
  <b-modal id="updateFormTitleModal" centered hide-footer hide-header>
    <b-container>
      <b-row>
        <b-col>
          <div class="mb-4 p-2">
            <h3 class="text-center text-bold">
              Modifier le titre du formulaire
            </h3>
          </div>
          <ValidationObserver
            v-slot="{ invalid }"
            ref="form"
            tag="form"
            novalidate
            @submit.prevent="onUpdateFormSubmit"
            @reset.prevent="onReset"
            label-class="text-dash-color"
          >
            <b-form @submit.prevent="onUpdateFormSubmit">
              <b-form-group>
                <label class="text-dash-color" for="text-firstName"
                  >Titre du formulaire
                  <span class="text-danger"> *</span></label
                >
                <FormFieldInput
                  v-model="targetForm.title"
                  type="text"
                  id="text-firstName"
                  rules="required"
                  name="Titre du formulaire"
                  mode="aggressive"
                />
              </b-form-group>
              <div class="mt-4 text-center">
                <b-button
                  @click.prevent="onCancelFormTitleSubmit()"
                  type="submit"
                  variant="outline-danger"
                  class="mr-3"
                  >Annuler</b-button
                >
                <b-button
                  @click.prevent="onUpdateFormTitleSubmit()"
                  type="submit"
                  variant="primary"
                  >Modifier</b-button
                >
              </div>
            </b-form>
          </ValidationObserver>
        </b-col>
      </b-row>
    </b-container>
  </b-modal>
</template>

<script>
import FormFieldInput from '../../../../../../components/forms/FormFieldInput.vue';
import { ValidationObserver } from 'vee-validate';
import { mapActions, mapState } from 'vuex';
export default {
  components: {
    FormFieldInput,
    ValidationObserver,
  },
  props: {
    isUpdatingFormTile: {
      type: Boolean,
      default: () => false,
    },
  },
  data() {
    return {
      isUpdating: this.isUpdatingFormTile,
    };
  },
  mounted() {
    this.getFormTitle();
  },
  computed: {
    ...mapState({
      targetForm: (state) => state.form.form,
    }),
  },
  watch: {
    targetForm() {
      return this.targetForm;
    },
  },
  methods: {
    ...mapActions(['formShow']),
    onReset() {
      this.formUpdate = {};
    },
    async getFormTitle() {
      await this.formShow({ id: this.$route.params.form_id });
    },
    hideModal() {
      this.$bvModal.hide('updateFormTitleModal');
    },
    onUpdateFormTitleSubmit() {
      const formSubmit = {
        ...this.targetForm,
        title: this.targetForm.title,
        formFieldmodalMessage:
          'Le titre du formulaire a été modifié avec succès',
      };
      this.$emit('onUpdateFormTitle', formSubmit);
      this.hideModal();
    },
    onCancelFormTitleSubmit() {
      this.hideModal();
    },
  },
};
</script>

<style></style>
