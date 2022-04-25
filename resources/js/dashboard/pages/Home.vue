<template>
  <div>
    <b-container
      fluid
      class="dash-home-page"
      ref="dash_home_page"
      id="dash_home_page"
    >
      <div class="container-filter-btn d-lg-none" v-show="!canShowNavMobile">
        <b-button @click="toggleNavMobile" class="btn-dash-blue">
          <i class="fa fa-filter"></i>
        </b-button>
      </div>

      <div
        class="mt-lg-2 top-menu"
        :class="{ 'mob-header-container': isSmOrMd, row: !isSmOrMd }"
        style="z-index: 8"
        v-show="!isSmOrMd || (isSmOrMd && canShowNavMobile)"
      >
        <b-col cols="12" class="pl-lg-2">
          <div
            @click="toggleNavMobile"
            class="container-filter-btn-close d-lg-none"
          >
            <i class="fa fa-times"></i>
          </div>
          <MenuFlux
            v-show="activeMenu == 1"
            @submitFluxForm="submitFluxForm"
            @populationFluxChecked="populationFluxChecked"
            @flux::predefined::changed="fluxPredefinedChanged"
            @toggleShowMobiliteGenerale="toggleShowMobiliteGenerale"
            :fluxZones="fluxZones"
            :fluxProvinces="fluxProvinces"
            :flux24Errors="flux24Errors"
          />
          <MenuEpidemology
            v-show="activeMenu == 2"
            @covidCaseChecked="getCovidCases"
            :covidCasesCount="covidCasesCount"
          />
          <MenuIndicateur
            v-show="activeMenu == 3"
            :fluxZones="fluxZones"
            :fluxProvinces="fluxProvinces"
            :flux24Errors="flux24Errors"
          />
          <MenuInfrastructure
            v-show="activeMenu == 5"
            :hospitalCount="hospitalCount"
            :townships="townships"
            :hospitals="hospitalsList"
            @hopitalChecked="gethopitals"
            @submitInfrastructureForm="submitInfrastructureForm"
          />
          <MenuOrientation
            v-show="activeMenu == 6"
            @medicalOrientationChecked="getmedicalOrientations"
            @medicalOrientationChanged="medicalOrientationChanged"
          />
        </b-col>
      </div>
      <indicateur-chart v-if="activeMenu == 3"></indicateur-chart>
      <about v-if="activeMenu == 7"></about>
      <b-row
        class="position-relative map-wrap flex-lg-row-reverse"
        v-show="showMaps"
      >
        <b-col
          cols="12"
          lg="6"
          class="side-right mt-2"
          :class="{ 'side-right-100': !hasCovidCases }"
          v-if="hasRightSide"
        >
          <b-card no-body>
            <transition name="fade">
              <b-tabs
                @input="rightTabActived"
                v-model="activeRightSide"
                pills
                card
                v-if="selectedSource == 2"
              >
                <b-tab title="Carte" :active="isSmOrMd" v-if="isSmOrMd"></b-tab>
                <b-tab title="Mobilité africell" v-if="activeMenu == 1">
                  <AfriFluxChart
                    :fluxAfricellDaily="fluxAfricellDaily"
                    :fluxAfricelPresence="fluxAfricelPresence"
                    :fluxAfricelInOut="fluxAfricelInOut"
                    :isLoading="isLoading"
                  />
                </b-tab>
              </b-tabs>
            </transition>
            <transition name="fade">
              <b-tabs
                pills
                card
                v-if="selectedSource == 1 || activeMenu == 5"
                @input="rightTabActived"
                v-model="activeRightSide"
                ref="tabs_right"
              >
                <b-tab title="Carte" :active="isSmOrMd" v-if="isSmOrMd"></b-tab>
                <b-tab
                  title="Données Covid-19"
                  v-if="(!!hasCovidCases || isLoading) && activeMenu == 2"
                  :active="!isSmOrMd && !!hasCovidCases"
                >
                  <SideCaseCovid
                    :covidCases="covidCases"
                    :isLoading="isLoading"
                  />
                </b-tab>
                <b-tab
                  title="Données Orientation médicale covid-19"
                  v-if="
                    (orientationCount != null || isLoading) && activeMenu == 6
                  "
                  :active="orientationCount != null"
                >
                  <SideOrientation
                    :medicalOrientations="medicalOrientations"
                    :isLoading="isLoading"
                  />
                </b-tab>
                <b-tab title="Vue Globale des Provinces" v-if="activeMenu == 1">
                  <b-row>
                    <b-col cols="12" md="6" class="pr-2">
                      <div v-if="isLoading">
                        <b-skeleton-wrapper :loading="isLoading">
                          <template #loading>
                            <b-card no-body class="p-2 rounded-0 cardtype2">
                              <b-skeleton
                                class="m-auto"
                                width="60%"
                                height="20"
                              ></b-skeleton>
                              <b-skeleton
                                class="mt-2"
                                width="100%"
                                height="820px"
                              ></b-skeleton>
                            </b-card>
                          </template>
                        </b-skeleton-wrapper>
                      </div>
                      <GlobalProvince
                        v-else
                        title="Mobilité entrante"
                        :color="palette.flux_in_color"
                        :globalData="fluxGlobalIn"
                        reference="fluxglobalIn"
                      />
                    </b-col>
                    <b-col cols="12" md="6" class="pl-2 pr-2">
                      <div v-if="isLoading">
                        <b-skeleton-wrapper :loading="isLoading">
                          <template #loading>
                            <b-card no-body class="p-2 rounded-0 cardtype2">
                              <b-skeleton
                                class="m-auto"
                                width="60%"
                                height="20"
                              ></b-skeleton>
                              <b-skeleton
                                class="mt-2"
                                width="100%"
                                height="820px"
                              ></b-skeleton>
                            </b-card>
                          </template>
                        </b-skeleton-wrapper>
                      </div>
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
                  :title="titleMobility"
                  v-if="
                    (hasFlux24DailyIn || isLoading || hasFlux30Daily) &&
                    !isFirstLoad &&
                    this.activeMenu == 1
                  "
                  :active="computeActiveRightSide"
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
                    :flux30Daily="flux30Daily"
                    :flux30General="flux30General"
                    :flux30MapsData="flux30MapsData"
                  />
                </b-tab>
                <b-tab
                  title="Infrastructures"
                  v-if="(hospitalCount != null || isLoading) && activeMenu == 5"
                  :active="!!selectedHospital || activeMenu == 5"
                >
                  <HospitalSituation
                    :hospitalSituationAll="hospitalSituationAll"
                  />
                </b-tab>
              </b-tabs>
            </transition>
          </b-card>
        </b-col>
        <b-col
          cols="12"
          class="map-md"
          v-show="canShowMapMobile"
          :class="`${hasRightSide ? 'col-lg-6' : 'col-lg-12'}`"
          :style="{ top: isSmOrMd ? mapMdTop : 0 }"
        >
          <div
            class="layer-set-contenair"
            v-if="hasFlux24DailyIn && activeMenu == 1 && selectedSource == 1"
          >
            <b-link
              :class="{ active: fluxMapStyle == 1 }"
              @click="layerSetSyle(1)"
              >Hachurés</b-link
            >
            <b-link
              :class="{ active: fluxMapStyle == 2, disabled: disabledArc }"
              @click="layerSetSyle(2)"
              >Arcs</b-link
            >
          </div>
          <b-row
            class="map-container"
            :class="{ 'map-container-100': !hasCovidCases }"
          >
            <FullScreen
              id="fullscreenMap"
              no-flex
              link
              @change="fullscreenMapChange"
            >
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
                :flux30MapsData="flux30MapsData"
                :fluxAfricelInOut="fluxAfricelInOut"
                :fluxAfricelPresence="fluxAfricelPresence"
                :activeRightSide="activeRightSide"
              />
              <MapsLegend
                v-if="
                  (((flux24DailyIn.length > 0 || flux30MapsData.length > 0) &&
                    selectedSource == 1) ||
                    (fluxAfricelInOut.length > 0 && isStartEndDate)) &&
                  activeMenu == 1
                "
              ></MapsLegend>
              <MapsLegendEpidemic
                v-if="covidCases && activeMenu == 2"
              ></MapsLegendEpidemic>
              <Legend
                showTotal
                :data="orientationLegend"
                class="legend-orientation"
                v-if="
                  orientationCount && orientationCount > 0 && activeMenu == 6
                "
              ></Legend>
            </FullScreen>
          </b-row>
        </b-col>
      </b-row>
      <b-row v-if="hasBottom && selectedSource == 1">
        <b-col cols="12" class="d-flex justify-content-center">
          <div
            @click="toggleBottomBar"
            class="
              bottom-bar-button
              d-flex
              align-items-center
              justify-content-center
            "
            :class="{ 'bottom-collapse': !showBottom }"
          >
            <span
              :class="{ rotate: showBottom }"
              class="fa fa-chevron-up"
            ></span>
          </div>
        </b-col>
      </b-row>
      <transition name="bounce">
        <b-row
          class="row-side-bottom mb-2"
          :class="{ 'mt-2': !showBottom }"
          v-if="activeMenu != 3 && hasBottom && showBottom"
        >
          <b-col class="side-bottom" cols="12">
            <b-card no-body>
              <b-tabs pills card>
                <b-tab
                  title="Covid-19 chart"
                  v-if="hasCovidCases && activeMenu == 2"
                  :active="hasCovidCases"
                >
                  <CovidCaseChart
                    :covidCasesStat="covidCasesStat"
                    :covidCasesStatDaily="covidCasesStatDaily"
                  />
                </b-tab>
                <b-tab
                  title="Flux comparaison"
                  v-if="hasflux24DailyComparison && activeMenu == 1"
                >
                  <FluxComparisonChart
                    :fluxGeoOptions="fluxGeoOptions"
                    :flux24DailyComparison="flux24DailyComparison"
                  />
                </b-tab>
                <b-tab
                  title="Flux tendance"
                  v-if="hasFlux24Daily && activeMenu == 1"
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
      <ChangeLogModal id="change-log-modal" />
    </b-container>
  </div>
