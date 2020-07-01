<template>
  <div>
    <b-container fluid class="dash-home-page">
      <Header />
      <b-row class="position-relative">
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
          @flux::predefined::changed="fluxPredefinedChanged"
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
        <b-col cols="12" offset-md="3" :class="`${hasRightSide?'col-md-5':'col-md-9'}`">
          <!--  <b-button
            v-if="hasFlux24||hasCovidCases||hasOrientation"
            variant="success"
            @click="seeSide"
            class="btn-see-side"
          >
            <span class="fa fa-table"></span> voir
          </b-button>-->
          <b-row class="map-container" :class="{'map-container-100':!hasCovidCases}">
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
        <b-col cols="12" md="4" class="side-right mt-2 pl-2" :class="{'side-right-100':!hasCovidCases}" v-if="hasRightSide">
          <b-card no-body>
            <b-tabs pills card>
              <b-tab title="Covid-19 data" v-if="!!covidCases" :active="!!covidCases">
                <SideCaseCovid :covidCases="covidCases" />
              </b-tab>
              <b-tab title="FLux chart" v-if="hasFlux24Daily" :active="hasFlux24Daily">
                <FluxChart
                  :flux24Daily="flux24Daily"
                  :flux24DailyIn="flux24DailyIn"
                  :flux24DailyOut="flux24DailyOut"
                />
              </b-tab>
              <b-tab title="Hôpital" v-if="!!selectedHospital" :active="!!selectedHospital">
                <HospitalSituation />
              </b-tab>
            </b-tabs>
          </b-card>
        </b-col>
      </b-row>
      <b-row class="side-bottom" no-gutters v-if="hasCovidCases">
        <b-col cols="12" md="9" offset-md="3">
          <b-card no-body>
            <b-tabs pills card>
              <b-tab title="Covid-19 chart" v-if="hasCovidCases" :active="hasCovidCases">
                <CovidCaseChart
                  :covidCasesStat="covidCasesStat"
                  :covidCasesStatDaily="covidCasesStatDaily"
                />
              </b-tab>
            </b-tabs>
          </b-card>
        </b-col>
      </b-row>
    </b-container>
    <Waiting v-if="isLoading" />

    <!--  <DataModal
      :flux24="flux24WithoutReference"
      :flux24Daily="flux24Daily"
      :flux24DailyOut="flux24DailyOut"
      :flux24DailyIn="flux24DailyIn"
      :covidCases="covidCases"
      :covidCasesStat="covidCasesStat"
      :covidCasesStatDaily="covidCasesStatDaily"
      :medicalOrientations="medicalOrientations"
      :medicalOrientationsStat="medicalOrientationsStat"
      id="data-modal"
    />-->
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
import DataModal from "../components/DataModal";
import SideFluxChart from "../components/SideFlux";
import FluxChart from "../components/FluxChart";
import Header from "../components/Header";
import HospitalSituation from "../components/HospitalSituation";

import { mapState, mapActions } from "vuex";

