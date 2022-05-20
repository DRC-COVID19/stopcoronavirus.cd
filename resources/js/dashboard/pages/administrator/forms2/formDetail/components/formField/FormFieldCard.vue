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
      <div class="img-response-action">
        <i class="fa fa-arrow-up icon-action icon-action-up"  v-show="isFirstField"    aria-hidden="true"  @click="dropUpField"></i>
      </div>
       <div class="img-response-action"  >
         <i class="fa fa-arrow-down  icon-action icon-action-down" v-show="isLastField"  aria-hidden="false" @click="dropDownField"></i>
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
    fieldForms: {
      type: Array,
      default: () => [],
      required: false
    },
    fieldKey: {
      type: Number,
      default: null,
      required: false
    },
    indexField: {
      type: Number,
      default: null,
      required: false
    },
    lastField: {
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
  computed: {
    isFirstField () {
      return this.indexField !== 0
    },
    isLastField () {
      return this.indexField !== this.lastField
    }
  },
  methods: {
    ...mapActions(['removeFormField', 'updateFormField']),
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
    },
    dropUpField () {
      this.$emit('dropUp')
      const index = this.fieldForms.findIndex((field) => field.id === this.formField.id) - 1
      Promise.all([
        this.updateFormField({ id: this.formField.id, order_field: this.formField.order_field - 1 }),
        this.updateFormField({ id: this.fieldForms[index].id, order_field: this.fieldForms[index].order_field + 1 })
      ])
        .then(() => {
          console.log('champ actuel : id', this.formField.id, 'order_field', this.formField.order_field - 1)
          console.log('champ precedent:id', this.fieldForms[index].id, 'order_field', this.fieldForms[index].order_field + 1)
          this.$emit('resetList')
        })
    },
    dropDownField () {
      this.$emit('dropDown')
      const index = this.fieldForms.findIndex((field) => field.id === this.formField.id) + 1
      Promise.all([
        this.updateFormField({ id: this.formField.id, order_field: this.formField.order_field + 1 }),
        this.updateFormField({ id: this.fieldForms[index].id, order_field: this.fieldForms[index].order_field - 1 })
      ])
        .then(() => {
          this.$emit('resetList')
        })
    }

  }

}
</script>
<style lang="scss" scoped>
 @import "@~/sass/_variables";

  .container-icon{
    background-color: white;
    padding: 6px 10px;
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
  &.icon-action-up {
    color: $dash-blue;
  }
  &.icon-action-down {
    color: $dash-blue;
  }

 }
</style>
