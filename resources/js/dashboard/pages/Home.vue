<template>
  <div>
    <b-container fluid class="dash-home-page" ref="dash_home_page" id="dash_home_page">
      <Header />
      <b-row class="mt-2 top-menu">
        <b-col>
          <MenuFlux
            v-if="activeMenu==1"
            @submitFluxForm="submitFluxForm"
            @populationFluxChecked="populationFluxChecked"
            @flux::predefined::changed="fluxPredefinedChanged"
            :fluxZones="fluxZones"
            :fluxProvinces="fluxProvinces"
            :flux24Errors="flux24Errors"
          />
          <MenuEpidemology
            v-if="activeMenu==2"
            @covidCaseChecked="getCovidCases"
            :covidCasesCount="covidCasesCount"
          />
          <MenuInfrastructure
            v-if="activeMenu==5"
            :hospitalCount="hospitalCount"
            @hopitalChecked="gethopitals"
          />
          <MenuOrientation
            v-if="activeMenu==6"
            @medicalOrientationChecked="getmedicalOrientations"
            @medicalOrientationChanged="medicalOrientationChanged"
            :orientationCount="orientationCount"
            :finCount="finCount"
            :fin5Count="fin5Count"
            :fin8Count="fin8Count"
          />
        </b-col>
      </b-row>
      <b-row class="position-relative map-wrap">
        <!--   <LeftColumn
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
        />-->
        <b-col cols="12" :class="`${hasRightSide?'col-md-6':'col-md-12'}`">
          <div class="layer-set-contenair" v-if="hasFlux24Daily">
            <b-link :class="{'active':fluxMapStyle==2}" @click="layerSetSyle(2)">Arc</b-link>
            <b-link :class="{'active':fluxMapStyle==1}" @click="layerSetSyle(1)">Hachurés</b-link>
          </div>
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
              :flux24Presence="flux24Presence"
            />
          </b-row>
        </b-col>
        <b-col
          cols="12"
          md="6"
          class="side-right mt-2 pl-2"
          :class="{'side-right-100':!hasCovidCases}"
          v-if="hasRightSide"
        >
          <b-card no-body>
            <b-tabs pills card>
              <b-tab title="Covid-19 data" v-if="!!covidCases" :active="!!covidCases">
                <SideCaseCovid :covidCases="covidCases" />
              </b-tab>
              <b-tab title="FLux chart" v-if="hasFlux24DailyIn" :active="hasFlux24DailyIn">
                <FluxChart
                  :flux24Daily="flux24Daily"
                  :flux24DailyIn="flux24DailyIn"
                  :flux24DailyOut="flux24DailyOut"
                  :flux24Presence="flux24Presence"
                  :flux24PresenceDailyIn="flux24PresenceDailyIn"
                />
              </b-tab>
              <b-tab title="Hôpital" v-if="!!selectedHospital" :active="!!selectedHospital">
                <HospitalSituation />
              </b-tab>
            </b-tabs>
          </b-card>
        </b-col>
      </b-row>
      <b-row
        class="row-side-bottom mt-2 mb-2"
        v-if="hasCovidCases||hasFlux24Daily||hasflux24DailyComparison"
      >
        <b-col class="side-bottom" cols="12">
          <b-card no-body>
            <b-tabs pills card>
              <b-tab title="Covid-19 chart" v-if="hasCovidCases" :active="hasCovidCases">
                <CovidCaseChart
                  :covidCasesStat="covidCasesStat"
                  :covidCasesStatDaily="covidCasesStatDaily"
                />
              </b-tab>
              <b-tab title="Flux tendance" v-if="hasFlux24Daily" :active="hasFlux24Daily">
                <FluxTendanceChart :flux24Daily="flux24Daily" />
              </b-tab>
              <b-tab
                title="Flux comparaison"
                v-if="hasflux24DailyComparison"
                :active="hasflux24DailyComparison"
              >
                <FluxComparisonChart
                  :fluxGeoOptions="fluxGeoOptions"
                  :flux24DailyComparison="flux24DailyComparison"
                />
              </b-tab>
            </b-tabs>
          </b-card>
        </b-col>
      </b-row>
      <Waiting v-if="isLoading" />
    </b-container>
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
import FluxTendanceChart from "../components/flux/TendanceChart";
import FluxComparisonChart from "../components/flux/ComparisonChart";
import MenuFlux from "../components/menu/Flux";
import MenuEpidemology from "../components/menu/Epidemiology";
import MenuInfrastructure from "../components/menu/Infrastructure";
import MenuOrientation from "../components/menu/Orientation";

