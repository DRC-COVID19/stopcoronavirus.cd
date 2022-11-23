<template>
  <div>
    <b-card>
      <b-card-body class="py-0">
        <div class="d-flex justify-content-between align-items-center">
          <strong class="mb-0"> CHAMPS </strong>
          <i class="fab fa-wpforms" aria-hidden="true"></i>
        </div>
      </b-card-body>
    </b-card>
    <FormFieldForm
      :target-form="form"
      :row-form-field="rowFormField"
      @created="onCreatedFormField"
      @updated="onUpdateFormField"
      class="mt-4"
    />
    <FormFieldList
      :target-form="form"
      class="mt-4"
      @onDeletedForm="onDeletedFormField"
      @onUpdateFormField="toUpdateFormField"
    />
  </div>
</template>

<script>
import { mapActions } from 'vuex';
import FormFieldForm from './FormFieldForm';
import FormFieldList from './FormFieldList';
export default {
  props: {
    form: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      isEditingMode: false,
      rowFormField: {},
    };
  },
  components: {
    FormFieldForm,
    FormFieldList,
  },
  methods: {
    ...mapActions(['formShow']),
    onCreatedFormField() {
      this.$emit('formFieldCreated');
    },
    onDeletedFormField() {
      this.$emit('formFieldDeleted');
    },
    onUpdateFormField() {
      this.$emit('formFieldUpdated');
      this.isEditingMode = false;
    },
    toUpdateFormField(item) {
      this.isEditingMode = true;
      this.rowFormField = { ...item };
    },
  },
};
</script>
