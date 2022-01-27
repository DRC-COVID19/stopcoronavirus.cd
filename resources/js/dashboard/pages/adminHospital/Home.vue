<template>
  <div>
    <Header />
    <b-container>
      <b-row class="mt-4">
        <b-col cols="12" md="10">
          <h3>Dernières mise à jour situation épidemiologique</h3>
             {{ updateData }}k
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
              <span class="badge badge-pill badge-statut"
                :style="'background-color : ' + getColor(data.item.last_update)">

                </span>
            </template>
            <template v-slot:cell(last_update)="data">
              <span>{{moment(data.item.last_update).format('DD.MM.Y')}}</span>
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
export default {
  components: {
    Header
  },
  data () {
    return {
      fields: [
        { key: 'statut', label: 'Statut' },
        { key: 'last_update', label: 'Date' },
        { key: 'name', label: 'CTCO' },
        { key: 'confirmed', label: 'Confirmés' },
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

    getColor (date) {
      const dateFormat = this.moment(date)
      const curDate = this.moment(new Date())

      const diffDay = curDate.diff(dateFormat, 'days')

      if (diffDay < 8) return '#8BC34A' // green
      else if (diffDay < 10) return '#FFEB3B' // yellow
      else return '#F44336' // red
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
