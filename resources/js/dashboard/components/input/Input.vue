<template>
    <b-form-input
      :type="type"
      :placeholder="placeholder"
      :id="inputId"
      :required="required"
      :state="state"
      @blur="blur()"
      :value="value"
    >
    </b-form-input>
</template>
<script>
export default {
  name: 'Input',
  props: {
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
      required: false
    },
    type: {
      type: String,
      required: false
    },
    value: {
      required: false
    }
  },
  data () {
    return {
    }
  },
  methods: {
    blur () {
      console.log('bonjour')
      this.$emit('blur')
    }
  }
}
</script>