const preference_start = "2020-02-01";
const preference_end = "2020-03-18";
export default {
  components: {
    Maps,
    LeftColumn,
    Waiting,
    SideCaseCovid,
    CovidCaseChart,
    OrientationChart,
    SideOrientation,
    DataModal,
    SideFluxChart,
    FluxChart,
    Header,
    HospitalSituation
  },
  data() {
    return {
      isLoading: false,
      covidCases: null,
      covidCasesStat: null,
      covidCasesStatDaily: null,
      covidCasesCount: null,
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
      fluxProvinces: [],
      flux24: [],
      flux24Errors: {},
      flux24Daily: [],
      flux24DailyIn: [],
      flux24DailyOut: []
    };
  },
  computed: {
    ...mapState({
      hospitals: state => state.hospital.hospitalData,
      hospitalCount: state => state.hospital.hospitalCount,
      selectedHospital: state => state.hospital.selectedHospital
    }),
    hasRightSide() {
      return this.getHasCoviCases() || this.flux24Daily.length > 0 || !!this.selectedHospital;
    },
    hasCovidCases() {
      return this.getHasCoviCases();
    },
    hasOrientation() {
      return this.getHasOrientation();
    },
    hasFlux24() {
      return this.flux24.length > 0;
    },
    hasFlux24Daily() {
      return this.flux24Daily.length > 0;
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
    ...mapActions(["userMe", "getHospitalsData"]),
    getHasCoviCases() {
      return this.covidCases && this.covidCases.data.features.length > 0;
    },
    getHasOrientation() {
      return this.medicalOrientations && this.medicalOrientations.length > 0;
    },
    gethopitals(checked) {
      this.getHospitalsData(checked);
    },
    getCovidCases(checked) {
      this.isLoading = true;
      if (checked) {
        let confirmedCount = 0;

        axios
          .get("/api/dashboard/cavid-cases/statistics")
          .then(({ data }) => {
            let labels = [],
              sick = [],
              confirmed = [],
              dead = [],
              healed = [];
            data.map(function(d) {
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
          .catch(response => {});

        axios
          .get("/api/dashboard/cavid-cases/statistics/daily")
          .then(({ data }) => {
            let labels = [],
              sick = [],
              confirmed = [],
              dead = [],
              healed = [];
            data.map(function(d) {
              confirmed.push(d.confirmed);
              dead.push(d.dead);
              healed.push(d.healed);
              labels.push(d.last_update);
            });
            this.covidCasesStatDaily = {
              confirmed,
              dead,
              healed,
              labels
            };
          })
          .catch(response => {});

        axios
          .get(`/api/dashboard/cavid-cases`)
          .then(({ data }) => {
            let Features = data.map(value => {
              confirmedCount += Number(value.confirmed);
              return {
                type: "Feature",
                geometry: {
                  type: "Point",
                  coordinates: [value.longitude, value.latitude]
                },
                properties: {
                  name: value.name,
                  confirmed: Number(value.confirmed ?? 0),
                  healed: Number(value.healed ?? 0),
                  dead: Number(value.dead ?? 0),
                  sick: Number(value.sick ?? 0),
                  last_update: value.last_update,
                  seriously: Number(value.seriously ?? 0),
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
      } else {
        this.covidCases = null;
        this.covidCasesStat = null;
        this.covidCasesCount = null;
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

      let url = `api/dashboard/flux/origin`;
      let urlDaily = `api/dashboard/flux/origin`;
      let urlDailyIn = `api/dashboard/flux/origin`;
      let urlDailyOut = `api/dashboard/flux/origin`;

      switch (values.fluxGeoGranularity) {
        case 1:
          url += "/provinces";
          urlDaily += "/provinces";
          urlDailyIn += "/provinces";
          urlDailyOut += "/provinces";
          break;
        case 2:
        default:
          url += "/zones";
          urlDaily += "/zones";
          urlDailyIn += "/zones";
          urlDailyOut += "/zones";
          break;
      }

      switch (values.fluxTimeGranularity) {
        case 1:
          url += "/h-24";
          urlDaily += "/h-24";
          urlDailyIn += "/h-24";
          urlDailyOut += "/h-24";
          break;
        case 2:
        default:
          url += "/m-30";
          urlDaily += "/m-30";
          urlDailyIn += "/m-30";
          urlDailyOut += "/m-30";
          break;
      }

      urlDaily += "/daily";
      urlDailyIn += "/daily-in";
      urlDailyOut += "/daily-out";

      this.flux24Daily = [];
      axios
        .get(urlDaily, {
          params: values
        })
        .then(({ data }) => {
          this.flux24Daily = data;
        })
        .catch(({ response }) => {});

      // get flux data in

      this.flux24DailyIn = [];
      axios
        .get(urlDailyIn, {
          params: values
        })
        .then(({ data }) => {
          this.flux24DailyIn = data;
        })
        .catch(({ response }) => {});

      // get flux data out

      this.flux24DailyOut = [];
      axios
        .get(urlDailyOut, {
          params: values
        })
        .then(({ data }) => {
          this.flux24DailyOut = data;
        })
        .catch(({ response }) => {});

      this.flux24 = [];
      axios
        .get(url, {
          params: values
        })
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
    },
    fluxPredefinedChanged(value) {
      const values = {
        option: value,
        preference_start,
        preference_end
      };
      this.isLoading = true;
      this.flux24Errors = {};

      let url = `api/dashboard/flux/predefined/zones/h-24/`;
      let urlDaily = `api/dashboard/flux/predefined/zones/h-24/daily`;
      let urlDailyIn = `api/dashboard/flux/predefined/zones/h-24/daily-in`;
      let urlDailyOut = `api/dashboard/flux/predefined/zones/h-24/daily-out`;

      this.flux24Daily = [];
      axios
        .get(urlDaily, {
          params: values
        })
        .then(({ data }) => {
          this.flux24Daily = data;
        })
        .catch(({ response }) => {});

      // get flux data in

      this.flux24DailyIn = [];
      axios
        .get(urlDailyIn, {
          params: values
        })
        .then(({ data }) => {
          this.flux24DailyIn = data;
        })
        .catch(({ response }) => {});

      // get flux data out

      this.flux24DailyOut = [];
      axios
        .get(urlDailyOut, {
          params: values
        })
        .then(({ data }) => {
          this.flux24DailyOut = data;
        })
        .catch(({ response }) => {});

      this.flux24 = [];
      axios
        .get(url, {
          params: values
        })
        .then(({ data }) => {
          this.flux24 = data;
          this.isLoading = false;
        })
        .catch(({ response }) => {
          this.flux24Errors = response.data.errors;
          this.isLoading = false;
        });
    }
  }
};
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";
.dash-home-page {
  // height: 100vh;
  background: $dash-background;
  .side-bottom {
    // height: calc(20vh - 72.5px);
  }
}

.map-container {
  padding: 10px 10px 10px 10px;
  height: calc(80vh - 56px);
  transition: 500ms all ease;
}
.map-container-100,.side-right-100 {
  height: calc(100vh - 56px);
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