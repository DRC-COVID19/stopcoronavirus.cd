<template>
  <div>
    <b-container class="mt-4">
      <b-row>
        <b-col v-if="user && user.hospital">
          <h3>
            Situations CTCO
            <b-link :to="{name:'hospital.data'}" v-b-tooltip.hover title="Editer le CTCO">
              <span class="fa fa-edit"></span>
            </b-link>

          </h3>
          <b-card class="mb-4 bg-dash">
            <b-card-header class="border-0 p-2 bg-default text-dark"><h5 class="mt-2">{{`Structure: ${user.hospital.name}`}}</h5></b-card-header>
           <b-card-body>
              <p v-if="user.hospital.address">{{`Adresse: ${user.hospital.address}`}}</p>
            <p v-if="hospitalManagerName && hospitalManagerFirstName">Connecté en tant que <strong>{{hospitalManagerName }} - </strong><span><strong>{{ hospitalManagerFirstName}}</strong></span></p>
           </b-card-body>
          </b-card>
        </b-col>
      </b-row>
      <b-row class="mt-4 mb-4">
        <b-col>
          <b-button :to="{name:'hospital.create',params:{ form_id: defaultFormId }}" class="btn-dash-blue">+ Nouveau</b-button>
        </b-col>
      </b-row>
      <b-row>
        <b-col>
          <b-table
            :busy="iscompletedFormsLoading"
            :fields="fields"
            :items="completedForms.data"
            responsive
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
                class="mb-1 btn-dash"
                :to="{
                  name:'hospital.detail',
                  params:{
                    completed_form_id:data.item.id,
                    hospital_id: data.item.hospital_id || 0
                    }
                    }"
              >Details</b-button>
              <b-button
                v-if="(data.item.diff_date * 24) < 24"
                variant="outline-success mb-1"
                class="btn-dash"
                :to="{
                  name: 'hospital.edit',
                  params: {
                    completed_form_id:data.item.id,
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
import ManagerUserName from '../../components/hospital/ManagerUserName'
import { mapState, mapActions, mapMutations } from 'vuex'
import { DEFAULT_FORM_ID } from '../../config/env'
export default {
  components: {
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
      hospitalId: null,
      alertVariant: 'secondary',
      iscompletedFormsLoading: false,
      completedForms: {}
    }
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
      hospitalManagerName: (state) => state.hospital.hospitalManagerName,
      hospitalManagerFirstName: (state) => state.hospital.hospitalManagerFirstName,
      completedForms: (state) => state.completedForm.completedForms,
      isLoading: (state) => state.hospital.isLoading
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
    },
    completedFormsData () {
      return this.completedForms.data.map((completedForm) => {
        completedForm.name_manager = completedForm.created_manager_name.split(' ')[0]
        completedForm.first_name_manager = completedForm.created_manager_name.split(' ')[1]
        return completedForm
      })
    }
  },
  mounted () {
    if (!this.hospitalManagerName) {
      this.$bvModal.show('nameModal')
    }
    this.$store.commit('SET_COMPLETED_FORMS', { isLoading: true })
    this.getCompletedForms()
  },
  watch: {
    user () {
      this.getCompletedForms()
    }
  },
  methods: {
    ...mapActions(['completedForm__getByHospital']),
    ...mapMutations(['setDetailHospital', 'setHospitalManagerName']),
    async getCompletedForms (page) {
      this.iscompletedFormsLoading = true
      if (typeof page === 'undefined') page = 1
      if (this.user && this.user.hospital) {
        this.completedForms = await this.completedForm__getByHospital({
          page,
          hospital_id: this.user.hospital.id
        })
        if (this.completedForms.length !== 0) {
          this.iscompletedFormsLoading = false
        }
      }
    },

    onPageChange (page) {
      this.getCompletedForms(page)
    }

  }
}
</script>

<style lang="scss">
$bg_primary:#F4F6FC;
 .hopita_mome{
  background-color: $bg_primary;
}
  .light{
    background-color: $bg_primary;
  }
  .bg-dash{
    box-shadow: -5px 10px 25px -1px rgba(0,0,0,0.1);
    border: 0 !important;
  }
</style>
