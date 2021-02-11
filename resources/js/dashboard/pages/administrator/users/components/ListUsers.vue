<template>
  <div>
    <b-row class="my-3 d-flex space-between">
      <b-col md="4" class="">
        <b-form-input
          v-model="filter"
          type="search"
          placeholder='Filtrer'
        ></b-form-input>
      </b-col>
      <b-col md="4" class="ml-auto">
        <div class="d-flex justify-content-end">
          <b-button class="btn-dash-blue" variant="success">
            <b-link :to="{name:'administrator.users.create'}"><i class="fa fa-plus"></i></b-link>
          </b-button>
        </div>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-table 
          striped 
          hover
          :fields="fields"
          :items="users" 
          :filter="filter"
          :per-page="perPage"
          :current-page="currentPage"
        >
          <template
            v-slot:cell(actions)="data"
            class="action-btn-group"
          >
            <i @click="deleteUser(data.item.id)" class="fas fa-user-times"></i>
            <i @click="updateUser(data.item.id)" class="fas fa-user-edit"></i>
            <!--<b-button variant="danger" @click="deleteUser(data.item.id)" class="btn-remove"><i class="fas fa-user-times"></i></b-button>
            <b-button variant="primary" @click="deleteUser(data.item.id)" class="btn-edit"><i class="fas fa-user-edit"></i></b-button>-->
          </template>
        </b-table>
        <b-pagination v-model="currentPage" :per-page="perPage" :total-rows="rows"></b-pagination>
      </b-col>
    </b-row>
    <b-modal v-model="deleteModalShow">Voulez-vous supprimer l'utilisateurs {{currentUserId}} ?</b-modal>
  </div>
</template>

<script>
  export default {
    props: {
      users: {
        type: Array,
        required: true
      }
    },
    data () {
      return {
        fields: ['id', 'usernmae', 'name', 'role', 'actions'], // usernmae instead of username (see backend response)
        filter: '',
        perPage: 15,
        currentPage: 1,
        deleteModalShow: false,
        editModalShow: false,
        currentUserId: -1
      }
    },
    computed: {
      rows () {
        return this.users.length
      }
    },
    methods: {
      deleteUser (id) {
        this.deleteModalShow = true
        this.currentUserId = id
      },
      updateUser (id) {

      }
    }
  }
</script>
<style lang='scss' scoped>
  @import "@~/sass/_variables";
  .fa-user-times {
    color: $dash-red;
    font-size: 16px;
  }
  .fa-user-edit {
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