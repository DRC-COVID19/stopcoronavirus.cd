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
    <FormFieldForm class="mt-4" />
    <FormFieldList class="mt-4" />
</div>
</template>

<script>
import FormFieldForm from './FormFieldForm'
import FormFieldList from './FormFieldList'
export default {
  components: {
    FormFieldForm,
    FormFieldList
  }
}
</script>
