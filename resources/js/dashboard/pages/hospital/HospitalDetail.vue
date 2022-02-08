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
          <h3 class="mb-4 mt-2 ">Situation hospitalière de la mise à jour du <br> {{moment(form.slice(0,1)[0].last_update).format("DD/MM/Y")}}</h3>
            <b-col
                  v-for="(step, index) in renderSituations"
                  :key="index"

                  cols="12" md="12" >
                  <h3 class="mb-4">{{step.form_step_title}}</h3>
                  <ul   v-for="(step, count) in step.form_field_values"
                    :key="count">
                    <li>{{step.form_field_name}} : {{step.form_field_value}}</li>
                  </ul>
            </b-col>
          <div>Données envoyées par <b> {{form.slice(0,1)[0].created_manager_name}}</b></div>
          <!-- <div v-if="form.slice(0,1)[0].created_manager_name">Modifier par {{form.slice(0,1)[0].updated_manager_name}}</div> -->
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

  mounted () {
    this.getHospital()
  },
  computed: {
    ...mapState({
      user: state => state.auth.user,
      form: state => state.hospitalSituation.hospitalSituationDetail,
      isLoading: state => state.hospitalSituation.isLoading
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
      return createSituationsReduce(this.form)
    }
  },
  methods: {
    ...mapActions(['getHospitalSituationsDetail']),
    getHospital () {
      this.getHospitalSituationsDetail({ isLoading: this.isLoading, update_id: this.$route.params.update_id })
    }
  }
}
</script>

<style>
</style>
