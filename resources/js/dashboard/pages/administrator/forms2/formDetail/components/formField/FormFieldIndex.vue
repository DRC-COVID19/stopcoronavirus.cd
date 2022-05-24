<template>
  <b-container>
    <div class="row">
      <div class="col-12">
          <div class="text-right">
            <b-button
              class="btn-dash-blue btn-create-field"
              @click="onResetModalCreate"
            >
              <small>Ajouter un champ</small>
            </b-button>
            <FormFieldCreate
              :form-to-populate="formFieldKey"
              :form-field-order="form_field_order"
              :order-field-end="order_field_end"
              @created="onCreatedField"
              @updated="onUpdatedField"
            />
            <FormFieldCardOrder
              :form-to-populate="formFieldKey"
              :form-fields="formFields"
              @createdField="onCallCreatedFieldCard"
              @createdFieldAfter="onCallCreatedFieldAfter"
              @createdFieldEnd="onCreatedFieldEnd"
            />
          </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
         <transition-group name="form-field-list" tag="div">
          <div
            v-for="(field, index) in formFields"
            :key="'form-field' + field.id"
            :class="{'container-component-field-skeleton' : field.animateVisibility, 'animate-in-leave': selectedFormKey || deleteContext}"
            class="container-component-field d-flex justify-content-between mt-4"
          >
            <div class="d-flex justify-content-between w-100" v-if="field.skeleton">
              <b-skeleton-img no-aspect class="skeleton-form-field"></b-skeleton-img>
              <b-skeleton-img no-aspect class="skeleton-form-field-actions"></b-skeleton-img>
            </div>
            <div v-if="!field.skeleton" class="field-card">
              <FormFieldList
                :formField="field"
                @updatedTypeForm="onUpdatedTypeForm"
              />
            </div>
            <div v-if="!field.skeleton" class="field-create">
              <FormFieldCard
                @deleted="onDeletedField"
                @edit="onEditField"
                @orderFieldCard="onCallOrderFieldCrad"
                @dropUp="onDropUpField"
                @dropDown="onDropDownField"
                @resetList="onResetList"
                :indexField="index"
                :lastField="lastField"
                :fieldForms="fieldForms"
                :formField="field"
                :fieldKey="field.id"
              />
            </div>
          </div>
         </transition-group>
      </div>
    </div>
  </b-container>
</template>

