/* eslint-disable space-before-blocks */
<template>

     <form-wizard
           title="FORMULAIRE"
           subtitle
           shape="tab"
           color="#2e5bff"
           nextButtonText="Suivant"
           backButtonText="Précédent"
           finishButtonText="Envoyer"
           @on-complete="onComplete"
           :startIndex="0"
         >
           <b-alert variant="success" v-if="!!isLoading" show
             >L'insertion reussi avec success</b-alert
           >
           <tab-content
             v-for="(step, index) in targetForm.form_steps"
             :key="index"
             v-else
           >
             <h3 class="mb-4 text-center">{{ step.title }}</h3>
             <b-row align-h="center">
               <b-col cols="12" md="8">
                 <b-form-group
                   v-for="(item, counter) in formFieldSorted(step.id)"
                   :key="counter"
                   :label="
                     item.roules !== null ? item.name + ' * ' : item.name
                   "
                   :label-for="item.name"
                 >
                   <b-row>
                     <b-col class="col-sm-12 col-md-12">
                       <b-form-group
                         v-slot="{ ariaDescribedby }"
                         v-if="item.form_field_type.name === 'boolean'"
                       >
                         <b-form-radio-group
                           :options="requiredOptions"
                           :aria-describedby="ariaDescribedby"
                           id="required"
                         ></b-form-radio-group>
                       </b-form-group>
                       <b-form-input
                         v-else
                         :type="item.form_field_type.name"
                         v-model="item.default_value"
                         :placeholder="`Entrer ${item.name}`"
                         required
                         @change="
                           handelChange(
                             item.id,
                             item.default_value,
                             item.name,
                             step.id
                           )
                         "
                         :id="item.name"
                       >
                       </b-form-input>
                     </b-col>
                   </b-row>
                 </b-form-group>
               </b-col>
             </b-row>
           </tab-content>
           <tab-content v-if="formFieldNullStepSorted.length > 0">
             <h3 class="mb-4 text-center">Champs affectés à aucune étape</h3>
             <b-row align-h="center">
               <b-col cols="12" md="8">
                 <b-form-group
                   v-for="(field, counter) in formFieldNullStepSorted"
                   :key="counter"
                   :label="
                     field.roules !== null ? field.name + ' * ' : field.name
                   "
                   :label-for="field.name"
                 >
                   <b-row>
                     <b-col class="col-sm-12 col-md-12">
                       <b-form-group
                         v-slot="{ ariaDescribedby }"
                         v-if="field.form_field_type.name === 'boolean'"
                       >
                         <b-form-radio-group
                           :options="requiredOptions"
                           :aria-describedby="ariaDescribedby"
                           id="required"
                         ></b-form-radio-group>
                       </b-form-group>
                       <b-form-input
                         v-else
                         :type="field.form_field_type.name"
                         v-model="field.default_value"
                         :placeholder="`Entrer ${field.name}`"
                         @change="
                           handelChange(
                             field.id,
                             field.default_value,
                             field.name,
                             step.id
                           )
                         "
                         :id="field.name"
                       >
                       </b-form-input>
                     </b-col>
                   </b-row>
                 </b-form-group>
               </b-col>
             </b-row>
           </tab-content>
           <tab-content>
             <b-row align-h="center">
               <b-col
                 v-for="(step, index) in targetForm.form_steps"
                 :key="index"
                 cols="12"
                 md="6"
               >
                 <h3 class="mb-4">{{ step.title }}</h3>

                 <div v-for="(summary, count) in targetForm.form_fields" :key="count">
                   <ul v-if="step.id === summary.form_step_id">
                     <li>{{ summary.name }} : {{ summary.default_value }}</li>
                   </ul>
                 </div>
               </b-col>
            <b-col class="col-md-12">
               <b-alert show variant="warning">
               <p class="text-center">NB: Une soumission ne peut pas être modifiée.</p>
             </b-alert>
            </b-col>
               <b-form-group class="no-border">
                 <label for="last_update" class="text-dash-color"
                   >Sélectionnez la date</label
                 >
                 <b-form-datepicker
                   v-model="form.last_update"
                   :max="max"
                   required
                   id="last_update"
                   class="mb-2"
                   :disabled="!!$route.params.hospital_id"
                 ></b-form-datepicker>
               </b-form-group>
             </b-row>
           </tab-content>
         </form-wizard>
</template>

<script>
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
export default {
  components: {
    FormWizard,
    TabContent
  },
  props: {
    user: {},
    targetForm: {},
    hospitalManagerName: {},
    formSteps: {},
    isHospitalSituationLoading: {}
  },
  data () {
    const now = new Date()
    return {
      formData: new Map(),
      form: {},
      max: now,
      errors: {},
      isLoading: false
    }
  },
  computed: {

    formFieldNullStepSorted () {
      return this.targetForm.form_fields
        ? this.targetForm.form_fields
          .slice()
          .sort((a, b) => a.order_field - b.order_field)
          .filter(item => item.form_step_id === null)
        : []
    }
  },
  methods: {
    formFieldSorted (id) {
      return this.targetForm.form_fields
        ? this.targetForm.form_fields.filter(item => item.form_step_id === id)
        : []
    },
    onComplete () {
      this.isLoading = true
      this.errors = {}
      this.$emit('onComplete', { formData: this.formData, lastUpdate: this.form.last_update })
    },
    handelChange (key, value, fieldName, stepId) {
      if (value) {
        this.targetForm.form_fields.forEach(item => {
          if ((item.id === key) && (item.name === fieldName)) item.default_value = value
          this.formData.set(key, value)
        })
      }
    }
  }
}
</script>
