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
      <b-form-group>
        <label class="text-dash-color" :for="id"
          >{{ labelText
          }}<span v-show="isObligated" class="text-danger">*</span></label
        >
        <div :class="{ 'select-error': errors[0] }">
          <v-select
            v-model="formFieldValue"
            :options="options"
            :label="label"
            :reduce="reduce"
            :id="id"
            class="border-0"
            :multiple="isMultiple"
            @input="handleSelect"
            :searchable="false"
          >
          </v-select>
        </div>
        <span class="text-danger label-error mb-2">{{ errors[0] }}</span>
      </b-form-group>
    </ValidationProvider>
  </div>
</template>
<script>
import { ValidationProvider } from 'vee-validate';
export default {
  name: 'FomFieldSelect',
  components: {
    ValidationProvider,
  },
  props: {
    reduce: {
      type: [Function, String, Number],
      required: false,
    },
    isMultiple: {
      type: Boolean,
      required: false,
    },
    rules: {
      type: String,
      required: false,
    },
    id: {
      type: [String],
      required: true,
    },
    forId: {
      type: String,
      required: false,
    },
    state: {
      type: Boolean,
      required: false,
      default: () => null,
    },
    disabled: {
      type: Boolean,
      required: false,
    },
    label: {
      type: String,
      required: false,
    },
    vid: {
      type: String,
      required: false,
    },
    mode: {
      type: String,
      required: false,
    },
    value: {
      type: [String, Number, Array, Object],
      default: '',
    },
    labelText: {
      type: String,
      default: '',
    },
    options: {
      type: Array,
      default: () => [],
    },
    isObligated: {
      type: Boolean,
      default: false,
    },
    required: {
      type: Boolean,
      default: false,
    },
    name: {
      type: String,
      required: false,
    },
  },
  data() {
    return {
      formFieldValue: this.value,
    };
  },
  computed: {
    isRequired() {
      return !!this.rules?.match(/required/i) || false;
    },
  },
  watch: {
    formFieldValue(value) {
      this.$emit('input', value);
    },
    value() {
      this.formFieldValue = this.value;
    },
  },
  methods: {
    handleSelect(value) {
      this.$emit('handleSelect', value);
    },
  },
};
</script>
<style scoped>
.select-error {
  border: 1px solid red;
  border-radius: 0.3rem;
  background: white;
}
.label-error {
  font-family: 'Rubik', sans-serif;
  font-size: 12px;
}
</style>
