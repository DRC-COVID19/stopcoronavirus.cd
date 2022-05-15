<template>
   <div class="container-all">
      <Loading v-if="isLoading" class="h-100"  message="Chargement des champs ..."/>
      <div class="row">
         <div class="col-12">
            <div class="text-right">
               <b-button
               class="btn-dash-blue btn-create-field"
               @click="onResetModalCreate"
               >
                  Ajouter un champ
               </b-button>
               <FormFieldCreate
               :form-to-populate="formFieldKey"
               @created="onCreatedField"

               />
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-12">
             <div class="container-component-field d-flex justify-content-between align-items-center mt-4"
               v-for="(formField, index) in formField" :key="index"
            >
               <div class="field-card" style="width: 90%">
                  <FormFieldList
                  :formField="formField"
                  />
               </div>
               <div class="field-create">
                  <FormFieldCard
                  @deleted="onDeletedField"
                  @edit="onEditField"
                  :formField="formField"
                  :fieldKey="formField.id"
                  />
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<script>
import FormFieldList from './FormFieldList.vue'
import FormFieldCard from './FormFieldCard.vue'
import FormFieldCreate from './FormFieldCreate.vue'
import Loading from '../../../../../../components/Loading.vue'
import { mapState, mapActions } from 'vuex'
export default {
  components: { FormFieldCard, FormFieldList, FormFieldCreate, Loading },
  data () {
    return {
      isLoading: false,
      fieldForm: {},
      selectedFormKey: null
    }
  },
  async  mounted () {
    await this.getFormFields({ id: this.form_id })
    this.init()
  },
  computed: {
    ...mapState({
      formField: (state) => state.formField.formFields
    }),
    form_id () {
      return this.$route.params.form_id
    },
    formFieldKey () {
      if (this.selectedFormKey && this.selectedFormKey > -1) {
        const index = this.formField.findIndex((field) => this.selectedFormKey === field.id)
        return this.formField[index]
      } else {
        return null
      }
    }
  },
  methods: {
    ...mapActions(['getFormFields']),
    async init () {
      this.isLoading = true
      this.fieldForm = await this.getFormFields({ id: this.form_id })
      if (this.fieldForm.length !== 0) {
        this.isLoading = false
      }
    },
    onCreatedField () {
      console.log('created form')
      this.init()
    },
    onDeletedField () {
      this.init()
    },
    onEditField (formId) {
      this.selectedFormKey = formId
      this.$bvModal.show('createResponse')
    },
    onResetModalCreate () {
      this.selectedFormKey = null
      this.$bvModal.show('createResponse')
    }
  }

}
</script>
 <style lang="scss" scoped>

 </style>
