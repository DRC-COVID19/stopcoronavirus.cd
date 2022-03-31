<template>
  <div>
    <ValidationProvider
      v-slot="{ errors }"
      :mode="mode"
      :rules="rules"
      tag="div"
      :vid="vid"
      :name="name"
      class="bg-transparent"
    >
      <b-form-group :class="className">
        <label class="text-dash-color" :for="id"
          >{{ labelText
          }}<span v-show="isObligated" class="text-danger">*</span></label
        >
        <b-form-textarea
          :rows="rows"
          v-model="formFieldValue"
          :required="isRequired || required"
          :id="id"
          :state="errors[0] ? !true : null || state"
          class="input-dash"
          :disabled="disabled"
        />
      </b-form-group>
      <span class="text-danger input-error">{{ errors[0] }}</span>
    </ValidationProvider>
  </div>
</template>
<script>
import { ValidationProvider } from 'vee-validate'
export default {
  name: 'FormFieldTextArea',
  components: {
    ValidationProvider
  },
  props: {
    type: {
      type: String,
      required: true
    },
    value: {
      type: String,
      default: ''
    },
    rows: {
      type: Number,
      required: false
    },
    rules: {
      type: String,
      required: false
    },
    className: {
      type: String,
      required: false
    },
    id: {
      type: [String, Number],
      required: true
    },
    required: {
      type: Boolean,
      required: false,
      default: false
    },
    state: {
      type: Boolean,
      required: false,
      default: () => {
        return null
      }
    },
    disabled: {
      type: Boolean,
      required: false
    },
    name: {
      type: String,
      required: false
    },
    vid: {
      type: String,
      required: false
    },
    mode: {
      type: String,
      required: false
    },
    isObligated: {
      type: Boolean,
      required: false
    },
    labelText: {
      type: String,
      required: false
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
      return !!this.rules?.match(/required/i) || false
    },
    stateFormFields () {
      return true

      // if(){
      //   return true
      // }
    }
  },
  watch: {
    formFieldValue (value) {
      this.$emit('input', value)
    },
    value (value) {
      this.formFieldValue = value
    }
  },
  methods: {}
}
</script>
<style scoped>
.input-error {
  font-family: "Rubik", sans-serif;
  font-size: 12px;
}
</style>
