<template>
  <div class="px-5">
    <b-row class="my-3 d-flex justif-content-start">
      <b-col cols="12" md="6">
        <b-form-input
          v-model="filter"
          class="input-dash"
          type="search"
          placeholder='Filtrer'
        ></b-form-input>
      </b-col>
      <b-col cols="12" md="6" class="ml-auto">
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
            <i @click="editSituation(data.item.last_update)" class="mx-2 fas fa-edit"></i>
          </template>
        </b-table>
        <b-pagination page-class="text-blue-dash" v-model="currentPage" :per-page="perPage" :total-rows="rows"></b-pagination>
      </b-col>
    </b-row>
    <b-modal  v-model="isDeleteModalShown">
      Voulez-vous vraiment supprimer la situation {{currentSituation.id}} ?
      <template #modal-footer>
        <b-button size="sm" variant="success" @click="onValidateDelection()">
          Accepter 
        </b-button>
        <b-button size="sm" variant="danger" @click="onCancelDelection()">
          Annuler
        </b-button>
      </template>
    </b-modal>
  </div>
</template>

<script>
  export default {
    props: {
      // situations: {
      //   type: Array,
      //   default: () => [],
      //   required: false
      // }
    },
    data () {
      return {
        fields: ['Date', 'Confirmé', 'Actifs', 'Graves', 'Guéris', 'Décès', 'Importé', 'Locale', 'actions'],
        filter: '',
        perPage: 15,
        currentPage: 1,
        isDeleteModalShown: false,
        currentSituation: {
          id: -1,
          last_update: ''
        },
        editModalShow: false,
        situations: [
          {last_update:'12.01.2021', confirmed: 203, sick: 239, seriously: 31, healed: 238, dead: 31, imported: 13, local: 123},
          {last_update:'12.01.2021', confirmed: 203, sick: 239, seriously: 31, healed: 238, dead: 31, imported: 13, local: 123},
          {last_update:'12.07.2020', confirmed: 4903, sick: 399, seriously: 341, healed: 238, dead: 31, imported: 13, local: 123},
          {last_update:'12.01.2021', confirmed: 203, sick: 239, seriously: 31, healed: 238, dead: 31, imported: 13, local: 123},
          {last_update:'12.01.2021', confirmed: 203, sick: 239, seriously: 341, healed: 238, dead: 31, imported: 13, local: 123},
          {last_update:'12.01.2021', confirmed: 203, sick: 339, seriously: 81, healed: 238, dead: 31, imported: 13, local: 123},
          {last_update:'12.01.2021', confirmed: 203, sick: 239, seriously: 31, healed: 238, dead: 31, imported: 13, local: 123},
          {last_update:'12.01.2021', confirmed: 203, sick: 239, seriously: 31, healed: 238, dead: 31, imported: 13, local: 123},
        ]
      }
    },
    computed: {
      rows () {
        return this.situations.length
      }
    },
    methods: {
      editSituation (last_update) {
        console.log('Edit')
        // this.isDeleteModalShown = true
        // this.currentUser.id = userId
        // this.currentUser.name = name
      },
      onValidateDelection () {
        // this.$emit('onEditSituation', this.currentUser.id)
        // this.isDeleteModalShown = false
      },
      onCancelDelection () {
        this.isDeleteModalShown = false
      },
      // updateSituation (name, id, usernmae, roles, email) {
      //   this.currentUser = {
      //     id,
      //     name,
      //     usernmae,
      //     roles,
      //     email
      //   }
      //   this.$emit('onUpdateUser', this.currentUser)
      // }
    }
  }
</script>
<style lang='scss' scoped>
  @import "@~/sass/_variables";
  .fa-edit {
    color: $fin-8;
    font-size: 16px;
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