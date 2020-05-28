<template>
  <div>
    <b-container fluid>
      <b-row class="header">
        <b-col cols="12" md="6" class="map-form-header">
          <h1 class="mb-0">Dashboard COVID-19</h1>
        </b-col>
        <b-col cols="12" md="6" class="map-form-logo d-flex justify-content-end">
          <img src="/img/partners_top.png" width="100" class="img-fluid" alt />
          <img src="/img/commite_riposte.jpg" width="100" class="img-fluid" alt />
        </b-col>
      </b-row>
      <b-row align-h="end" class="position-relative">
        <LeftColumn @covidCaseChecked="getCovidCases" />
        <b-col cols="12" md="9">
          <b-row class="map-container">
            <Maps :covidCases="covidCases" />
          </b-row>
          <b-row class="chart-container"></b-row>
        </b-col>
      </b-row>
    </b-container>
    <Waiting v-if="isLoading" />
  </div>
</template>

<script>
import Maps from "../components/Maps";
import LeftColumn from "../components/LeftColumn";
import Waiting from "../components/Waiting";
export default {
  components: {
    Maps,
    LeftColumn,
    Waiting
  },
  data() {
    return {
      isLoading: false,
      covidCases: null
    };
  },
  methods: {
    getCovidCases(checked) {
      this.isLoading = true;
      if (checked) {
        axios
          .get(`/api/dashboard/cavid-cases`)
          .then(({ data }) => {
            let Features = data.map(value => {
              return {
                type: "Feature",
                geometry: {
                  type: "Point",
                  coordinates: [value.longitude, value.latitude]
                },
                properties: {
                  confirmed: value.confirmed,
                  color: "#ED5F68"
                }
              };
            });
            this.covidCases = {
              type: "geojson",
              data: {
                type: "FeatureCollection",
                features: Features
              }
            };
            this.isLoading = false;
          })
          .catch(response => {
            console.log(response);
            this.isLoading = false;
          });
      } else {
        this.covidCases = null;
      }
    }
  }
};
</script>
<style lang="scss" scoped>
.header {
  padding: 12px 24px;
  border-bottom: 1px solid #ddd;
  h1 {
    font-size: 20px;
    font-weight: 600;
    line-height: 24px;
  }
}
.map-container {
  height: 80vh;
}
.chart-container {
  height: 20vh;
}
</style>