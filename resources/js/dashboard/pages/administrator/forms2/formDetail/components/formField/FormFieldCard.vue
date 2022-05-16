<template>
  <div class="container-icon">
      <div class="">
          <img
           src="/img/icon/create_response.svg"
           class="img-create"
           height="32px"
           width="32px"
           alt
           @click="callCardOrderField"
            />
      </div>
      <div class="img-response-action">
          <img src="/img/icon/delete_response.svg"
          class="img-delete"
          height="32px"
          width="32px"
          alt
          @click="deleteHospital"
           />
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
          <img src="/img/icon/pencil_response.svg"
           class="img-pencil"
           height="32px"
           width="32px"
            alt
            @click="setPopulateForm"
             />
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
  .container-icon{
    background-color: white;
    padding: 3px;
    padding-right: 10px;
    padding-bottom: 54px;
    margin-right: 0px;
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
 @media screen and (max-width: 767px) {
   .container-icon{
     padding-bottom: 145px;
   }
 }
</style>
