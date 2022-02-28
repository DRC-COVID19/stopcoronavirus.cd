<template>
<div>
  <b-form-group
    v-slot="{ ariaDescribedby }"
    v-if="type === 'boolean'"
  >
    <b-form-radio-group
      v-model="formFieldValue"
      :options="requiredOptions"
      :aria-describedby="ariaDescribedby"
      :id="id"
    ></b-form-radio-group>
  </b-form-group>
  <b-form-input
    v-else
    v-model="formFieldValue"
    :type="type"
    :placeholder="placeholder"
    :id="id"
    :required="isRequired"
  >
  </b-form-input>
</div>
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
      default: ''
    },
    placeholder: {
      type: String,
      required: true
    },
    rules: {
      type: String,
      required: true
    },
    id: {
      type: [String, Number],
      required: true
    }
  },
  data () {
    return {
      requiredOptions: [
        { text: 'Oui', value: 1 },
        { text: 'Non', value: 0 }
      ],
      formFieldValue: this.value
    }
  },
  computed: {
    isRequired () {
      return !!this.rules.match(/required/i)
    }
  },
  watch: {
    formFieldValue (value) {
      this.$emit('input', value)
    },
    value (value) {
      this.formFieldValue = value
    }
  }
}
</script>