</template>

<script>
import ChangeLogModal from "../components/ChangeLogModal";
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
import HospitalSituation from "../components/HospitalSituation";
import FluxTendanceChart from "../components/flux/TendanceChart";
import FluxComparisonChart from "../components/flux/ComparisonChart";
import MenuFlux from "../components/menu/Flux";
import MenuEpidemology from "../components/menu/Epidemiology";
import MenuInfrastructure from "../components/menu/Infrastructure";
import MenuOrientation from "../components/menu/Orientation";
import MenuIndicateur from "../components/menu/Indicateur";
import GlobalProvince from "../components/flux/GLobalProvince";
import About from "../components/About";
import { groupBy } from "lodash";

import {
  OBSERVATION_START,
  OBSERVATION_END,
  PALETTE,
  PREFERENCE_START,
  PREFERENCE_END,
  HOTSPOT_TYPE,
  INFRASTRUCTURE_FIRST_UPDATE,
} from "../config/env";

import { mapState, mapActions, mapMutations } from "vuex";
import { difference } from "@turf/turf";
import ToggleButton from "../components/ToggleButton";
import AfriFluxChart from "../components/africell/AfriFluxChart";
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
    HospitalSituation,
    FluxTendanceChart,
    FluxComparisonChart,
    MenuFlux,
    MenuEpidemology,
    MenuInfrastructure,
    MenuOrientation,
    MenuIndicateur,
    GlobalProvince,
    About,
    ToggleButton,
    AfriFluxChart,
    ChangeLogModal,
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
      fluxGeneralTendance: [],
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
      townships: [],
      isFluxGlobalProvinceloading: {},
      globalProgress: null,
      orientationLegend: [],
      showBottom: false,
      isFirstLoad: true,
      disabledArc: false,
      flux30MapsData: [],
      flux30Daily: [],
      fluxDataProvider: [
        {
          lbl: "Orange",
          val: 1,
        },
        {
          lbl: "Africell",
          val: 2,
        },
      ],
      selectedFluxDataProvider: 1,
      flux30General: {},
      fluxAfricellDaily: [],
      fluxAfricelPresence: [],
      fluxAfricelInOut: [],
      showMobileMaps: true,
      activeRightSide: 0,
      mapMdTop: 46.4,
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
      selectedSource: (state) => state.flux.selectedSource,
      fluxGeoGranularity: (state) => state.flux.fluxGeoGranularityTemp,
      observationDate: (state) => state.flux.observationDate,
      fluxHotspotType: (state) => state.flux.fluxHotspotType,
      canShowNavMobile: (state) => state.app.canShowNavMobile,
      fluxType: (state) => state.flux.fluxType,
      hospitalsList: (state) => state.hospitalSituation.hospitalsList,
      hospitalSituationAll: (state) =>
        state.hospitalSituation.hospitalSituationAll,
    }),
    canShowMapMobile() {
      if (this.isSmOrMd) {
        return this.showMobileMaps;
      }
      return true;
    },
    computeActiveRightSide() {
      if (
        this.isSmOrMd &&
        (this.isLoading || !this.isLoading || this.fluxType)
      ) {
        this.activeRightSide = 0;
      } else if (
        !this.isSmOrMd &&
        (this.hasFlux24DailyIn || this.isLoading || this.hasFlux30Daily)
      ) {
        this.activeRightSide = 1;
      }
      return true;
    },
    titleMobility() {
      let name = "Provinces";
      switch (this.fluxGeoGranularity) {
        case 2:
          name = "Zone de santé";
          break;
        case 3:
          name = "Hotspot";
          break;
      }
      return name;
    },
    isStartEndDate() {
      return this.observationDate.start == this.observationDate.end;
    },
    hasRightSide() {
      return (
        (this.getHasCoviCases() && this.activeMenu == 2) ||
        ((this.flux24DailyIn.length > 0 || this.flux30Daily.lenth > 0) &&
          this.activeMenu == 1) ||
        (this.hospitalCount != null && this.activeMenu == 5) ||
        (this.fluxGlobalIn.length > 0 && this.activeMenu == 1) ||
        (this.orientationCount != null && this.activeMenu == 6) ||
        (this.isLoading &&
          (this.activeMenu == 1 ||
            this.activeMenu == 5 ||
            this.activeMenu == 2 ||
            this.activeMenu == 6))
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
    hasFlux30Daily() {
      return this.flux30Daily && this.fluxGeoGranularity == 3;
    },
    flux24WithoutReference() {
      return this.flux24.filter((x) => !x.isReference);
    },
    mapStyle() {
      return {
        height:
          this.getHasCoviCases() || this.getHasOrientation()
            ? "64vh"
            : "calc(100vh - 52.5px)",
      };
    },
    isLoading() {
      this.showBottom = false;
      // if (this.isSmOrMd) {
      //   this.activeRightSide = 0;
      // }
      this.resizeTopMap();
      return !!Object.values(this.loadings).find((val) => val === true);
    },
    flux24PresenceDailyInFormat() {
      if (this.typePresence == 3) return this.flux24PresenceDailyInNight;
      else if (this.typePresence == 2) return this.flux24PresenceDailyInDay;
      else return this.flux24PresenceDailyIn;
    },
    showMaps() {
      if (this.activeMenu == 3 || this.activeMenu == 7) return false;
      return true;
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
      const data = { observations: [], references: [] };
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
  mounted() {
    this.$set(this.loadings, "healthZoneGeo", true);
    this.$set(this.loadings, "provinceGeo", true);
    this.$set(this.loadings, "hotspotGeo", true);
    this.$set(this.loadings, "hotspotPointGeo", true);
    this.initForm();

    this.getFluxZone();
    if (this.healthZones.length == 0) {
      this.getHealthZone();
    }
    this.getFluxHotSpot();
    this.getFluxProvinces();
    this.$store.watch(
      (state) => state.hospital.isLoading,
      (value) => {
        this.$set(this.loadings, "hospital", value);
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
    this.getHospitals();

    this.$store.watch(
      (state) => state.flux.fluxType,
      (value) => {
        if (this.isSmOrMd) {
          this.activeRightSide = 0;
        }
        if (value == 3 || value == 4) {
          this.disabledArc = true;
          this.setMapStyle(1);
        } else {
          this.disabledArc = false;
        }
      }
    );

    // Prefetch infranstructure data
    this.getHospitalsData({
      observation_end: moment().format("YYYY-MM-DD"),
      observation_start: INFRASTRUCTURE_FIRST_UPDATE,
      township: 0,
      isLoading: false,
    });

    // watch activeMenu store state
    this.$store.watch(
      (state) => state.nav.activeMenu,
      (value) => {
        this.resizeTopMap();
      }
    );

    // Watch unread changelogs
    this.$store.watch(
      (state) => state.changeLog.listChangeLogs,
      (value) => {
        if (
          value.data &&
          value.data.filter((x) => x.notRead).length &&
          this.activeMenu != 7
        ) {
          this.$bvModal.show("change-log-modal");
        }
      }
    );
  },
  methods: {
    ...mapActions([
      "userMe",
      "getHospitalsData",
      "getHealthZone",
      "getFluxHotSpot",
      "getSituationHospital",
      "getHospitals",
      "completedForm__getAggregatedByHospitals",
      "completedForm__getDataByHospitals",
    ]),
    ...mapMutations([
      "setMapStyle",
      "setFluxType",
      "setObservationDate",
      "setCanShowNavMobile",
      "SET_FILTER__DATA",
      "SET_IS_COMPLETED_FORMS_AGGREGATED_LOADING",
    ]),
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
      this.setCanShowNavMobile(false);
      if (checked) {
        let confirmedCount = 0;

        this.$gtag.event("fetch_epidemioloy_data_request", {
          event_category: "fetch_epidemioloy_data",
          event_label: "covid_data_req_send",
        });

        this.$set(this.loadings, "getCovidCases_stat", true);
        axios
          .get("/api/dashboard/cavid-cases/statistics")
          .then(({ data }) => {
            const labels = [];
            const sick = [];
            const confirmed = [];
            const dead = [];
            const healed = [];

            data.sort((a, b) => {
              return a.last_update < b.last_update ? 1 : -1;
            });
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

            this.$gtag.event("fetch_epidemioloy_data_response", {
              event_category: "fetch_epidemioloy_data",
              event_label: "getCovidCases_stat",
            });
          })
          .catch(({ response }) => {
            this.$set(this.loadings, "getCovidCases_stat", false);
            this.$gtag.exception(response);
          });

        this.$set(this.loadings, "getCovidCases_statdaily", true);
        axios
          .get("/api/dashboard/cavid-cases/statistics/daily")
          .then(({ data }) => {
            const labels = [];
            const sick = [];
            const confirmed = [];
            const dead = [];
            const healed = [];
            data.sort((a, b) => {
              return a.last_update < b.last_update ? 1 : -1;
            });
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
            this.$gtag.event("fetch_epidemioloy_data_response", {
              event_category: "fetch_epidemioloy_data",
              event_label: "getCovidCases_statdaily",
            });
          })
          .catch(({ response }) => {
            this.$set(this.loadings, "getCovidCases_statdaily", false);
            this.$gtag.exception(response);
          });

        this.$set(this.loadings, "getCovidCases_cases", true);

        axios
          .get("/api/dashboard/cavid-cases")
          .then(({ data }) => {
            const Features = data.map((value) => {
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
            this.$gtag.event("fetch_epidemioloy_data_response", {
              event_category: "fetch_epidemioloy_data",
              event_label: "getCovidCases_cases",
            });
          })
          .catch(({ response }) => {
            this.$set(this.loadings, "getCovidCases_cases", false);
            this.$gtag.exception(response);
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

        this.$gtag.event("fetch_medical_orientation_data_request", {
          event_category: "fetch_medical_orientation",
          event_label: "medical_orientation_req_send",
        });
        axios
          .get("/api/dashboard/orientation-medical-result")
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

            this.$gtag.event("fetch_medical_orientation_data_response", {
              event_category: "fetch_medical_orientation",
              event_label: "orientation_medical",
            });
          })
          .catch(({ response }) => {
            this.$set(this.loadings, "orientation_medical", false);
            this.orientationCount = null;
            this.$gtag.exception(response);
          });

        this.$set(this.loadings, "orientation_medical_stats", true);
        axios
          .get("/api/dashboard/orientation-medical-stats")
          .then(({ data }) => {
            const fin = [];
            const fin5 = [];
            const fin8 = [];
            const labels = [];
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

            this.$gtag.event("fetch_medical_orientation_data_response", {
              event_category: "fetch_medical_orientation",
              event_label: "orientation_medical_stats",
            });
          })
          .catch(({ response }) => {
            this.$set(this.loadings, "orientation_medical_stats", false);
            this.$gtag.exception(response);
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
        this.$set(this.loadings, "hasSondageChecked", true);
        axios
          .get("/api/dashboard/sondages")
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
      this.setCanShowNavMobile(false);
      if (this.isLoading) {
        return;
      }
      if (values.selectedFluxSource == 2) {
        this.submitFluxAfricell(values);
        return;
      }

      this.setObservationDate({
        start: values.observation_start,
        end: values.observation_end,
      });

      if (values.selectedFluxSource == 1 && values.fluxGeoGranularity == 3) {
        this.submitFlux30Form(values);
        return;
      }

      this.isFirstLoad = false;
      this.setFluxType(1);

      const computedFluxDataByDate = this.computedFluxDataByDate;

      this.flux24Errors = {};

      let url = "api/dashboard/flux/origin";
      let urlDaily = "api/dashboard/flux/origin";
      let urlDailyCompare = "api/dashboard/flux/origin";
      let urlDailyIn = "api/dashboard/flux/origin";
      let urlDailyOut = "api/dashboard/flux/origin";

      let urlPresence = "api/dashboard/flux/origin";
      let urlPresenceDaily = "api/dashboard/flux/origin";
      let urlPresenceDailyIn = "api/dashboard/flux/origin";

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

      this.$gtag.event("fetch_orange_flux_data_request", {
        event_category: "fetch_orange_flux",
        event_label: "fetch_orange_flux_req_send",
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

          this.$gtag.event("fetch_orange_flux_data_response", {
            event_category: "fetch_orange_flux",
            event_label: "urlDaily",
          });
        })
        .catch(({ response }) => {
          this.$set(this.loadings, "urlDaily", false);
          this.$gtag.exception(response);
        });

      // get flux data in

      this.flux24DailyIn = [];
      this.$set(this.loadings, "urlDailyIn", true);
      axios
        .get(urlDailyIn, {
          params: values,
        })
        .then(({ data }) => {
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

          this.$gtag.event("fetch_orange_flux_data_response", {
            event_category: "fetch_orange_flux",
            event_label: "urlDailyIn",
          });
        })
        .catch(({ response }) => {
          this.$set(this.loadings, "urlDailyIn", false);
          this.$gtag.exception(response);
        });

      // get flux data out

      this.flux24DailyOut = [];
      this.$set(this.loadings, "urlDailyOut", true);
      axios
        .get(urlDailyOut, {
          params: values,
        })
        .then(({ data }) => {
          const groupObservations = groupBy(
            data.observations,
            (d) => d.destination
          );
          const groupReferences = groupBy(
            data.references,
            (d) => d.destination
          );
          if (values.fluxTimeGranularity == 2) {
            const referenceGroupByDate = [];
            Object.entries(groupReferences).forEach(([key, value]) => {
              referenceGroupByDate.push(
                groupBy(groupReferences[key], (d) => d.date)
              );
            });

            Object.entries(groupObservations).forEach(([key, value]) => {
              this.flux24DailyOut.push({
                references: groupReferences[key],
                observations: groupObservations[key],
              });
            });
          } else {
            Object.entries(groupObservations).forEach(([key, value]) => {
              this.flux24DailyOut.push({
                references: groupReferences[key],
                observations: groupObservations[key],
              });
            });
          }

          this.fluxDataGroupedByDateOut = computedFluxDataByDate(
            data.observations,
            data.references,
            "origin"
          );

          this.$set(this.loadings, "urlDailyOut", false);
          this.$gtag.event("fetch_orange_flux_data_response", {
            event_category: "fetch_orange_flux",
            event_label: "urlDailyOut",
          });
        })
        .catch(({ response }) => {
          this.$set(this.loadings, "urlDailyOut", false);
          this.$gtag.exception(response);
        });

      this.flux24Presence = [];

      this.flux24PresenceDailyInData = {};
      this.$set(this.loadings, "urlPresenceDailyIn", true);
      axios
        .get(urlPresenceDailyIn, {
          params: values,
        })
        .then(({ data }) => {
          this.flux24PresenceDailyInData = data;

          this.$set(this.loadings, "urlPresenceDailyIn", false);

          this.$gtag.event("fetch_orange_flux_data_response", {
            event_category: "fetch_orange_flux",
            event_label: "urlPresenceDailyIn",
          });
        })
        .catch(({ response }) => {
          this.$set(this.loadings, "urlPresenceDailyIn", false);
          this.$gtag.exception(response);
        });

      this.flux24 = [];
      this.fluxZoneGlobalIn = [];
      this.fluxZoneGlobalOut = [];
      this.topHealthZoneConfirmed = [];

      if (values.fluxGeoGranularity == 2) {
        return;
      }
      this.$gtag.event("fetch_pandemics_top_confirmed_data_request", {
        event_category: "fetch_pandemics_top_confirmed",
        event_label: "top_confirmed_req_send",
      });
      const pandemicParams = Object.assign({}, values);
      pandemicParams.fluxGeoOptions = pandemicParams.fluxGeoOptions[0];
      axios
        .get("/api/dashboard/pandemics/top-confirmed", {
          params: pandemicParams,
        })
        .then(({ data }) => {
          this.topHealthZoneConfirmed = data;

          this.$gtag.event("fetch_pandemics_top_confirmed_data_response", {
            event_category: "fetch_pandemics_top_confirmed",
            event_label: "top_confirmed",
          });
        });

      const healthZones = this.healthZones.filter(
        (x) => x.province == values.fluxGeoOptions[0]
      );
      const countAll = healthZones.length;

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

          // Get  zone in by province
          axios
            .get("/api/dashboard/flux/origin/zones/h-24/global-in/province", {
              params: healthZoneValues,
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
              this.$gtag.event("fetch_orange_flux_data_request", {
                event_category: "fetch_orange_flux",
                event_label: "global_in_provinces",
              });
            })
            .catch(({ error }) => {
              countIn++;
              this.globalProgress =
                ((countIn + countOut) / (countAll * 2)) * 100;

              this.$gtag.exception(error);
            });

          // Get  zone out by province
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

          // Get  zone out by province
          axios
            .get("/api/dashboard/flux/origin/zones/h-24/global-out/province", {
              params: healthZoneValues,
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

              this.$gtag.event("fetch_orange_flux_data_response", {
                event_category: "fetch_orange_flux",
                event_label: "global_out_provinces",
              });
            })
            .catch((error) => {
              countOut++;
              this.globalProgress =
                ((countIn + countOut) / (countAll * 2)) * 100;
              this.$gtag.exception(error);
            });

          // Get  zone out by province
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
    submitFluxAfricell(values) {
      const urlDaily = "api/dashboard/flux/africell/hors-zone/zones";
      const urlPresenceZone = "api/dashboard/flux/africell/presence/zones";
      const urlInOutZone = "api/dashboard/flux/africell/in-out/zones";

      this.$set(this.loadings, "urlFluxAfricell", true);

      const dailyRequest = axios.get(urlDaily, {
        params: values,
      });

      const presenceRequest = axios.get(urlPresenceZone, {
        params: values,
      });

      const inOutRequest = axios.get(urlInOutZone, {
        params: values,
      });

      this.setObservationDate({
        start: values.observation_start,
        end: values.observation_end,
      });

      const allRequest = [dailyRequest, presenceRequest];

      if (values.observation_start == values.observation_end) {
        allRequest.push(inOutRequest);
      }

      this.fluxAfricellDaily = [];
      this.fluxAfricelPresence = [];
      this.fluxAfricelInOut = [];

      this.$gtag.event("fetch_africell_flux_data_request", {
        event_category: "fetch_africell_flux",
        event_label: "fluxAfricell_req_send",
      });

      Promise.all(allRequest)
        .then((response) => {
          if (response[0]) {
            this.fluxAfricellDaily = response[0].data;
          }
          if (response[1]) {
            this.fluxAfricelPresence = response[1].data;
          }
          if (response[2]) {
            this.fluxAfricelInOut = response[2].data;
          }
          this.$gtag.event("fetch_africell_flux_data_response", {
            event_category: "fetch_africell_flux",
            event_label: "fluxAfricell_response",
          });
        })
        .catch(({ response }) => {
          this.$gtag.exception(response);
        })
        .finally(() => {
          this.$set(this.loadings, "urlFluxAfricell", false);
        });
    },
    submitFlux30Form(input) {
      let urlMaps = "api/dashboard/flux/hotspots";
      let urlDaily = "api/dashboard/flux/hotspots";
      let urlTendance = "api/dashboard/flux/hotspots";
      let urlGeneral = "api/dashboard/flux/hotspots";

      const values = { ...input };
      const hotspot = HOTSPOT_TYPE.find(
        (x) => x.pseudo == input.fluxGeoOptions[0]
      );
      if (hotspot) {
        // urlMaps += `/types`;
        urlDaily += "/types";
        urlTendance += "/types";
        urlGeneral += "/types";
        values.fluxGeoOptions = [hotspot.name];
      }

      urlMaps += "/maps";
      if (values.observation_start == values.observation_end) {
        urlDaily += "/daily";
      } else {
        urlDaily += "/daily-date";
      }

      urlTendance += "/tendance";
      urlGeneral += "/general";

      const dailyRequest = axios.get(urlDaily, {
        params: values,
      });
      const tendanceRequest = axios.get(urlTendance, {
        params: values,
      });

      const generalRequest = axios.get(urlGeneral, {
        params: values,
      });

      let mapsValues = values;
      if (hotspot) {
        mapsValues = { ...values };
        mapsValues.fluxGeoOptions = ["Tout"];
      }
      const mapsRequest = axios.get(urlMaps, {
        params: mapsValues,
      });

      this.isFirstLoad = false;

      this.$set(this.loadings, "urlFluxTIme30", true);
      this.flux30MapsData = [];
      this.flux24Daily = [];
      this.flux24DailyIn = [];
      this.flux24DailyOut = [];
      this.flux24Presence = [];
      this.flux24 = [];
      this.flux24PresenceDailyInData = {};
      this.fluxZoneGlobalIn = [];
      this.fluxZoneGlobalOut = [];
      this.topHealthZoneConfirmed = [];

      this.$gtag.event("fetch_orange_flux_hotspot_data_request", {
        event_category: "fetch_orange_flux_hotspot",
        event_label: "fetch_orange_flux_hotspot_req_send",
      });

      tendanceRequest
        .then(({ data }) => {
          this.flux24Daily = data.observations;
        })
        .catch(({ response }) => {
          this.$gtag.exception(response);
        });

      Promise.all([mapsRequest, dailyRequest, generalRequest])
        .then((response) => {
          if (response[0]) {
            const data = response[0].data;
            const observations = data.observations;
            const references = data.references;

            // const observations = [];
            // const references = [];

            observations.forEach((item) => {
              const referenceData = references.find(
                (x) => x.origin == item.origin
              );
              if (!item || !referenceData) {
                return;
              }
              const difference = item.volume - referenceData.volume;
              const percent = (difference / referenceData.volume) * 100;
              if (referenceData) {
                const element = {
                  origin: item.origin,
                  volume: item.volume,
                  difference,
                  percent,
                  volumeReference: referenceData.volume,
                };
                this.flux30MapsData.push(element);
              }
            });
            // si aucune donnée n'existe pour ce hotspot
            if (this.flux30MapsData.length == 0) {
              const element = {
                origin: values.fluxGeoOptions[0],
                volume: null,
                difference: null,
                percent: null,
                volumeReference: null,
                empty: true,
              };
              this.flux30MapsData.push(element);
            }
          }
          if (response[1]) {
            this.flux30Daily = this.flux30Daily = response[1].data.observations;
          }
          // if (response[2]) {
          //   this.flux24Daily = response[2].data.observations;
          // }
          if (response[2]) {
            const observation = response[2].data.observations;
            const reference = response[2].data.references;
            let difference = null;
            let percent = null;

            if (reference) {
              difference = observation - reference;
              percent = (difference * 100) / reference;
            }

            this.flux30General = {
              observation,
              reference,
              difference,
              percent,
            };
          }

          this.$gtag.event("fetch_orange_flux_hotspot_data_response", {
            event_category: "fetch_orange_flux_hotspot",
            event_label: "fetch_orange_flux_hotspot_response",
          });
        })
        .catch(({ response }) => {
          this.$gtag.exception(response);
        })
        .finally(() => {
          this.$set(this.loadings, "urlFluxTIme30", false);
        });
    },
    initForm() {
      this.setCanShowNavMobile(false);
      this.isLoading = true;
      this.SET_IS_COMPLETED_FORMS_AGGREGATED_LOADING(true);
    },
    submitInfrastructureForm(values) {
      this.setCanShowNavMobile(false);
      values.isLoading = true;
      this.getHospitalsData(values);
      this.SET_FILTER__DATA(values);
      this.completedForm__getAggregatedByHospitals(values);
      this.initForm();
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

      const url = "api/dashboard/flux/predefined/zones/h-24/";
      const urlDaily = "api/dashboard/flux/predefined/zones/h-24/daily";
      const urlDailyIn = "api/dashboard/flux/predefined/zones/h-24/daily-in";
      const urlDailyOut = "api/dashboard/flux/predefined/zones/h-24/daily-out";
      const urlDailyCompare =
        "api/dashboard/flux/predefined/zones/h-24/daily-compare";

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
    toggleShowMobiliteGenerale(checked) {
      this.showMobiliteGenerale = checked;
    },
    toggleFullscreenMap() {
      this.$refs.fullscreenMap.toggle();
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
      this.$set(this.isFluxGlobalProvinceloading, "in", true);

      axios
        .get("/api/dashboard/flux/origin/provinces/h-24/global-in", {
          params: {
            observation_start: OBSERVATION_START,
            observation_end: OBSERVATION_END,
            preference_start: PREFERENCE_START,
            preference_end: PREFERENCE_END,
          },
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

      this.$set(this.isFluxGlobalProvinceloading, "out", true);
      axios
        .get("/api/dashboard/flux/origin/provinces/h-24/global-out", {
          params: {
            observation_start: OBSERVATION_START,
            observation_end: OBSERVATION_END,
            preference_start: PREFERENCE_START,
            preference_end: PREFERENCE_END,
          },
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

      if (this.fluxDataGroupedByDateIn.referencesByDate) {
        temp.referencesByDate = [
          ...temp.referencesByDate,
          ...this.fluxDataGroupedByDateIn.referencesByDate,
        ];
      }

      if (this.fluxDataGroupedByDateOut.referencesByDate) {
        temp.referencesByDate = [
          ...temp.referencesByDate,
          ...this.fluxDataGroupedByDateOut.referencesByDate,
        ];
      }

      if (this.fluxDataGroupedByDateIn.observationsByDate) {
        temp.observationsByDate = [
          ...temp.observationsByDate,
          ...this.fluxDataGroupedByDateIn.observationsByDate,
        ];
      }

      if (this.fluxDataGroupedByDateOut.observationsByDate) {
        temp.observationsByDate = [
          ...temp.observationsByDate,
          ...this.fluxDataGroupedByDateOut.observationsByDate,
        ];
      }

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

    loadTownships() {
      axios.get("/api/dashboard/townships").then(({ data }) => {
        this.townships = data;
      });
    },
    fluxDataProvideChanged(value) {
      this.selectedFluxDataProvider = value;
    },
    rightTabActived(newTabIndex) {
      this.showMobileMaps = newTabIndex == 0;
    },
    toggleNavMobile() {
      this.setCanShowNavMobile(!this.canShowNavMobile);
    },
    resizeTopMap() {
      if (!this.isSmOrMd) {
        return;
      }
      if (this.$refs.tabs_right) {
        setTimeout(() => {
          this.mapMdTop = this.$refs.tabs_right.$refs.nav.clientHeight + 16.4;
        }, 100);
      }
    },
  },
};
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";
.dash-home-page {
  // height: 100vh;
  background: $dash-background;
  overflow-y: scroll;
  // .side-bottom {
  // height: calc(20vh - 72.5px);
  // }
  .side-right {
    .flux-data-toggle {
      position: absolute;
      right: 0;
    }
  }
  // }

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
  background: transparent;
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
    background: rgba(46, 91, 255, 0.5);
    color: white !important;
    border-radius: 5px;
    &.active {
      background: $dash-green;
      color: white !important;
    }
    &:hover {
      opacity: 0.8;
    }
  }
}
.legend-orientation {
  position: absolute;
  bottom: 20px;
  left: 20px;
  z-index: 200;
}

.map-md {
  @media screen and (max-width: 1023px) {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    top: 5%;
  }
  @media screen and (max-width: 576px) {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    top: 12%;
  }
}
.container-filter-btn {
  position: fixed;
  right: 2%;
  top: 90%;
  z-index: 10;
  button {
    box-shadow: 0px 0px 8px 0px #2e5bffb8;
  }
}
.container-filter-btn-close {
  position: absolute;
  right: 5%;
  top: -30px;
  z-index: 10;
  i {
    font-size: 1.5rem;
    color: #eee;
  }
}
.mob-header-container {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: $waiting_background;
  display: flex;
  place-items: center;
}
</style>
