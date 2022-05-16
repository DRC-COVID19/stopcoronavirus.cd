<template>
 <div class="px-5">
    <b-container fluid class="px-3 mt-4">
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

      <CompletedFormList
        :hospitalId="user.hospital.id"
        :showHospitalFilter="false"
        :showUserFilter="false"
        :showDateFilter="false"
      />
    </b-container>
    <ManagerUserName id="nameModal" />
  </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex'
import ManagerUserName from '../../components/hospital/ManagerUserName'
import CompletedFormList from '../../components/completedForm/CompletedFormList'

export default {
  components: {
    ManagerUserName,
    CompletedFormList
  },
  data () {
    return {
      alertVariant: 'secondary'
    }
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
      hospitalManagerName: (state) => state.hospital.hospitalManagerName,
      hospitalManagerFirstName: (state) => state.hospital.hospitalManagerFirstName,
      isLoading: (state) => state.hospital.isLoading
    })
  },
  mounted () {
    if (!this.hospitalManagerName) {
      this.$bvModal.show('nameModal')
    }
    this.$store.commit('SET_COMPLETED_FORMS', { isLoading: true })
  },
  methods: {
    ...mapMutations(['setDetailHospital', 'setHospitalManagerName'])
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
