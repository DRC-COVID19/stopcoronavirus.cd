<template>
   <div class="container-all">
      <div>
         <b-button
         class="btn-dash-blue btn-create-field"
         v-b-modal.createResponse
         >
            Ajouter un champ
         </b-button>
         <FormFieldCreate/>
      </div>
      <div class="container-component-field"
       v-for="(formField, index) in formField"
         :key="index"
      >
         <div class="field-card">
            <FormFieldList
             :formField="formField"
            />
         </div>
         <div class="field-create">
            <FormFieldCard
             :formField="formField"
            />
         </div>
      </div>
   </div>
</template>

<script>
import FormFieldList from './FormFieldList.vue'
import FormFieldCard from './FormFieldCard.vue'
import FormFieldCreate from './FormFieldCreate.vue'
import { mapState, mapActions } from 'vuex'
export default {
  components: { FormFieldCard, FormFieldList, FormFieldCreate },
  async mounted () {
    await this.getFormFields({ id: this.form_id })
  },
  computed: {
    ...mapState({
      formField: (state) => state.formField.formFields
    }),
    form_id () {
      return this.$route.params.form_id
    }
  },
  methods: {
    ...mapActions(['getFormFields'])
  }
}
</script>
 <style lang="scss" scoped>
 .container-all{
   .btn-create-field{
    position: relative;
    top: 130px;
    left: 600px;
   }
   .container-component-field{
    display: flex;
   justify-content: center;
    .field-create{
       margin-top: 175px;
    }
 }
 }
 @media screen and (max-width: 767px) {
   .btn-create-field{
    position: relative !important;
    top: 145px !important;
    left: 15px !important;
  }

 }
 </style>
