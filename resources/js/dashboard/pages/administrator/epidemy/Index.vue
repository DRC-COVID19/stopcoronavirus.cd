<template>
  <b-container fluid class="align-center">
    <b-row>
      <b-col md="8">
        <b-row class="d-flex justify-content-start">
          <Header :title="title" :iconClass="iconClass" />
        </b-row>
        <ListSituation :situations="situations" />
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
    mounted () {
      this.getSituationList()
    },
    data () {
      return {
        title: 'Epidemie',
        iconClass: "fas fa-file-medical",
        isSituationAdded: false,
        isLoading: false,
        showSuccess: false,
        timeOut: 3,
        situations: [],
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
      },
      getSituationList (page = 1) {
        this.isLoading = true;
        axios.get('/api/pandemic-stats', {
          params: {page}
        })
        .then(({data}) => {
          this.situations = data.data;
          this.isLoading = false;
        })
        .catch(e => console.log(e))
      },
      switchPage (page) {
        this.getSituationList(page)
      }
    }
  }
</script>

<style lang="scss" scoped>

</style>