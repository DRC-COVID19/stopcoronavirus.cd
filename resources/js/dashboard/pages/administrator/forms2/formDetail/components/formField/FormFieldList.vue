<template>
<div class="container">
    <b-card class="border-0 card-form-field px-6">
        <b-card-body>
          <b-container>
              <b-row>
                <b-col  md="6" xs="12">
                    <label id="input-group-1" for="input-1" class="">{{formField.name}}</label>
                      <b-form-input
                        :type="formField.form_field_type.name"
                        :placeholder="formField.default_value"
                        class="input-dash"
                        >
                      </b-form-input>
                </b-col>
                <b-col  md="6" xs="12">
                  <label  for="input-1" class="label-format-response">Format réponse</label>
                  <v-select
                      :options="formFieldType"
                      label="name"
                      :reduce="(item)=>item.id"
                      :searchable="false"
                    >
                    </v-select>
                </b-col>
              </b-row>
              <b-row class="mt-3">
                  <b-col cols="12">
                      <b-form-checkbox  switch size="lg" class="switch-required" :checked="isRequired">obligatoire</b-form-checkbox>
                  </b-col>
              </b-row>
          </b-container>
        </b-card-body>
    </b-card>
</div>
</template>

<script>
import { mapState, mapActions } from 'vuex'
export default {
  props: {
    formField: {
      type: Object,
      default: () => ({}),
      required: false
    }
  },
  async mounted () {
    await this.formFieldTypeIndex()
    console.log('formField', this.formField)
  },
  computed: {
    ...mapState({
      formFieldType: (state) => state.formFieldType.formFieldTypes
    }),
    isRequired () {
      return !!this.formField.rules?.match(/required/i) || false
    }
  },
  methods: {
    ...mapActions(['formFieldTypeIndex'])
  }
}
</script>
 <style lang="scss" scoped>
 @import "@~/sass/_variables";
 .container{
   padding-top: 0px;
  .card-form-field{
    margin-top: 172px;
  }
  .switch-required{
    margin-left: 370px;
    color:rgba(0, 0, 0, 0.5);
    font-size: 15px;
  }
 }
 @media screen and (max-width: 767px) {
  .card-form-field{
      margin-left: 0px !important;
      margin-right: 0px !important;
  }
  .label-format-response{
    margin-top:20px ;
  }
  .switch-required{
    margin-left: 0px !important;
    margin-top: 5px;
    color:rgba(0, 0, 0, 0.5);
    font-size: 15px;
  }
}
 </style>
