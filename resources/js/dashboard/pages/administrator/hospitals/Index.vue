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
          :townships="townships"
          :hospitals="hospitals"
          :users ="users"
          :errors="errors"
          :isLoading="isLoading"
          :updating="updating"
        />
      </b-col>
      <b-col cols="12" md="8">
        <div class="ml-2">
          <Header :title="title" :iconClass="iconClass" />
        </div>
        <div class="hide-waiting" v-if="updating"></div>
         <HospitalList
          :hospitals="hospitals"
          @onSearch="filterHospitals"
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
      title: 'Hopitaux( CTCOS  )',
      iconClass: 'fas fa-hospital',
      isLoading: false,
      hospitals: {},
      hospitalUpdated: false,
      hospitalAdded: false,
      showSuccess: false,
      isHospitalDeleted: false,
      timeOut: 3,
      formToPopulate: {},
      updating: false,
      errors: {},
      currentPage: 1,
      users: [],
      affected: null
    }
  },
  async mounted () {
    this.getUsers()
    this.getHospitalList()
    this.getTownShips()
  },
  computed: {
    ...mapState({
      townships: (state) => state.township.townships
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
    ...mapActions([
      'getHospitals', 'hospital__remove',
      'townships__getAll', 'hospital__store',
      'hospital__update', 'hospital__filter',
      'hospital__getAgents'
    ]),

    filterHospitals (filter) {
      this.isLoading = true
      if (filter !== '') {
        return new Promise((resolve, reject) => {
          this.hospital__filter(filter)
            .then(({ data }) => {
              this.hospitals = data
              this.isLoading = false
              resolve(true)
            })
            .catch(({ response }) => {
              this.$gtag.exception(response)
              this.isLoading = false
              reject(response)
            })
        })
      } else {
        this.getHospitalList()
        this.isLoading = false
      }
    },
    deleteHospital (currentHospitalId) {
      return new Promise((resolve, reject) => {
        this.hospital__remove({ id: currentHospitalId })
          .then(() => {
            this.getHospitalList()
            this.isHospitalDeleted = true
            this.$notify({
              group: 'alert',
              title: 'Rétirer un Agent dans un CTCO',
              text: "L'Agent a été rétiréavec succès !",
              type: 'success'
            })
            resolve()
          })
          .catch(({ response }) => {
            reject(response)
            this.$gtag.exception(response)
            this.$notify({
              group: 'alert',
              title: 'Rétirer un Agent dans un CTCO',
              text: 'Une erreur est survenue!',
              type: 'error'
            })
          })
      })
    },
    populateForm (currentHospital) {
      this.updating = true
      this.formToPopulate = currentHospital
    },
    cancelUpdate () {
      this.updating = false
      this.isLoading = false
    },

    updateHospital (currentHospital) {
      this.isLoading = true
      this.hospitalUpdated = false
      return new Promise((resolve, reject) => {
        this.hospital__update(currentHospital)
          .then(() => {
            this.hospitalUpdated = true
            this.showSuccess = true
            this.isLoading = false
            this.updating = false

            this.getHospitalList(1)
            this.getUsers()
            this.getTownShips()
            this.$notify({
              group: 'alert',
              title: 'Modification du CTCO',
              text: 'Modifié avec succès',
              type: 'success'
            })
            resolve(true)
          })
          .catch(({ response }) => {
            this.getHospitalList(1)
            this.$gtag.exception(response)
            this.$notify({
              group: 'alert',
              title: 'Modification du CTCO',
              text: 'Une erreur est survenue ! ' + this.renderErrorsMessages(response.data.errors).join(','),
              type: 'error'
            })
            reject(response)
          })
          .finally(() => {
            this.isLoading = false
          })
      })
    },
    createHospital (form) {
      this.hospitalAdded = false
      this.isLoading = true
      this.errors = {}
      return new Promise((resolve, reject) => {
        this.hospital__store(form)
          .then(() => {
            this.showSuccess = true
            this.isLoading = false
            this.hospitalAdded = true
            this.getHospitalList(1)
            this.getUsers()
            this.getTownShips()
            this.$notify({
              group: 'alert',
              title: 'Nouvel CTCO',
              text: 'Ajouter avec succès',
              type: 'success'
            })
            resolve(true)
          })
          .catch(({ response }) => {
            this.$gtag.exception(response)
            this.isLoading = false
            this.errors = response.data.errors
            const messages = this.renderErrorsMessages(this.errors).join(',')
            this.$notify({
              group: 'alert',
              title: 'Nouvel CTCO',
              text: 'Oups! Une erreur est survenue :\r\n' + messages,
              type: 'error'
            })
            reject(response)
          })
      })
    },
    async getUsers () {
      this.isLoading = true
      this.users = await this.hospital__getAgents()
      this.isLoading = false
    },
    async getTownShips () {
      await this.townships__getAll()
    },
    async getHospitalList (page = 1) {
      this.isLoading = true
      this.hospitals = Object.assign({}, await this.getHospitals({ page }))['0']
      if (this.hospitals.length !== 0) {
        this.isLoading = false
      }
    },

    switchPage (page) {
      this.getHospitalList(page)
    },
    renderErrorsMessages (errors) {
      const errorsMessage = []
      if (errors.name) {
        errorsMessage.push('Cette CTCO existe déjà.')
      } else if (errors.township_id) {
        errorsMessage.push('La commune doit être unique et obligatoire ')
      } else if (errors.agent_id) {
        errorsMessage.push(errors.agent_id.join(','))
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
