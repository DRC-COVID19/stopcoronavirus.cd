<template>
  <b-form-group
    :label-class="labelClass"
    :id="inputGroupId"
    :label="label"
    :label-for="labelFor"
    :invalid-feedback="invalidFeedback"
    :state="errors"
  >
  </b-form-group>
</template>
<script>
export default {
  name: 'InputGroup',
  props: {
    errors: {
      type: Boolean,
      required: false
    },
    invalidFeedback: {
      type: String,
      required: false
    },
    labelClass: {
      type: String,
      required: false
    },
    inputGroupId: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: true
    },
    labelFor: {
      type: String,
      required: true
    }
  }
}
</script>