import { mapState, mapActions, mapMutations } from "vuex";

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
    HospitalSituation,
    FluxTendanceChart,
    FluxComparisonChart,
    MenuFlux,
    MenuEpidemology,
    MenuInfrastructure,
    MenuOrientation
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
      flux24Presence: [],
      flux24Errors: {},
      flux24Daily: [],
      flux24DailyComparison: [],
      flux24DailyIn: [],
      flux24DailyOut: [],
      fluxGeoOptions: [],
      menuColunmStyle: {},
      flux24PrensenceDaily: [],
      flux24PresenceDailyIn: []
    };
  },
  computed: {
    ...mapState({
      hospitals: state => state.hospital.hospitalData,
      hospitalCount: state => state.hospital.hospitalCount,
      selectedHospital: state => state.hospital.selectedHospital,
      fluxMapStyle: state => state.flux.mapStyle,
      activeMenu: state => state.nav.activeMenu
    }),
    hasRightSide() {
      return (
        this.getHasCoviCases() ||
        this.flux24DailyIn.length > 0 ||
        !!this.selectedHospital
      );
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
    hasflux24DailyComparison() {
      return this.flux24DailyComparison.length > 0;
    },
    hasFlux24DailyIn() {
      return this.flux24DailyIn.length > 0;
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
  async mounted() {
    this.getFluxZone();
    this.getFluxProvinces();
    // await this.sleep(2000);
    // this.$nextTick(() => {
    //   console.log(this.$refs.dash_home_page);
    //   console.log(this.$refs);
    //   this.$refs.dash_home_page.addEventListener(
    //     "resize",
    //     this.LeftColumnStyle()
    //   );
    // });
  },
  // destroyed() {
  //   this.$nextTick(() => {
  //     this.$refs.dash_home_page.removeEventListener(
  //       "resize",
  //       this.LeftColumnStyle()
  //     );
  //   });
  // },
  methods: {
    ...mapActions(["userMe", "getHospitalsData"]),
    ...mapMutations(["setMapStyle"]),
    layerSetSyle(value) {
      this.setMapStyle(value);
    },
    LeftColumnStyle() {
      let height = "100vh";
      if (this.$refs.dash_home_page) {
        height = this.$refs.dash_home_page.clientHeight;
      }
      this.menuColunmStyle = {
        height: `calc(${height} - 70px)`
      };
    },
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
        this.flux24DailyComparison = [];
        this.flux24DailyIn = [];
        this.flux24DailyOut = [];
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
      if (this.isLoading) {
        return;
      }
      this.isLoading = true;
      this.flux24Errors = {};

      let url = `api/dashboard/flux/origin`;
      let urlDaily = `api/dashboard/flux/origin`;
      let urlDailyCompare = `api/dashboard/flux/origin`;
      let urlDailyIn = `api/dashboard/flux/origin`;
      let urlDailyOut = `api/dashboard/flux/origin`;

      let urlPresence = `api/dashboard/flux/origin`;
      let urlPresenceDaily = `api/dashboard/flux/origin`;
      let urlPresenceDailyIn = `api/dashboard/flux/origin`;

      switch (values.fluxGeoGranularity) {
        case 1:
          url += "/provinces";
          urlDaily += "/provinces";
          urlDailyIn += "/provinces";
          urlDailyOut += "/provinces";
          urlDailyCompare += "/provinces";
          urlPresence += "/provinces";
          urlPresenceDaily += "/provinces";
          urlPresenceDailyIn += "/provinces";
          break;
        case 2:
        default:
          url += "/zones";
          urlDaily += "/zones";
          urlDailyIn += "/zones";
          urlDailyOut += "/zones";
          urlDailyCompare += "/zones";
          urlPresence += "/zones";
          urlPresenceDaily += "/zones";
          urlPresenceDailyIn += "/zones";
          break;
      }

      urlPresence += "/presence";
      urlPresenceDaily += "/presence";
      urlPresenceDailyIn += "/presence";

      switch (values.fluxTimeGranularity) {
        case 1:
          url += "/h-24";
          urlDaily += "/h-24";
          urlDailyIn += "/h-24";
          urlDailyOut += "/h-24";
          urlDailyCompare += "/h-24";

          urlPresence += "/h-24";
          urlPresenceDaily += "/h-24";
          urlPresenceDailyIn += "/h-24";
          break;
        case 2:
        default:
          url += "/m-30";
          urlDaily += "/m-30";
          urlDailyIn += "/m-30";
          urlDailyOut += "/m-30";
          urlDailyCompare += "/m-30";

          urlPresence += "/m-30";
          urlPresenceDaily += "/m-30";
          urlPresenceDailyIn += "/m-30";
          break;
      }

      urlPresenceDaily += "/daily";
      urlPresenceDailyIn += "/daily-in";

      urlDaily += "/daily";
      urlDailyIn += "/daily-in";
      urlDailyOut += "/daily-out";
      urlDailyCompare += "/daily-compare";

      this.flux24DailyComparison = [];
      this.fluxGeoOptions = [];
      axios
        .get(urlDailyCompare, {
          params: values
        })
        .then(({ data }) => {
          this.flux24DailyComparison = data;
          this.fluxGeoOptions = values.fluxGeoOptions;
        })
        .catch(({ response }) => {});

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

      this.flux24Presence = [];
      axios
        .get(urlPresence, {
          params: values
        })
        .then(({ data }) => {
          this.flux24Presence = data;
        })
        .catch(({ response }) => {});

      this.flux24PrensenceDaily = [];
      axios
        .get(urlPresenceDaily, {
          params: values
        })
        .then(({ data }) => {
          this.flux24PrensenceDaily = data;
        })
        .catch(({ response }) => {});

      this.flux24PresenceDailyIn = [];
      axios
        .get(urlPresenceDailyIn, {
          params: values
        })
        .then(({ data }) => {
          this.flux24PresenceDailyIn = data;
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
      if (!value) {
        this.flux24Daily = [];
        this.flux24 = [];
        this.flux24DailyComparison = [];
        this.flux24DailyIn = [];
        this.flux24DailyOut = [];
        return;
      }
      const values = {
        option: value,
        preference_start,
        preference_end
      };
      this.isLoading = true;
      this.flux24Errors = {};

      const url = `api/dashboard/flux/predefined/zones/h-24/`;
      const urlDaily = `api/dashboard/flux/predefined/zones/h-24/daily`;
      const urlDailyIn = `api/dashboard/flux/predefined/zones/h-24/daily-in`;
      const urlDailyOut = `api/dashboard/flux/predefined/zones/h-24/daily-out`;
      const urlDailyCompare = `api/dashboard/flux/predefined/zones/h-24/daily-compare`;

      this.flux24DailyComparison = [];
      axios
        .get(urlDailyCompare, {
          params: values
        })
        .then(({ data }) => {
          this.flux24DailyComparison = data;
        })
        .catch(({ response }) => {});

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
      // axios
      //   .get(urlDailyIn, {
      //     params: values
      //   })
      //   .then(({ data }) => {
      //     this.flux24DailyIn = data;
      //   })
      //   .catch(({ response }) => {});

      // get flux data out

      this.flux24DailyOut = [];
      // axios
      //   .get(urlDailyOut, {
      //     params: values
      //   })
      //   .then(({ data }) => {
      //     this.flux24DailyOut = data;
      //   })
      //   .catch(({ response }) => {});

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
  height: 100%;
  transition: 500ms all ease;
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
.layer-set-contenair {
  background: #f4f6fc;
  position: absolute;
  z-index: 7;
  top: 14px;
  padding: 1px;
  a {
    display: inline-block;
    width: 85px;
    padding: 5px;
    text-align: center;
    text-decoration: unset;
    background: #2e5bff3d;
    color: #2e5bff !important;
    &.active {
      background: $dash-green;
      color: white !important;
    }
  }
}
</style>