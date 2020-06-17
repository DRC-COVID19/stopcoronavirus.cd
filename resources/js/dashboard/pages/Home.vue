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
          @priceIncreaseChecked="priceIncreaseChecked"
          @maskChecked="maskChecked"
          @makalaChecked="makalaChecked"
          @flourChecked="flourChecked"
          @antiBacterialGelChecked="antiBacterialGelChecked"
          @submitFluxForm="submitFluxForm"
          @populationFluxChecked="populationFluxChecked"
          :covidCasesCount="covidCasesCount"
          :hospitalCount="hospitalCount"
          :orientationCount="orientationCount"
          :finCount="finCount"
          :fin5Count="fin5Count"
          :fin8Count="fin8Count"
          :fluxZones="fluxZones"
          :fluxProvinces="fluxProvinces"
          :flux24Errors="flux24Errors"
        />
        <b-col cols="12" md="9">
          <b-button
            v-if="hasFlux24||hasCovidCases||hasOrientation"
            variant="success"
            @click="seeSide"
            class="btn-see-side"
          >
            <span class="fa fa-table"></span> voir
          </b-button>
          <b-row class="map-container">
            <Maps
              :covidCases="covidCases"
              :hospitals="hospitals"
              :medicalOrientations="medicalOrientations"
              :medicalOrientationSelected="medicalOrientationSelected"
              :sondages="sondages"
              :worried="worried"
              :catchVirus="catchVirus"
              :priceIncrease="priceIncrease"
              :mask="mask"
              :makala="makala"
              :flour="flour"
              :antiBacterialGel="antiBacterialGel"
              :flux24="flux24"
            />
          </b-row>
        </b-col>
      </b-row>
    </b-container>
    <Waiting v-if="isLoading" />

    <DataModal
      :flux24="flux24WithoutReference"
      :flux24Daily="flux24Daily"
      :flux24DailyOut="flux24DailyOut"
      :flux24DailyIn="flux24DailyIn"
      :covidCases="covidCases"
      :covidCasesStat="covidCasesStat"
      :medicalOrientations="medicalOrientations"
      :medicalOrientationsStat="medicalOrientationsStat"
      id="data-modal"
    />
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
import SideFluxChart from "../components/SideFlux";
import DataModal from "../components/DataModal";
export default {
  components: {
    Maps,
    LeftColumn,
    Waiting,
    SideCaseCovid,
    CovidCaseChart,
    OrientationChart,
    SideOrientation,
    DataModal
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
      worried: false,
      catchVirus: false,
      priceIncrease: false,
      mask: false,
      makala: false,
      flour: false,
      antiBacterialGel: false,
      fluxZones: [],
      fluxProvinces:[],
      flux24: [],
      flux24Errors: {},
      flux24Daily: [],
      flux24DailyIn: [],
      flux24DailyOut: []
    };
  },
  computed: {
    hasCovidCases() {
      return this.getHasCoviCases();
    },
    hasOrientation() {
      return this.getHasOrientation();
    },
    hasFlux24() {
      return this.flux24.length > 0;
    },
    flux24WithoutReference() {
      return this.flux24.filter(x => !x.isReference);
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
  mounted() {
    this.getFluxZone();
    this.getFluxProvinces();
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
        this.orientationCount = null;
        this.isLoading = false;
      }
    },
    medicalOrientationChanged(item) {
      this.medicalOrientationSelected = item;
    },
    hasSondageChecked(checked) {
      if (checked) {
        this.isLoading = true;
        axios.get(`/api/dashboard/sondages`).then(({ data }) => {
          this.isLoading = false;
          this.sondages = data;
        });
      } else {
        this.sondages = null;
      }
    },
    worriedChecked(checked) {
      this.worried = checked;
    },
    catchVirusChecked(checked) {
      this.catchVirus = checked;
    },
    priceIncreaseChecked(checked) {
      this.priceIncrease = checked;
    },
    maskChecked(checked) {
      this.mask = checked;
    },
    makalaChecked(checked) {
      this.makala = checked;
    },
    flourChecked(checked) {
      this.flour = checked;
    },
    antiBacterialGelChecked(checked) {
      this.antiBacterialGel = checked;
    },
    populationFluxChecked(checked) {
      if (!checked) {
        this.flux24Daily = [];
        this.flux24 = [];
      }
    },
    getFluxZone() {
      axios.get("api/dashboard/flux-zone").then(({ data }) => {
        this.fluxZones = data;
      });
    },
    getFluxProvinces() {
      axios.get("api/dashboard/flux-provinces").then(({ data }) => {
        this.fluxProvinces = data;
      });
    },
    submitFluxForm(values) {
      this.isLoading = true;
      this.flux24Errors = {};

      let urlDaily = `api/dashboard/flux-24-origin-daily`;
      let urlDailyIn = `api/dashboard/flux-24-origin-daily-in`;
      let urlDailyOut = `api/dashboard/flux-24-origin-daily-out`;
      let url = `api/dashboard/flux-24-origin`;
      
      switch (values.filter) {
        case 'filter_2':
          urlDaily = `api/dashboard/flux-24-daily`;
          url = `api/dashboard/flux-24`;
          break;
        case 'filter_3':
          urlDaily = `api/dashboard/flux-24-origin-daily-provinces`;
          urlDailyIn = `api/dashboard/flux-24-origin-daily-in-provinces`;
          urlDailyOut = `api/dashboard/flux-24-origin-daily-out-provinces`;
          url = `api/dashboard/flux-24-origin-provinces`;
        default:
          break;
      }

      this.flux24Daily = [];
      axios
        .post(urlDaily, values)
        .then(({ data }) => {
          this.flux24Daily = data;
        })
        .catch(({ response }) => {});

      // get flux data in
      
      
      this.flux24DailyIn = [];
      axios
        .post(urlDailyIn, values)
        .then(({ data }) => {
          this.flux24DailyIn = data;
        })
        .catch(({ response }) => {});

      // get flux data out

      
      this.flux24DailyOut = [];
      axios
        .post(urlDailyOut, values)
        .then(({ data }) => {
          this.flux24DailyOut = data;
        })
        .catch(({ response }) => {});




      
      this.flux24 = [];
      axios
        .post(url, values)
        .then(({ data }) => {
          this.flux24 = data;
          this.isLoading = false;
        })
        .catch(({ response }) => {
          this.flux24Errors = response.data.errors;
          this.isLoading = false;
        });
    },
    seeSide() {
      this.$bvModal.show("data-modal");
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
  height: calc(100vh - 52.5px);
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
.btn-see-side {
  position: absolute;
  z-index: 7;
  top: 10px;
}
</style>