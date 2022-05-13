<template>
  <b-modal id="deleteFormModal" centered title="Suppression du formulaire" hide-header-close hide-footer>
      <p>Voulez-vous vraiment supprimer ce formulaire ?</p>
              <div class="mt-4 text-center">
                <b-button
                @click="onCancelDeleteForm"
                type="submit"
                variant="outline-danger"
                class="mr-3"
                >Annuler</b-button
                >
                 <b-button
                @click="onDeleteForm(formId)"
                type="submit"
                variant="primary"
                >Supprimer</b-button
                >
              </div>
            </b-form>
  </b-modal>
</template>

<script>
import { mapActions } from 'vuex'
export default {

  props: {
    formId: {
      type: [String, Number],
      default: () => null,
      required: true
    }
  },
  methods: {
    hideModal () {
      this.$bvModal.hide('deleteFormModal')
    },
    ...mapActions(['form__Delete']),
    onCancelDeleteForm () {
      this.hideModal()
    },
    onDeleteForm (id) {
      this.form__Delete(id)
        .then(() => {
          this.init()
          this.isFormDeleted = true
          this.$notify({
            group: 'alert',
            title: 'Supprimer formulaire',
            text: 'Supprimer avec succès',
            type: 'success'
          })
          this.$router.push('/administration/forms/')
        })
        .catch(({ response }) => {
          this.$gtag.exception(response)
          this.$notify({
            group: 'alert',
            title: 'Supprimer formulaire',
            text: 'Une erreur est survenue',
            type: 'error'
          })
        })
      this.hideModal()
    }
  }
}
</script>

<style>

</style>
