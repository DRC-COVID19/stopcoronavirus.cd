<template>
  <b-container fluid class="align-center">
    <b-row>
      <b-col md="8">
        <b-row class="d-flex justify-content-start">
          <Header :title="title" :iconClass="iconClass" />
        </b-row>
        <b-row class="mx-4" vertical-align="center">
          <b-col md="5">
            Selectionner la province
            <v-select v-model="selectedProvince" :options="provinces" label="name" :reduce="item=>item.id" />
          </b-col>
          <b-col md="5">
            Selectionner la ville
            <v-select v-model="selectedVille" :options="villes" label="name" :reduce="item=>item.id" />
          </b-col>
          <b-col md="2" class="mt-3">
            <b-button type="submit" variant="success">Trier</b-button>
          </b-col>
        </b-row>
        <ListSituation />
      </b-col>
      <b-col md="4">
        <b-alert
          variant="success"
          :show="showSuccess"
          dismissible
          fade
          @dismiss-count-down="timeOut"
          class="mx-3 mt-3"
        >
          Situation ajoutee avec success
        </b-alert>
        <CreateSituation @onCreateSituation="createSituation" :isSituationAdded="isSituationAdded" />
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
  import Header from '../components/Header';
  import ListSituation from './components/ListSituation';
  import CreateSituation from './components/CreateSituation';
  export default {
    components: {
      Header,
      ListSituation,
      CreateSituation
    },
    data () {
      return {
        title: 'Epidemie',
        iconClass: "fas fa-file-medical",
        isSituationAdded: false,
        isLoading: false,
        showSuccess: false,
        timeOut: 3,
        provinces: [
          "Kinshasa",
          "Bandundu",
          "Nord-kivu"
        ],
        villes: [
          "Goma",
          "Kinshasa",
          "Lubumbashi",
          "Bukavu"
        ],
        selectedVille: "",
        selectedProvince: ""
      }
    },
    methods: {
      createSituation (form) {
        axios.post('/api/pandemic-stats', {
          confirmed: form.confirmed,
          local: form.local,
          imported: form.imported,
          sick: form.sick,
          seriously: form.seriously,
          healed: form.healed,
          dead: form.dead,
          last_update: form.last_update
        })
        .then(() => {
          this.isSituationAdded = true;
          this.isLoading = false;
          this.showSuccess = true;
        }).catch((err) => {
          
        });
      }
    }
  }
</script>

<style lang="scss" scoped>

</style>