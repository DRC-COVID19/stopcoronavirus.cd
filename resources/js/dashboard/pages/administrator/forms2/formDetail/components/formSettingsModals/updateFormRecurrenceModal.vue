<template>
  <b-modal id="updateFormRecurrenceModal" centered hide-footer hide-header>
    <b-container>
      <b-row>
        <b-col>
          <div class="mb-4 p-2">
            <h3 class="lead text-center text-bold">
              Changer la récurrence du formulaire
            </h3>
          </div>
          <ValidationObserver
            v-slot="{ invalid }"
            ref="form"
            tag="form"
            novalidate
            @submit.prevent="onUpdateFormRecurrence"
            @reset.prevent="onReset"
            label-class="text-dash-color"
          >
            <b-form @submit.prevent="onUpdateFormRecurrence">
              <FomFieldSelect
                v-model="targetForm.form_recurrence_id"
                :options="formRecurrences"
                label="name"
                :reduce="(item) => item.id"
                :isObligated="true"
                value="name"
                rules="required"
                id="form.form_recurrence_id"
                labelText="Recurrence du formulaire "
                name="Recurrence du formulaire"
                mode="aggressive"
              />
              <div class="mt-4 text-center">
                <b-button type="submit" variant="primary">Modifier</b-button>
              </div>
            </b-form>
          </ValidationObserver>
        </b-col>
      </b-row>
    </b-container>
  </b-modal>
</template>

<script>
import FomFieldSelect from "../../../../../../components/forms/FomFieldSelect";
import { ValidationObserver } from "vee-validate";
import { mapActions, mapState } from "vuex";
export default {
  components: {
    FomFieldSelect,
    ValidationObserver,
  },
  props: {
    form: {
      type: Object,
      default: () => {},
    },
    isUpdatingFormTile: {
      type: Boolean,
      default: () => false,
    },
  },
  data() {
    return {
      targetForm: { form_recurrence_id: null },
      isUpdating: this.isUpdatingFormTile,
    };
  },
  async mounted() {
    this.resetForm();
    await this.getFormsRecurrences();
  },
  computed: {
    ...mapState({
      formRecurrences: (state) => state.form.formsRecurrences,
    }),
  },
  methods: {
    ...mapActions(["getFormsRecurrences"]),
    onReset() {
      this.targetForm = {};
    },

    onUpdateFormRecurrence() {
      this.$emit("onUpdateFormRecurrence", {
        ...this.targetForm,
        formFieldmodalMessage:
          "La recurrence du formulaire a été modifiée avec succès",
      });
      this.$bvModal.hide("updateFormRecurrenceModal");
    },
  },
};
</script>

<style></style>
