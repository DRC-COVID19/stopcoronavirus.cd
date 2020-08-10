<template>
  <div>
    <b-container fluid class="dash-home-page" ref="dash_home_page" id="dash_home_page">
      <Header />
      <b-row class="mt-2 top-menu position-relative" style="z-index:8">
        <b-col>
          <MenuFlux
            v-show="activeMenu==1"
            @submitFluxForm="submitFluxForm"
            @populationFluxChecked="populationFluxChecked"
            @flux::predefined::changed="fluxPredefinedChanged"
            :fluxZones="fluxZones"
            :fluxProvinces="fluxProvinces"
            :flux24Errors="flux24Errors"
          />
          <MenuEpidemology
            v-show="activeMenu==2"
            @covidCaseChecked="getCovidCases"
            :covidCasesCount="covidCasesCount"
          />
          <MenuIndicateur
            v-if="activeMenu==3"
            :fluxZones="fluxZones"
            :fluxProvinces="fluxProvinces"
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
      <indicateur-chart v-if="activeMenu == 3"></indicateur-chart>
      <b-row class="position-relative map-wrap" v-if="activeMenu != 3">
        <b-col cols="12" :class="`${hasRightSide?'col-md-6':'col-md-12'}`">
          <div class="layer-set-contenair" v-if="hasFlux24Daily">
            <b-link :class="{'active':fluxMapStyle==2}" @click="layerSetSyle(2)">Arcs</b-link>
            <b-link :class="{'active':fluxMapStyle==1}" @click="layerSetSyle(1)">Hachurés</b-link>
          </div>
          <b-row class="map-container" :class="{'map-container-100':!hasCovidCases}">
            <div class="fullscreen-container">
              <fullscreen ref="fullscreenMap" @change="fullscreenMapChange">
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
                  :flux24DailyIn="flux24DailyIn"
                  :flux24DailyOut="flux24DailyOut"
                  :isLoading="isLoading"
                  :flux24Presence="flux24PresenceDailyIn"
                />
                <MapsLegend v-if="this.flux24DailyIn.length > 0 && activeMenu == 1"></MapsLegend>
                <MapsLegendEpidemic v-if="covidCases && activeMenu == 2"></MapsLegendEpidemic>
              </fullscreen>
              <button type="button" @click="toggleFullscreenMap" class="fullscreen-btn">
                <i class="fa fa-expand"></i>
              </button>
            </div>
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
              <b-tab title="Province">
                <b-row>
                  <b-col cols="6" class="pr-2">
                    <GlobalProvince
                      title="Mobilité entrante"
                      :color="palette.flux_in_color"
                      :globalData="fluxGlobalIn"
                      reference="fluxglobalIn"
                    />
                  </b-col>
                  <b-col cols="6" class="pl-2">
                    <GlobalProvince
                      title="Mobilité sortante"
                      :color="palette.flux_out_color"
                      :globalData="fluxGlobalOut"
                      reference="fluxglobalOut"
                    />
                  </b-col>
                </b-row>
              </b-tab>
              <b-tab title="FLux chart" v-if="hasFlux24DailyIn" :active="hasFlux24DailyIn">
                <FluxChart
                  :flux24Daily="flux24Daily"
                  :flux24DailyIn="flux24DailyIn"
                  :flux24DailyOut="flux24DailyOut"
                  :flux24Presence="flux24Presence"
                  :flux24PresenceDailyIn="flux24PresenceDailyIn"
                  :fluxZoneGlobalIn="fluxZoneGlobalIn"
                  :fluxZoneGlobalOut="fluxZoneGlobalOut"
                />
              </b-tab>
              <b-tab title="Hôpital" v-if="hospitalCount != null" :active="!!selectedHospital">
                <HospitalSituation :hospitalTotalData="hospitalTotalData" />
              </b-tab>
            </b-tabs>
          </b-card>
        </b-col>
      </b-row>
      <b-row
        class="row-side-bottom mt-2 mb-2"
        v-if="activeMenu != 3 && (hasCovidCases||hasFlux24Daily||hasflux24DailyComparison)"
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
              <b-tab title="Flux comparaison" v-if="hasflux24DailyComparison">
                <FluxComparisonChart
                  :fluxGeoOptions="fluxGeoOptions"
                  :flux24DailyComparison="flux24DailyComparison"
                />
              </b-tab>
              <b-tab title="Flux tendance" v-if="hasFlux24Daily" :active="hasFlux24Daily">
                <FluxTendanceChart :flux24Daily="flux24Daily" />
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
import MapsLegend from "../components/MapsLegend";
import MapsLegendEpidemic from "../components/MapsLegendEpidemic";
import LeftColumn from "../components/LeftColumn";
import Waiting from "../components/Waiting";
import SideCaseCovid from "../components/SideCaseCovid";
import CovidCaseChart from "../components/CovidCaseChart";
import OrientationChart from "../components/OrientationChart";
import IndicateurChart from "../components/IndicateurChart";
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
import MenuIndicateur from "../components/menu/Indicateur";
import GlobalProvince from "../components/flux/GLobalProvince";
import { OBSERVATION_START, OBSERVATION_END, PALETTE } from "../config/env";

