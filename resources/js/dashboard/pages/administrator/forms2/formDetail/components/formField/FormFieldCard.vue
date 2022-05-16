<template>
  <div class="container-icon">
      <div class="">
          <i class="fa fa-plus-circle icon-action icon-action-add" aria-hidden="true" @click="callCardOrderField"></i>
      </div>
      <div class="img-response-action">
          <i class="fa fa-trash icon-action icon-action-delete" aria-hidden="true" @click="deleteHospital"></i>

          <b-modal v-model="isDeleteModalShown" centered hide-header>
            <template #modal-header>
              <div class="mx-auto">
                <h5 class="lead text-secondary">
                  Suppression du champ
                </h5>
              </div>
            </template>
            <div class="col-12">
              <div class="mx-5 my-2">
                Voulez-vous supprimer le champ ?
              </div>
            </div>
            <template #modal-footer>
              <b-button size="sm" variant="success" @click="onValidateDelete()">
                Accepter
              </b-button>
              <b-button size="sm" variant="danger" @click="onCancelDelete()">
                Annuler
              </b-button>
            </template>
          </b-modal>
      </div>
      <div class="img-response-action">
          <i class="fa fa-pencil icon-action icon-action-edit" aria-hidden="true" @click="setPopulateForm"></i>
      </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  props: {
    formField: {
      type: Object,
      default: () => ({}),
      required: false
    },
    fieldKey: {
      type: Number,
      default: null,
      required: false
    }
  },
  data () {
    return {
      isDeleteModalShown: false,
      fillInFormField: {}
    }
  },
  methods: {
    ...mapActions(['removeFormField']),
    setPopulateForm () {
      this.$emit('edit', this.fieldKey)
    },
    callCardOrderField () {
      this.$emit('orderFieldCard', this.fieldKey)
    },
    deleteHospital () {
      this.isDeleteModalShown = true
    },
    onValidateDelete () {
      this.removeFormField(this.formField.id)
        .then(() => {
          this.$notify({
            group: 'alert',
            title: 'Supprimer ce champ',
            text: 'Supprimer avec succès',
            type: 'Supprimer avec succès'
          })
          this.isDeleteModalShown = false
          this.$emit('deleted')
        })
        .catch(() => {
          this.$notify({
            group: 'alert',
            title: "Supprimer  l'étape",
            text: 'Une erreur est survenus',
            type: 'error'
          })
        })
    },
    onCancelDelete () {
      this.isDeleteModalShown = false
    }
  }

}
</script>
<style lang="scss" scoped>
 @import "@~/sass/_variables";

  .container-icon{
    background-color: white;
    padding: 20px 10px;
    margin-right: 0px;
    text-align: center;
    border-radius: 8px;
    .img-response-action{
      margin-top: 20px;
    }
    .img-create{
      cursor: pointer;
    }
    .img-delete{
      cursor: pointer;
    }
    .img-pencil{
      cursor: pointer;
    }
  }
 .icon-action {
  font-size: 20px;
  cursor: pointer;
  &:hover {
    opacity: 0.7;
  }
  &.icon-action-add {
    color: $dash-blue;
  }
  &.icon-action-edit {
    color: $flag-yellow;
  }
  &.icon-action-delete {
    color: $dash-red;
  }
 }
</style>
