<template>
    <b-form-input
      :v-model="vModel"
      :type="type"
      :placeholder="placeholder"
      :id="inputId"
      :required="required"
      :state="state"
      :description="description"
      @blur="blur()"
    >
    </b-form-input>
</template>
<script>
export default {
  name: 'Input',
  props: {
    vModel: {
      type: String,
      required: true
    },
    placeholder: {
      type: String,
      required: true
    },
    inputId: {
      type: String,
      required: true
    },
    required: {
      type: Boolean,
      required: true
    },
    state: {
      type: Boolean,
      required: true
    },
    description: {
      type: Boolean,
      required: false
    }
  },
  methods: {
    blur () {
      this.$emit('blur')
    }
  }
}
</script>
