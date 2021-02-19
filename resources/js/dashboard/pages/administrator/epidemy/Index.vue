<template>
  <b-container fluid>
    <b-row>
      <b-col md="8">
        <b-row class="d-flex justify-content-start">
          <Header :title="title" :iconClass="iconClass" />
        </b-row>
        <b-row class="mx-4">
          <b-col md="6">
            Selectionner la province
            <v-select v-model="selectedProvince" multiple :options="provinces" label="name" :reduce="item=>item.id" />
          </b-col>
          <b-col md="6">
            Selectionner la ville
            <v-select v-model="selectedVille" multiple :options="villes" label="name" :reduce="item=>item.id" />
          </b-col>        
        </b-row>
        <ListSituation />
      </b-col>
      <b-col md="4">
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
  import Header from '../components/Header';
  import ListSituation from './components/ListSituation';
  export default {
    components: {
      Header,
      ListSituation
    },
    data () {
      return {
        title: 'Epidemie',
        iconClass: "fas fa-file-medical",
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
    }
  }
</script>

<style lang="scss" scoped>

</style>