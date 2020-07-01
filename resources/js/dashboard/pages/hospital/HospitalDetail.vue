<template>
  <div>
    <Header />
    <b-container>
      <Loading v-if="isLoading" class="h-100" />
      <b-row v-else align-h="center" class="mb-3">
        <b-col cols="12" md="6">
          <h3 class="mb-4 mt-4">Situation hospitalière de la mise à jour du <br> {{moment(form.last_update).format("DD.MM.Y")}}</h3>

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
import Header from "../../components/hospital/Header";
import Loading from "../../components/Loading";
export default {
  components: {
    Loading,Header
  },
  data() {
    return {
      form: {},
      isLoading: false
    };
  },
  mounted(){
    this.getHospital();
  },
  methods: {
    getHospital() {
      this.isLoading = true;
      axios
        .get(
          `/api/dashboard/hospital-situations/${this.$route.params.hospital_id}`
        )
        .then(({ data }) => {
          this.form = data;
        })
        .catch(response => {})
        .finally(() => {
          this.isLoading = false;
        });
    }
  }
};
</script>

<style>
</style>