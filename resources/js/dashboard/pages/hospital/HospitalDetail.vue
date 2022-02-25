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
          <h3 class="mb-4 mt-2 ">Situation hospitalière de la mise à jour du <br> {{moment(completedForms[0].completed_form.last_update).format("DD/MM/Y")}}</h3>
            <b-col
              v-for="(step, index) in createCompletedFormsReduce()"
              :key="index"
              cols="12" md="12"
            >
                  <h3 class="mb-4">{{step.form_step_title}}</h3>
                  <ul   v-for="(field, count) in step.completed_form_fields"
                    :key="count">
                    <li>{{field.form_field.name}} : {{field.value}}</li>
                  </ul>
            </b-col>
          <div>Données envoyées par <b> {{completedForms[0].completed_form.created_manager_name}}</b></div>
          <!-- <div v-if="completedForms.slice(0,1)[0].created_manager_name">Modifier par {{completedForms.slice(0,1)[0].updated_manager_name}}</div> -->
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
      completedForms: [],
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
    renderSituations () {
      return this.createCompletedFormsReduce()
    }
  },
  methods: {
    ...mapActions(['completedForm__getByHospitalDetail']),
    async getCompletedForm () {
      this.isLoading = true
      this.completedForms = await this.completedForm__getByHospitalDetail({ isLoading: this.isLoading, completed_form_id: this.$route.params.completed_form_id })
      if (this.completedForms.length > 0) {
        this.isLoading = false
      }
    },
    createCompletedFormsReduce () {
      const formIds = []
      if (this.completedForms.length > 0) {
        this.completedForms
          .slice()
          .sort(
            (prevFormItem, nextFormItem) =>
              prevFormItem.form_field.form_step.id - nextFormItem.form_field.form_step.id
          )
          .forEach(item => {
            if (formIds.every(form => form.form_step_id !== item.form_field.form_step.id)) {
              formIds.push({
                form_step_id: item.form_field.form_step.id,
                form_step_title: item.form_field.form_step.title
              })
            }
          })
        const formStepsList = formIds.map(form => {
          const formStep = {
            form_step_id: form.form_step_id,
            form_step_title: form.form_step_title
          }
          formStep.completed_form_fields = this.completedForms.filter(
            arr => arr.form_field.form_step.id == formStep.form_step_id
          )
          return formStep
        })
        return formStepsList
      }
      return []
    }
  }
}
</script>

<style>
</style>
