<template>
  <b-modal id="orderResponse" centered hide-footer hide-header>
      <b-card class="border-0">
          <div class="mb-4">
              <h2 class="lead text-center text-bold">
                  Insertion du champ
              </h2>
          </div>
          <div>
            <b-form
             @submit.prevent="onSubmit"
             label-class="text-dash-color"
            >
              <div
                id="input-group-1"
                class="form-group-radio"
              >
                  <b-form-radio
                    v-model="form.form_field_order"
                    name="some-radios"
                    :value="true"
                    >Avant</b-form-radio
                  >
                  <b-form-radio
                    v-model="form.form_field_order"
                    name="some-radios"
                    :value="false"
                    class="mt-2"
                    >Après</b-form-radio
                  >
              </div>
              <b-row class="mt-4">
                <b-button
                  type="submit"
                  variant="primary"
                  class="btn-dash-blue"
                >
                  Valider
                </b-button>
              </b-row>
            </b-form>
          </div>
      </b-card>
  </b-modal>
</template>
<script>
export default {
  props: {
    formToPopulate: {
      type: Object,
      default: () => ({}),
      required: false
    },
    formFields: {
      type: Array,
      default: () => [],
      required: false
    }
  },
  data () {
    return {
      form: {
        form_field_order: false
      }
    }
  },

  methods: {
    onSubmit () {
      if (this.form.form_field_order) {
        this.$bvModal.hide('orderResponse')
        this.$emit('createdField', this.formToPopulate.id)
      } else {
        const index = this.formFields.findIndex((formField) => formField.id === this.formToPopulate.id) + 1
        if (this.formFields[index]) {
          this.$bvModal.hide('orderResponse')
          this.$emit('createdFieldAfter', this.formFields[index].id)
        } else {
          this.$bvModal.hide('orderResponse')
          this.$emit('createdFieldEnd', this.formFields[index - 1])
        }
      }
    }
  }

}
</script>
<style lang="scss" scoped>
  .form-group-radio{
    margin-left:126px;
  }
</style>
