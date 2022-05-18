<template>
  <b-container class="form__settings-container">
    <b-row>
      <b-col class="form__settings-body py-2">
        <b-container>
          <div>
            <h3>Paramètres</h3>
            <hr />
          </div>
          <div>
            <div>
              <div class="d-flex justify-content-between">
                <h4>Modifier le titre du formulaire</h4>
                <img
                  src="/img/akar-icons_pencil.svg"
                  class="form__settings-icon"
                  v-b-modal.updateFormTitleModal
                />
              </div>
              <h6>Cliquer sur l'icon à droite pour modifier le titre du formulaire</h6>
              <hr />
              <update-form-modal @onUpdateFormTitle="updateForm" />
            </div>
            <div class="mt-5">
              <div class="d-flex justify-content-between">
                <h4>Changer la récurrence du formulaire</h4>
                <img
                  src="/img/akar-icons_pencil.svg"
                  class="form__settings-icon"
                  v-b-modal.updateFormRecurrenceModal
                />
              </div>
              <h6>Pour mettre à jour la récurrence, cliquer sur l'icon à droite</h6>
              <hr />
              <update-form-recurrence-modal
                @onUpdateFormRecurrence="updateForm"
              />
            </div>
            {{ form}}
            <div class="mt-5">
              <div class="d-flex justify-content-between">
                <h4>Supprimer le formulaire</h4>
                <img
                  src="/img/ant-design_delete-twotone.svg"
                  class="form__settings-icon"
                  v-b-modal.deleteFormModal
                />
              </div>
              <h6>Cette action supprimera le formulaire définitivement</h6>
              <hr />
              <delete-form-modal :formId="getFormId"/>
            </div>
            <div class="mt-5">
              <div class="d-flex justify-content-between">
                <h4>Rendre visible le formulaire</h4>
                <img
                  src="/img/akar-icons_pencil.svg"
                  class="form__settings-icon"
                  v-b-modal.updateFormVisibilityModal
                />
              </div>
              <h6>
                Cliquer sur l'icon à droite pour changer la visibilité de ce le
                formulaire
              </h6>
              <hr />
              <update-form-visibility-modal
                @updateFormVisibility="updateForm"
              />
            </div>
          </div>
        </b-container>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import { mapActions, mapState } from 'vuex'
import DeleteFormModal from './components/formSettingsModals/deleteFormModal'
import UpdateFormVisibilityModal from './components/formSettingsModals/UpdateFormVisibilityModal'
import UpdateFormRecurrenceModal from './components/formSettingsModals/updateFormRecurrenceModal'
import UpdateFormModal from './components/formSettingsModals/updateFormTitleModal'
export default {
  components: {
    UpdateFormModal,
    UpdateFormRecurrenceModal,
    DeleteFormModal,
    UpdateFormVisibilityModal
  },
  data () {
    return {
      isLoading: false,
      isUpdatingFormTile: false,
      formUpdated: false,
      updating: false
    }
  },
  mounted () {
    this.getForm()
  },
  computed: {
    ...mapState({
      form: (state) => state.form.form
    }),
    getFormId () {
      return this.$route.params.form_id ?? null
    }
  },
  methods: {
    ...mapActions(['formShow', 'form__Update']),
    async getForm () {
      await this.formShow({ id: this.getFormId() })
    },
    async updateForm (currentForm) {
      this.isLoading = true
      this.formUpdated = false
      this.updating = true
      const form = {
        title: currentForm.title,
        form_recurrence_value: currentForm.form_recurrence_value,
        form_recurrence_id: currentForm.form_recurrence_id,
        publish: currentForm.publish,
        hospitals_id: currentForm.hospitals ?? [],
        visible_all_hospitals: currentForm.visibleAllHositals
      }

      this.form__Update({ form, id: this.getFormId })
        .then(() => {
          this.formUpdated = true
          this.isLoading = false
          this.updating = false
          this.$notify({
            group: 'alert',
            title: 'Modification du Formulaire',
            text: currentForm.formFieldmodalMessage,
            type: 'success'
          })
        })
        .catch(({ response }) => {
          this.$gtag.exception(response)
          this.$notify({
            group: 'alert',
            title: 'Modification du Formulaire',
            text: 'Une erreur est survenu',
            type: 'error'
          })
        })
    }
  }
}
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";
.form__settings-container {
  width: 100%;
  position: relative;
  top: 10rem;
  height: auto;
  .form__settings-body {
    width: 100%;
    min-height: 400px;
    background-color: #ffffff;
    h3,
    h4 {
      font-weight: 500;
    }
    h3 {
      color: #3767fa;
    }
    .form__settings-icon {
      cursor: pointer;
      padding: 2px;
      transition: all .3s ease-in-out;
      &:hover{
        background-color: #e6e6e7;
        border-radius: 5px;

      }
    }
  }
}
 @media (max-width: $max-width) {
  .form__settings-container {
  width: 100%;
  position: relative;
  top: 10rem;
  height: auto;
  .form__settings-body {
    h3,
    h4 {
      font-size: 16px;
      font-weight: 600;
    }
    h6 {
      font-size: 12px;
    }
  }
}
 }
</style>
