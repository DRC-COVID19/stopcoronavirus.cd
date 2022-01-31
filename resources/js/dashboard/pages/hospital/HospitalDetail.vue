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
          {{ this.$route.params.update_id }}
          <h3 class="mb-4 mt-2 ">Situation hospitalière de la mise à jour du <br> {{moment(form.last_update).format("DD.MM.Y")}}</h3>

          <h4 class="mb-4">Données épidemologiques</h4>
          <ul>
            <li>Confirmés : {{form.confirmed}}</li>
            <li>Hospitalisés : {{form.sick}}</li>
            <li>Guéris : {{form.healed}}</li>
            <li>Décès : {{form.dead}}</li>
          </ul>
          <h4 class="mb-4">Capacité de prise en charge des patiens</h4>
          <ul>
            <li>Lits avec mousse occupés: {{form.occupied_foam_beds}}</li>
            <li>Lits de réanimation occupés : {{form.occupied_resuscitation_beds}}</li>
            <li>Respirateurs occupés : {{form.occupied_respirators}}</li>
            <li>Ventilateur de réanimation occupés : {{form.resuscitation_ventilator}}</li>
            <li>Masques : {{form.masks}}</li>
            <li>Equipement de protection individuelle : {{form.individual_protection_equipment}}</li>
            <li>Oxygénérateur : {{form.oxygenator}}</li>
            <li>Dépistage rapide : {{form.rapid_screening}}</li>
            <li>Radiographie : {{form.x_ray}}</li>
            <li>Automate Genexpert : {{form.automate_genexpert}}</li>
            <li>Gel hydro alcoolique : {{form.gel_hydro_alcoolique}}</li>
            <li>Check point : {{form.check_point}}</li>
          </ul>
          <h4 class="mb-4">Médicaments</h4>
          <ul>
            <li>Chloroquine : {{form.chloroquine}}</li>
            <li>Hydrochloroquine : {{form.hydrochloroquine}}</li>
            <li>Azytromicine : {{form.azytromicine}}</li>
            <li>Vitamince c : {{form.Vitamince_c}}</li>
          </ul>
          <div>Données envoyées par <b> {{form.created_manager_name}}</b></div>
          <div v-if="form.updated_manager_name">Modifier par {{form.updated_manager_name}}</div>
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
  
  mounted () {
    this.getHospital()
  },
  computed: {
    ...mapState({
      user: state => state.auth.user,
      form: state => state.hospitalSituation.hospitalSituationDetail,
      isLoading: state => state.hospitalSituation.isLoading ,
    }),
    backRoute () {
      if (this.user.isHospitalAdmin) {
        return {
          name: 'hospital.admin.data',
          params: { hospital_id: this.$route.params.hospital_id }
        }
      } else return { name: 'hospital.home' }
    }
  },
  methods: {
    ...mapActions(['getHospitalSituationsDetail']),
    getHospital () {
      this.isLoading = true
      this.getHospitalSituationsDetail({ isLoading: this.isLoading, update_id: this.$route.params.update_id })
    }
  }
}
</script>

<style>
</style>
