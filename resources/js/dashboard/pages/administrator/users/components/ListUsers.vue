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
         <!-- <div class="d-flex justify-content-end">
          <b-button class="btn-dash-blue" variant="success">
            <b-link :to="{name:'administrator.users.create'}"><i class="fa fa-plus"></i></b-link>
          </b-button>
        </div> -->
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-table 
          responsive
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
            <i @click="deleteUser(data.item.name, data.item.id)" class="fas fa-user-times"></i>
            <i @click="updateUser(data.item.name, data.item.id, data.item.usernmae, data.item.roles, data.item.email)" class="fas fa-user-edit"></i>
          </template>
          <template 
            v-slot:cell(role)="data"
          >
            <b-badge class="mx-1 my-1" v-for="(role, index) in data.item.roles" variant="secondary" :key="index">{{role.name}}</b-badge>
          </template>
        </b-table>
        <b-pagination page-class="text-blue-dash" v-model="currentPage" :per-page="perPage" :total-rows="rows"></b-pagination>
      </b-col>
    </b-row>
    <b-modal  v-model="isDeleteModalShown">
      Voulez-vous vraiment supprimer l'utilisateurs {{currentUser.name}} ?
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
      users: {
        type: Array,
        default: () => [],
        required: false
      }
    },
    data () {
      return {
        fields: ['id', 'usernmae', 'name', 'role', 'actions'], // usernmae instead of username (see backend response)
        filter: '',
        perPage: 15,
        currentPage: 1,
        isDeleteModalShown: false,
        currentUser: {
          id: -1,
          name: ''
        },
        editModalShow: false
      }
    },
    computed: {
      rows () {
        return this.users.length
      }
    },
    methods: {
      deleteUser (name, userId) {
        this.isDeleteModalShown = true
        this.currentUser.id = userId
        this.currentUser.name = name
      },
      onValidateDelection () {
        this.$emit('onDeleteUser', this.currentUser.id)
        this.isDeleteModalShown = false
      },
      onCancelDelection () {
        this.isDeleteModalShown = false
      },
      updateUser (name, id, usernmae, roles, email) {
        this.currentUser = {
          id,
          name,
          usernmae,
          roles,
          email
        }
        this.$emit('onUpdateUser', this.currentUser)
      }
    }
  }
</script>
<style lang='scss' scoped>
  @import "@~/sass/_variables";
  i {
    margin-left: 10px;
  }
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