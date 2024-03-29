<template>
  <div>
    <b-container fluid>
      <b-row no-gutters class="mb-3">
        <b-col
          cols="12"
          md="12 d-flex flex-row-reverse justify-content-between"
        >
          <div class="container-filter" sm="12">
            <b-form-input
              v-model="filter"
              debounce="1500"
              class="input-dash input-filter"
              type="search"
              placeholder="Filtrer"
            ></b-form-input>
          </div>
          <div class="container-new-btn d-lg-none">
            <b-button
              @click="openToogle()"
              v-b-toggle.sidebar-right
              class="btn-dash-blue d-block"
              ><span class="default-label">Nouveau</span>
              <i class="fas fa-plus responsive-label"></i>
            </b-button>
          </div>
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
                class="
                  align-items-center
                  d-flex
                  justify-content-center
                  my-2
                  text-center text-danger
                  loading-height
                "
              >
                <b-spinner class="align-middle"></b-spinner>
                <strong>Loading...</strong>
              </div>
            </template>
            <template v-slot:cell(actions)="data" class="action-btn-group">
              <b-button
                variant="outline-success mb-1"
                class="btn-dash"
                @click="
                  updateUser(
                    data.item.name,
                    data.item.id,
                    data.item.usernmae,
                    data.item.roles,
                    data.item.hospital,
                    data.item.email,
                    data.item.phone_number
                  )
                "
                v-b-toggle.sidebar-right
                >Editer</b-button
              >
              <b-button
                variant="outline-danger mb-1"
                class="btn-dash"
                @click="deleteUser(data.item.name, data.item.id)"
              >
                Supprimer
              </b-button>
            </template>
            <template v-slot:cell(role)="data">
              <b-badge
                class="mx-1 my-1"
                v-for="(role, index) in data.item.roles"
                variant="secondary"
                :key="index"
                >{{ role.label }}</b-badge
              >
            </template>
            <template v-slot:cell(hospital)="data">
              <b-badge class="mx-1 my-1">{{ data.value.name }}</b-badge>
            </template>
          </b-table>
        </b-col>
      </b-row>
    </b-container>
    <b-modal v-model="isDeleteModalShown" centered hide-header>
      <b-container class="text-center">
        Voulez-vous vraiment supprimer l'utilisateurs {{ currentUser.name }} ?
        ?</b-container
      >

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
      type: Object,
      default: () => ({})
    },
    isLoading: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      fields: [
        { key: 'usernmae', sortable: false, label: 'Nom utilisateur' }, // usernmae instead of username (see backend response)
        { key: 'phone_number', sortable: false, label: 'N°Téléphone' },
        { key: 'role', sortable: false, label: 'Rôle' },
        { key: 'hospital', sortable: false, label: 'Hôpital' },
        { key: 'actions', sortable: false, label: 'Actions' }
      ],
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
    },

    userFilter () {
      return (
        (this.users.data &&
          this.users.data
            .slice()
            .sort((a, b) => a.id - b.id)
            .map((user) => {
              user.roles = user.roles.filter(
                (v, i, a) =>
                  a.findIndex((t) => t.label === v.label) === i &&
                  (v.label === 'Administrateur' ||
                    v.label === 'Agent Point Focal')
              )
              return user
            })) ??
        []
      )
    }
  },
  watch: {
    filter () {
      this.search()
    }
  },
  methods: {
    search () {
      this.$emit('onSearch', this.filter.trim())
    },
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
    openToogle () {
      this.$emit('openToogle', false)
    },
    updateUser (name, id, usernmae, roles, hospital, email, phone_number) {
      this.currentUser = {
        id,
        name,
        usernmae,
        roles,
        hospital,
        email,
        phone_number
      }
      this.$emit('onUpdateUser', this.currentUser)
    }
  }
}
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";
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
.modal-dialog {
  width: auto !important;
}
.responsive-label {
  display: none;
}
.default-label {
  display: block;
}
.container-new-btn {
  display: block !important;
}
@media (max-width: $max-width) {
  .default-label {
    display: none;
  }
  .responsive-label {
    display: block;

    font-size: 20px;
  }
}
</style>
