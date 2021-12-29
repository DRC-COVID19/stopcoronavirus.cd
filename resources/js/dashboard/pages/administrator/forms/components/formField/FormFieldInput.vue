<template>
  <b-form-input
    :type="type"
    :value="value"
    :name="name"
    :placeholder="placeholder"
    :id="id"
  ></b-form-input>
</template>
<script>
export default {
  name: 'FormFieldInput',
  props: {
    type: {
      type: String,
      required: true
    },
    value: {
      type: String,
      required: true
    },
    placeholder: {
      type: String,
      required: true
    },
    name: {
      type: String,
      required: true
    },
    id: {
      type: String,
      required: true
    }
  },
  data () {
    return {}
  }
}
</script>
