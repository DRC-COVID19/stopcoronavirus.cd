<template>
<div class="">
 <b-card class="border-0 card-form-field">
        <b-card-body>
          <b-container>
              <b-row class="">
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
                      v-model="form.form_field_type_id"
                      :options="formFieldType"
                      label="label"
                      :reduce="(item)=>item.id"
                      :searchable="false"
                      id="form.form_field_type_id"
                      @input="updateFormFieldType"
                    >
                    </v-select>
                </b-col>
              </b-row>
              <b-row class="mt-3">
                  <b-col cols="12" class="text-right">
                      <b-form-checkbox
                        v-model="form.require"
                        switch size="lg"
                        class="switch-required"
                        @input="updateRequiredFormField"
                      >
                        obligatoire
                      </b-form-checkbox>
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
  },
  data () {
    return {
      form: {
        form_field_type_id: this.formField.form_field_type_id,
        require: !!this.formField.rules?.match(/required/i) || false
      }
    }
  },
  watch: {
    formField () {
      this.form.form_field_type_id = this.formField.form_field_type_id
      this.form.require = !!this.formField.rules?.match(/required/i) || false
    }
  },
  computed: {
    ...mapState({
      formFieldType: (state) => state.formFieldType.formFieldTypes
    })
  },
  methods: {
    ...mapActions(['formFieldTypeIndex', 'updateFormField']),
    updateFormFieldType () {
      this.updateFormField({ id: this.formField.id, form_field_type_id: this.form.form_field_type_id })
        .then(() => {
          // this.$notify({
          //   group: 'alert',
          //   title: 'Champs du Formulaire',
          //   text: 'Modifier avec succès',
          //   type: 'success'
          // })
          this.$emit('updatedTypeForm')
        })
        .catch(({ response }) => {
          this.$notify({
            group: 'alert',
            title: 'Champs du Formulaire',
            text: 'Une erreur est survenus',
            type: 'error'
          })
          if (response.status == 422) {
            this.errors = response.data.errors
          }
        })
    },
    updateRequiredFormField () {
      this.updateFormField({ id: this.formField.id, rules: this.form.require ? 'required' : '' })
        .then(() => {
          // this.$notify({
          //   group: 'alert',
          //   title: 'Champs du Formulaire',
          //   text: 'Modifier avec succès',
          //   type: 'success'
          // })
        })
        .catch(({ response }) => {
          this.$notify({
            group: 'alert',
            title: 'Champs du Formulaire',
            text: 'Une erreur est survenus',
            type: 'error'
          })
          if (response.status == 422) {
            this.errors = response.data.errors
          }
        })
    }

  }
}
</script>
 <style lang="scss" scoped>
 @import "@~/sass/_variables";

 .container{
   padding-top: 0px;
  .card-form-field{
    margin-top: 0px;
  }
  .switch-required{
    margin-left: 370px;
    color:rgba(0, 0, 0, 0.5);
    font-size: 15px;
    &::v-deep {
      label {
        font-size: 15px;
      }
    }
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
