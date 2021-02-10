<template>
  <div>
    <b-row>
      <b-col md="3" class="d-flex justify-content-end">
        <b-form-input
          class="my-3"
          v-model="filter"
          type="search"
          placeholder='Recherche'
        ></b-form-input>
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
            <i @click="deleteUser(data.users.id)" class="fas fa-user-times"></i>
            <i @click="updateUser(data.users.id)" class="fas fa-user-edit"></i>
            <!--<b-button variant="danger" @click="deleteUser(data.users.id)" class="btn-remove"><i class="fas fa-user-times"></i></b-button>
            <b-button variant="primary" @click="deleteUser(data.users.id)" class="btn-edit"><i class="fas fa-user-edit"></i></b-button>-->
          </template>
        </b-table>
        <b-pagination v-model="currentPage" :per-page="perPage" :total-rows="rows"></b-pagination>
      </b-col>
    </b-row>
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
        fields: ['id', 'username', 'name', 'role', 'actions'],
        filter: '',
        perPage: 15,
        currentPage: 1
      }
    },
    computed: {
      rows () {
        return this.users.length
      }
    },
    methods: {
      deleteUser (id) {

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