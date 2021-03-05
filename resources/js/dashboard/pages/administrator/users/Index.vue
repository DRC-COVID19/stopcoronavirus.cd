<template>
  <b-container fluid>
    <b-row class="flex-md-row-reverse" no-gutters>
      <b-col cols="12" md="4" class="mt-3">
        <Create
          @onUpdate="updateUser"
          @onCreate="createUser"
          @onCancelUpdate="cancelUpdate"
          :userAdded="userAdded"
          :userUpdated="userUpdated"
          :formToPopulate="formToPopulate"
          :roles="roles"
          :errors="errors"
        />
      </b-col>
      <b-col cols="12" md="8">
        <Header :title="title" :iconClass="iconClass" />

        <div class="hide-waiting" v-if="updating"></div>
        <ListUser
          :users="users"
          @onSearch="search"
          @onDeleteUser="deleteUser"
          @onUpdateUser="populateForm"
          :isLoading="isLoading"
          :updating="updating"
        />
        <b-col cols="12" class="d-flex justify-content-end">
          <b-pagination
            page-class="text-blue-dash"
            v-model="currentPage"
            :per-page="userMeta.perPage"
            :total-rows="userMeta.total"
            @change="getUserList"
            :disabled="updating"
          ></b-pagination>
        </b-col>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import Header from "../components/Header";
import ListUser from "./components/ListUsers";
import Create from "./components/Create";
export default {
  components: {
    Header,
    Create,
    ListUser,
  },
  data() {
    return {
      title: "Utilisateurs",
      iconClass: "fa fa-home",
      isLoading: false,
      users: {},
      userUpdated: false,
      userAdded: false,
      showSuccess: false,
      isUserDeleted: false,
      timeOut: 3,
      formToPopulate: {},
      updating: false,
      errors: {},
      currentPage: 1,
      roles: [],
    };
  },
  mounted() {
    this.getUserList();
    this.getUserRoles();
  },
  computed: {
    userMeta() {
      if (!this.users.meta) {
        return {
          current_page: 1,
          from: 1,
          last_page: 1,
          path: "#",
          per_page: 1,
          to: 1,
          total: 1,
        };
      }
      return this.users.meta;
    },
  },
  methods: {
    search (filter) {
      if (filter !== '') {
        axios
          .get('api/admin_users/filter?key_words='+filter)
          .then(({ data }) => {
            this.users = data;

          })
          .catch(({ response }) => {
            this.$gtag.exception(response);
          });
      } else {
        this.getUserList();
      }
    },
    deleteUser(currentUserId) {
      axios
        .delete("/api/admin_users/" + currentUserId)
        .then(() => {
          this.getUserList();
          this.isUserDeleted = true;
          this.$notify({
            group: "alert",
            title: "Supprimer utilisateur",
            text: "Supprimer avec succès",
            type: "success",
          });
        })
        .catch(({ response }) => {
          this.$gtag.exception(response);
          this.$notify({
            group: "alert",
            title: "Supprimer utilisateur",
            text: "Une erreur est surveni",
            type: "error",
          });
        });
    },
    populateForm(currentUser) {
      this.updating = true;
      this.formToPopulate = currentUser;
    },
    cancelUpdate() {
      this.updating = false;
    },
    updateUser(currentUser) {
      this.isLoading = true;
      this.userUpdated = false;
      const form = {
        username: currentUser.username,
        name: currentUser.name,
        email: currentUser.email,
        roles_id: currentUser.roles,
      };

      if (currentUser && currentUser.password) {
        form.password = currentUser.password;
        form.password_confirmation = currentUser.confirmPassword;
      }

      axios
        .put("/api/admin_users/" + currentUser.id, form)
        .then(() => {
          this.userUpdated = true;
          this.showSuccess = true;
          this.isLoading = false;
          this.updating = false;
          this.getUserList(1);
          this.$notify({
            group: "alert",
            title: "Modifer utilisateur",
            text: "Modifier avec succès",
            type: "success",
          });
        })
        .catch(({ response }) => {
          this.$gtag.exception(response);
          this.$notify({
            group: "alert",
            title: "Modifer utilisateur",
            text: "Une erreur est surveni",
            type: "error",
          });
        });
    },
    createUser(form) {
      this.userAdded = false;
      this.isLoading = true;
      this.errors = {};
      axios
        .post("/api/admin_users", {
          username: form.username,
          name: form.name,
          password: form.password,
          password_confirmation: form.confirmPassword,
          email: form.email,
          roles_id: form.roles,
        })
        .then(() => {
          this.userAdded = true;
          this.showSuccess = true;
          this.isLoading = false;
          this.getUserList(1);
          this.$notify({
            group: "alert",
            title: "Nouvel utilisateur",
            text: "Ajouter avec succès",
            type: "success",
          });
        })
        .catch(({ response }) => {
          this.$gtag.exception(response);
          this.isLoading = false;
          this.errors = response.data.errors;
          this.$notify({
            group: "alert",
            title: "Nouvel utilisateur",
            text: "Une erreur est surveni",
            type: "error",
          });
        });
    },
    getUserList(page = 1) {
      this.isLoading = true;
      axios
        .get("/api/admin_users", {
          params: { page },
        })
        .then(({ data }) => {
          this.users = data;
          this.isLoading = false;
        })
        .catch(({ response }) => {
          this.$gtag.exception(response);
        });
    },
    getUserRoles() {
      axios
        .get("/api/admin_roles")
        .then(({ data }) => {
          this.roles = data;
        })
        .catch(({ response }) => {
          this.$gtag.exception(response);
        });
    },
    switchPage(page) {
      this.getUserList(page);
    },
  },
};
</script>

<style lang='scss' scoped>
@import "@~/sass/_variables";
.fa-plus {
  color: white;
  font-size: 14px;
}
.mask {
  position: absolute;
  z-index: 100;
  background-color: $dash-background;
  opacity: 0.5;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}
.alert {
  position: absolute;
  z-index: 100;
  opacity: 0.6;
  top: 0;
  right: 0;
  width: 100%;
}
</style>
