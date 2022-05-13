<template>
  <div class="px-5">
    <b-container fluid class="px-3 mt-4">
      <b-row>
        <b-col cols="12" class="mb-3">
          <b-link :to="{
            name:'hospital.admin'
          }">
            <span class="fa fa-chevron-left"> Retour</span>
          </b-link>
        </b-col>
        <b-col v-if="hospital">
          <h3>
             Historique mise à jour : {{ hospital.name }}
          </h3>
        </b-col>
      </b-row>

      <CompletedFormList
        :hospitalId="$route.params.hospital_id"
        :showNewAction="false"
      />
    </b-container>
  </div>
</template>

<script>
import CompletedFormList from '../../components/completedForm/CompletedFormList'
import { mapState, mapActions } from 'vuex'
export default {
  components: {
    CompletedFormList
  },
  data () {
    return {
      completedForms: {},
      isLoading: false
    }
  },
  computed: {
    ...mapState({
      hospital: (state) => state.hospital.hospitalData
    })
  },
  async mounted () {
    await this.getHospital({ hospital_id: this.$route.params.hospital_id })
  },
  methods: {
    ...mapActions(['getHospital'])
  }
}
</script>

<style>
</style>
