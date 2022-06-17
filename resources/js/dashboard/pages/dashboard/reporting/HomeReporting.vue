<template>
  <b-container fluid class="px-0 mx-0 containerReporting h-100">
    <b-row class="mx-0 px-0 w-100" lg="12">
      <HeaderReporting
        :forms="forms"
        :hospitals="hospitals"
        class="d-flex justify-content-center bg-white py-3 w-100"
      />
      <b-row>
        <div class="d-flex justify-content-between">
          <apexchart
            width="800"
            type="bar"
            :options="options"
            :series="series"
          ></apexchart>
          <apexchart
            width="800"
            type="bar"
            :options="options"
            :series="series"
          ></apexchart>
        </div>
        <div class="d-flex"></div>
      </b-row>
    </b-row>
    <b-row> </b-row>
    <div>Bonjour</div>
    <div>{{  }}</div>
  </b-container>
</template>
<script>
import { mapState, mapActions, mapMutations } from 'vuex'
import HeaderReporting from './components/HeaderReporting'
export default {
  name: 'Reporting',
  components: {
    HeaderReporting
  },

  data () {
    return {
      options: {
        chart: {
          id: 'vuechart-example'
        },
        xaxis: {
          categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998]
        }
      },
      series: [
        {
          name: 'series-1',
          data: [30, 40, 45, 50, 49, 60, 70, 91]
        }
      ]
    }
  },
  mounted () {
    this.getForms()
    this.getHospitals()
    console.log('forms ->', this.forms)
  },
  computed: {
    ...mapState({
      forms: (state) => state.form.forms,
      hospitals: (state) => state.hospital.hospitals
    })
  },
  methods: {
    ...mapActions(['getForms', 'getHospitals'])
  }
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.containerReporting {
  background-color: #f4f6fc;
}
</style>
