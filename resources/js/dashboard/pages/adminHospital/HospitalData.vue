<template>
  <div>
    <b-container class="mt-4">
      <b-row>
        <b-col cols="12" class="mb-3">
          <b-link :to="{
            name:'hospital.admin'
          }">
            <span class="fa fa-chevron-left">Retour</span>
          </b-link>
        </b-col>
        <b-col v-if="hospital">
          <h3>
             Historique mise à jour : {{ hospital.name }}
          </h3>
          <!-- <b-alert show variant="info">
            <p v-if="hospital.address">{{`Adresse: ${hospital.address}`}}</p>
          </b-alert> -->
        </b-col>
      </b-row>
      <b-row class="mt-4" >
        <b-col>
          <b-table
            :busy="isLoading"
            :fields="fields"
            :items="completedForms.data"
            hover
            show-empty
          >
            <template v-slot:empty="scope">
              <h4>{{ scope.emptyText }}</h4>
            </template>
            <template v-slot:table-busy>
              <div class="text-center text-danger my-2">
                <b-spinner class="align-middle" />
                <strong>Chargement des données...</strong>
              </div>
            </template>
            <template v-slot:cell(last_update)="data">
              <span>{{moment(data.item.last_update).format('DD.MM.Y')}}</span>
            </template>
            <template v-slot:cell(actions)="data">
              <b-button
               variant="outline-primary"
                class="btn-dash "
                :to="{
                  name:'hospital.detail',
                  params:{
                    hospital_id: data.item.hospital_id || 0,
                    completed_form_id:data.item.id
                    }
                    }"
              >Details</b-button>
              <b-button
               variant="outline-success btn-dash"
                :to="{
                  name: 'hospital.edit',
                  params: {
                    completed_form_id:data.item.id,
                    hospital_id: data.item.hospital_id,
                    form_id: defaultFormId
                  }
                }"
              >Editer</b-button>
            </template>
          </b-table>
        </b-col>
      </b-row>
      <b-row align-h="end">
        <b-col lg="6">
          <b-pagination
            v-model="currentPage"
            :total-rows="totalRows"
            :per-page="perPage"
            class="my-0 mb-3 justify-content-end"
            @change="onPageChange"
          />
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import ManagerUserName from '../../components/hospital/ManagerUserName'
import { mapState, mapMutations, mapActions } from 'vuex'
import { DEFAULT_FORM_ID } from '../../config/env'
export default {
  components: {
    // eslint-disable-next-line vue/no-unused-components
    ManagerUserName
  },
  data () {
    return {
      fields: [
        { key: 'last_update', label: 'Date' },
        { key: 'created_manager_name', label: 'Nom' },
        { key: 'created_manager_first_name', label: 'Prénom' },
        { key: 'actions', label: 'Actions' }
      ],
      currentPage: 1,
      completedForms: {}
    }
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
      hospital: (state) => state.hospital.hospitalData,
      isLoading: (state) => state.completedForm.isLoading
    }),
    totalRows () {
      if (this.completedForms) {
        return this.completedForms.total
      }
      return null
    },
    perPage () {
      if (this.completedForms) {
        return this.completedForms.per_page
      }
      return 15
    },
    defaultFormId () {
      return DEFAULT_FORM_ID
    }
  },
  async mounted () {
    await this.getHospital({ hospital_id: this.$route.params.hospital_id })
    this.getCompletedForms()
  },
  methods: {
    ...mapActions(['getHospital', 'completedForm__getByHospital']),
    ...mapMutations(['setDetailHospital', 'setHospitalManagerName']),
    async getCompletedForms (page) {
      this.isLoading = true
      if (typeof page === 'undefined') page = 1
      this.completedForms = await this.completedForm__getByHospital({ page, hospital_id: this.$route.params.hospital_id })
      if (this.completedForms.length !== 0) {
        this.isLoading = false
      }
    },
    onPageChange (page) {
      this.getCompletedForms(page)
    }

  }

}
</script>

<style>
</style>
