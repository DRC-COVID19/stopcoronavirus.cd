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
          <h3 class="mb-4 mt-2 ">Situation hospitalière de la mise à jour du <br> {{moment(form.last_update).format("DD.MM.Y")}}</h3>

          <h4 class="mb-4">Données épidémiologiques</h4>
          <ul>
            <li v-for="(question, i) in questions.epidemiologicalData" :key="i">
              {{ question.text }} : {{ form[question.column] }}
            </li>
          </ul>
          <h4 class="mb-4">Capacité de prise en charge</h4>
          <ul>
            <li v-for="(question, i) in questions.patientCareCapacity" :key="i">
              {{ question.text }} : {{ form[question.column] }}
            </li>
            <li v-for="(question, i) in questions.medications" :key="i">
              {{ question.text }} : {{ form[question.column] }}
            </li>
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
import {mapState} from "vuex" ;
import Questions from "../../config/questions";

export default {
  components: {
    Loading,Header
  },
  data() {
    return {
      form: {},
      isLoading: false,
      questions: Questions
    };
  },
  mounted(){
    this.getHospital();
  },
  computed : {
    ...mapState({
      user: state => state.auth.user
    }) ,
    backRoute(){
      if(this.user.isHospitalAdmin){
        return {
          name: 'hospital.admin.data' ,
          params: { hospital_id: this.$route.params.hospital_id }
        }
      }
      else return { name: 'hospital.home' }
    }
  },
  methods: {
    getHospital() {
      this.isLoading = true;
      axios
        .get(
          `/api/dashboard/hospital-situations/${this.$route.params.update_id}`
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