import { mapState, mapActions, mapMutations } from "vuex";
import { difference } from "@turf/turf";

const preference_start = "2020-02-01";
const preference_end = "2020-03-18";

export default {
  components: {
    Maps,
    MapsLegend,
    MapsLegendEpidemic,
    LeftColumn,
    Waiting,
    SideCaseCovid,
    CovidCaseChart,
    OrientationChart,
    IndicateurChart,
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
    MenuOrientation,
    MenuIndicateur,
    GlobalProvince,
  },
  data() {
    return {
      loadings: {},
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
      flux24PresenceDailyIn: [],
      fluxGlobalIn: [],
      fluxGlobalOut: [],
      palette: PALETTE,
      fluxZoneGlobalIn: [],
      fluxZoneGlobalOut: [],
    };
  },
  computed: {
    ...mapState({
      hospitals: (state) => state.hospital.hospitalData,
      hospitalCount: (state) => state.hospital.hospitalCount,
      selectedHospital: (state) => state.hospital.selectedHospital,
      hospitalTotalData: (state) => state.hospital.hospitalTotalData,
      fluxMapStyle: (state) => state.flux.mapStyle,
      activeMenu: (state) => state.nav.activeMenu,
    }),
    hasRightSide() {
      return (
        this.getHasCoviCases() ||
        this.flux24DailyIn.length > 0 ||
        this.hospitalCount != null ||
        this.fluxGlobalIn.length > 0
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
      return this.flux24.filter((x) => !x.isReference);
    },
    mapStyle() {
      return {
        height:
          this.getHasCoviCases() || this.getHasOrientation()
            ? `64vh`
            : `calc(100vh - 52.5px)`,
      };
    },
    isLoading() {
      return Object.values(this.loadings).find((val) => val === true)
        ? true
        : false;
    },
  },
  mounted() {
    this.getFluxZone();
    this.getFluxProvinces();
    this.$store.watch(
      (state) => state.nav.activeMenu,
      (value) => {
        this.gethopitals(false);
        switch (value) {
          case 1:
            break;
          case 2:
          default:
            break;
        }
      }
    );
    this.$store.watch(
      (state) => state.indicator.isLoading,
      (value) => {
        this.$set(this.loadings, "indicator", value);
      }
    );
    this.loadFluxGLobalData();
  },
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
        height: `calc(${height} - 70px)`,
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
      if (checked) {
        let confirmedCount = 0;

        this.$set(this.loadings, "getCovidCases_stat", true);
        axios
          .get("/api/dashboard/cavid-cases/statistics")
          .then(({ data }) => {
            let labels = [],
              sick = [],
              confirmed = [],
              dead = [],
              healed = [];
            data.map(function (d) {
              confirmed.push(d.confirmed);
              dead.push(d.dead);
              healed.push(d.healed);
              labels.push(d.last_update);
            });
            this.covidCasesStat = {
              confirmed,
              dead,
              healed,
              labels,
            };
            this.$set(this.loadings, "getCovidCases_stat", false);
          })
          .catch((response) => {
            this.$set(this.loadings, "getCovidCases_stat", false);
          });

        this.$set(this.loadings, "getCovidCases_statdaily", true);
        axios
          .get("/api/dashboard/cavid-cases/statistics/daily")
          .then(({ data }) => {
            let labels = [],
              sick = [],
              confirmed = [],
              dead = [],
              healed = [];
            data.map(function (d) {
              confirmed.push(d.confirmed);
              dead.push(d.dead);
              healed.push(d.healed);
              labels.push(d.last_update);
            });
            this.covidCasesStatDaily = {
              confirmed,
              dead,
              healed,
              labels,
            };
            this.$set(this.loadings, "getCovidCases_statdaily", false);
          })
          .catch((response) => {
            this.$set(this.loadings, "getCovidCases_statdaily", false);
          });

        this.$set(this.loadings, "getCovidCases_cases", true);

        axios
          .get(`/api/dashboard/cavid-cases`)
          .then(({ data }) => {
            let Features = data.map((value) => {
              confirmedCount += Number(value.confirmed);
              return {
                type: "Feature",
                geometry: {
                  type: "Point",
                  coordinates: [value.longitude, value.latitude],
                },
                properties: {
                  name: value.name,
                  confirmed: Number(value.confirmed ?? 0),
                  healed: Number(value.healed ?? 0),
                  dead: Number(value.dead ?? 0),
                  sick: Number(value.sick ?? 0),
                  last_update: value.last_update,
                  seriously: Number(value.seriously ?? 0),
                  color: "#ED5F68",
                },
              };
            });
            this.covidCases = {
              type: "geojson",
              data: {
                type: "FeatureCollection",
                features: Features,
              },
            };

            this.covidCasesCount = confirmedCount;
            this.$set(this.loadings, "getCovidCases_cases", false);
          })
          .catch((response) => {
            this.$set(this.loadings, "getCovidCases_cases", false);
          });
      } else {
        this.covidCases = null;
        this.covidCasesStat = null;
        this.covidCasesCount = null;
      }
    },
    getmedicalOrientations(checked) {
      if (checked) {
        this.$set(this.loadings, "orientation_medical", true);
        axios
          .get(`/api/dashboard/orientation-medical-result`)
          .then(({ data }) => {
            this.medicalOrientations = data;
            let total_fin = 0;
            let total_fin5 = 0;
            let total_fin8 = 0;
            data.map((item) => {
              total_fin += item.FIN ?? 0;
              total_fin5 += item.FIN5 ?? 0;
              total_fin8 += item.FIN8 ?? 0;
            });
            this.finCount = total_fin;
            this.fin5Count = total_fin5;
            this.fin8Count = total_fin8;

            this.$set(this.loadings, "orientation_medical", false);
            this.orientationCount = total_fin + total_fin8 + total_fin5;
          })
          .catch(() => {
            this.$set(this.loadings, "orientation_medical", false);
            this.orientationCount = null;
          });

        this.$set(this.loadings, "orientation_medical_stats", true);
        axios
          .get(`/api/dashboard/orientation-medical-stats`)
          .then(({ data }) => {
            let fin = [],
              fin5 = [],
              fin8 = [],
              labels = [];
            data.map((item) => {
              fin.push(item.FIN);
              fin5.push(item.FIN5);
              fin8.push(item.FIN8);
              labels.push(item.created_at);
            });
            this.medicalOrientationsStat = {
              fin,
              fin5,
              fin8,
              labels,
            };
            this.$set(this.loadings, "orientation_medical_stats", false);
          })
          .catch(() => {
            this.$set(this.loadings, "orientation_medical_stats", false);
          });
      } else {
        this.medicalOrientations = null;
        this.orientationCount = null;
      }
    },
    medicalOrientationChanged(item) {
      this.medicalOrientationSelected = item;
    },
    hasSondageChecked(checked) {
      if (checked) {
        this.$set(this.loadings, "hasSondageChecked", true);
        axios
          .get(`/api/dashboard/sondages`)
          .then(({ data }) => {
            this.$set(this.loadings, "hasSondageChecked", false);
            this.sondages = data;
          })
          .catch(() => {
            this.$set(this.loadings, "hasSondageChecked", false);
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
      /**
       * formate les données flux
       */
      const computedFluxData = (dataObservations, dataReferences) => {
        const dataOut = [];
        return dataObservations.map((item) => {
          const references = dataReferences.filter(
            (x) =>
              x.destination == item.destination &&
              x.origin == item.origin &&
              x.day == item.day
          );
          const count = references.length;
          if (count > 0) {
            let referenceVolume = null;
            if (count % 2 == 0) {
              let index = (count + 1) / 2;
              index = parseInt(index);
              const volume1 = references[index].volume;
              const volume2 = references[index - 1].volume;
              referenceVolume = (volume1 + volume2) / 2;
            } else {
              const index = (count + 1) / 2;
              referenceVolume = references[index - 1].volume;
            }
            item.volume_reference = referenceVolume;
            const difference = item.volume - referenceVolume;
            item.difference = difference;
            item.percent = (difference / referenceVolume) * 100;
          } else {
            item.volume_reference = 0;
            item.difference = item.volume;
            item.percent = 0;
          }
          return Object.assign({}, item);
        });
      };

      const computedFluxPresenceData = (dataObservations, dataReferences) => {
        const dataOut = [];
        return dataObservations.map((item) => {
          const references = dataReferences.filter(
            (x) => x.zone == item.zone && x.day == item.day
          );
          const count = references.length;
          if (count > 0) {
            let referenceVolume = null;
            if (count % 2 == 0) {
              let index = (count + 1) / 2;
              index = parseInt(index);
              const volume1 = references[index].volume;
              const volume2 = references[index - 1].volume;
              referenceVolume = (volume1 + volume2) / 2;
            } else {
              const index = (count + 1) / 2;
              referenceVolume = references[index - 1].volume;
            }
            item.volume_reference = referenceVolume;
            const difference = item.volume - referenceVolume;
            item.difference = difference;
            item.percent = (difference / referenceVolume) * 100;

          } else {
            item.volume_reference = 0;
            item.difference = item.volume;
            item.percent = 0;
          }
          return Object.assign({}, item);
        });
      };
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

      this.$set(this.loadings, "urlDailyCompare", true);
      axios
        .get(urlDailyCompare, {
          params: values,
        })
        .then(({ data }) => {
          this.flux24DailyComparison = data;
          this.fluxGeoOptions = values.fluxGeoOptions;
          this.$set(this.loadings, "urlDailyCompare", false);
        })
        .catch(({ response }) => {
          this.$set(this.loadings, "urlDailyCompare", false);
        });

      this.flux24Daily = [];
      this.$set(this.loadings, "urlDaily", true);
      axios
        .get(urlDaily, {
          params: values,
        })
        .then(({ data }) => {
          this.flux24Daily = data;
          this.$set(this.loadings, "urlDaily", false);
        })
        .catch(({ response }) => {
          this.$set(this.loadings, "urlDaily", false);
        });

      // get flux data in

      this.flux24DailyIn = [];
      this.$set(this.loadings, "urlDailyIn", true);
      axios
        .get(urlDailyIn, {
          params: values,
        })
        .then(({ data }) => {
          this.flux24DailyIn = computedFluxData(
            data.observations,
            data.references
          );
          this.$set(this.loadings, "urlDailyIn", false);
        })
        .catch(({ response }) => {
          this.$set(this.loadings, "urlDailyIn", false);
        });

      // get flux data out

      this.flux24DailyOut = [];
      this.$set(this.loadings, "urlDailyOut", true);
      axios
        .get(urlDailyOut, {
          params: values,
        })
        .then(({ data }) => {
          this.flux24DailyOut = computedFluxData(
            data.observations,
            data.references
          );
          this.$set(this.loadings, "urlDailyOut", false);
        })
        .catch(({ response }) => {
          this.$set(this.loadings, "urlDailyOut", false);
        });

      this.flux24Presence = [];
      // this.$set(this.loadings, "urlPresence", true);
      // axios
      //   .get(urlPresence, {
      //     params: values,
      //   })
      //   .then(({ data }) => {
      //     this.flux24Presence = data;
      //     this.$set(this.loadings, "urlPresence", false);
      //   })
      //   .catch(({ response }) => {
      //     this.$set(this.loadings, "urlPresence", false);
      //   });

      this.$set(this.loadings, "urlPresenceDaily", true);
      this.flux24PrensenceDaily = [];
      axios
        .get(urlPresenceDaily, {
          params: values,
        })
        .then(({ data }) => {
          this.flux24PrensenceDaily = data;
          this.$set(this.loadings, "urlPresenceDaily", false);
        })
        .catch(({ response }) => {
          this.$set(this.loadings, "urlPresenceDaily", false);
        });

      this.flux24PresenceDailyIn = [];
      this.$set(this.loadings, "urlPresenceDailyIn", true);
      axios
        .get(urlPresenceDailyIn, {
          params: values,
        })
        .then(({ data }) => {
          this.flux24PresenceDailyIn = computedFluxPresenceData(
            data.observations,
            data.references
          );
          this.$set(this.loadings, "urlPresenceDailyIn", false);
        });
      // .catch(({ response }) => {
      //   this.$set(this.loadings, "urlPresenceDailyIn", false);
      // });

      this.flux24 = [];
      // this.$set(this.loadings, "flux24", true);
      // axios
      //   .get(url, {
      //     params: values,
      //   })
      //   .then(({ data }) => {
      //     this.flux24 = computedFluxData(data.observations, data.references);
      //     this.$set(this.loadings, "flux24", false);
      //   })
      //   .catch(({ response }) => {
      //     this.flux24Errors = response.data.errors;
      //     this.$set(this.loadings, "flux24", false);
      //   });

      //if geo granularity is health zone
      if (values.fluxGeoGranularity == 2) {
        return;
      }

      //Get  zone in by province
      this.fluxZoneGlobalIn = [];
      axios
        .get(`/api/dashboard/flux/origin/zones/h-24/global-in/province`, {
          params: values,
        })
        .then(({ data }) => {
          this.fluxZoneGlobalIn = data;
        });

      //Get  zone out by province
      this.fluxZoneGlobalOut = [];
      axios
        .get(`/api/dashboard/flux/origin/zones/h-24/global-out/province`, {
          params: values,
        })
        .then(({ data }) => {
          this.fluxZoneGlobalOut = data;
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
        preference_end,
      };
      this.flux24Errors = {};

      const url = `api/dashboard/flux/predefined/zones/h-24/`;
      const urlDaily = `api/dashboard/flux/predefined/zones/h-24/daily`;
      const urlDailyIn = `api/dashboard/flux/predefined/zones/h-24/daily-in`;
      const urlDailyOut = `api/dashboard/flux/predefined/zones/h-24/daily-out`;
      const urlDailyCompare = `api/dashboard/flux/predefined/zones/h-24/daily-compare`;

      this.$set(this.loadings, "fluxPC_urlDailyCompare", true);
      axios
        .get(urlDailyCompare, {
          params: values,
        })
        .then(({ data }) => {
          this.flux24DailyComparison = data;
          this.$set(this.loadings, "fluxPC_urlDailyCompare", false);
        })
        .catch(({ response }) => {
          this.$set(this.loadings, "fluxPC_urlDailyCompare", false);
        });

      this.flux24Daily = [];
      this.$set(this.loadings, "fluxPC_urlDaily", true);
      axios
        .get(urlDaily, {
          params: values,
        })
        .then(({ data }) => {
          this.flux24Daily = data;
          this.$set(this.loadings, "fluxPC_urlDaily", false);
        })
        .catch(({ response }) => {
          this.$set(this.loadings, "fluxPC_urlDaily", false);
        });

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
      this.$set(this.loadings, "fluxPC_flux24", true);
      axios
        .get(url, {
          params: values,
        })
        .then(({ data }) => {
          this.flux24 = data;
          this.$set(this.loadings, "fluxPC_flux24", false);
        })
        .catch(({ response }) => {
          this.flux24Errors = response.data.errors;
          this.$set(this.loadings, "fluxPC_flux24", false);
        });
    },
    toggleFullscreenMap() {
      this.$refs['fullscreenMap'].toggle()
    },
    fullscreenMapChange (fullscreen) {
      this.fullscreen = fullscreen
    },
    loadFluxGLobalData() {
      axios
        .get("/api/dashboard/flux/origin/provinces/h-24/global-in", {
          params: {
            observation_start: OBSERVATION_START,
            observation_end: OBSERVATION_END,
          },
        })
        .then(({ data }) => {
          this.fluxGlobalIn = data;
        });

      axios
        .get("/api/dashboard/flux/origin/provinces/h-24/global-out", {
          params: {
            observation_start: OBSERVATION_START,
            observation_end: OBSERVATION_END,
          },
        })
        .then(({ data }) => {
          this.fluxGlobalOut = data;
        });
    },
  },
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
    border-radius: 5px;
    &.active {
      background: $dash-green;
      color: white !important;
    }
  }
}
</style>
