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
                <b-button
                @click.prevent="onCancelRecurrenceForm()"
                type="submit"
                variant="outline-danger"
                class="mr-3"
                >Annuler</b-button
                >
                 <b-button
                @click.prevent="onUpdateFormRecurrence()"
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
import FomFieldSelect from '../../../../../../components/forms/FomFieldSelect'
import { ValidationObserver } from 'vee-validate'
import { mapActions, mapState } from 'vuex'
export default {
  components: {
    FomFieldSelect,
    ValidationObserver
  },
  props: {
    formToPopulate: {
      type: Object,
      default: () => {}
    },
    isUpdatingFormTile: {
      type: Boolean,
      default: () => false
    }
  },
  data () {
    return {
      targetForm: { form_recurrence_id: null },
      isUpdating: this.isUpdatingFormTile
    }
  },
  async mounted () {
    await this.getFormsRecurrences()
  },
  computed: {
    ...mapState({
      formRecurrences: (state) => state.form.formsRecurrences
    })
  },
  watch: {
    formToPopulate () {
      this.populateRecurrenceForm()
    }
  },
  methods: {
    ...mapActions(['getFormsRecurrences']),
    onReset () {
      this.targetForm = {}
    },
    hideModal () {
      this.$bvModal.hide('updateFormRecurrenceModal')
    },
    onCancelRecurrenceForm () {
      this.hideModal()
    },
    populateRecurrenceForm () {
      this.targetForm.form_recurrence_id = this.formToPopulate.form_recurrence
    },
    onUpdateFormRecurrence () {
      this.$emit('onUpdateFormRecurrence', {
        ...this.targetForm,
        formFieldmodalMessage:
          'La recurrence du formulaire a été modifiée avec succès'
      })
      this.hideModal()
    }
  }
}
</script>

<style></style>
