<template>
  <b-container>
    <b-row class="my-3" align-h="start">
      <b-col cols="12" md="6">
        <b-form-datepicker
          id="datepicker"
          v-model="filter"
          placeholder="Choisir la date"
          class="mb-2">
        </b-form-datepicker>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-table
          responsive
          striped
          hover
          :fields="fields"
          :items="situations"
          :filter="filter"
          :per-page="perPage"
          :current-page="currentPage"
        >
          <template
            v-slot:cell(actions)="data"
            class="action-btn-group"
          >
            <i @click="editSituation(data.item.last_update, data.item.confirmed, data.item.sick, data.item.dead, data.item.healed, data.item.imported, data.item.local, data.item.seriously)" class="mx-2 fas fa-edit"></i>
            <i @click="deleteSituation(data.item.last_update)" class="mx-2 fas fa-trash"></i>
          </template>
          <template
            v-slot:cell(last_update)="data"
          >
            {{moment(data.item.last_update).format('D MMMM YYYY')}}
          </template>
        </b-table>
        <b-pagination page-class="text-blue-dash" v-model="currentPage" :per-page="perPage" :total-rows="rows"></b-pagination>
      </b-col>
    </b-row>
    <b-modal  v-model="isDeleteModalShown">
      Voulez-vous supprimer la mise à jour du {{currentSituation.last_update}} ?
      <template #modal-footer>
        <b-button size="sm" variant="success" @click="onValidateDelection()">
          Accepter 
        </b-button>
        <b-button size="sm" variant="danger" @click="onCancelDelection()">
          Annuler
        </b-button>
      </template>
    </b-modal>
  </b-container>
</template>

<script>
  export default {
    props: {
      situations: {
        type: Array,
        default: () => [],
        required: false
      }
    },
    data () {
      return {
        fields: [
          {key: 'last_update', label: 'Date'}, 
          {key: 'confirmed', label: 'Confirme', sortable: true}, 
          {key: 'sick', label: 'Actifs', sortable: true}, 
          {key: 'seriously', label: 'Grave', sortable: true}, 
          {key: 'healed', label: 'Gueris', sortable: true}, 
          {key: 'dead', label: 'Deces', sortable: true}, 
          {key: 'imported', label: 'Importes', sortable: true}, 
          {key: 'local', label: 'Local', sortable: true}, 
          'actions'
        ],
        filter: '',
        perPage: 15,
        currentPage: 1,
        isDeleteModalShown: false,
        currentSituation: {
          last_update: ''
        },
        editModalShow: false,
      }
    },
    computed: {
      rows () {
        return this.situations.length
      }
    },
    methods: {
      deleteSituation (last_update) {
        this.isDeleteModalShown = true
        this.currentSituation.last_update = last_update
      },
      editSituation (last_update, confirmed, sick, dead, healed, imported, local, seriously) {
        this.currentSituation = {
          last_update,
          confirmed,
          sick,
          dead,
          local,
          imported,
          seriously,
          healed
        }
        this.$emit('onEditSituation', this.currentSituation)
      },
      onValidateDelection () {
        this.$emit('onDeleteSituation', this.currentSituation.last_update)
        this.isDeleteModalShown = false
      },
      onCancelDelection () {
        this.isDeleteModalShown = false
      }
    }
  }
</script>
<style lang='scss' scoped>
  @import "@~/sass/_variables";
  .fa-edit {
    color: $fin-8;
    font-size: 18px;
  }
  .fa-trash {
    color: $fin-5;
    font-size: 18px; 
  }
  .btn-remove {
    background-color: $dash-red;
  }
  .btn-edit {
    background-color: $fin-8;
  }
  .action-btn-group {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
  }
</style>