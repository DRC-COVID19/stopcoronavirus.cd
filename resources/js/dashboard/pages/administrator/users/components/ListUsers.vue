<template>
  <b-container fluid>
    <b-row no-gutters class="mb-3">
      <b-col cols="12" md="6">
        <b-form-input
          v-model="filter"
          debounce="1500"
          class="input-dash input-filter"
          type="search"
          placeholder="Filtrer"
        ></b-form-input>
      </b-col>
    </b-row>
    <b-row no-gutters>
      <b-col cols="12">
        <b-skeleton-table
          v-if="isLoading"
          :rows="15"
          :columns="5"
          :table-props="{ bordered: false, striped: true, responsive: true }"
        ></b-skeleton-table>

        <b-table
          v-else
          responsive
          striped
          hover
          :fields="fields"
          :items="userFilter"
          :filter="filter"
          :per-page="perPage"
          :current-page="currentPage"
        >
          <template #table-busy>
            <div
              class="align-items-center d-flex justify-content-center my-2 text-center text-danger loading-height"
            >
              <b-spinner class="align-middle"></b-spinner>
              <strong>Loading...</strong>
            </div>
          </template>
          <template v-slot:cell(actions)="data" class="action-btn-group">
            <i
              @click="deleteUser(data.item.name, data.item.id)"
              class="mx-2 my-1 fas fa-user-times"
            ></i>
            <i
              @click="
                updateUser(
                  data.item.name,
                  data.item.id,
                  data.item.usernmae,
                  data.item.roles,
                  data.item.hospitals,
                  data.item.email,
                  data.item.phone_number

                )
              "
              class="mx-2 my-1 fas fa-user-edit"
            ></i>
          </template>
          <template v-slot:cell(role)="data">
            <b-badge
              class="mx-1 my-1"
              v-for="(role, index) in data.item.roles"
              variant="secondary"
              :key="index"
              >{{ role.name }}</b-badge
            >
          </template>
          <template v-slot:cell(hopital)="data">
            <b-badge
              class="mx-1 my-1"
              v-for="(hopital, index) in data.item.hospitals"
              variant="secondary"
              :key="index"
              >{{ hopital.name }}</b-badge
            >
          </template>
        </b-table>
      </b-col>
    </b-row>
    <b-modal v-model="isDeleteModalShown">
      Voulez-vous vraiment supprimer l'utilisateurs {{ currentUser.name }} ?
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
    users: {
      type: Object,
      default: () => ({}),
    },
    isLoading: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      fields: [{ key: "id", sortable: true }, "username", "name","phone_number", "role","hopital", "actions"], // usernmae instead of username (see backend response)
      filter: "",
      perPage: 15,
      currentPage: 1,
      isDeleteModalShown: false,
      currentUser: {
        id: -1,
        name: "",
      },
      editModalShow: false,
    };
  },
  computed: {
    rows() {
      return this.users.length;
    },
    userFilter() {
      return this.users.data.slice().sort((a,b) => a.id.toString().localeCompare(b.id.toString()))
    }
  },
  watch: {
    filter () {
      this.search();
    }
  },
  methods: {
    search () {
      this.$emit('onSearch', this.filter.trim());
    },
    deleteUser(name, userId) {
      this.isDeleteModalShown = true;
      this.currentUser.id = userId;
      this.currentUser.name = name;
    },
    onValidateDelection() {
      this.$emit("onDeleteUser", this.currentUser.id);
      this.isDeleteModalShown = false;
    },
    onCancelDelection() {
      this.isDeleteModalShown = false;
    },
    updateUser(name, id, usernmae, roles,hospitals, email, phone_number) {
      this.currentUser = {
        id,
        name,
        usernmae,
        roles,
        hospitals,
        email,
        phone_number,
      };
      this.$emit("onUpdateUser", this.currentUser);
    },
  },
};
</script>
<style lang='scss' scoped>
@import "@~/sass/_variables";
.input-filter {
  background: white;
}
.fa-user-times {
  color: $dash-red;
  font-size: 16px;
}
.loading-height {
  height: 660px;
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