<script>
import FormFieldList from './FormFieldList.vue'
import FormFieldCard from './FormFieldCard.vue'
import FormFieldCreate from './FormFieldCreate.vue'
import FormFieldCardOrder from './FormFieldCardOrder.vue'
import Loading from '../../../../../../components/Loading.vue'
import { mapActions } from 'vuex'
export default {
  components: { FormFieldCard, FormFieldList, FormFieldCreate, Loading, FormFieldCardOrder },
  data () {
    return {
      isLoading: false,
      formFields: [
        { id: 1, skeleton: true },
        { id: 2, skeleton: true },
        { id: 3, skeleton: true }
      ],
      fieldForms: [],
      selectedFormKey: null,
      form_field_order: null,
      order_field_end: null,
      deleteContext: false
    }
  },
  async  mounted () {
    this.init()
  },
  watch: {
    step_id () {
      this.init()
    }
  },
  computed: {
    form_id () {
      return this.$route.params.form_id
    },
    step_id () {
      return this.$route.params.step_id
    },
    lastField () {
      return this.formFields.length - 1
    },
    formFieldKey () {
      if (this.selectedFormKey && this.selectedFormKey > -1) {
        const index = this.formFields.findIndex((field) => this.selectedFormKey === field.id)
        return this.formFields[index]
      } else {
        return null
      }
    }
  },
  methods: {
    ...mapActions(['getFormFields']),
    async init () {
      this.form_field_order = null
      this.order_field_end = null
      setTimeout(() => {
        this.selectedFormKey = null
        this.deleteContext = false
      }, 2000);
      this.formFields = await this.getFormFields({ form_id: this.form_id, step_id: this.step_id })
    },
    onCreatedField (formFieldCreated) {
      formFieldCreated.skeleton = true
      formFieldCreated.animateVisibility = true

      let indexToPlace = this.formFields.findIndex((field) => field.order_field > formFieldCreated.order_field)
      indexToPlace = indexToPlace === -1 ? this.formFields.length : indexToPlace - 1
      this.formFields.splice(indexToPlace, 0, formFieldCreated)
      setTimeout(() => {
        this.init()
      }, 1000)
    },
    onUpdatedField (formFieldUpdated) {
      formFieldUpdated.skeleton = true
      formFieldUpdated.animateVisibility = true

      const targetFormFieldIndex = this.formFields.findIndex((field) => field.id === formFieldUpdated.id)
      if (formFieldUpdated.order_field === this.formFields[targetFormFieldIndex].order_field) {
        this.$set(this.formFields, targetFormFieldIndex, formFieldUpdated)
        this.init()
      } else {
        this.formFields[targetFormFieldIndex].animateVisibility = true
        this.$set(this.formFields, targetFormFieldIndex, this.formFields[targetFormFieldIndex])
        this.$nextTick(() => {
          this.formFields.splice(targetFormFieldIndex, 1)
          setTimeout(() => {
            let indexToPlace = this.formFields.findIndex((field) => field.order_field > formFieldUpdated.order_field)
            indexToPlace = indexToPlace === -1 ? this.formFields.length : indexToPlace - 1
            this.formFields.splice(indexToPlace, 0, formFieldUpdated)
            setTimeout(() => {
              this.init()
            }, 1000)
          }, 1000)
        })
      }
    },
    onDeletedField (formFieldDeleted) {
      formFieldDeleted.animateVisibility = true
      const targetFormFieldIndex = this.formFields.findIndex((field) => field.id === formFieldDeleted.id)
      this.$set(this.formFields, targetFormFieldIndex, formFieldDeleted)
      this.deleteContext = true
      this.$nextTick(() => {
        this.formFields.splice(targetFormFieldIndex, 1)
        setTimeout(() => {
          this.init()
        }, 1000)
      })
    },
    onUpdatedTypeForm (formFieldUpdated) {
      formFieldUpdated.skeleton = true
      formFieldUpdated.animateVisibility = true
      const targetFormFieldIndex = this.formFields.findIndex((field) => field.id === formFieldUpdated.id)
      this.$set(this.formFields, targetFormFieldIndex, formFieldUpdated)
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
    onDropUpField () {
      this.fieldForms = this.formFields
    },
    onDropDownField () {
      this.fieldForms = this.formFields
    },
    onResetList () {
      this.init()
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
    onCreatedFieldEnd (field) {
      this.selectedFormKey = null
      this.order_field_end = field
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
  .container {
    margin-top: 10px;
    @media (min-width: 1441px) {
      margin-top: 50px;
    }
  }
  .field-card {
    width: calc(100% - 65px);
  }

  .container-component-field {
    .skeleton-form-field, .skeleton-form-field-actions {
      height: 192px;
    }
    .skeleton-form-field {
      width: calc(100% - 65px);
    }
    .skeleton-form-field-actions {
      width: 40px;
    }
  }
  .form-field-list-enter-active, .form-field-list-leave-active {
    &.container-component-field-skeleton {
      transition: all 1s;
      overflow: hidden;
      max-height: 1000px;
    }
  }
  .form-field-list-enter, .form-field-list-leave-to {
    &.container-component-field-skeleton {
      opacity: 0;
      transform: translateX(100%);
      max-height: 0px;
    }
  }
  .form-field-list-enter {
    &.container-component-field-skeleton {
      transition: all 1s;
    }
  }
  .form-field-list-leave-to {
    &.container-component-field-skeleton {
      transition: all 0s;
    }
    &.animate-in-leave {
      transition: all 1s !important;
    }
  }
</style>
