<template>
  <b-container class="form__settings-container">
    <b-row>
      <b-col class="form__settings-body py-2">
       <b-container>
          <div>
            <h3>Paramètres</h3>
            <hr>
          </div>
          <div>
          <div>
              <div class="d-flex justify-content-between">
                <h4>Modifier le titre du  formulaire </h4>
                <img src="/img/akar-icons_pencil.svg" class="form__settings-icon" v-b-modal.updateFormModal>
              </div>
              <h6>Avoir la possibilité de modifier le nom du formulaire</h6>
              <hr>
              <b-modal id="updateFormModal"  centered hide-footer hide-header>
              <b-container>
      <b-row>
        <b-col>
          <div class="mb-4 p-2">
            <h2 class="lead text-center text-uppercase text-bold">
              Modifier le titre du  formulaire
            </h2>
          </div>
          <ValidationObserver
            v-slot="{ invalid }"
            ref="form"
            tag="form"
            novalidate
            @submit.prevent="onUpdateFormSubmit"
            @reset.prevent="onReset"
            label-class="text-dash-color"
          >
            <b-form @submit.prevent="onUpdateFormSubmit">
              <b-form-group>
                <label class="text-dash-color" for="text-firstName"
                  >Titre du formulaire <span class="text-danger"> *</span></label
                >
                <FormFieldInput
                  v-model="form.title"
                  type="text"
                  id="text-firstName"
                  rules="required"
                  name="Titre du formulaire"
                  mode="aggressive"
                />
              </b-form-group>
              <div class="mt-4 text-center">
                <b-button type="submit" variant="primary"
                  >Modifier</b-button
                >
              </div>
            </b-form>
          </ValidationObserver>
        </b-col>
      </b-row>
    </b-container>
          </b-modal>
          </div>
           <div class="mt-5">
              <div class="d-flex justify-content-between">
                <h4>Changer  la récurrence du formulaire </h4>
                <img src="/img/akar-icons_pencil.svg"  class="form__settings-icon">
              </div>
              <h6>Avoir la possibilité de modifier la récurrence</h6>
              <hr>
          </div>
           <div class="mt-5">
              <div class="d-flex justify-content-between">
                <h4>Supprimer  le formulaire </h4>
                <img src="/img/ant-design_delete-twotone.svg"  class="form__settings-icon">
              </div>
              <h6>Cette action supprimera le formulaire définitivement</h6>
              <hr>
          </div>
          </div>

       </b-container>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import FormFieldInput from '../../../../components/forms/FormFieldInput'
import FomFieldSelect from '../../../../components/forms/FomFieldSelect'
import { ValidationObserver } from 'vee-validate'
export default {
  components: {
    FormFieldInput,
    FomFieldSelect,
    ValidationObserver
  },
  data () {
    return {
      form: {
        title: ''
      }
    }
  },
  methods: {
    onReset () {
      this.form = {}
    },
    onUpdateFormSubmit () {}
  }
}
</script>
<style lang="scss" scoped>
.form__settings-container{
  width: 100%;
  position: relative;
   top: 10rem;
 .form__settings-body{
   width: 100%;
   height: 400px;
   background-color: #FFFFFF;
    h3, h4{
     font-weight: 500;
   }
   h3{
     color: #3767FA;
   }
   .form__settings-icon{
     cursor: pointer;
   }
 }
}
</style>
