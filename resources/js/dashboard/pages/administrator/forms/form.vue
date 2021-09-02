<template>
  <div>
  <b-container>
      <b-row  class="mb-3">
            <b-col cols="12" md="6" class="mt-4">
              <ul>
                <li>Title : {{form.title}}</li>
                <li v-if="form.form_recurrence_value">Valeur de la recurrence : {{form.form_recurrence_value}}</li>
                <li>Recurrence du formulaire : {{form.form_recurrence.name}}</li>
                <li>Publier : {{form.publish}}</li>
             </ul>
            </b-col>
      </b-row>
  </b-container>
  <FormStepIndex
    :formId="$route.params.form_id"
  />
  </div>
</template>
<script>
import { mapActions } from 'vuex'
import FormStepIndex from "./components/formStep/index";
export default {
  components: {
    FormStepIndex
  },
  data(){
    return{
      form:{}
    }
  },

  mounted(){
    this.init()
    
  },

  methods:{
     ...mapActions([
       "showForm"
     ]),

    async init () {
      this.form = await this.showForm({ id: this.$route.params.form_id })
    }

  }
  
}
</script>