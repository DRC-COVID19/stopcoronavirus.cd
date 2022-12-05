<template>
  <b-modal id="updateConflictResolutionMode" centered hide-footer hide-header>
    <b-container>
      <div class="mb-4">
        <h3 class="text-center text-bold">
          Modifier le mode de résolution des conflits
        </h3>
        <ValidationObserver
          v-slot="{ invalid }"
          ref="form"
          tag="form"
          novalidate
          @submit.prevent="onUpdateConflictResolutionMode"
          @reset.prevent="onReset"
          label-class="text-dash-color"
        >
          <b-form @submit.prevent="onUpdateConflictResolutionMode">
            <FomFieldSelect
              v-model="targetForm.conflict_resolution_mode_id"
              :options="conflictResolutionModes"
              label="name"
              :reduce="(item) => item.id"
              :isObligated="true"
              value="name"
              rules="required"
              id="form.conflict_resolution_mode_id"
              labelText="Mode résolution de conflit"
              name="Mode de résolution de conflict"
              mode="aggressive"
            />
            <div class="mt-4 text-center">
              <b-button
                @click.prevent="onCancelConflictResolutionMode()"
                type="submit"
                variant="outline-danger"
                class="mr-3"
                >Annuler</b-button
              >
              <b-button
                @click.prevent="onUpdateConflictResolutionMode()"
                type="submit"
                variant="primary"
                >Modifier</b-button
              >
            </div>
          </b-form>
        </ValidationObserver>
      </div>
    </b-container>
  </b-modal>
</template>
<script>
import FomFieldSelect from '../../../../../../components/forms/FomFieldSelect';
import { ValidationObserver } from 'vee-validate';
import { mapActions, mapState } from 'vuex';
export default {
  components: {
    FomFieldSelect,
    ValidationObserver,
  },
  props: {
    formToPopulate: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      targetForm: {
        conflict_resolution_mode_id: '',
      },
    };
  },
  async mounted() {
    console.log('formToPopulate', this.formToPopulate);
    await this.getConflictResolutionModes();
  },
  computed: {
    ...mapState({
      conflictResolutionModes: (state) => state.form.conflictResolutionModes,
    }),
  },
  watch: {
    formToPopulate() {
      this.populateRecurrenceForm();
    },
  },
  methods: {
    ...mapActions(['getConflictResolutionModes']),
    onReset() {
      this.targetForm = {};
    },
    hideModal() {
      this.$bvModal.hide('updateConflictResolutionMode');
    },
    onCancelConflictResolutionMode() {
      this.hideModal();
    },
    populateRecurrenceForm() {
      this.targetForm.conflict_resolution_mode_id =
        this.formToPopulate.conflict_resolution_mode_id;
    },
    onUpdateConflictResolutionMode() {
      this.$emit('onUpdateConflictResolutionMode', {
        ...this.targetForm,
        formFieldmodalMessage:
          'Le mode de résolution de conflict a été modifiée avec succès',
      });
      this.hideModal();
    },
  },
};
</script>
