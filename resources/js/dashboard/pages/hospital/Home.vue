<template>
  <div>
    <Header />
    <b-container class="mt-4">
      <b-row>
        <b-col v-if="user && user.hospital">
          <h3>
            Situations CTCO
            <b-link :to="{name:'hospital.data'}">
              <span class="fa fa-edit"></span>
            </b-link>

          </h3>
          <b-alert show variant="info">
            <div>{{`Structure: ${user.hospital.name}`}}</div>
            <p v-if="user.hospital.address">{{`Adresse: ${user.hospital.address}`}}</p>
            <p v-if="hospitalManagerName">Connecté en tant que {{hospitalManagerName}}</p>
          </b-alert>
        </b-col>
      </b-row>
      <b-row class="mt-4 mb-4">
        <b-col>
          <b-button :to="{name:'hospital.create',params:{ form_id: defaultFormId }}" class="btn-dash-blue">Nouveau</b-button>
        </b-col>
      </b-row>
      <b-row>
        <b-col>
          <b-table
            :busy="isLoading"
            :fields="fields"
            :items="completedForms.data"
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
                size="sm"
                class="btn-dash-blue mb-1"
                :to="{
                  name:'hospital.detail',
                  params:{
                    completed_id:data.item.id,
                    hospital_id: data.item.hospital_id || 0
                    }
                    }"
              >Details</b-button>
              <b-button
                v-if="(data.item.diff_date * 24) < 24"
                class="btn btn-warning mb-1"
                :to="{
                  name: 'hospital.edit',
                  params: {
                    completed_id:data.item.id,
                    hospital_id:user.hospital.id,
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
    <ManagerUserName id="nameModal" />
  </div>
</template>

<script>
import Header from '../../components/hospital/Header'
import ManagerUserName from '../../components/hospital/ManagerUserName'
import { mapState, mapActions, mapMutations } from 'vuex'
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
      hospitalId: null
    }
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
      hospitalManagerName: (state) => state.hospital.hospitalManagerName,
      completedForms: (state) => state.completedForm.completedForms,
      isLoading: (state) => state.hospital.isLoading
    }),
    totalRows () {
      if (this.completedForms.meta) {
        return this.completedForms.meta.total
      }
      return null
    },
    perPage () {
      if (this.completedForms.meta) {
        return this.completedForms.meta.per_page
      }
      return 15
    },
    defaultFormId () {
      return DEFAULT_FORM_ID
    }
  },
  async mounted () {
    if (!this.hospitalManagerName) {
      this.$bvModal.show('nameModal')
    }
    await this.getCompletedForms()
  },
  methods: {
    ...mapActions(['completedForm__getByHospital']),
    ...mapMutations(['setDetailHospital', 'setHospitalManagerName']),
    getCompletedForms (page) {
      if (typeof page === 'undefined') page = 1
      this.completedForm__getByHospital({ page, hospital_id: this.user.hospital.id, isLoading: this.isLoading })
    },
    onPageChange (page) {
      this.getCompletedForms(page)
    }

  }
}
</script>

<style>
</style>
