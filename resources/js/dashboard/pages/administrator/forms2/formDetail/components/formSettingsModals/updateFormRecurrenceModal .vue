<template>
    <b-modal id="updateFormRecurrenceModal"  centered hide-footer hide-header>
    <b-container>
      <b-row>
        <b-col>
          <div class="mb-4 p-2">
            <h3 class="text-center text-bold">
              Modifier le titre du  formulaire
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
               <FomFieldSelect
              v-model="targetForm.form_recurrence_id"
              :options="formRecurrences"
              label="name"
              :reduce="(item) => item.id"
              :isObligated="true"
              rules="required"
              id="form.form_recurrence_id"
              labelText="Recurrence du formulaire "
              name="Recurrence du formulaire"
              mode="aggressive"
             />
              <div class="mt-4 text-center">
                <b-button type="submit" variant="primary"
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
    form: {
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
    this.getFormTitle()
    this.resetForm()
    await this.getFormsRecurrences()
  },
  computed: {
    ...mapState({
      formRecurrences: (state) => state.form.formsRecurrences
    })
  },
  watch: {
    // formTitle () {
    //   this.getFormTitle()
    // }
  },

  methods: {
    ...mapActions(['getFormsRecurrences']),
    onReset () {
      this.formUpdate = {}
    },
    getFormTitle () {
      this.targetForm = this.form
    },

    onUpdateFormSubmit () {
      this.$emit('onUpdateFormTitle', this.targetForm)
      this.$bvModal.hide('updateFormModal')
    }
  }
}
</script>

<style>

</style>
