<template>
  <div>
    <Header />
    <b-container>
      <b-row class="mt-4">
        <b-col cols="12" md="10">
          <h3>Résumé mise à jour CTCOS</h3>
        </b-col>
        <b-col cols="12" md="2">
          <b-button class="btn-dash-blue" @click="getData()">
            <i class="fa fa-sync"></i>
          </b-button>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols="12" class="mt-4">
          <b-table
            :busy="isLoading"
            :fields="fields"
            responsive
            hover
            :items="updateData"
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

            <template v-slot:cell(statut)="data">
             <div v-if="renderDiffDate(moment, data.item.last_update) < 2" class="d-flex justify-content-start align-item-center">
                <span class="badge badge-pill badge-statut"
                :style="'background-color : ' + '#8BC34A'">

                </span>
                <span class="ml-4">À jours</span>
             </div>
             <div v-else-if="renderDiffDate(moment, data.item.last_update) >=2 && renderDiffDate(moment, data.item.last_update)" class="d-flex justify-content-start align-item-center">
                <span class="badge badge-pill badge-statut"
                :style="'background-color : ' + '#f08c2e'">

                </span>
                <span class="ml-4">Retard de {{ renderDiffDate(moment, data.item.last_update) }} jours</span>
             </div>
             <div v-else-if="renderDiffDate(moment,data.item.last_update) > 3" class="d-flex justify-content-start align-item-center">
                <span class="badge badge-pill badge-statut"
                :style="'background-color : ' + '#F44336'">

                </span>
                <span class="ml-4">Retard de {{ renderDiffDate(moment, data.item.last_update) }} jours </span>
             </div>
             <div v-else  class="d-flex justify-content-start align-item-center">
                <span class="badge badge-pill badge-statut"
                :style="'background-color : ' + '#888888'">

                </span>
                <span class="ml-4">jamais mis à jour</span>
             </div>
            </template>
            <template v-slot:cell(last_update)="data">
              <span v-if="data.item.last_update">{{moment(data.item.last_update).format('DD.MM.Y')}}</span>
              <span v-else> </span>
            </template>
            <template v-slot:cell(actions)="data">
              <b-button
                size="sm"
                class="btn-dash-blue mb-1"
                :to="{
                  name:'hospital.admin.data',
                  params:{
                    hospital_id:data.item.hospital_id
                  }
                }"
                v-if="data.item.last_update"
                >Details</b-button>
            </template>
          </b-table>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>
<script>
import { mapActions, mapState } from 'vuex'
import Header from '../../components/hospital/Header'
import { renderDiffDate as diffDate } from '../../plugins/functions'
export default {
  components: {
    Header
  },
  data () {
    return {
      fields: [
        { key: 'statut', label: 'Statut' },
        { key: 'last_update', label: 'Date' },
        { key: 'name', label: 'Nom CTCO' },
        { key: 'created_manager_name', label: 'Soumis par' },
        { key: 'actions', label: 'Actions' }
      ],
      isLoading: false
    }
  },
  computed: {
    ...mapState({ updateData: (state) => state.hospitalSituation.AllhospitalSituationByLastUpdate })
  },
  mounted () {
    this.getAllHospitalSituationsByLastUpdate()
  },
  methods: {
    ...mapActions(['getAllHospitalSituationsByLastUpdate']),

    renderDiffDate (moment, date) {
      return diffDate(this.moment, date)

      // if (diffDay < 4) return '#8BC34A' // vert
      // else if (diffDay < 8) return '#f08c2e' // orange
      // else if (diffDay < 10) return '#F44336' // rouge
      // else return '#888888' // gris
    }
  }
}
</script>

<style>

</style>
<style lang="scss">
  .badge-statut{
    content: "";
    display: block !important;
    width: 20px;
    height: 20px;
    width: 30px;
    height: 30px;
    box-shadow: 0px 0px 10px rgba(0,0,0,.2);
  }
</style>
