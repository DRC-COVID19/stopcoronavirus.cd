<template>
  <div>
    <Header />
    <b-container class="mt-4">
      <b-row>
        <b-col cols="12" class="mb-3">
          <b-link :to="{
            name:'hospital.admin'
          }">
            <span class="fa fa-chevron-left">Retour</span>
          </b-link>
        </b-col>
        <b-col v-if="hospital.id">
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
            :busy="ishospitalSituationLoading"
            :fields="fields"
            :items="hospitalSituations.data"
            show-empty
          >
            <template v-slot:empty="scope">
              <h4>{{ scope.emptyText }}</h4>
            </template>
            <template v-slot:table-busy>
              <div class="text-center text-danger my-2">
                <b-spinner class="align-middle" />
                <strong>Loading...</strong>
              </div>
            </template>
            <template v-slot:cell(last_update)="data">
              <span>{{moment(data.item.last_update).format('DD.MM.Y')}}</span>
            </template>
            <template v-slot:cell(actions)="data">
              <b-button
                size="sm"
                class="btn-dash-blue mb-1"
                :to="{
                  name:'hospital.detail',
                  params:{
                    update_id:data.item.last_update,
                    hospital_id: $route.params.hospital_id
                  }
                }"
              >Details</b-button>
                 <b-button
                class="btn btn-warning mb-1"
                :to="{
                  name: 'hospital.edit',
                  params: {
                    update_id:data.item.last_update,
                    hospital_id:$route.params.hospital_id,
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
import Header from '../../components/hospital/Header'
import ManagerUserName from '../../components/hospital/ManagerUserName'
import { mapState, mapMutations, mapActions } from 'vuex'
import { DEFAULT_FORM_ID } from '../../config/env'
export default {
  components: {
    Header,
    ManagerUserName
  },
  data () {
    return {
      fields: [
        { key: 'last_update', label: 'Date' },
        { key: 'name', label: 'Nom' },
        { key: 'actions', label: 'Actions' }
      ],
      currentPage: 1,
    }
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
      hospital: (state) => state.hospital.hospitalData,
      hospitalSituations: (state) => state.hospital.hospitalSituations,
      ishospitalSituationLoading: (state) => state.hospital.isLoading
    }),
    totalRows () {
      if (this.hospitalSituations.meta) {
        return this.hospitalSituations.meta.total
      }
      return null
    },
    perPage () {
      if (this.hospitalSituations.meta) {
        return this.hospitalSituations.meta.per_page
      }
      return 15
    },
    defaultFormId () {
      return DEFAULT_FORM_ID
    }
  },
  mounted () {
    this.getSituations()
    this.getHospital({ hospital_id: this.$route.params.hospital_id })
  },
  methods: {
    ...mapActions(['getHospital', 'getHospitalSituations']),
    ...mapMutations(['setDetailHospital', 'setHospitalManagerName']),
    getSituations (page) {
      if (typeof page === 'undefined') page = 1
      this.getHospitalSituations({ page, hospital_id: this.$route.params.hospital_id, isLoading: this.ishospitalSituationLoading })
    },
    onPageChange (page) {
      this.getHospitalSituations(page)
    }
  }
}
</script>

<style>
</style>
