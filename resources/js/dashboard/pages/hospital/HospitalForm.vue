/* eslint-disable space-before-blocks */
<template>
  <div>
    <Header />
    <b-container class="mt-4">
      <Loading v-if="isLoading" class="h-100" />
      <b-row v-else align-h="center">

        <b-col cols="12">
          <b-link
            :to="backRoute"
          >
            <span class="fa fa-chevron-left">Retour</span>
          </b-link>
          <h3 v-if="$route.params.update_id" class="mb-4 mt-4">
            Modifier la mise à jour du
            {{ moment($route.params.update_id).format("DD/MM/Y") }}
          </h3>
            <form-wizard
           title="FORMULAIRE"
           subtitle
           shape="tab"
           color="#2e5bff"
           nextButtonText="Suivant"
           backButtonText="Précédent"
           :finishButtonText="$route.params.update_id ?'Modifier' :'Envoyer'"
           @on-complete="onComplete"
           :startIndex="0"
         >
           <tab-content
             v-for="(step, index) in targetForm.form_steps"
             :key="index"
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
                           handleChange(
                             item.id,
                             item.default_value,
                             item.name
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
                         :placeholder="`Entrer ${field.name }`"
                         @change="
                           handleChange(
                             field.id,
                             field.default_value,
                             field.name
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
                 <div  v-if="!!$route.params.update_id">
                   <div v-for="(summary, count) in editionData" :key="count" >
                    <ul v-if="step.id === summary.form_step_id">
                      <li>{{ summary.name }} : {{ summary.default_value }}</li>
                    </ul>
                  </div>
                 </div>
                <div v-else>
                   <div v-for="(summary, count) in targetForm.form_fields" :key="count">
                   <ul v-if="step.id === summary.form_step_id">
                     <li>{{ summary.name }} : {{ summary.default_value }}</li>
                   </ul>
                 </div>
                </div>
               </b-col>
            <b-col class="col-md-12">
               <b-alert show variant="warning" v-if="!user.isHospitalAdmin">
               <p class="text-center">NB: Une soumission ne peut plus être modifiée après 24 heures!</p>
             </b-alert>
            </b-col>
               <b-form-group class="no-border">
                 <label for="last_update" class="text-dash-color"
                   >Sélectionnez la date</label
                 >
                 <b-form-datepicker
                  v-if="!!$route.params.update_id"
                   v-model="editionData[0].last_update"
                   :max="max"
                   required
                   id="last_update"
                   class="mb-2"
                   :disabled="!!$route.params.update_id"
                 ></b-form-datepicker>
                  <b-form-datepicker
                  v-else
                   v-model="form.last_update"
                   :max="max"
                   required
                   id="last_update"
                   class="mb-2"
                   :disabled="!!$route.params.update_id"
                 ></b-form-datepicker>
               </b-form-group>
             </b-row>
           </tab-content>
         </form-wizard>
        </b-col>
      </b-row>
    </b-container>
    <ManagerUserName />
  </div>
</template>

<script>
import Header from '../../components/hospital/Header'
import Loading from '../../components/Loading'
import ManagerUserName from '../../components/hospital/ManagerUserName'
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import { mapState, mapActions } from 'vuex'

export default {
  components: {
    Header,
    ManagerUserName,
    Loading,
    FormWizard,
    TabContent
  },
  data () {
    const now = new Date()
    return {
      formData: new Map(),
      formSummary: [],
      formDataFormatted: [],
      form: {},
      max: now,
      errors: {},
      isLoading: false
    }
  },
  computed: {
    ...mapState({
      user: state => state.auth.user,
      targetForm: state => state.form.forms,
      hospitalManagerName: state => state.hospital.hospitalManagerName,
      formSteps: state => state.formStep.formSteps,
      editionData: state => state.hospitalSituation.hospitalSituationDetail,
      isHospitalSituationLoading: state => state.hospitalSituation.isLoading,
      isCreating: state => state.hospitalSituation.isCreating
    }),
    formFieldNullStepSorted () {
      if (this.$route.params.update_id) {
        return this.isEditionData(null)
      }
      return this.arraySortAndFilter(this.targetForm.form_fields, null)
    },
    backRoute () {
      if (this.user.isHospitalAdmin) {
        return {
          name: 'hospital.admin.data',
          params: { hospital_id: this.$route.params.hospital_id }
        }
      } else return { name: 'hospital.home' }
    }
  },

  mounted () {
    this.getForm()
    if (this.$route.params.update_id) {
      this.getHospitalSituations()
    }
    if (!this.hospitalManagerName) {
      this.$bvModal.show('nameModal')
    }
  },
  methods: {
    ...mapActions([
      'formShow',
      'createHospitalSituation',
      'updateHospitalSituation',
      'getHospitalSituationsDetail'
    ]),
    formFieldSorted (id) {
      if (this.$route.params.update_id) {
        return this.isEditionData(id)
      }
      return this.arraySortAndFilter(this.targetForm.form_fields, id)
    },
    isEditionData (id) {
      this.editionData.forEach(item => {
        if (item.id === id) {
          item.form_field_type = { name: item.form_field_type }
        }
      })
      return this.arraySortAndFilter(this.editionData, id)
    },
    arraySortAndFilter (data, id = null) {
      return data
        .slice()
        .sort((a, b) => b.order_field - a.order_field)
        ? data.filter(item => item.form_step_id === id)
        : []
    },
    getHospitalSituations () {
      this.getHospitalSituationsDetail({
        isLoading: true,
        update_id: this.$route.params.update_id,
        hospital_id: this.$route.params.hospital_id
      })
    },
    async getForm () {
      await this.formShow({ id: this.$route.params.form_id })
    },

    onComplete () {
      this.isLoading = false
      this.errors = {}
      this.form.hospital_id = this.$route.params.hospital_id
      if (this.$route.params.update_id) {
        this.form._method = 'PUT'
        if (this.submitSituation(this.updateHospitalSituation, null, this.hospitalManagerName)) {
          this.isLoading = true
          if (this.user.isHospitalAdmin) {
            this.$router.push(`/admin/hospitals/${this.$route.params.hospital_id}`)
          } else {
            this.$router.push('/hospitals')
          }
        }
      } else {
        if (this.submitSituation(this.createHospitalSituation, this.hospitalManagerName)) {
          this.$router.push('/hospitals')
        }
      }
    },
    handleChange (key, value, fieldName) {
      if (this.editionData.length > 0) {
        this.editionData.forEach(item => {
          if (item.id === key) {
            item.default_value = value
            this.formData.set(key, value)
          }
        })
      }
      this.targetForm.form_fields.forEach(item => {
        if ((item.id === key) && (item.name === fieldName)) item.default_value = value
        this.formData.set(key, value)
      })
    },
    submitSituation (storeMethod, createdManagerName = null, updatedManagerName = null) {
      for (const [key, value] of this.formData) {
        this.formDataFormatted.push({
          form_field_id: key,
          value,
          last_update: this.$route.params.update_id || this.form.last_update,
          updated_manager_name: this.form.updated_manager_name,
          hospital_id: this.form.hospital_id || this.user.hospital.id
        })
      }

      if (this.formDataFormatted.length > 0) {
        this.formDataFormatted.forEach(item => {
          storeMethod({
            value: item.value,
            form_field_id: item.form_field_id,
            last_update: item.last_update,
            created_manager_name: createdManagerName,
            updated_manager_name: updatedManagerName,
            hospital_id: item.hospital_id
          }).then(() => {
            this.$notify({
              group: 'alert',
              title: 'Champ rajouté avec succès',
              type: 'success'
            })
            this.$emit('created')
          })
            .catch(() => {
              this.$notify({
                group: 'alert',
                title: 'Une erreur est survenu',
                type: 'error'
              })
            })
        })

        return this.isCreating
      }
    }

  }
}
</script>

<style scoped lang="scss">
.no-data {
  font-size: 12px;
  line-height: 26px;
  margin-top: 5px;
}
fieldset {
  border-bottom: 1px solid rgb(0 0 0 / 0.1);
  padding-bottom: 5px;
}
fieldset.no-border {
  border-bottom: none;
}
</style>
