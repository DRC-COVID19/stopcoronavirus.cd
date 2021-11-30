<template>
  <div>
    <b-card>
      <b-card-body class="py-0">
        <div class="d-flex justify-content-between align-items-center">
          <strong class="mb-0">
            CHAMPS
          </strong>
          <i class="fab fa-wpforms" aria-hidden="true"></i>
        </div>
      </b-card-body>
    </b-card>
    <FormFieldForm
      :target-form="form"
      @created="onCreatedFormField"
      class="mt-4"
    />
    <FormFieldList
      :target-form="form"
      class="mt-4"
      @deleted="onDeletedFormField"
    />
</div>
</template>

<script>
import { mapActions } from 'vuex'
import FormFieldForm from './FormFieldForm'
import FormFieldList from './FormFieldList'
export default {
  props: {
    form: {
      type: Object,
      required: true
    }
  },
  components: {
    FormFieldForm,
    FormFieldList
  },
  methods: {
    ...mapActions([
      'formShow'
    ]),
    onCreatedFormField () {
      this.$emit('formFieldCreated')
    },
    onDeletedFormField () {
      this.$emit('formFieldDeleted')
    }
  }
}
</script>
