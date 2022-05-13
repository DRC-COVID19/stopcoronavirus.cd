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
            @submit.prevent="onUpdateFormVisible"
            @reset.prevent="onReset"
            label-class="text-dash-color"
          >
            <b-form @submit.prevent="onUpdateFormVisible">
               <FomFieldSelect
              v-model="targetForm.hospitals"
              :options="hospitals"
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
      targetForm: {
        hospitals: []
      },
      isLoading: false
    }
  },
  async mounted () {
    this.resetForm()
    await this.getAllHospitals()
  },
  computed: {
    ...mapState({
      hospitals: (state) => state.hospital.AllHospitals
    })
  },
  methods: {
    ...mapActions(['getAllHospitals']),
    onReset () {
      this.targetForm = {}
    },
    onUpdateFormVisible () {
      const form = {
        ...this.targetForm,
        form_recurrence_value: this.formRecurrences.find((form) => form.id === this.targetForm.form_recurrence_id)
      }
      this.$emit('onUpdateFormVisible', this.targetForm)
      this.$bvModal.hide('updateFormRecurrenceModal')
    }
  }
}
</script>

<style>

</style>
