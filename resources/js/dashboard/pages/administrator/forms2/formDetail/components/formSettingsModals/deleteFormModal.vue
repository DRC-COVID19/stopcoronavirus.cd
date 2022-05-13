<template>
  <b-modal id="deleteForm" centered title="Suppression du formulaire" hide-header-close hide-footer>
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
      this.$bvModal.hide('deleteForm')
    },
    onCancelDeleteForm () {
      this.hideModal()
    },
    onDeleteForm (id) {
      this.$emit('onDeleteForm', id)
      this.hideModal()
    }
  }
}
</script>

<style>

</style>
