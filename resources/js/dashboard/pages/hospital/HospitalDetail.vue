<template>
  <div>
    <Header />
    <b-container>
      <Loading v-if="isLoading" class="h-100" message="Chargement des données ..."/>
      <b-row v-else align-h="center" class="mb-3">
        <b-col cols="12" md="6" class="mt-4">
          <b-link :to="backRoute">
            <span class="fa fa-chevron-left"> Retour</span>
          </b-link>
          <h3 class="mb-4 mt-2 ">Situation hospitalière de la mise à jour du <br> {{moment(completedForm.last_update).format("DD/MM/Y")}}</h3>
            <b-col
              v-for="(step, index) in completedFormFieldFiltered"
              :key="index"
              cols="12" md="12"
            >
                  <h3 class="mb-4">{{step.form_step_title}}</h3>
                  <ul   v-for="(field, count) in step.completed_form_fields"
                    :key="count">
                    <li>{{field.form_field.name}} : {{field.value}}</li>
                  </ul>
            </b-col>
          <div>Données envoyées par <b> {{completedForm.created_manager_name}}</b></div>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import Header from '../../components/hospital/Header'
import Loading from '../../components/Loading'
import { mapActions, mapState } from 'vuex'
export default {
  components: {
    Loading, Header
  },
  data () {
    return {
      completedFormFields: [],
      completedForm: {},
      isLoading: false
    }
  },
  mounted () {
    this.getCompletedForm()
  },
  computed: {
    ...mapState({
      user: state => state.auth.user
    }),
    backRoute () {
      if (this.user.isHospitalAdmin) {
        return {
          name: 'hospital.admin.data',
          params: { hospital_id: this.$route.params.hospital_id }
        }
      } else return { name: 'hospital.home' }
    },
    completedFormFieldFiltered () {
      return this.completedFormFieldFilter()
    }
  },
  methods: {
    ...mapActions(['completedForm__getByHospitalDetail']),
    async getCompletedForm () {
      this.isLoading = true
      this.completedFormFields = await this.completedForm__getByHospitalDetail({ isLoading: this.isLoading, completed_form_id: this.$route.params.completed_form_id })
      if (this.completedFormFields.length > 0) {
        this.isLoading = false
        this.setLastUpdate(this.completedFormFields[0].completed_form.last_update)
        this.setCreatedManagerName(this.completedFormFields[0].completed_form.created_manager_name)
      }
    },
    setLastUpdate (lastUpdate) {
      this.completedForm.last_update = lastUpdate
    },
    setCreatedManagerName (createdManagerName) {
      this.completedForm.created_manager_name = createdManagerName
    },
    completedFormFieldEvery () {
      const completedFormFieldsId = []
      if (this.completedFormFields.length > 0) {
        this.completedFormFields
          .slice()
          .sort(
            (prevFormItem, nextFormItem) =>
              prevFormItem.form_field.form_step.id - nextFormItem.form_field.form_step.id
          )
          .forEach(item => {
            if (completedFormFieldsId.every(form => form.form_step_id !== item.form_field.form_step.id)) {
              completedFormFieldsId.push({
                form_step_id: item.form_field.form_step.id,
                form_step_title: item.form_field.form_step.title
              })
            }
          })
        return completedFormFieldsId
      }
    },
    completedFormFieldFilter () {
      const formStepsList = this.completedFormFieldEvery()?.map(form => {
        const formStep = {
          form_step_id: form.form_step_id,
          form_step_title: form.form_step_title
        }
        formStep.completed_form_fields = this.completedFormFields.filter(
          arr => arr.form_field.form_step.id == formStep.form_step_id
        )
        return formStep
      })
      return formStepsList
    }

  }
}
</script>

<style>
</style>
