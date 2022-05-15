<template>
    <b-modal id="updateFormVisibilityModal"  centered hide-footer hide-header>
      <div v-if="isLoading">
      </div>
    <b-container v-else>
      <b-row>
        <b-col>
          <div class="mb-4 p-2">
            <h3 class="lead text-center text-bold">
              Rendre visible le formulaire
            </h3>
          </div>
          <ValidationObserver
            v-slot="{ invalid }"
            ref="form"
            tag="form"
            novalidate
            @submit.prevent="onUpdateFormVisibility"
            @reset.prevent="onReset"
            label-class="text-dash-color"
          >
            <b-form @submit.prevent="onUpdateFormVisibility">
              <b-row class="d-flex flex-column justify-content-between mt-3">
                <b-col md="12" class="border-1">
                   <b-form-checkbox v-model="visibleAllHositals" name="check-button" switch class="mb-4">
                   Pour tous les CTCOS
                  </b-form-checkbox>
               </b-col>
                <b-col md="12" >
                  <FomFieldSelect
                    v-model="targetForm.hospitals"
                    :options="hospitals"
                    label="name"
                    :reduce="(item) => item.id"
                    :isObligated="true"
                    value="name"
                    rules="required"
                    isMultiple
                    id="form.form_recurrence_id"
                    labelText="Selectionnez un ou plusieurs CTCOs "
                    name="Recurrence du formulaire"
                    mode="aggressive"
                    :disabled="visibleAllHositals"
                    />
                </b-col>
              </b-row>
              <div class="mt-4 text-center">
                <b-button type="submit" variant="primary"
                >Publier</b-button
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
      targetForm: {
        hospitals: []
      },
      isLoading: false,
      visibleAllHositals: false
    }
  },
  async mounted () {
    this.resetForm()
    await this.hospital__getAll()
  },
  computed: {
    ...mapState({
      hospitals: (state) => state.hospital.AllHospitals
    })
  },
  methods: {
    ...mapActions(['hospital__getAll']),
    onReset () {
      this.targetForm = {}
    },
    onUpdateFormVisibility () {
      const form =
      {
        ...this.targetForm,
        visibleAllHositals: this.visibleAllHositals,
        formFieldmodalMessage: 'La visibilité du formulaire a été modifié avec succès'
      }

      this.$emit('updateFormVisibility', form)
      this.$bvModal.hide('updateFormVisibilityModal')
    }
  }
}
</script>

<style>

</style>
