<template>
  <b-container fluid>
    <b-row>
      <b-col md="8">
        <b-row class="d-flex justify-content-start">
          <Header :title="title" :iconClass="iconClass" />
        </b-row>
        <b-row>
          <b-col md="6">
            <b-text>Selectionner la province</b-text>
            <v-select v-model="selectedProvince" multiple :options="provinces" label="name" :reduce="item=>item.id" />
          </b-col>
          <b-col md="6">
            <b-text>Selectionner la ville</b-text>
            <v-select v-model="selectedVille" multiple :options="villes" label="name" :reduce="item=>item.id" />
          </b-col>          
        </b-row>
      </b-col>
      <b-col md="4">
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
  import Header from '../components/Header';
  export default {
    components: {
      Header
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