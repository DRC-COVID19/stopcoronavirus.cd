<template>
  <b-container class="form__settings-container">
    <b-row>
      <b-col class="form__settings-body py-2">
       <b-container>
          <div>
            <h3>Paramètres</h3>
            <hr>
          </div>
          <div>
          <div>
              <div class="d-flex justify-content-between">
                <h4>Modifier le titre du  formulaire </h4>
                <img src="/img/akar-icons_pencil.svg" class="form__settings-icon" v-b-modal.updateFormModal>
              </div>
              <h6>Avoir la possibilité de modifier le nom du formulaire</h6>
              <hr>
              <update-form-modal
              @onUpdateFormTitle="updateFormTitleSubmit"
              />
          </div>
           <div class="mt-5">
              <div class="d-flex justify-content-between">
                <h4>Changer  la récurrence du formulaire </h4>
                <img src="/img/akar-icons_pencil.svg"  class="form__settings-icon" v-b-modal.updateFormRecurrenceModal>
              </div>
              <h6>Avoir la possibilité de modifier la récurrence</h6>
              <hr>
          </div>
           <div class="mt-5">
              <div class="d-flex justify-content-between">
                <h4>Supprimer  le formulaire </h4>
                <img src="/img/ant-design_delete-twotone.svg"  class="form__settings-icon">
              </div>
              <h6>Cette action supprimera le formulaire définitivement</h6>
              <hr>
          </div>
          <div class="mt-5">
              <div class="d-flex justify-content-between">
                <h4>Rendre visible le formulaire </h4>
                <img src="/img/ant-design_delete-twotone.svg"  class="form__settings-icon">
              </div>
              <h6>Cette action supprimera le formulaire définitivement</h6>
              <hr>
          </div>
          </div>
       </b-container>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import { mapActions } from 'vuex'
import UpdateFormModal from './components/formSettingsModals/updateFormTitleModal'
export default {
  components: {
    UpdateFormModal
  },
  data () {
    return {
      form: {},
      formRecurrences: [],
      isLoading: false,
      isUpdatingFormTile: false,
      formUpdated: false,
      showSuccess: false,
      updating: false
    }
  },
  mounted () {
    this.init()
  },
  methods: {
    ...mapActions(['formShow']),
    async init () {
      this.isLoading = true
      await this.formShow({ id: this.$route.params.form_id })
    },
    onReset () {
      this.form = {}
    },
    updateFormTitleSubmit (value) {
      this.updateForm(value)
    },
    updateForm (currentForm) {
      this.isLoading = true
      this.formUpdated = false
      const form = {
        title: currentForm.title ?? null,
        form_recurrence_value: currentForm.form_recurrence_value ?? null,
        form_recurrence_id: currentForm.form_recurrence_id ?? null,
        publish: currentForm.publish ?? null
      }

      axios
        .put('/api/dashboard/forms/' + currentForm.id, form)
        .then(() => {
          // this.formUpdated = true
          // this.showSuccess = true
          // this.isLoading = false
          // this.updating = false
          this.init()
          this.$notify({
            group: 'alert',
            title: 'Modification du  Formulaire',
            text: 'Modifier avec succès',
            type: 'success'
          })
        })
        .catch(({ response }) => {
          this.$gtag.exception(response)
          this.$notify({
            group: 'alert',
            title: 'Modification du  Formulaire',
            text: 'Une erreur est survenus',
            type: 'error'
          })
        })
    },
    backToRoute ({ formId }) {
      return this.$router.push(`/administration/forms/${formId}/`)
    }
  }
}
</script>
<style lang="scss" scoped>
.form__settings-container{
  width: 100%;
  position: relative;
   top: 10rem;
   height:auto ;
 .form__settings-body{
   width: 100%;
   min-height: 400px;
   background-color: #FFFFFF;
    h3, h4{
     font-weight: 500;
   }
   h3{
     color: #3767FA;
   }
   .form__settings-icon{
     cursor: pointer;
   }
 }
}
</style>
