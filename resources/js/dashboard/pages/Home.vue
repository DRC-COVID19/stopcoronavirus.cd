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
        <LeftColumn
          @covidCaseChecked="getCovidCases"
          @hopitalChecked="gethopitals"
          @medicalOrientationChecked="getmedicalOrientations"
          @medicalOrientationChanged="medicalOrientationChanged"
          @hasSondageChecked="hasSondageChecked"
          @worriedChecked="worriedChecked"
          @catchVirusChecked="catchVirusChecked"
          :covidCasesCount="covidCasesCount"
          :hospitalCount="hospitalCount"
          :orientationCount="orientationCount"
          :finCount="finCount"
          :fin5Count="fin5Count"
          :fin8Count="fin8Count"
        />

        <b-tabs
          content-class="mt-3"
          v-if="hasCovidCases || hasOrientation"
          class="cols-12 col-md-3 offset-md-3 side-case-covid"
        >
          <b-tab title="Cas covid " v-if="hasCovidCases" :active="hasCovidCases">
            <SideCaseCovid :covidCases="covidCases" />
          </b-tab>
          <b-tab title="Orientation" v-if="hasOrientation" :active="hasOrientation">
            <SideOrientation :medicalOrientations="medicalOrientations" />
          </b-tab>
        </b-tabs>

        <b-col cols="12" md="9">
          <b-row class="map-container" :style="mapStyle">
            <Maps
              :covidCases="covidCases"
              :hospitals="hospitals"
              :medicalOrientations="medicalOrientations"
              :medicalOrientationSelected="medicalOrientationSelected"
              :sondages="sondages"
              :worried="worried"
              :catchVirus="catchVirus"
            />
          </b-row>
          <div class="chart-container" v-if="hasCovidCases || hasOrientation">
            <b-col>
              <b-tabs content-class="mt-3">
                <b-tab title="Cas covid " v-if="hasCovidCases" :active="hasCovidCases">
                  <CovidCaseChart :covidCasesStat="covidCasesStat" />
                </b-tab>
                <b-tab title="Orientation" v-if="hasOrientation" :active="hasOrientation">
                  <OrientationChart :medicalOrientationsStat="medicalOrientationsStat" />
                </b-tab>
              </b-tabs>
            </b-col>
          </div>
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
import SideCaseCovid from "../components/SideCaseCovid";
import CovidCaseChart from "../components/CovidCaseChart";
import OrientationChart from "../components/OrientationChart";
import SideOrientation from "../components/SideOrientation";
export default {
  components: {
    Maps,
    LeftColumn,
    Waiting,
    SideCaseCovid,
    CovidCaseChart,
    OrientationChart,
    SideOrientation
  },
  data() {
    return {
      isLoading: false,
      covidCases: null,
      covidCasesStat: null,
      covidCasesCount: null,
      hospitals: null,
      hospitalCount: null,
      medicalOrientations: null,
      medicalOrientationSelected: null,
      medicalOrientationsStat: null,
      orientationCount: null,
      finCount: null,
      fin5Count: null,
      fin8Count: null,
      sondages: null,
      worried: false
    };
  },
  computed: {
    hasCovidCases() {
      return this.getHasCoviCases();
    },
    hasOrientation() {
      return this.getHasOrientation();
    },
    mapStyle() {
      return {
        height:
          this.getHasCoviCases() || this.getHasOrientation()
            ? `64vh`
            : `calc(100vh - 52.5px)`
      };
    }
  },
  methods: {
    getHasCoviCases() {
      return this.covidCases && this.covidCases.data.features.length > 0;
    },
    getHasOrientation() {
      return this.medicalOrientations && this.medicalOrientations.length > 0;
    },
    gethopitals(checked) {
      this.isLoading = true;
      if (checked) {
        axios
          .get(`/api/dashboard/hospitals`)
          .then(({ data }) => {
            let Features = data.map((value, index) => {
              return {
                type: "Feature",
                geometry: {
                  type: "Point",
                  coordinates: [value.longitude, value.latitude]
                },
                properties: {
                  name: value.name ? value.name : "Hopital",
                  address: value.address,
                  beds: value.beds,
                  occupied_beds: value.occupied_beds,
                  masks: value.masks,
                  respirators: value.respirators,
                  occupied_respirators: value.occupied_respirators,
                  confirmed: value.last_situation
                    ? value.last_situation.confirmed
                    : 0,
                  dead: value.last_situation ? value.last_situation.dead : 0,
                  sick: value.last_situation ? value.last_situation.sick : 0,
                  healed: value.last_situation
                    ? value.last_situation.healed
                    : 0,
                  last_update: value.last_situation
                    ? value.last_situation.last_update
                    : 0,
                  color: "#ED5F68"
                }
              };
            });
            this.hospitals = {
              type: "geojson",
              data: {
                type: "FeatureCollection",
                features: Features
              }
            };
            this.hospitalCount = data.length;
            this.isLoading = false;
          })
          .catch(() => {
            this.isLoading = false;
          });
      } else {
        this.hospitals = null;
        this.hospitalCount = null;
        this.isLoading = false;
      }
    },
    getCovidCases(checked) {
      this.isLoading = true;
      if (checked) {
        let confirmedCount = 0;
        axios
          .get(`/api/dashboard/cavid-cases`)
          .then(({ data }) => {
            let Features = data.map(value => {
              confirmedCount += value.confirmed;
              return {
                type: "Feature",
                geometry: {
                  type: "Point",
                  coordinates: [value.longitude, value.latitude]
                },
                properties: {
                  name: value.name,
                  confirmed: value.confirmed ?? 0,
                  healed: value.healed ?? 0,
                  dead: value.dead ?? 0,
                  sick: value.sick ?? 0,
                  last_update: value.last_update,
                  seriously: value.seriously ?? 0,
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
            this.covidCasesCount = confirmedCount;
          })
          .catch(response => {
            this.isLoading = false;
          });
        axios
          .get("/api/pandemicstatsasc")
          .then(({ data }) => {
            let labels = [],
              sick = [],
              confirmed = [],
              dead = [],
              healed = [];
            data.data.map(function(d) {
              confirmed.push(d.confirmed);
              dead.push(d.dead);
              healed.push(d.healed);
              labels.push(d.last_update);
            });
            this.covidCasesStat = {
              confirmed,
              dead,
              healed,
              labels
            };
          })
          .catch(response => {
            this.isLoading = false;
          });
      } else {
        this.covidCases = null;
        this.covidCasesStat = null;
        this.isLoading = false;
      }
    },
    getmedicalOrientations(checked) {
      this.isLoading = true;
      if (checked) {
        axios
          .get(`/api/dashboard/orientation-medical-result`)
          .then(({ data }) => {
            this.medicalOrientations = data;
            let total_fin = 0;
            let total_fin5 = 0;
            let total_fin8 = 0;
            data.map(item => {
              total_fin += item.FIN ?? 0;
              total_fin5 += item.FIN5 ?? 0;
              total_fin8 += item.FIN8 ?? 0;
            });
            this.finCount = total_fin;
            this.fin5Count = total_fin5;
            this.fin8Count = total_fin8;
            this.isLoading = false;
            this.orientationCount = total_fin + total_fin8 + total_fin5;
          })
          .catch(() => {
            this.isLoading = false;
            this.orientationCount = null;
          });
        axios
          .get(`/api/dashboard/orientation-medical-stats`)
          .then(({ data }) => {
            let fin = [],
              fin5 = [],
              fin8 = [],
              labels = [];
            data.map(item => {
              fin.push(item.FIN);
              fin5.push(item.FIN5);
              fin8.push(item.FIN8);
              labels.push(item.created_at);
            });
            this.medicalOrientationsStat = {
              fin,
              fin5,
              fin8,
              labels
            };
          });
      } else {
        this.medicalOrientations = null;
        this.isLoading = false;
      }
    },
    medicalOrientationChanged(item) {
      this.medicalOrientationSelected = item;
    },
    hasSondageChecked(checked) {
      this.isLoading = true;
      axios.get(`/api/dashboard/sondages`).then(({ data }) => {
        this.isLoading = false;
        this.sondages = data;
      });
    },
    worriedChecked(checked) {
      this.worried = checked;
    },
    catchVirusChecked(checked){
      this.catchVirus=checked;
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
  height: 60vh;
}
.chart-container {
  height: calc(40vh - 52.5px);
  border-top: 1px solid rgba(0, 0, 0, 0.125);
  position: absolute;
  z-index: 6;
  left: 0;
  right: 0;
}
.side-case-covid {
  position: absolute;
  left: 0;
  z-index: 5;
  top: 15px;
  bottom: 15px;
}
</style>