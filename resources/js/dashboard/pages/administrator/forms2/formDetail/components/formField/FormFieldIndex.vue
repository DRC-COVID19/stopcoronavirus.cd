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
               :form-field-order="form_field_order"
               @created="onCreatedField"

               />
               <FormFieldCardOrder
               :form-to-populate="formFieldKey"
               :form-fields="formField"
               @createdField="onCallCreatedFieldCard"
               @createdFieldAfter="onCallCreatedFieldAfter"
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
                  @orderFieldCard="onCallOrderFieldCrad"
                  @updated="onUpdated"
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
import FormFieldCardOrder from './FormFieldCardOrder.vue'
import Loading from '../../../../../../components/Loading.vue'
import { mapState, mapActions } from 'vuex'
export default {
  components: { FormFieldCard, FormFieldList, FormFieldCreate, Loading, FormFieldCardOrder },
  data () {
    return {
      isLoading: false,
      fieldForm: {},
      selectedFormKey: null,
      form_field_order: null
    }
  },
  async  mounted () {
    await this.getFormFields({ form_id: this.form_id, step_id: 1 })
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
      this.fieldForm = await this.getFormFields({ form_id: this.form_id, step_id: 1 })
      if (this.fieldForm.length !== 0) {
        this.isLoading = false
      }
    },
    onCreatedField () {
      this.init()
    },
    onUpdated () {
      this.init()
    },
    onDeletedField () {
      this.init()
    },
    onEditField (formId) {
      this.selectedFormKey = formId
      this.$bvModal.show('createResponse')
    },
    onCallOrderFieldCrad (fieldId) {
      this.selectedFormKey = fieldId
      this.$bvModal.show('orderResponse')
    },
    onCallCreatedFieldCard (idField) {
      this.selectedFormKey = null
      this.form_field_order = idField
      this.$bvModal.show('createResponse')
    },
    onCallCreatedFieldAfter (idField) {
      this.selectedFormKey = null
      this.form_field_order = idField
      this.$bvModal.show('createResponse')
    },
    onResetModalCreate () {
      this.selectedFormKey = null
      this.form_field_order = null
      this.$bvModal.show('createResponse')
    }
  }

}
</script>
 <style lang="scss" scoped>

 </style>
