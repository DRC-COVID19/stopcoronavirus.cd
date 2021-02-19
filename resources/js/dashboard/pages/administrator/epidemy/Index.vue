<template>
  <b-container fluid vertical-align='canter'>
    <b-row>
      <b-col md="8">
        <b-row class="d-flex justify-content-start">
          <Header :title="title" :iconClass="iconClass" />
        </b-row>
        <ListSituation :class="{hidden_list:isUpdating}" :situations="situations" @onEditSituation="editSituation" />
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
        <CreateSituation @onCancelUpdate="cancelUpdate" @onCreateSituation="createSituation" :isSituationAdded="isSituationAdded" :formToPopulate="formToPopulate" />
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
        isUpdating: false,
        formToPopulate: {}
      }
    },
    methods: {
      createSituation (form) {
        this.isSituationAdded = false;
        this.isLoading = true
        axios.post('/api/pandemic-stats', {
          confirmed: form.confirmed,
          local: form.local,
          imported: form.imported,
          sick: form.sick,
          seriously: form.seriously,
          healed: form.healed,
          dead: form.dead,
          isUpdating: false,
          last_update: form.last_update
        })
        .then(() => {
          this.isSituationAdded = true;
          this.isLoading = false;
          this.showSuccess = true;
          this.getSituationList()
        }).catch((err) => {
          console.local(err)
        });
      },
      editSituation (form) {
        this.isUpdating = true;
        this.formToPopulate = form
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
      cancelUpdate () {
        this.isUpdating = false;
      },
      switchPage (page) {
        this.getSituationList(page)
      }
    }
  }
</script>

<style lang="scss" scoped>
  .hidden_list {
    opacity: 0.6
  }
</style>