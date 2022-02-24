<template>
  <div>
    <Header />
    <b-container>
      <Loading v-if="isLoading" class="h-100" />
      <b-row v-else align-h="center" class="mb-3">
        <b-col cols="12" md="6" class="mt-4">
          <b-link :to="backRoute">
            <span class="fa fa-chevron-left"> Retour</span>
          </b-link>
          {{completedForms}}
          <h3 class="mb-4 mt-2 ">Situation hospitalière de la mise à jour du <br> {{moment(completedForms[0].last_update).format("DD/MM/Y")}}</h3>
            <!-- <b-col
              v-for="(step, index) in renderSituations"
              :key="index"
              cols="12" md="12"
            >
                  <h3 class="mb-4">{{step.form_step_title}}</h3>
                  <ul   v-for="(field, count) in step.form_field_values"
                    :key="count">
                    <li>{{field.name}} : {{field.default_value}}</li>
                  </ul>
            </b-col> -->
          <div>Données envoyées par <b> {{completedForms[0].created_manager_name}}</b></div>
          <!-- <div v-if="completedForms.slice(0,1)[0].created_manager_name">Modifier par {{completedForms.slice(0,1)[0].updated_manager_name}}</div> -->
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import Header from '../../components/hospital/Header'
import Loading from '../../components/Loading'
import { createSituationsReduce } from '../../plugins/functions'
import { mapActions, mapState } from 'vuex'
export default {
  components: {
    Loading, Header
  },
  async mounted () {
    await this.getCompletedForm()
  },
  computed: {
    ...mapState({
      user: state => state.auth.user,
      completedForms: state => state.completedForm.completedFormsDetail,
      isLoading: state => state.completedForm.isLoading
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
      return createSituationsReduce(this.completedForms)
    }
  },
  methods: {
    ...mapActions(['completedForm__getByHospitalDetail']),
    getCompletedForm () {
      this.completedForm__getByHospitalDetail({ isLoading: this.isLoading, completed_form_id: this.$route.params.completed_form_id })
    }
  }
}
</script>

<style>
</style>
