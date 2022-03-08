<template>
  <b-container fluid>
    <b-row class="flex-md-row-reverse" no-gutters>
      <b-col cols="12" md="4" class="mt-3">
        <Create
          @onUpdate="updateHospital"
          @onCreate="createHospital"
          @onCancelUpdate="cancelUpdate"
          :hospitalAdded="hospitalAdded"
          :hospitalUpdated="hospitalUpdated"
          :formToPopulate="formToPopulate"
          :roles="roles"
          :hospitals="hospitals"
          :errors="errors"
        />
      </b-col>
      <b-col cols="12" md="8">
        <Header :title="title" :iconClass="iconClass" />
        <div class="hide-waiting" v-if="updating"></div>
         <HospitalList
          :hospitals="hospitals"
          @onSearch="search"
          @onDeleteHospital="deleteHospital"
          @onUpdateHospital="populateForm"
          :isLoading="isLoading"
          :updating="updating"
        />
        <b-col cols="12" class="d-flex justify-content-end">
          <b-pagination
            page-class="text-blue-dash"
            v-model="currentPage"
            :per-page="hospitalMeta.per_page"
            :total-rows="hospitalMeta.total"
            @change="getHospitalList"
            :disabled="updating"
          ></b-pagination>
        </b-col>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import Header from '../components/Header'
import HospitalList from './components/HospitalLists'
import Create from './components/Create'
import { mapActions, mapState } from 'vuex'

export default {
  components: {
    Header,
    Create,
    HospitalList
  },
  data () {
    return {
      title: 'Hopitaux',
      iconClass: 'fas fa-hospital',
      isLoading: false,
      hospitals: {},
      HospitalUpdated: false,
      HospitalAdded: false,
      showSuccess: false,
      isHospitalDeleted: false,
      timeOut: 3,
      formToPopulate: {},
      updating: false,
      errors: {},
      currentPage: 1,
      roles: []
    }
  },
  async mounted () {
    // this.getHospitalList()
    // this.getHospitalRoles()
    this.findHospitals()
  },
  computed: {
    ...mapState({
    }),
    hospitalMeta () {
      if (!this.hospitals) {
        return {
          current_page: 1,
          from: 1,
          last_page: 1,
          path: '#',
          per_page: 1,
          to: 1,
          total: 1
        }
      }
      return this.hospitals
    }
  },
  methods: {
    ...mapActions(['getHospitals', 'removeHospital']),

    search (filter) {
      this.isLoading = true
      if (filter !== '') {
        // eslint-disable-next-line no-undef
        this.hospitals.data.filter((item) => item.name.includes(filter))
      } else {
        this.getHospitalList()
        this.isLoading = false
      }
    },
    deleteHospital (currentHospitalId) {
      // eslint-disable-next-line no-undef
      this.removeHospital({ hospital_id: currentHospitalId })
        .then(() => {
          this.getHospitalList()
          this.isHospitalDeleted = true
          this.$notify({
            group: 'alert',
            title: 'Supprimer Hopital',
            text: 'Supprimer avec succès !',
            type: 'success'
          })
        })
        .catch(({ response }) => {
          this.$gtag.exception(response)
          this.$notify({
            group: 'alert',
            title: 'Supprimer Hopital',
            text: 'Une erreur est survenue!',
            type: 'error'
          })
        })
    },
    populateForm (currentHospital) {
      this.updating = true
      this.formToPopulate = currentHospital
    },
    cancelUpdate () {
      this.updating = false
    },
    updateHospital (currentHospital) {
      this.isLoading = true
      this.HospitalUpdated = false
      const form = {
      }

      // eslint-disable-next-line no-undef
      axios
        .put('/api/hospitals/' + currentHospital.id, form)
        .then(() => {
          this.HospitalUpdated = true
          this.showSuccess = true
          this.isLoading = false
          this.updating = false
          this.getHospitalList(1)
          this.$notify({
            group: 'alert',
            title: 'Modifer utilisateur',
            text: 'Modifier avec succès',
            type: 'success'
          })
        })
        .catch(({ response }) => {
          this.$gtag.exception(response)
          this.$notify({
            group: 'alert',
            title: 'Modifer utilisateur',
            text: 'Une erreur est surveni',
            type: 'error'
          })
        })
    },

    createHospital (form) {
      this.HospitalAdded = false
      this.isLoading = true
      this.errors = {}
      // eslint-disable-next-line no-undef
      axios
        .post('/api/admin_hospitals', {
          username: form.username,
          name: form.name,
          password: form.password,
          password_confirmation: form.confirmPassword,
          email: form.email,
          roles_id: form.roles,
          hospitals_id: form.hospitals
        })
        .then(() => {
          this.userAdded = true
          this.showSuccess = true
          this.isLoading = false
          this.getHospitalList(1)
          this.$notify({
            group: 'alert',
            title: 'Nouvel utilisateur',
            text: 'Ajouter avec succès',
            type: 'success'
          })
        })
        .catch(({ response }) => {
          this.$gtag.exception(response)
          this.isLoading = false
          this.errors = response.data.errors
          const messages = this.renderErrorsMessages(this.errors).join(',')
          this.$notify({
            group: 'alert',
            title: 'Nouvel utilisateur',
            text: 'Oups! Une erreur est survenue :\r\n' + messages,
            type: 'error'
          })
        })
    },

    getHospitalList (page = 1) {
      this.isLoading = true
      // eslint-disable-next-line no-undef
      axios
        .get('/api/admin_hospitals', {
          params: { page }
        })
        .then(({ data }) => {
          this.hospitals = data
          this.isLoading = false
        })
        .catch(({ response }) => {
          this.$gtag.exception(response)
        })
    },

    getHospitalRoles () {
      // eslint-disable-next-line no-undef
      axios
        .get('/api/admin_roles')
        .then(({ data }) => {
          this.roles = data
        })
        .catch(({ response }) => {
          this.$gtag.exception(response)
        })
    },
    async findHospitals () {
      this.isLoading = true
      this.hospitals = Object.assign({}, await this.getHospitals())['0']
      if (this.hospitals.length !== 0) {
        this.isLoading = false
      }
    },

    switchPage (page) {
      this.getHospitalList(page)
    },
    renderErrorsMessages (errors) {
      const errorsMessage = []
      if (errors.roles_id) {
        errorsMessage.push("Le Role d'un utilisateur est obligatoire.")
      } else if (errors.username) {
        errorsMessage.push("Ce nom d'utilisateur est déjà utilisé.")
      } else if (errors.email) {
        errorsMessage.push("L'adresse email doit être unique et obligatoire ")
      } else if (errors.password) {
        errorsMessage.push('Le Mot de passe de passe est obligatoire ')
      }

      return errorsMessage
    }

  }

}
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
