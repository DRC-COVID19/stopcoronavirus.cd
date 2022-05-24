<template>
  <b-container>
    <div class="row">
      <div class="col-12 px-0">
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
            @updated="onUpdated"
          />
          <FormFieldCardOrder
            :form-to-populate="formFieldKey"
            :form-fields="formField"
            @createdField="onCallCreatedFieldCard"
            @createdFieldAfter="onCallCreatedFieldAfter"
            @createdFieldEnd="onCreatedFieldEnd"
          />
        </div>
      </div>
    </div>
    <Loading
      v-if="isLoading"
      class="h-25"
      message="Chargement des champs ..."
    />
    <div class="row">
      <div class="col-12">
        <div
          class="
            container-component-field
            d-sm-flex
            justify-content-between
            mt-4
          "
          v-for="(field, index) in formField"
          :key="index"
        >
          <div class="field-card">
            <FormFieldList
              :formField="field"
              @updatedTypeForm="onUpdatedTypeForm"
            />
          </div>
          <div class="field-create">
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
import { mapState, mapActions } from 'vuex'
export default {
  components: {
    FormFieldCard,
    FormFieldList,
    FormFieldCreate,
    Loading,
    FormFieldCardOrder
  },
  data () {
    return {
      isLoading: false,
      fieldForm: {},
      fieldForms: [],
      selectedFormKey: null,
      form_field_order: null,
      order_field_end: null
    }
  },
  async mounted () {
    await this.getFormFields({ form_id: this.form_id, step_id: this.step_id })
    this.init()
  },
  watch: {
    step_id () {
      this.init()
    }
  },
  computed: {
    ...mapState({
      formField: (state) => state.formField.formFields
    }),
    form_id () {
      return this.$route.params.form_id
    },
    step_id () {
      return this.$route.params.step_id
    },
    lastField () {
      return this.formField.length - 1
    },
    formFieldKey () {
      if (this.selectedFormKey && this.selectedFormKey > -1) {
        const index = this.formField.findIndex(
          (field) => this.selectedFormKey === field.id
        )
        return this.formField[index]
      } else {
        return null
      }
    }
  },
  methods: {
    ...mapActions(['getFormFields']),
    async init () {
      this.selectedFormKey = null
      this.form_field_order = null
      this.order_field_end = null
      this.isLoading = true
      this.fieldForm = await this.getFormFields({
        form_id: this.form_id,
        step_id: this.step_id
      })
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
    onUpdatedTypeForm () {
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
      this.fieldForms = this.formField
    },
    onDropDownField () {
      this.fieldForms = this.formField
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
  width: 100%;

  @media (min-width: 576px) {
    width: calc(100% - 65px);
  }
}
</style>
