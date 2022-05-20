<template>
  <div>
    <ValidationProvider
      v-slot="{ errors }"
      :rules="rules"
      tag="div"
      :name="name"
      class="bg-transparent"
    >
      <div v-if="type === 'boolean'">
        <b-form-group v-slot="{ ariaDescribedby }">
          <b-form-radio-group
            v-model="formFieldValue"
            :options="requiredOptions"
            :aria-describedby="ariaDescribedby"
            :id="id"
            :required="isRequired || required"
          ></b-form-radio-group>
        </b-form-group>
        <input type="hidden" v-model="formFieldValue">
      </div>

      <v-date-picker
        v-else-if="type === 'date'"
        v-model="formFieldValue"
        opens="center"
        class="d-flex style-picker"
        :max-date="maxDate"
        :mode="mode"
      >
        <template v-slot="{ inputEvents, inputValue }">
          <div class="w-100 d-flex">
            <input type="hidden" v-model="formFieldValue">
            <b-form-input
              :value="inputValue ? moment(formFieldValue).format('DD/MM/YYYY') : 'Sélectionner la date'"
              :required="isRequired || required"
              :state="errors[0] ? false : null || state"
              :id="id"
              :disabled="disabled"
              v-on="inputEvents"
              class="date-picker-input"
              placeholder="Sélectionner la date"
              readonly
            >
            </b-form-input>
            <b-button
              class='button-icon'
              variant="primary"
              :disabled="!formFieldValue"
              @click="formFieldValue = null"
            >
              <i class="fa fa-close" aria-hidden="true"></i>
            </b-button>
          </div>
        </template>
      </v-date-picker>

      <b-form-input
        v-else
        v-model="formFieldValue"
        :type="type"
        :placeholder="placeholder"
        :id="id"
        :required="isRequired || required"
        :state="errors[0] ? false : null || state"
        class="input-dash"
        :disabled="disabled"
      >
      </b-form-input>

      <div v-if="errors.length">
        <div class="text-danger input-error mt-2">{{ errors[0] }}</div>
      </div>
    </ValidationProvider>
  </div>
</template>
<script>
import { ValidationProvider } from 'vee-validate'
export default {
  name: 'FormFieldInput',
  components: {
    ValidationProvider
  },
  props: {
    type: {
      type: String,
      required: true
    },
    value: {
      type: [String, Date, Number],
      default: null
    },
    placeholder: {
      type: String,
      required: false
    },
    rules: {
      type: String,
      required: false,
      default: null
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
      required: false,
      default: 'date'
    },
    maxDate: {
      type: Date,
      required: false,
      default: null
    }
    // defaultValue: {
    //   type: String,
    //   default: ''
    // }
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
<style lang="scss">
@import "@~/sass/_variables";

::placeholder {
  font-size: 0.85rem;
}
@media screen and($medium) {
  ::placeholder {
    font-size: 1rem;
  }
}
.input-error {
  font-family: "Lato", sans-serif;
  font-size: 12px;
}
.date-picker-input {
  border-top-right-radius: 0px;
  border-bottom-right-radius: 0px;
  &.form-control[readonly]{
    background-color: white;
  }
}
button.button-icon {
  border-top-left-radius: 0px;
  border-bottom-left-radius: 0px;
  background-color: $dash-blue;
}
</style>
