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
            @toggleShowMobiliteGenerale="toggleShowMobiliteGenerale"
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
            v-show="activeMenu==3"
            :fluxZones="fluxZones"
            :fluxProvinces="fluxProvinces"
            :flux24Errors="flux24Errors"
          />
          <MenuInfrastructure
            v-show="activeMenu==5"
            :hospitalCount="hospitalCount"
            :townships="townships"
            @hopitalChecked="gethopitals"
            @submitInfrastructureForm="submitInfrastructureForm"
          />
          <MenuOrientation
            v-show="activeMenu==6"
            @medicalOrientationChecked="getmedicalOrientations"
            @medicalOrientationChanged="medicalOrientationChanged"
          />
        </b-col>
      </b-row>
      <indicateur-chart v-if="activeMenu == 3"></indicateur-chart>
      <b-row class="position-relative map-wrap" v-show="activeMenu != 3">
        <b-col cols="12" :class="`${hasRightSide?'col-md-6':'col-md-12'}`">
          <div class="layer-set-contenair" v-if="hasFlux24DailyIn && activeMenu==1">
            <b-link :class="{'active':fluxMapStyle==2}" @click="layerSetSyle(2)">Arcs</b-link>
            <b-link :class="{'active':fluxMapStyle==1}" @click="layerSetSyle(1)">Hachurés</b-link>
          </div>
          <b-row class="map-container" :class="{'map-container-100':!hasCovidCases}">
            <FullScreen id="fullscreenMap" no-flex link @change="fullscreenMapChange">
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
                :fluxDataGroupedByDateIn="fluxDataGroupedByDateIn"
                :fluxDataGroupedByDateOut="fluxDataGroupedByDateOut"
                :flux24DailyGenerale="flux24DailyGenerale"
                :isLoading="isLoading"
                :flux24Presence="flux24PresenceDailyInFormat"
                :fluxZoneGlobalIn="fluxZoneGlobalIn"
                :isFluxGlobalProvinceloading="isFluxGlobalProvinceloading"
                :hasRightSide="hasRightSide"
                @geoJsonLoaded="geoJsonLoaded"
                :showBottom="showBottom"
                :fluxZoneGlobalOut="fluxZoneGlobalOut"
              />
              <MapsLegend v-if="flux24DailyIn.length > 0 && activeMenu == 1"></MapsLegend>
              <MapsLegendEpidemic v-if="covidCases && activeMenu == 2"></MapsLegendEpidemic>
              <Legend
                showTotal
                :data="orientationLegend"
                class="legend-orientation"
                v-if="orientationCount && orientationCount > 0 && activeMenu == 6"
              ></Legend>
            </FullScreen>
          </b-row>
        </b-col>
        <b-col
          cols="12"
          md="6"
          class="side-right mt-2 pl-2"
          :class="{'side-right-100':!hasCovidCases}"
          v-if="hasRightSide || ( isLoading && activeMenu ==1)"
        >
          <b-card no-body>
            <b-tabs pills card>
              <b-tab
                title="Covid-19 data"
                v-if="!!covidCases && activeMenu==2"
                :active="!!covidCases"
              >
                <SideCaseCovid :covidCases="covidCases" />
              </b-tab>
              <b-tab
                title="Orientation data"
                v-if="orientationCount != null && activeMenu==6"
                :active="orientationCount != null"
              >
                <SideOrientation :medicalOrientations="medicalOrientations" />
              </b-tab>
              <b-tab title="Province" v-if="activeMenu==1 ">
                <b-row>
                  <b-col cols="6" class="pr-2">
                    <skeleton-loading v-if="isLoading">
                      <square-skeleton
                        :boxProperties="{
                                width: '100%',
                                height: '830px'
                            }"
                      ></square-skeleton>
                    </skeleton-loading>
                    <GlobalProvince
                      v-else
                      title="Mobilité entrante"
                      :color="palette.flux_in_color"
                      :globalData="fluxGlobalIn"
                      reference="fluxglobalIn"
                    />
                  </b-col>
                  <b-col cols="6" class="pl-2">
                    <skeleton-loading v-if="isLoading">
                      <square-skeleton
                        :boxProperties="{
                                width: '100%',
                                height: '830px'
                            }"
                      ></square-skeleton>
                    </skeleton-loading>
                    <GlobalProvince
                      v-else
                      title="Mobilité sortante"
                      :color="palette.flux_out_color"
                      :globalData="fluxGlobalOut"
                      reference="fluxglobalOut"
                    />
                  </b-col>
                </b-row>
              </b-tab>
              <b-tab
                title="FLux chart"
                v-if="(hasFlux24DailyIn || isLoading) && !isFirstLoad && this.activeMenu==1"
                :active="hasFlux24DailyIn || isLoading"
              >
                <FluxChart
                  :flux24Daily="flux24Daily"
                  :flux24DailyIn="flux24DailyIn"
                  :flux24DailyOut="flux24DailyOut"
                  :flux24DailyGenerale="flux24DailyGenerale"
                  :fluxDataGroupedByDateIn="fluxDataGroupedByDateIn"
                  :fluxDataGroupedByDateOut="fluxDataGroupedByDateOut"
                  :fluxDataGroupedByDateGen="fluxDataGroupedByDateGen"
                  :flux24Presence="flux24Presence"
                  :flux24PresenceDailyIn="flux24PresenceDailyInFormat"
                  :fluxZoneGlobalIn="fluxZoneGlobalIn"
                  :fluxZoneGlobalOut="fluxZoneGlobalOut"
                  :mobiliteGenerale="showMobiliteGenerale"
                  :topHealthZoneConfirmed="topHealthZoneConfirmed"
                  :globalProgress="globalProgress"
                  :isLoading="isLoading"
                />
              </b-tab>
              <b-tab
                title="Hôpital"
                v-if="hospitalCount != null && activeMenu==5"
                :active="!!selectedHospital || activeMenu==5"
              >
                <HospitalSituation :hospitalTotalData="hospitalTotalData" />
              </b-tab>
            </b-tabs>
          </b-card>
        </b-col>
      </b-row>
      <b-row v-if="hasBottom">
        <b-col cols="12" class="d-flex justify-content-center">
          <div
            @click="toggleBottomBar"
            class="bottom-bar-button d-flex align-items-center justify-content-center"
            :class="{'bottom-collapse':!showBottom}"
          >
            <span :class="{'rotate':showBottom}" class="fa fa-chevron-up"></span>
          </div>
        </b-col>
      </b-row>
      <transition name="bounce">
        <b-row
          class="row-side-bottom mb-2"
          :class="{'mt-2':!showBottom}"
          v-if="activeMenu != 3 && hasBottom && showBottom"
        >
          <b-col class="side-bottom" cols="12">
            <b-card no-body>
              <b-tabs pills card>
                <b-tab
                  title="Covid-19 chart"
                  v-if="hasCovidCases && activeMenu==2"
                  :active="hasCovidCases"
                >
                  <CovidCaseChart
                    :covidCasesStat="covidCasesStat"
                    :covidCasesStatDaily="covidCasesStatDaily"
                  />
                </b-tab>
                <b-tab title="Flux comparaison" v-if="hasflux24DailyComparison && activeMenu==1">
                  <FluxComparisonChart
                    :fluxGeoOptions="fluxGeoOptions"
                    :flux24DailyComparison="flux24DailyComparison"
                  />
                </b-tab>
                <b-tab
                  title="Flux tendance"
                  v-if="hasFlux24Daily && activeMenu==1"
                  :active="hasFlux24Daily"
                >
                  <FluxTendanceChart :flux24Daily="flux24Daily" />
                </b-tab>
              </b-tabs>
            </b-card>
          </b-col>
        </b-row>
      </transition>
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
import { groupBy } from "lodash";
import {
  OBSERVATION_START,
  OBSERVATION_END,
  PALETTE,
  PREFERENCE_START,
  PREFERENCE_END,
} from "../config/env";

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
      flux24DailyGenerale: [],
      fluxGeoOptions: [],
      menuColunmStyle: {},
      flux24PrensenceDaily: [],
      flux24PresenceDailyIn: {},
      flux24PresenceDailyInData: {},
      flux24PresenceDailyInDay: {},
      flux24PresenceDailyInNight: {},
      fluxGlobalIn: [],
      fluxGlobalOut: [],
      palette: PALETTE,
      fluxZoneGlobalIn: [],
      fluxZoneGlobalOut: [],
      fluxZoneGlobalPresence: [],
      showMobiliteGenerale: false,
      fluxDataGroupedByDateIn: {},
      fluxDataGroupedByDateOut: {},
      fluxDataGroupedByDateGen: {},
      topHealthZoneConfirmed: [],
      listAxiosToken : {},
      townships: [],
      isFluxGlobalProvinceloading: {},
      globalProgress: null,
      orientationLegend: [],
      showBottom: false,
      isFirstLoad:true,
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
      healthZones: (state) => state.app.healthZones,
      typePresence: (state) => state.flux.typePresence,
    }),
    hasRightSide() {
      return (
        (this.getHasCoviCases() && this.activeMenu == 2) ||
        (this.flux24DailyIn.length > 0 && this.activeMenu == 1) ||
        (this.hospitalCount != null && this.activeMenu == 5) ||
        (this.fluxGlobalIn.length > 0 && this.activeMenu == 1) ||
        (this.orientationCount != null && this.activeMenu == 6)
      );
    },
    hasBottom() {
      return (
        (this.activeMenu == 2 && this.hasCovidCases) ||
        (this.activeMenu == 1 &&
          (this.hasFlux24Daily || this.hasflux24DailyComparison))
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
    flux24PresenceDailyInFormat() {
      if (this.typePresence == 3) return this.flux24PresenceDailyInNight;
      else if (this.typePresence == 2) return this.flux24PresenceDailyInDay;
      else return this.flux24PresenceDailyIn;
    },
  },
  mounted() {
    this.$set(this.loadings, "healthZoneGeo", true);
    this.$set(this.loadings, "provinceGeo", true);

    this.getFluxZone();
    if (this.healthZones.length == 0) {
      this.getHealthZone();
    }
    this.getFluxProvinces();
    this.$store.watch(
      (state) => state.nav.activeMenu,
      (value) => {
        this.gethopitals(false);
        switch (value) {
          case 1:
            break;
          case 2:
            break;
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
    this.loadTownships();
  },
  methods: {
    ...mapActions(["userMe", "getHospitalsData", "getHealthZone"]),
    ...mapMutations(["setMapStyle"]),
    toggleBottomBar() {
      this.showBottom = !this.showBottom;
    },
    geoJsonLoaded(item) {
      this.$set(this.loadings, item, false);
      this.$set(this.loadings, item, false);
    },
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
      // this.getHospitalsData(checked);
    },
    getCovidCases(checked) {
      if (checked) {
        let confirmedCount = 0;

        this.cancelAxios("covidCases")

        this.listAxiosToken.covidCases.push(axiosInstance.CancelToken.source())
        this.$set(this.loadings, "getCovidCases_stat", true);
        axios
          .get("/api/dashboard/cavid-cases/statistics",
            { cancelToken: this.listAxiosToken.covidCases.slice(-1).token }
          )
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

        this.listAxiosToken.covidCases.push(axiosInstance.CancelToken.source())
        this.$set(this.loadings, "getCovidCases_statdaily", true);
        axios
          .get("/api/dashboard/cavid-cases/statistics/daily",
            { cancelToken: this.listAxiosToken.covidCases.slice(-1).token }
          )
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

        this.listAxiosToken.covidCases.push(axiosInstance.CancelToken.source())
        this.$set(this.loadings, "getCovidCases_cases", true);
        axios
          .get(`/api/dashboard/cavid-cases`,
            { cancelToken: this.listAxiosToken.covidCases.slice(-1).token }
          )
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

        this.cancelAxios("medicalOr")

        this.listAxiosToken.medicalOr.push(axiosInstance.CancelToken.source())
        this.$set(this.loadings, "orientation_medical", true);
        axios
          .get(`/api/dashboard/orientation-medical-result`,
            { cancelToken: this.listAxiosToken.medicalOr.slice(-1).token }
          )
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
            this.setDataOrientationLegend(
              this.finCount,
              this.fin5Count,
              this.fin8Count
            );

            this.$set(this.loadings, "orientation_medical", false);
            this.orientationCount = total_fin + total_fin8 + total_fin5;
          })
          .catch(() => {
            this.$set(this.loadings, "orientation_medical", false);
            this.orientationCount = null;
          });

        this.listAxiosToken.medicalOr.push(axiosInstance.CancelToken.source())
        this.$set(this.loadings, "orientation_medical_stats", true);
        axios
          .get(`/api/dashboard/orientation-medical-stats`,
            { cancelToken: this.listAxiosToken.medicalOr.slice(-1).token }
          )
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
    setDataOrientationLegend(a, b, c) {
      this.orientationLegend = [
        { color: "#3b9d3b", label: "Peu probale", caption: a },
        { color: "#ffb93b", label: "Probale", caption: b },
        { color: "#ff3b3b", label: "Très probale", caption: c },
      ];
    },
    medicalOrientationChanged(item) {
      this.medicalOrientationSelected = item;
    },
    hasSondageChecked(checked) {
      if (checked) {
        this.cancelAxios("hasSondage")

        this.listAxiosToken.hasSondage.push(axiosInstance.CancelToken.source())
        this.$set(this.loadings, "hasSondageChecked", true);
        axios
          .get(`/api/dashboard/sondages`,
            { cancelToken: this.listAxiosToken.hasSondage.slice(-1).token }
          )
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
        this.flux24DailyGenerale = [];
      }
    },
    getFluxZone() {
      this.cancelAxios("fluxZone")
      this.listAxiosToken.fluxZone.push(axiosInstance.CancelToken.source())

      axios.get("api/dashboard/flux-zone",
        { cancelToken: this.listAxiosToken.fluxZone.slice(-1).token }
      ).then(({ data }) => {
        this.fluxZones = data;
      });
    },
    getFluxProvinces() {
      this.cancelAxios("fluxProvince")

      this.listAxiosToken.fluxProvince.push(axiosInstance.CancelToken.source())
      axios.get("api/dashboard/flux-provinces",
        { cancelToken: this.listAxiosToken.fluxProvince.slice(-1).token }
      ).then(({ data }) => {
        this.fluxProvinces = data;
      });
    },
    submitFluxForm(values) {
      if (this.isLoading) {
        return;
      }

      // Cancel des requetes axios en attente
      this.cancelAxios("flux")

      /**
       * formate les données flux
       */
      this.isFirstLoad=false;
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

      const computedFluxDataByDate = this.computedFluxDataByDate;

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

      const computedFluxPresenceDataByDate = this
        .computedFluxPresenceDataByDate;

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

      // this.$set(this.loadings, "urlDailyCompare", true);
      // axios
      //   .get(urlDailyCompare, {
      //     params: values,
      //   })
      //   .then(({ data }) => {
      //     if (values.fluxGeoGranularity == 2) {
      //       const origin = data.origin;
      //       origin.map((item) => {
      //         const element = data.destination.find(
      //           (x) => x.origin == item.origin && x.date == item.date
      //         );
      //         if (element) {
      //           item.volume += element.volume;
      //         }
      //       });
      //       this.flux24DailyComparison = origin;
      //     } else {
      //       this.flux24DailyComparison = data;
      //     }

      //     this.fluxGeoOptions = values.fluxGeoOptions;
      //     this.$set(this.loadings, "urlDailyCompare", false);
      //   })
      //   .catch(({ response }) => {
      //     this.$set(this.loadings, "urlDailyCompare", false);
      //   });

      this.flux24Daily = [];
      this.cancelAxios("flux24Daily")
      this.listAxiosToken.flux24Daily.push(axiosInstance.CancelToken.source())
      this.$set(this.loadings, "urlDaily", true);
      axios
        .get(urlDaily, {
          params: values,
          cancelToken: this.listAxiosToken.flux24Daily.slice(-1).token
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
      this.listAxiosToken.flux.push(axiosInstance.CancelToken.source())
      axios
        .get(urlDailyIn, {
          params: values,
          cancelToken: this.listAxiosToken.flux.slice(-1).token
        })
        .then(({ data }) => {
          // this.flux24DailyIn = computedFluxData(
          //   data.observations,
          //   data.references
          // );
          const groupObservations = groupBy(data.observations, (d) => d.origin);
          const groupReferences = groupBy(data.references, (d) => d.origin);
          Object.entries(groupObservations).forEach(([key, value]) => {
            this.flux24DailyIn.push({
              references: groupReferences[key],
              observations: groupObservations[key],
            });
          });

          this.fluxDataGroupedByDateIn = computedFluxDataByDate(
            data.observations,
            data.references,
            "destination"
          );
          this.$set(this.loadings, "urlDailyIn", false);
        })
        .catch(({ response }) => {
          this.$set(this.loadings, "urlDailyIn", false);
        });

      // get flux data out

      this.flux24DailyOut = [];
      this.$set(this.loadings, "urlDailyOut", true);
      this.listAxiosToken.flux.push(axiosInstance.CancelToken.source())
      axios
        .get(urlDailyOut, {
          params: values,
          cancelToken: this.listAxiosToken.flux.slice(-1).token
        })
        .then(({ data }) => {
          // this.flux24DailyOut = computedFluxData(
          //   data.observations,
          //   data.references
          // );
          const groupObservations = groupBy(
            data.observations,
            (d) => d.destination
          );
          const groupReferences = groupBy(
            data.references,
            (d) => d.destination
          );
          Object.entries(groupObservations).forEach(([key, value]) => {
            this.flux24DailyOut.push({
              references: groupReferences[key],
              observations: groupObservations[key],
            });
          });

          this.fluxDataGroupedByDateOut = computedFluxDataByDate(
            data.observations,
            data.references,
            "origin"
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

      // this.$set(this.loadings, "urlPresenceDaily", true);
      // this.flux24PrensenceDaily = [];
      // axios
      //   .get(urlPresenceDaily, {
      //     params: values,
      //   })
      //   .then(({ data }) => {
      //     this.flux24PrensenceDaily = data;
      //     this.$set(this.loadings, "urlPresenceDaily", false);
      //   })
      //   .catch(({ response }) => {
      //     this.$set(this.loadings, "urlPresenceDaily", false);
      //   });

      this.flux24PresenceDailyInData = {};
      this.$set(this.loadings, "urlPresenceDailyIn", true);
      this.listAxiosToken.flux.push(axiosInstance.CancelToken.source())
      axios
        .get(urlPresenceDailyIn, {
          params: values,
          cancelToken: this.listAxiosToken.flux.slice(-1).token
        })
        .then(({ data }) => {
          this.flux24PresenceDailyInData = data;

          this.$set(this.loadings, "urlPresenceDailyIn", false);
        })
        .catch(({ response }) => {
          this.$set(this.loadings, "urlPresenceDailyIn", false);
        });

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

      this.fluxZoneGlobalIn = [];
      this.fluxZoneGlobalOut = [];
      this.topHealthZoneConfirmed = [];

      if (values.fluxGeoGranularity == 2) {
        return;
      }

      const pandemicParams = Object.assign({}, values);
      pandemicParams.fluxGeoOptions = pandemicParams.fluxGeoOptions[0];
      this.listAxiosToken.flux.push(axiosInstance.CancelToken.source())
      axios
        .get("/api/dashboard/pandemics/top-confirmed", {
          params: pandemicParams,
          cancelToken: this.listAxiosToken.flux.slice(-1).token
        })
        .then(({ data }) => {
          this.topHealthZoneConfirmed = data;
        });

      const healthZones = this.healthZones.filter(
        (x) => x.province == values.fluxGeoOptions[0]
      );
      let countAll = healthZones.length;

      let healthZonesWorkingIn = healthZones.slice(0, 3);
      let healthZonesWorkingOut = healthZones.slice(0, 3);

      let healthIndexIn = healthZonesWorkingIn.length;
      let healthIndexOut = healthZonesWorkingOut.length;

      let loopLenghtIn = healthIndexIn;

      let loopLenghtOut = healthIndexOut;

      let countIn = 0;
      let countOut = 0;

      this.globalProgress = ((countIn + countOut) / (countAll * 2)) * 100;

      const globalInFunc = () => {
        for (let index = 0; index < loopLenghtIn; index++) {
          const item = healthZonesWorkingIn[index];
          const healthZoneValues = Object.assign({}, values);
          healthZoneValues.fluxGeoOptions = item.zone;

          //Get  zone in by province
          this.listAxiosToken.flux.push(axiosInstance.CancelToken.source())
          axios
            .get(`/api/dashboard/flux/origin/zones/h-24/global-in/province`, {
              params: healthZoneValues,
              cancelToken: this.listAxiosToken.flux.slice(-1).token
            })
            .then(async (response) => {
              this.fluxZoneGlobalIn.push(response.data);
              countIn++;
              this.globalProgress =
                ((countIn + countOut) / (countAll * 2)) * 100;
              if (Number(response.headers["x-ratelimit-remaining"]) < 7) {
                await this.sleep(25000);
              }
              healthZonesWorkingIn = healthZones.slice(
                healthIndexIn,
                healthIndexIn + 1
              );
              healthIndexIn++;
              loopLenghtIn = 1;
              if (healthIndexIn <= healthZones.length) {
                globalInFunc();
              }
            })
            .catch(() => {
              countIn++;
              this.globalProgress =
                ((countIn + countOut) / (countAll * 2)) * 100;
            });

          //Get  zone out by province
          // axios
          //   .get(`/api/dashboard/flux/origin/zones/h-24/global-out/province`, {
          //     params: healthZoneValues,
          //   })
          //   .then(({ data }) => {
          //     this.fluxZoneGlobalOut.push(data);
          //   });
        }
        healthZonesWorkingIn = [];
      };
      const globalOutFunc = () => {
        for (let index = 0; index < loopLenghtOut; index++) {
          const item = healthZonesWorkingOut[index];
          const healthZoneValues = Object.assign({}, values);
          healthZoneValues.fluxGeoOptions = item.zone;

          //Get  zone in by province
          this.listAxiosToken.flux.push(axiosInstance.CancelToken.source())
          axios
            .get(`/api/dashboard/flux/origin/zones/h-24/global-out/province`, {
              params: healthZoneValues,
              cancelToken: this.listAxiosToken.flux.slice(-1).token
            })
            .then(async (response) => {
              this.fluxZoneGlobalOut.push(response.data);
              countOut++;
              this.globalProgress =
                ((countIn + countOut) / (countAll * 2)) * 100;
              if (Number(response.headers["x-ratelimit-remaining"]) < 7) {
                await this.sleep(25000);
              }
              healthZonesWorkingOut = healthZones.slice(
                healthIndexOut,
                healthIndexOut + 1
              );
              healthIndexOut++;
              loopLenghtOut = 1;
              if (healthIndexOut <= healthZones.length) {
                globalOutFunc();
              }
            })
            .catch(() => {
              countOut++;
              this.globalProgress =
                ((countIn + countOut) / (countAll * 2)) * 100;
            });

          //Get  zone out by province
          // axios
          //   .get(`/api/dashboard/flux/origin/zones/h-24/global-out/province`, {
          //     params: healthZoneValues,
          //   })
          //   .then(({ data }) => {
          //     this.fluxZoneGlobalOut.push(data);
          //   });
        }
        healthZonesWorkingOut = [];
      };

      globalInFunc();
      globalOutFunc();
    },
    submitInfrastructureForm(values) {
      this.getHospitalsData(values);
    },
    seeSide() {
      this.$bvModal.show("data-modal");
    },
    fluxPredefinedChanged(value) {
      this.cancelAxios("fluxPredefined")
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
      this.listAxiosToken.fluxPredefined.push(axiosInstance.CancelToken.source())
      axios
        .get(urlDailyCompare, {
          params: values,
          cancelToken: this.listAxiosToken.fluxPredefined.slice(-1).token
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
      this.cancelAxios("flux24Daily")
      this.listAxiosToken.flux24Daily.push(axiosInstance.CancelToken.source())
      axios
        .get(urlDaily, {
          params: values,
          cancelToken: this.listAxiosToken.flux24Daily.slice(-1).token
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
      this.listAxiosToken.fluxPredefined.push(axiosInstance.CancelToken.source())
      axios
        .get(url, {
          params: values,
          cancelToken: this.listAxiosToken.fluxPredefined.slice(-1).token
        })
        .then(({ data }) => {
          this.flux24 = data;
          this.$set(this.loadings, "fluxPC_flux24", false);
        })
        .catch((thrown) => {
          if (!axiosInstance.isCancel(thrown)) {
            this.flux24Errors = thrown.response.data.errors;
          }
          this.$set(this.loadings, "fluxPC_flux24", false);
        });
    },
    toggleShowMobiliteGenerale(checked) {
      this.showMobiliteGenerale = checked;
    },
    toggleFullscreenMap() {
      this.$refs["fullscreenMap"].toggle();
    },
    fullscreenMapChange(fullscreen) {
      this.fullscreen = fullscreen;
    },
    computedFluxData(dataObservations, dataReferences) {
      return dataObservations.map((item) => {
        const reference = dataReferences.find((x) => x.zone == item.zone);
        if (reference) {
          item.volume_reference = reference.volume;
          const difference = item.volume - reference.volume;
          item.difference = difference;
          item.percent = (difference / reference.volume) * 100;
        } else {
          item.volume_reference = 0;
          item.difference = item.volume;
          item.percent = 0;
        }
        return Object.assign({}, item);
      });
    },
    loadFluxGLobalData() {
      this.cancelAxios("fluxGlobal")

      this.listAxiosToken.fluxGlobal.push(axiosInstance.CancelToken.source())
      this.$set(this.isFluxGlobalProvinceloading, "in", true);

      axios
        .get("/api/dashboard/flux/origin/provinces/h-24/global-in", {
          params: {
            observation_start: OBSERVATION_START,
            observation_end: OBSERVATION_END,
            preference_start: PREFERENCE_START,
            preference_end: PREFERENCE_END,
          },
          cancelToken: this.listAxiosToken.fluxGlobal.slice(-1).token
        })
        .then(({ data }) => {
          const groupObservations = groupBy(data.observations, (d) => d.zone);
          const groupReferences = groupBy(data.references, (d) => d.zone);
          Object.entries(groupObservations).forEach(([key, value]) => {
            this.fluxGlobalIn.push({
              references: groupReferences[key],
              observations: groupObservations[key],
            });
          });
          this.$set(this.isFluxGlobalProvinceloading, "in", false);
        });

      this.listAxiosToken.fluxGlobal.push(axiosInstance.CancelToken.source())
      this.$set(this.isFluxGlobalProvinceloading, "out", true);
      axios
        .get("/api/dashboard/flux/origin/provinces/h-24/global-out", {
          params: {
            observation_start: OBSERVATION_START,
            observation_end: OBSERVATION_END,
            preference_start: PREFERENCE_START,
            preference_end: PREFERENCE_END,
          },
          cancelToken: this.listAxiosToken.fluxGlobal.slice(-1).token
        })
        .then(({ data }) => {
          const groupObservations = groupBy(data.observations, (d) => d.zone);
          const groupReferences = groupBy(data.references, (d) => d.zone);
          Object.entries(groupObservations).forEach(([key, value]) => {
            this.fluxGlobalOut.push({
              references: groupReferences[key],
              observations: groupObservations[key],
            });
          });
          this.$set(this.isFluxGlobalProvinceloading, "out", false);
        });
    },
    updateflux24DailyGenerale() {
      const temp = [
        ...this.flux24DailyIn.map((x) => {
          x.zone = x.origin;
          x.targetZone = x.destination;
          return x;
        }),
        ...this.flux24DailyOut.map((x) => {
          x.targetZone = x.origin;
          x.zone = x.destination;
          return x;
        }),
      ];
      this.flux24DailyGenerale = temp;
    },
    updateFluxDataGroupedByDateGen() {
      const temp = { referencesByDate: [], observationsByDate: [] };

      if (this.fluxDataGroupedByDateIn.referencesByDate)
        temp.referencesByDate = [
          ...temp.referencesByDate,
          ...this.fluxDataGroupedByDateIn.referencesByDate,
        ];

      if (this.fluxDataGroupedByDateOut.referencesByDate)
        temp.referencesByDate = [
          ...temp.referencesByDate,
          ...this.fluxDataGroupedByDateOut.referencesByDate,
        ];

      if (this.fluxDataGroupedByDateIn.observationsByDate)
        temp.observationsByDate = [
          ...temp.observationsByDate,
          ...this.fluxDataGroupedByDateIn.observationsByDate,
        ];

      if (this.fluxDataGroupedByDateOut.observationsByDate)
        temp.observationsByDate = [
          ...temp.observationsByDate,
          ...this.fluxDataGroupedByDateOut.observationsByDate,
        ];

      this.fluxDataGroupedByDateGen = this.computedFluxDataByDate(
        temp.observationsByDate,
        temp.referencesByDate,
        "zone"
      );
    },
    computedFluxDataByDate(dataObservations, dataReferences, key) {
      const referencesByDate = [];
      const observationsByDate = [];

      dataReferences.map((item) => {
        const element = referencesByDate.find(
          (x) => x.date == item.Date || x.date == item.date
        );
        if (element) {
          element.volume += item.volume;
        } else {
          referencesByDate.push({
            date: item.Date || item.date,
            day: item.day,
            volume: item.volume,
            zone: item[key],
          });
        }
      });

      dataObservations.map((item) => {
        const element = observationsByDate.find((x) => x.date == item.date);
        if (element) {
          element.volume += item.volume;
        } else {
          observationsByDate.push({
            date: item.date,
            day: item.day,
            volume: item.volume,
            zone: item[key],
          });
        }
      });

      return {
        referencesByDate,
        observationsByDate,
      };

      // return dataObservations.map((item) => {
      //   const references = dataReferences.filter((x) => x.day == item.day);
      //   const count = references.length;
      //   if (count > 0) {
      //     let referenceVolume = null;
      //     if (count % 2 == 0) {
      //       let index = (count + 1) / 2;
      //       index = parseInt(index);
      //       const volume1 = references[index].volume;
      //       const volume2 = references[index - 1].volume;
      //       referenceVolume = (volume1 + volume2) / 2;
      //     } else {
      //       const index = (count + 1) / 2;
      //       referenceVolume = references[index - 1].volume;
      //     }
      //     item.volume_reference = referenceVolume;
      //     const difference = item.volume - referenceVolume;
      //     item.difference = difference;
      //     item.percent = (difference / referenceVolume) * 100;
      //   } else {
      //     item.volume_reference = 0;
      //     item.difference = item.volume;
      //     item.percent = 0;
      //   }
      //   return Object.assign({}, item);
      // });
    },
    computedFluxPresenceDataByDate(dataObservations, dataReferences) {
      const referencesByDate = [];
      const observationsByDate = [];

      dataReferences.map((item) => {
        const element = referencesByDate.find((x) => x.date == item.date);
        if (element) {
          element.volume += item.volume;
        } else {
          referencesByDate.push({
            date: item.date,
            day: item.day,
            volume: item.volume,
            PresenceType: item.PresenceType,
            zone: item.zone,
          });
        }
      });

      dataObservations.map((item) => {
        const element = observationsByDate.find((x) => x.date == item.date);
        if (element) {
          element.volume += item.volume;
        } else {
          observationsByDate.push({
            date: item.date,
            day: item.day,
            volume: item.volume,
            PresenceType: item.PresenceType,
            zone: item.zone,
          });
        }
      });

      return {
        referencesByDate,
        observationsByDate,
      };
    },
    cancelAxios(token){
      console.log('token', token)
      if(this.listAxiosToken[token]){
        this.listAxiosToken[token].forEach(x => {
          x.cancel('Operation canceled.');
        })
      }
      this.listAxiosToken[token] = []
    },
    loadTownships() {
      axios.get("/api/dashboard/townships").then(({ data }) => {
        this.townships = data;
      });
    },
  },
  watch: {
    fluxDataGroupedByDateIn() {
      this.updateFluxDataGroupedByDateGen();
    },
    fluxDataGroupedByDateOut() {
      this.updateFluxDataGroupedByDateGen();
    },
    flux24PresenceDailyInData() {
      let data = { observations: [], references: [] };
      if (this.flux24PresenceDailyInData.observations) {
        data.observations = this.flux24PresenceDailyInData.observations;
      }
      if (this.flux24PresenceDailyInData.references) {
        data.references = this.flux24PresenceDailyInData.references;
      }

      this.flux24PresenceDailyInDay = this.computedFluxPresenceDataByDate(
        data.observations.filter((x) => x.PresenceType == "Jour"),
        data.references.filter((x) => x.PresenceType == "Jour")
      );
      this.flux24PresenceDailyInNight = this.computedFluxPresenceDataByDate(
        data.observations.filter((x) => x.PresenceType == "Nuit"),
        data.references.filter((x) => x.PresenceType == "Nuit")
      );
      this.flux24PresenceDailyIn = this.computedFluxPresenceDataByDate(
        data.observations,
        data.references
      );
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

  .bounce-enter-active {
    animation: slideInUp 0.5s;
  }
  .bounce-leave-active {
    animation: slideOutDown 0.5s;
  }
  @keyframes bounce-in {
    0% {
      transform: scale(0);
    }
    50% {
      transform: scale(1.5);
    }
    100% {
      transform: scale(1);
    }
  }
}
.bottom-collapse {
  box-shadow: 0px 0px 18px 10px #2e5bffb8;
  animation-name: shadow-animation;
  // animation-delay: 800ms;
  animation-duration: 3s;
  animation-fill-mode: backwards;
  animation-iteration-count: infinite;
}
@keyframes shadow-animation {
  0% {
    box-shadow: 0px 0px 18px 10px #2e5bffb8;
  }
  50% {
    box-shadow: 0px 0px 18px 1px #2e5bffb8;
  }
  0% {
    box-shadow: 0px 0px 18px 10px #2e5bffb8;
  }
}
.bottom-bar-button {
  width: 30px;
  height: 25px;
  background: $dash-blue;
  border-radius: 120px 120px 0px 0px;
  cursor: pointer;
  position: absolute;
  bottom: 0;
  z-index: 999;
  span {
    color: white;
    transition: all ease 800ms;
    &.rotate {
      transform: rotate(180deg);
    }
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
.legend-orientation {
  position: absolute;
  bottom: 20px;
  left: 20px;
  z-index: 200;
}
</style>
