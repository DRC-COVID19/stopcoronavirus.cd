<template>
  <div>
    <b-container class="p-0 flux-chart">
      <b-row class="mb-2">
        <div class="col-md col-12">
          <h3 class="d-flex align-items-center mb-0">
            <span class="ml-2 mr-2">{{ targetZone }}</span>

            <toggle-button
              v-if="fluxTimeGranularity == 1"
              :labels="typesMobilite"
              :globalProgress="globalProgress"
              v-model="typeMobilite"
            ></toggle-button>
          </h3>
        </div>
        <div class="col-md col-12 d-flex justify-content-end">
          <div>
            <p class="small m-0 text-muted">
              Données fournies par
              <b>Orange</b>
            </p>
            <p class="small m-0">
              <span class="text-muted">Mise à jour du</span>
              <b>{{ moment(last_update).format("Y-MM-DD") }}</b>
            </p>
          </div>
          <div>
            <b-img
              width="38"
              height="38"
              src="/img/Orange_logo.svg"
              class="logoPartenaire"
              alt="orange logo"
            />
          </div>
        </div>
      </b-row>

      <b-row no-gutters v-show="fluxTimeGranularity == 2" class="mb-4">
        <b-col
          cols="12"
          md="12"
          class="pl-0 col-mobilite-generale"
          v-show="!isLoading"
        >
          <b-card class="mb-3 flux-mobility active">
            <h5 class="percent-title">Présence</h5>
            <p class="text-muted" v-if="!flux30General.percent">
              Données non disponibles
            </p>
            <div v-else>
              <div class="percent flux-presence">
                {{ Math.round(flux30General.percent) }}%​
              </div>
              <p class="percent-p text-dash-color mb-0">
                {{ formatCash(flux30General.difference) }} personnes de
                <span v-if="flux30General.difference > 0">plus</span>
                <span v-else>moins</span>
                ont été présentes dans la zone
              </p>
            </div>
          </b-card>
          <FullScreen
            id="flux_30_daily"
            link="flux_30_daily_chart"
            @change="fullscreenMobileDaily"
            v-show="this.flux30Daily.length > 0"
          >
            <b-card no-body class="cardtype1 mb-3 p-2">
              <div class="general-top-title">Title</div>
              <div class="chart-container">
                <canvas
                  height="200"
                  width="100vh"
                  ref="flux_30_daily_chart"
                  id="flux_30_daily_chart"
                ></canvas>
              </div>
            </b-card>
          </FullScreen>
          <b-row>
            <b-col cols="12">
              <h3 class=" mt-2 mb-3">Légende type de Hotspot</h3>
            </b-col>
          </b-row>
          <b-row align-h="start">
            <b-col cols="12" md="3">
              <div
                v-for="(item, index) in hotspotType.slice(0, 5)"
                :key="index"
              >
                <span
                  class="flux-chart-lenged-color"
                  :style="{ background: item.color }"
                ></span>
                <span class="flux-chart-lenged-text">{{ item.name }}</span>
              </div>
            </b-col>
            <b-col cols="12" md="3">
              <div
                v-for="(item, index) in hotspotType.slice(5, 10)"
                :key="index"
              >
                <span
                  class="flux-chart-lenged-color"
                  :style="{ background: item.color }"
                ></span>
                <span class="flux-chart-lenged-text">{{ item.name }}</span>
              </div>
            </b-col>
          </b-row>
        </b-col>

        <b-col
          cols="12"
          md="12"
          class="pl-0 col-mobilite-generale"
          v-if="isLoading"
        >
          <skeleton-loading class="mb-3" v-if="isLoading">
            <square-skeleton
              :boxProperties="{
                width: '100%',
                height: '175px',
              }"
            ></square-skeleton>
          </skeleton-loading>

          <skeleton-loading class="mb-3" v-if="isLoading">
            <square-skeleton
              :boxProperties="{
                width: '100%',
                height: '200px',
              }"
            ></square-skeleton>
          </skeleton-loading>
        </b-col>
      </b-row>

      <b-row
        no-gutters
        v-show="fluxTimeGranularity == 1 && this.typeMobilite != 3"
      >
        <b-col
          cols="12"
          v-show="this.typeMobilite == 2"
          md="12"
          class="pl-0 col-mobilite-generale"
        >
          <b-card
            class="mb-3 flux-mobility"
            :class="{ active: fluxType == 4 }"
            @click="selectFluxType(4)"
          >
            <h5 class="percent-title">Mobilité générale</h5>
            <div class="percent flux-in-color">{{ percentGenerale }}%​</div>

            <p class="percent-p text-dash-color mb-0">
              {{ differenceGenerale }} personnes de
              <span v-if="differenceGenerale > 0">plus</span>
              <span v-else>moins</span>
              sont entrées et sorties de la zone
            </p>
          </b-card>

          <FullScreen
            id="mobile_generale_full"
            link="general_flux"
            @change="fullscreenMobileDaily"
          >
            <b-card no-body class="cardtype1 mb-3 p-2">
              <div class="general-top-title">
                Mobilité générale intérieure de la zone
              </div>
              <div class="chart-container">
                <canvas
                  height="200"
                  width="100vh"
                  ref="general_flux"
                  id="general_flux"
                ></canvas>
              </div>
            </b-card>
          </FullScreen>

          <b-row>
            <b-col cols="12" md="4">
              <FullScreen
                id="general_top_asc"
                link="general_top_asc"
                @change="fullscreenFluxInOut"
              >
                <b-card no-body class="cardtype2 p-2">
                  <div class="general-top-title">
                    Les 5 zones de santé avec la plus forte décroissance de
                    mobilité
                  </div>

                  <div class="chart-container">
                    <canvas
                      height="200"
                      width="100vh"
                      ref="general_top_asc"
                      id="general_top_asc"
                    ></canvas>
                  </div>
                </b-card>
              </FullScreen>
            </b-col>

            <b-col cols="12" md="4">
              <FullScreen
                id="general_top_desc"
                link="general_top_desc"
                @change="fullscreenFluxInOut"
              >
                <b-card no-body class="cardtype2 p-2">
                  <div class="general-top-title">
                    Les 5 zones de santé avec la plus faible décroissance de
                    mobilité
                  </div>

                  <div class="chart-container">
                    <canvas
                      height="200"
                      width="100vh"
                      ref="general_top_desc"
                      id="general_top_desc"
                    ></canvas>
                  </div>
                </b-card>
              </FullScreen>
            </b-col>

            <b-col cols="12" md="4">
              <FullScreen
                id="pandemic_top_desc"
                link="pandemic_top_desc"
                @change="fullscreenFluxInOut"
              >
                <b-card no-body class="cardtype2 p-2">
                  <div class="general-top-title">
                    Impacte sur la mobilité pour les 5 zones de santé les plus
                    affectées
                  </div>
                  <div class="chart-container">
                    <canvas
                      height="200"
                      width="100vh"
                      ref="pandemic_top_desc"
                      id="pandemic_top_desc"
                    ></canvas>
                  </div>
                </b-card>
              </FullScreen>
            </b-col>
          </b-row>
        </b-col>

        <b-col
          cols="12"
          v-show="this.typeMobilite == 1"
          md="4"
          class="pl-0"
          ref="mobility"
        >
          <b-row class="mb-3">
            <b-col cols="12">
              <skeleton-loading class="mb-3" v-if="isLoading">
                <square-skeleton
                  :boxProperties="{
                    width: '100%',
                    height: '175px',
                  }"
                ></square-skeleton>
              </skeleton-loading>

              <skeleton-loading class="mb-3" v-if="isLoading">
                <square-skeleton
                  :boxProperties="{
                    width: '100%',
                    height: '200px',
                  }"
                ></square-skeleton>
              </skeleton-loading>

              <skeleton-loading v-if="isLoading">
                <square-skeleton
                  :boxProperties="{
                    width: '100%',
                    height: '400px',
                  }"
                ></square-skeleton>
              </skeleton-loading>

              <b-card
                class="mb-3 flux-mobility"
                :class="{ active: fluxType == 1 }"
                @click="selectFluxType(1)"
                v-show="!isLoading"
              >
                <h5 class="percent-title">Mobilité entrante</h5>

                <div class="percent flux-in-color">{{ percentIn }}%​</div>
                <p class="percent-p text-dash-color mb-0">
                  {{ differenceIn }} personnes de
                  <span v-if="differenceIn > 0">plus</span>
                  <span v-else>moins</span>
                  sont entrées dans la zone
                  <br />
                  <span style="opacity: 0">-</span>
                </p>
              </b-card>

              <FullScreen
                id="fullscreenEntrance"
                link="mobile_in"
                @change="fullscreenMobileDaily"
                v-show="!isLoading"
              >
                <b-card
                  no-body
                  class="cardtype1 mb-3 p-2"
                  ref="mobile_entrance_card"
                >
                  <div class="chart-container">
                    <canvas
                      height="200"
                      width="100vh"
                      ref="mobile_in"
                      id="mobile_in"
                    ></canvas>
                  </div>
                </b-card>
              </FullScreen>

              <FullScreen
                id="fullscreenEntrance2"
                link="mobile_entrance_2_card"
                @change="fullscreenFluxInOut"
                v-show="!isLoading"
              >
                <b-card no-body class="cardtype2 p-2">
                  <div class="chart-container">
                    <canvas
                      height="400"
                      width="100vh"
                      ref="mobile_entrance_2_card"
                      id="mobile_entrance_2_card"
                    ></canvas>
                  </div>
                </b-card>
              </FullScreen>
            </b-col>
          </b-row>
        </b-col>

        <b-col
          cols="12"
          md="4"
          class="pr-0 pl-2"
          v-show="this.typeMobilite == 1"
        >
          <b-row class="mb-3">
            <b-col cols="12">
              <skeleton-loading class="mb-3" v-if="isLoading">
                <square-skeleton
                  :boxProperties="{
                    width: '100%',
                    height: '175px',
                  }"
                ></square-skeleton>
              </skeleton-loading>

              <skeleton-loading class="mb-3" v-if="isLoading">
                <square-skeleton
                  :boxProperties="{
                    width: '100%',
                    height: '200px',
                  }"
                ></square-skeleton>
              </skeleton-loading>

              <skeleton-loading v-if="isLoading">
                <square-skeleton
                  :boxProperties="{
                    width: '100%',
                    height: '400px',
                  }"
                ></square-skeleton>
              </skeleton-loading>
              <b-card
                class="mb-3 flux-mobility"
                :class="{ active: fluxType == 2 }"
                @click="selectFluxType(2)"
                v-show="!isLoading"
              >
                <h5 class="percent-title">Mobilité sortante</h5>
                <div class="percent flux-out-color">{{ percentOut }}%​</div>
                <p class="percent-p text-dash-color mb-0">
                  {{ differenceOut }} personnes de
                  <span v-if="differenceOut > 0">plus</span>
                  <span v-else>moins</span>
                  sont sorties de la zone
                  <br />
                  <span style="opacity: 0">-</span>
                </p>
              </b-card>

              <FullScreen
                id="fullscreenOut"
                link="mobile_out"
                @change="fullscreenMobileDaily"
                v-show="!isLoading"
              >
                <b-card
                  no-body
                  class="mb-3 p-2 cardtype1"
                  :ref="`mobile_out_card`"
                >
                  <div class="chart-container">
                    <canvas
                      height="200"
                      width="100vh"
                      ref="mobile_out"
                      id="mobile_out"
                    ></canvas>
                  </div>
                </b-card>
              </FullScreen>

              <FullScreen
                id="fullscreenOut2"
                link="mobile_out_2_card"
                @change="fullscreenFluxInOut"
                v-show="!isLoading"
              >
                <b-card no-body class="p-2 cardtype2">
                  <div class="chart-container">
                    <canvas
                      height="400"
                      width="100vh"
                      ref="mobile_out_2_card"
                      id="mobile_out_2_card"
                    ></canvas>
                  </div>
                </b-card>
              </FullScreen>
            </b-col>
          </b-row>
        </b-col>

        <b-col
          cols="12"
          md="4"
          class="pr-0 pl-2"
          v-show="this.typeMobilite == 1"
        >
          <skeleton-loading class="mb-3" v-if="isLoading">
            <square-skeleton
              :boxProperties="{
                width: '100%',
                height: '175px',
              }"
            ></square-skeleton>
          </skeleton-loading>

          <skeleton-loading class="mb-3" v-if="isLoading">
            <square-skeleton
              :boxProperties="{
                width: '100%',
                height: '200px',
              }"
            ></square-skeleton>
          </skeleton-loading>
          <b-card
            class="mb-3 flux-mobility"
            :class="{
              active: fluxType == 3,
              disabled: globalProgress && globalProgress < 100,
            }"
            @click="selectFluxType(3)"
            v-show="!isLoading"
          >
            <div class="row justify-content-between">
              <h5 class="percent-title">Présences</h5>
              <div class="btns-toggle-presence">
                <i
                  class="fa fa-sun"
                  title="N'afficher que les présences jour"
                  :class="{ active: typePresence == 2 || typePresence == 1 }"
                  @click="toggleTypePresence(2)"
                  @dblclick="defineTypePresence(2)"
                ></i>
                <i
                  class="fa fa-moon"
                  title="N'afficher que les présences nuit"
                  :class="{ active: typePresence == 3 || typePresence == 1 }"
                  @click="toggleTypePresence(3)"
                  @dblclick="defineTypePresence(3)"
                ></i>
              </div>
            </div>
            <div class="percent flux-presence">{{ percentPresence }}%​</div>
            <p class="percent-p text-dash-color mb-0">
              {{ differencePresence }} personnes de
              <span v-if="differencePresence > 0">plus</span>
              <span v-else>moins</span>
              étaient présentes dans la zone
              <br />
              <span v-if="typePresence == 2">durant la journée</span>
              <span v-else-if="typePresence == 3">durant la nuit</span>
              <span v-else style="opacity: 0">-</span>
            </p>
          </b-card>

          <FullScreen
            id="mobile_presence_full"
            link="mobile_presence"
            @change="fullscreenMobileDaily"
            v-show="!isLoading"
          >
            <b-card
              no-body
              class="mb-3 p-2 cardtype1"
              ref="mobile_presence_card"
            >
              <div class="chart-container">
                <canvas
                  height="400"
                  width="100vh"
                  ref="mobile_presence"
                  id="mobile_presence"
                ></canvas>
              </div>
            </b-card>
          </FullScreen>
        </b-col>
      </b-row>

      <b-row
        class="no-gutters"
        v-show="fluxTimeGranularity == 1 && this.typeMobilite == 3"
      >
        <!--
        <b-row>
          <b-col cols="12" md="6">
            <h5 @click="seeProvinceStat" class="return-global">
              <span class="fa fa-chevron-left"></span>
              {{fluxGeoOptions[0]}}
            </h5>
          </b-col>
          <b-col cols="12" md="6" class="text-right">
            <h5 class="m-0" style="font-size: 19px;">{{moment(last_update).format('Y-MM-DD')}}</h5>
            <span class="small text-muted">Dernière mise à jour</span>
          </b-col>
        </b-row>
        -->

        <b-col cols="12" md="6" class="pr-2">
          <GlobalProvice
            title="Mobilité entrante par zone"
            :color="palette.flux_in_color"
            :globalData="fluxZoneGlobalIn"
            reference="fluxZoneglobalIn"
          />
        </b-col>
        <b-col cols="12" md="6" class="pl-2">
          <GlobalProvice
            title="Mobilité sortante par zone"
            :color="palette.flux_out_color"
            :globalData="fluxZoneGlobalOut"
            reference="fluxZoneglobalOut"
          />
        </b-col>
      </b-row>
    </b-container>
    <!-- <ChartToolTip
      :item="toolTipItem"
      :position="toolTipItem ? toolTipItem.position : null"
    /> -->
  </div>
</template>

<script>
import * as d3 from "d3";
import { mapState, mapMutations } from "vuex";
import { PALETTE, FLUX_LAST_UPDATE, HOTSPOT_TYPE } from "../config/env";
import GlobalProvice from "./flux/GLobalProvince";
import ToggleButton from "../components/ToggleButton";
import { difference } from "@turf/turf";
import { debounce, includes } from "lodash";
import ChartToolTip from "./ChartToolTip";
import Chart from "chart.js";
import "chartjs-plugin-annotation";

Chart.defaults.global.defaultFontFamily = "'Rubik',sans-serif";
Chart.defaults.global.defaultFontColor = "#7b7f88";

export default {
  components: {
    GlobalProvice,
    ToggleButton,
    ChartToolTip,
  },
  props: {
    flux24Daily: {
      type: Array,
      default: () => [],
    },
    flux24PresenceDaily: {
      type: Array,
      default: () => [],
    },
    flux24PresenceDailyIn: {
      type: Object,
      default: () => ({}),
    },
    flux24DailyIn: {
      type: Array,
      default: () => [],
    },
    flux24DailyOut: {
      type: Array,
      default: () => [],
    },
    flux24DailyGenerale: {
      type: Array,
      default: () => [],
    },
    fluxZoneGlobalIn: {
      type: Array,
      default: () => [],
    },
    fluxZoneGlobalOut: {
      type: Array,
      default: () => [],
    },
    mobiliteGenerale: {
      type: Boolean,
      default: false,
    },
    fluxDataGroupedByDateIn: {
      type: Object,
      default: () => ({}),
    },
    fluxDataGroupedByDateOut: {
      type: Object,
      default: () => ({}),
    },
    fluxDataGroupedByDateGen: {
      type: Object,
      default: () => ({}),
    },
    topHealthZoneConfirmed: {
      type: Array,
      default: () => [],
    },
    globalProgress: {
      default: null,
    },
    isLoading: {
      type: Boolean,
      default: false,
    },
    flux30Daily: {
      type: Array,
      default: () => [],
    },
    flux30General: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      last_update: new Date(FLUX_LAST_UPDATE),
      flux24DailyInLocal: [],
      flux24DailyOutLocal: [],
      flux24DailyPresenceInLocal: [],
      flux24DailyGeneraleLocal: [],
      configBarChart: {},
      configBarChart2: {},
      configBarChartGen: {},
      barChart: {},
      barChart2: {},
      barChartGen: null,
      palette: PALETTE,
      lineCharts: {},
      percentOut: null,
      percentIn: null,
      percentGenerale: null,
      percentPresence: null,
      differenceIn: null,
      differenceOut: null,
      differenceGenerale: null,
      differencePresence: null,
      targetZone: null,
      typeMobilite: 1,
      fluxGeoGranularity: 2,
      areZoomable: [],
      toolTipItem: {},
      hotspotType: HOTSPOT_TYPE,
    };
  },
  computed: {
    ...mapState({
      fluxType: (state) => state.flux.fluxType,
      isProvinceStatSeeing: (state) => state.flux.isProvinceStatSeeing,
      fluxGeoOptions: (state) => state.flux.fluxGeoOptions,
      typePresence: (state) => state.flux.typePresence,
      fluxTimeGranularity: (state) => state.flux.fluxTimeGranularity,
      observationDate: (state) => state.flux.observationDate,
    }),
    typesMobilite() {
      let types = [{ val: 1, lbl: "Détails" }];
      if (
        this.fluxGeoGranularity == 1 &&
        this.globalProgress &&
        this.globalProgress == 100
      ) {
        types.push({ val: 2, lbl: "Général" });
      }
      if (
        (this.fluxZoneGlobalIn.length > 0 ||
          this.fluxZoneGlobalOut.length > 0) &&
        this.fluxGeoGranularity == 1 &&
        this.globalProgress &&
        this.globalProgress == 100
      ) {
        types.push({ val: 3, lbl: "Zones" });
      }
      return types;
    },
  },
  watch: {
    flux24DailyIn() {
      this.typeMobilite = 1;
      this.updateFluxInMobility();
    },
    flux24DailyOut() {
      this.updateFluxOutMobility();
    },
    flux24PresenceDailyIn() {
      this.mobilePresence();
    },
    fluxDataGroupedByDateIn() {
      this.mobileIn();
    },
    fluxDataGroupedByDateOut() {
      this.mobileOut();
    },
    flux30Daily() {
      this.$nextTick(() => {
        this.flux30Chart(
          this.flux30Daily,
          "flux_30_daily_chart",
          PALETTE.flux_presence
        );
      });
    },
    fluxZoneGlobalIn() {
      this.fluxMobilityFluxGeneralZone(
        this.fluxZoneGlobalIn,
        "general_top_asc",
        "general_top_desc",
        `Les 5 zones de santé avec la plus forte décroissance de mobilité`,
        "Les 5 zones de santé avec la plus faible décroissance de mobilité",
        this.topHealthZoneConfirmed,
        "Impacte sur la mobilité pour les 5 zones de santé les plus affectées",
        "pandemic_top_desc"
      );
      this.updateGeneralMobilityDaily();
    },
    topHealthZoneConfirmed() {
      // this.topHealthZonePandemics(
      //   this.topHealthZoneConfirmed,
      //   "pandemic_top_desc",
      //   "Impacte sur la mobilité pour les 5 zones de santé les plus affectées"
      // );
      this.fluxMobilityFluxGeneralZone(
        this.fluxZoneGlobalIn,
        "general_top_asc",
        "general_top_desc",
        `Les 5 zones de santé avec la plus forte décroissance de mobilité`,
        "Les 5 zones de santé avec la plus faible décroissance de mobilité",
        this.topHealthZoneConfirmed,
        "Impacte sur la mobilité pour les 5 zones de santé les plus affectées",
        "pandemic_top_desc"
      );
    },
    mobiliteGenerale() {
      if (this.mobiliteGenerale) {
        this.selectFluxType(4);
        this.typeMobilite = 2;
      }
    },
    typeMobilite() {
      if (this.typeMobilite == 2) {
        this.selectFluxType(4);
      } else if (this.typeMobilite == 1) {
        this.selectFluxType(1);
      }
      if (this.typeMobilite == 3) {
        this.setIsProvinceStatSeeing(true);
      } else if (this.isProvinceStatSeeing) {
        this.setIsProvinceStatSeeing(false);
      }
    },
  },
  mounted() {
    if (this.mobiliteGenerale) {
      this.selectFluxType(4);
      this.typeMobilite = 2;
    } else if (this.isProvinceStatSeeing) {
      this.typeMobilite = 3;
      this.selectFluxType(1);
    } else {
      this.selectFluxType(1);
    }

    this.updateFluxInMobility();
    this.updateFluxOutMobility();

    this.mobilePresence();

    this.mobileOut();

    this.mobileIn();

    this.fluxMobilityFluxGeneralZone(
      this.fluxZoneGlobalIn,
      "general_top_asc",
      "general_top_desc",
      `Les 5 zones de santé avec la plus forte décroissance de mobilité`,
      "Les 5 zones de santé avec la plus faible décroissance de mobilité",
      this.topHealthZoneConfirmed,
      "Impacte sur la mobilité pour les 5 zones de santé les plus affectées",
      "pandemic_top_desc"
    );

    // this.topHealthZonePandemics(
    //   this.topHealthZoneConfirmed,
    //   "pandemic_top_desc",
    //   "Impacte sur la mobilité pour les 5 zones de santé les plus affectées"
    // );

    this.updateGeneralMobilityDaily();
    this.targetZone = this.fluxGeoOptions[0];
    this.$nextTick(() => {
      this.flux30Chart(
        this.flux30Daily,
        "flux_30_daily_chart",
        PALETTE.flux_presence
      );
    });

    this.$store.watch(
      (state) => state.flux.fluxGeoOptions,
      (value) => {
        this.targetZone = value[0];
      }
    );
    this.fluxGeoGranularity = this.$store.state.flux.fluxGeoGranularity;
    this.$store.watch(
      (state) => state.flux.fluxGeoGranularityTemp,
      (value) => {
        this.fluxGeoGranularity = value;
        if (this.fluxGeoGranularity == 2) {
          this.typeMobilite = 1;
        }
      }
    );
  },
  methods: {
    ...mapMutations([
      "setFluxType",
      "setIsProvinceStatSeeing",
      "setTypePresence",
    ]),
    isStartIsEnd() {
      return (
        this.observationDate.start &&
        this.observationDate.start == this.observationDate.end
      );
    },
    selectFluxType(value) {
      this.setFluxType(value);
    },
    fluxInPercent({ referencesByDate, observationsByDate }) {
      if (!referencesByDate || !observationsByDate) {
        return {
          percent: null,
          difference: null,
        };
      }
      const result = this.formatFluxDataByMedian({
        references: referencesByDate,
        observations: observationsByDate,
      });
      return {
        percent: result.percent,
        difference: result.difference,
      };
    },
    mobilePresence() {
      this.$nextTick(() => {
        const result = this.fluxInPercent(
          Object.assign({}, this.flux24PresenceDailyIn)
        );
        this.percentPresence = result.percent;
        this.differencePresence = this.formatCash(result.difference);
        this.mobileCalc(
          this.flux24PresenceDailyIn,
          `mobile_presence`,
          PALETTE.flux_presence
        );
      });
    },
    mobileOut() {
      this.$nextTick(() => {
        const result = this.fluxInPercent(
          Object.assign({}, this.fluxDataGroupedByDateOut)
        );
        this.percentOut = result.percent;
        this.differenceOut = this.formatCash(result.difference);
        this.mobileCalc(
          this.fluxDataGroupedByDateOut,
          `mobile_out`,
          PALETTE.flux_out_color
        );
      });
    },
    mobileIn() {
      this.$nextTick(() => {
        const result = this.fluxInPercent(
          Object.assign({}, this.fluxDataGroupedByDateIn)
        );
        this.percentIn = result.percent;
        this.differenceIn = this.formatCash(result.difference);
        this.mobileCalc(
          this.fluxDataGroupedByDateIn,
          `mobile_in`,
          PALETTE.flux_in_color
        );
      });
    },
    updateGeneralMobilityZone() {
      this.$nextTick(() => {
        const referencesByDateIn = this.flux24DailyIn.referencesByDate ?? [];
        const observationsByDateIn =
          this.flux24DailyIn.observationsByDate ?? [];

        const referencesByDateOut = this.flux24DailyOut.referencesByDate ?? [];
        const observationsByDateOut =
          this.flux24DailyOut.observationsByDate ?? [];

        const referencesByDate = [];
        const observationsByDate = [];
        [...referencesByDateIn, ...referencesByDateOut].map((item) => {
          const element = referencesByDate.find((x) => x.date == item.date);
          if (element) {
            element.volume += item.volume;
          } else {
            referencesByDate.push({
              volume: item.volume,
              date: item.date,
            });
          }
        });

        [...observationsByDateIn, ...observationsByDateOut].map((item) => {
          const element = observationsByDate.find((x) => x.date == item.date);
          if (element) {
            element.volume += item.volume;
          } else {
            observationsByDate.push({
              volume: item.volume,
              date: item.date,
            });
          }
        });
        const general = {
          referencesByDate,
          observationsByDate,
        };
        const result = this.fluxInPercent(Object.assign({}, general));
        this.percentGenerale = result.percent;
        this.differenceGenerale = this.formatCash(result.difference);

        this.mobileCalc(general, "general_flux", PALETTE.flux_in_color);
      });
    },
    updateGeneralMobilityDaily() {
      this.$nextTick(() => {
        const referencesByDate = [];
        const observationsByDate = [];
        this.fluxZoneGlobalIn.map(
          ({ general_observation, general_reference }) => {
            general_reference.map((item) => {
              const reference = referencesByDate.find(
                (x) => x.date == item.date
              );
              if (reference) {
                reference.volume += item.volume;
              } else {
                referencesByDate.push({
                  volume: item.volume,
                  date: item.date,
                  day: item.day,
                });
              }
            });

            general_observation.map((item) => {
              const element = observationsByDate.find(
                (x) => x.date == item.date
              );
              if (element) {
                element.volume += item.volume;
              } else {
                observationsByDate.push({
                  volume: item.volume,
                  date: item.date,
                  day: item.day,
                });
              }
            });
          }
        );
        const general = {
          referencesByDate,
          observationsByDate,
        };
        const result = this.fluxInPercent(Object.assign({}, general));
        this.percentGenerale = result.percent;
        this.differenceGenerale = this.formatCash(result.difference);
        this.mobileCalc(
          Object.assign({}, general),
          `general_flux`,
          PALETTE.flux_in_color
        );
      });
    },
    updateFluxInMobility() {
      this.$nextTick(() => {
        this.fluxMobilityFluxZone(
          this.flux24DailyIn,
          "mobile_entrance_2_card",
          "origin",
          PALETTE.flux_in_color
        );
      });
    },
    updateFluxOutMobility() {
      this.$nextTick(() => {
        this.fluxMobilityFluxZone(
          this.flux24DailyOut,
          "mobile_out_2_card",
          "destination",
          PALETTE.flux_out_color
        );
      });
    },
    mobileCalc(
      { referencesByDate, observationsByDate },
      ref,
      color,
      title = null
    ) {
      // set the dimensions and margins of the graph

      if (!referencesByDate || !observationsByDate) {
        return;
      }

      let data = [];
      let DataReference = [];
      let totalReference = 0;
      let referenceAverage = 0;

      referencesByDate.sort((a, b) => {
        return new Date(a.date ?? 0) > new Date(b.date ?? 0) ? 1 : -1;
      });
      observationsByDate.sort((a, b) => {
        return new Date(a.date ?? 0) > new Date(b.date ?? 0) ? 1 : -1;
      });

      data = observationsByDate.map((item) => {
        const references = referencesByDate.filter((x) => x.day == item.day);
        references.sort((a, b) => {
          return Number(a.volume ?? 0) < Number(b.volume ?? 0) ? 1 : -1;
        });
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

      const max = d3.max(data.map((x) => x.percent));
      const min = d3.min(data.map((x) => x.percent));

      this.configBarChart[ref] = {
        type: "line",
        data: {
          labels: data.map((x) => new Date(x.date)),
          datasets: [
            {
              label: "Volume",
              fill: false,
              borderColor: color,
              backgroundColor: "rgb(166,180,205, 0.2)",
              data: data.map((x) => ({ x: new Date(x.date), y: x.percent })),
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            display: false,
          },
          title: {
            display: !!title,
            text: title,
          },
          plugins: {
            crosshair: {
              line: {
                color: "#F66", // crosshair line color
                width: 1, // crosshair line width
                dashPattern: [5, 5], // crosshair line dash pattern
              },
              zoom: {
                enabled: true,
              },
              sync: {
                enabled: false, // enable trace line syncing with other charts
              },
            },
          },
          tooltips: {
            enabled: true,
            mode: "interpolate",
            intersect: false,
            // custom: (tooltipModel) => {
            //   if (!tooltipModel || !tooltipModel.dataPoints) {
            //     this.toolTipItem = null;
            //     return;
            //   }
            //   const i = tooltipModel.dataPoints[0];
            //   const element = data.find(
            //     (x) => x.date == i.xLabel.format("YYYY-MM-DD")
            //   );

            //   // `this` will be the overall tooltip
            //   const position = this.lineCharts[
            //     ref
            //   ].canvas.getBoundingClientRect();
            //   element.position = {
            //     left: position.left + tooltipModel.caretX + window.pageXOffset,
            //     top: position.top + tooltipModel.caretY + window.pageYOffset,
            //   };
            //   this.toolTipItem = element;
            //   console.log("dataPoints", tooltipModel);
            // },
            callbacks: {
              title: (a, d) => {
                return this.moment(a[0].xLabel).format("DD.MM");
              },
              label: (i, d) => {
                const element = data.find(
                  (x) => x.date == i.xLabel.format("YYYY-MM-DD")
                );
                if (!element) {
                  return;
                }
                return [
                  `volume: ${this.formatCash(element.volume)}`,
                  `Médiane: ${this.formatCash(element.volume_reference)}`,
                  `Vol. en %: ${Math.round(element.percent)}`,
                ];
              },
            },
          },
          scales: {
            xAxes: [
              {
                display: true,
                gridLines: {
                  display: true,
                },
                scaleLabel: {
                  display: true,
                  labelString: "Période",
                  fontSize: 9,
                },
                type: "time",
                ticks: {
                  fontSize: 9,
                  beginAtZero: true,
                  major: {
                    enabled: true,
                    fontStyle: "bold",
                    fontColor: PALETTE.flux_in_color,
                    fontSize: 10,
                  },
                },
                time: {
                  unit: "day",
                  unitStepSize: 1,
                  displayFormats: {
                    day: "DD.MM",
                  },
                },
              },
            ],
            yAxes: [
              {
                display: true,
                ticks: {
                  fontSize: 9,
                  min: min < -100 ? (min + 10).toFixed(0) : -100,
                  max: max >= 100 ? (max + 10).toFixed(0) : 100,
                  callback: function (value) {
                    return value + "%";
                  },
                },
                scaleLabel: {
                  display: true,
                  labelString: "Pourcentage",
                  fontSize: 9,
                },
              },
            ],
          },
        },
      };
      let reference = this.$refs[ref];
      reference.style.height = 200;
      if (this.lineCharts[ref]) this.lineCharts[ref].destroy();
      this.lineCharts[ref] = new Chart(
        reference.getContext("2d"),
        this.configBarChart[ref]
      );
      reference.style.height = "200px";
      reference.style.maxHeight = "200px";
    },
    flux30Chart(data, ref, color, title = null) {
      const dataFormatted = [];
      data.map((x) => {
        if (this.isStartIsEnd()) {
          x.map((item) => {
            dataFormatted.push({
              x: moment(`${item.date} ${item.hour}`),
              y: item.percent,
            });
          });
        } else {
          let item = {};
          if (x.length % 2 == 0) {
            let indice = x.length / 2;

            const volume1 = x[indice].volume;
            const volume2 = x[indice - 1].volume;
            item.date = x[indice].date;
            item.volume = volume1 + volume2;
          } else {
            let indice = (x.length + 1) / 2;
            item = x[indice];
          }
          dataFormatted.push({
            date: item.date,
            x: moment(item.date),
            y: item.volume,
          });
        }
      });

      const max = d3.max(dataFormatted.map((x) => x.y));
      const min = d3.min(dataFormatted.map((x) => x.y));
      dataFormatted.sort((a, b) => {
        return a.x.toDate() - b.x.toDate();
      });
      this.configBarChart[ref] = {
        type: "line",
        data: {
          // labels: data.map(x => new Date(x.date)),
          datasets: [
            {
              label: "Volume",
              fill: false,
              borderColor: color,
              backgroundColor: color,
              data: dataFormatted,
              interpolate: true,
              showLine: true,
              borderWidth: 1.5,
              pointRadius: 1,
              lineTension: 0.08,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            display: false,
          },
          title: {
            display: !!title,
            text: title,
          },
          plugins: {
            crosshair: {
              line: {
                color: "#F66", // crosshair line color
                width: 1, // crosshair line width
                dashPattern: [5, 5], // crosshair line dash pattern
              },
              zoom: {
                enabled: true, // enable zooming
                zoomboxBackgroundColor: "rgba(66,133,244,0.2)", // background color of zoom box
                zoomboxBorderColor: "#48F", // border color of zoom box
                zoomButtonText: "Reset Zoom", // reset zoom button text
                zoomButtonClass: "reset-zoom", // reset zoom button class
              },
              sync: {
                enabled: false, // enable trace line syncing with other charts
              },
            },
          },
          tooltips: {
            mode: "interpolate",
            intersect: false,
            callbacks: {
              title: (a, d) => {
                let titleFormat = this.moment(a[0].xLabel).format("DD.MM.Y");
                if (this.fluxTimeGranularity == 2 && this.isStartIsEnd()) {
                  titleFormat = this.moment(a[0].xLabel).format(
                    "DD.MM.Y HH:mm"
                  );
                }
                return titleFormat;
              },

              label: function (i, d) {
                return (
                  d.datasets[i.datasetIndex].label +
                  ": " +
                  Math.round(i.yLabel, 0).toLocaleString(undefined, {
                    minimumFractionDigits: 0,
                  })
                );
              },
            },
          },
          scales: {
            xAxes: [
              {
                display: true,
                // id: "x-axis-0",
                scaleLabel: {
                  display: false,
                  labelString: "Month",
                },
                type: "time",
                time: {
                  unit:
                    this.fluxTimeGranularity == 2 && this.isStartIsEnd()
                      ? "hour"
                      : "day",
                  // unitStepSize: 1,
                  displayFormats: {
                    day: "DD.MM",
                    hour: "HH:mm",
                    minute: "HH:mm",
                  },
                },
                ticks: {
                  fontSize: 9,
                  major: {
                    enabled: true,
                    fontStyle: "bold",
                    fontColor: PALETTE.flux_in_color,
                    fontSize: 12,
                  },
                },
              },
            ],
            yAxes: [
              {
                display: true,
                ticks: {
                  fontSize: 9,
                  min: min < -100 ? (min + 10).toFixed(0) : -100,
                  max: max >= 100 ? (max + 10).toFixed(0) : 100,
                  callback: function (value) {
                    return value + "%";
                  },
                },
                scaleLabel: {
                  display: true,
                  labelString: "Pourcentage",
                  fontSize: 9,
                },
              },
            ],
          },
        },
      };
    
      let reference = this.$refs[ref];
      if (this.lineCharts[ref]) this.lineCharts[ref].destroy();
      this.lineCharts[ref] = new Chart(
        reference.getContext("2d"),
        this.configBarChart[ref]
      );
      reference.style.height = "200px";
      reference.style.maxHeight = "200px";
    },
    fluxMobilityFluxZone(InputData, ref, key, color) {
      if (!InputData) {
        return;
      }
      let DataReference = [];
      let totalReference = 0;
      let referenceAverage = 0;
      let localData = [];

      InputData.map(({ references, observations }) => {
        if (!observations || !references) {
          return {
            percent: null,
            difference: null,
          };
        }

        const result = this.formatFluxDataByMedian({
          references,
          observations,
        });

        localData.push({
          zone: observations[0][key],
          percent: Math.round(
            (result.difference / result.referenceVolume) * 100
          ),
          difference: result.difference,
          volume: result.observationVolume,
          volume_reference: result.referenceVolume,
        });
      });
      localData = localData.filter((x) => x.percent);
      localData.sort((a, b) => {
        return Number(a.volume ?? 0) < Number(b.volume ?? 0) ? 1 : -1;
      });

      localData.sort((a, b) => {
        return Number(a.percent ?? 0) < Number(b.percent ?? 0) ? 1 : -1;
      });

      const localDataPercent = localData.map((x) => x.percent);
      const minVal = d3.min(localDataPercent);
      const maxVal = d3.max(localDataPercent);
      localData = localData.slice(0, 10);

      // cond : key == origin
      this.drawHorizontalChart(localData, "zone", ref, color, 400);
    },
    topHealthZonePandemics(inPutData, ref, title = null) {
      const data = inPutData.map((item) => ({
        zone: item.name,
        volume: item.confirmed,
      }));
      this.drawHorizontalChart(
        data,
        "zone",
        ref,
        PALETTE.flux_in_color,
        200,
        title
      );
    },
    async fluxMobilityFluxGeneralZone(
      fluxDataIn,
      refAsc,
      refDesc,
      titleAsc,
      titleDesc,
      topHealthZoneConfirmed,
      titleHelth,
      refHealth
    ) {
      const generalData = [...fluxDataIn];

      const processing = new Promise((resolver, reject) => {
        const data = [];
        generalData.map(({ general_reference, general_observation, zone }) => {
          const result = this.formatFluxDataByMedian({
            references: general_reference,
            observations: general_observation,
          });

          data.push({
            zone: zone,
            volume: result.percent,
            percent: result.percent,
          });
        });
        resolver(data);
      });

      processing.then((data) => {
        let localData = data.filter((x) => x.percent);
        localData.sort((a, b) => {
          return Number(a.percent ?? 0) > Number(b.percent ?? 0) ? 1 : -1;
        });

        const localDataPercent = localData.map((x) => x.percent);
        const minVal = d3.min(localDataPercent);
        const maxVal = d3.max(localDataPercent);

        const ascData = localData.slice(0, 5);

        localData.sort((a, b) => {
          return Number(a.percent ?? 0) < Number(b.percent ?? 0) ? 1 : -1;
        });

        const descData = localData.slice(0, 5);

        const healthZones = topHealthZoneConfirmed.map((x) => x.name);

        const mobilityHealth = data.filter((x) =>
          includes(healthZones, x.zone)
        );

        this.drawHorizontalChart(
          ascData,
          "zone",
          refAsc,
          PALETTE.flux_in_color,
          200
        );
        this.drawHorizontalChart(
          descData,
          "zone",
          refDesc,
          PALETTE.flux_in_color,
          200
        );
        this.drawHorizontalChart(
          mobilityHealth,
          "zone",
          refHealth,
          PALETTE.flux_in_color,
          200
        );
      });
    },
    drawHorizontalChart(localData, key, ref, color, height, title = null) {
      const datasets = [];
      const volumeReferences = localData.map((d) => d.volume_reference);
      if (volumeReferences.some((x) => x)) {
        datasets.push({
          label: "Référence",
          backgroundColor: "#33ac2e",
          borderColor: "#33ac2e",
          borderWidth: 1,
          barThickness: 12,
          data: volumeReferences,
        });
      }

      datasets.push({
        label: "Observation",
        backgroundColor: color,
        borderColor: color,
        barThickness: 12,
        data: localData.map((d) => d.volume),
      });
      const dataChart = {
        labels: localData.map((d) => d[key]),
        datasets: datasets,
      };

      this.configBarChart[ref] = {
        type: "horizontalBar",
        data: dataChart,
        options: {
          elements: {
            rectangle: {
              borderWidth: 2,
            },
          },
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            position: "bottom",
            labels: {
              fontSize: 9,
            },
          },
          title: {
            display: !!title,
            text: title,
            fontSize: 15,
          },
          scales: {
            xAxes: [
              {
                ticks: {
                  beginAtZero: true,
                  fontSize: 9,
                  callback: (value, index, values) => {
                    const sign = value < 0 ? "-" : "";
                    return `${sign}${this.formatCash(value)}`;
                  },
                },
              },
            ],
            yAxes: [
              {
                ticks: {
                  fontSize: 9,
                  callback: function (label, index, labels) {
                    const value = localData.find((x) => x.zone == label);
                    if (value && value.percent) {
                      return `${label} (${value.percent}%)`;
                    } else {
                      return label;
                    }
                  },
                },
              },
            ],
          },
          plugins: {
            crosshair: {
              sync: {
                enabled: false, // enable trace line syncing with other charts
              },
            },
          },
        },
      };
      const reference = this.$refs[ref];
      if (this.barChart[ref]) this.barChart[ref].destroy();
      this.barChart[ref] = new Chart(
        reference.getContext("2d"),
        this.configBarChart[ref]
      );
      this.configBarChart[ref].height = height;
      reference.style.height = `${height}px`;;
      reference.style.maxHeight = `${height}px`;
    },
    getRangeColors(
      data,
      color,
      colorNeg = null,
      domaineMin = null,
      domaineMax = null
    ) {
      domaineMin = domaineMin == null ? d3.min(data) : domaineMin;
      domaineMax = domaineMax == null ? d3.max(data) : domaineMax;

      let colorScale = null;
      let colorScaleNeg = null;

      if (colorNeg) {
        colorScale = d3.scaleQuantile().domain([0, domaineMax]).range(color);

        colorScaleNeg = d3
          .scaleQuantile()
          .domain([domaineMin, 0])
          .range(colorNeg);
      } else {
        colorScale = d3
          .scaleQuantile()
          .domain([domaineMin, domaineMax])
          .range(color);
      }

      const getColorRange = (data) => {
        if (data < 0 && colorNeg) {
          return colorScaleNeg(data);
        } else {
          return colorScale(data);
        }
      };

      const rangeColors = data.map((d) => {
        return getColorRange(d);
      });

      return rangeColors;
    },
    fullscreenMobileDaily(fullscreen, ref) {
      
      if (!fullscreen) {
        const buttonResetZoom = this.lineCharts[ref].crosshair.button;
        if (buttonResetZoom) {
          console.log('buttonResetZoomd',buttonResetZoom);
          buttonResetZoom.click();
        }

        // this.configBarChart[ref].options.plugins.crosshair.zoom.enabled = false;
        this.$refs[ref].style.MaxHeight = "200px";
        this.$refs[ref].style.height = "200px";
        this.$refs[ref].height = "200px";

        this.lineCharts[ref].update();
      } else {
        this.configBarChart[ref].options.plugins.crosshair.zoom.enabled = true;
         this.$refs[ref].style.MaxHeight = "400px";
        this.$refs[ref].style.height = "400px";
        this.$refs[ref].height = "400px";

        // console.log('this.$refs[ref].style.MaxHeight',this.$refs[ref].style);

        this.lineCharts[ref].update();
      }
    },
    fullscreenFluxInOut(fullscreen, ref) {
      //this.fullscreen = fullscreen
      const element = this.$refs[ref];
      const parent_2 = element.parentElement.parentElement;
      if (!fullscreen) {
        element.style.height = this.configBarChart[ref].height;
        element.height = this.configBarChart[ref].height;
        element.parentElement.style.width = "";
        parent_2.style.display = "";
        parent_2.style.alignItem = "";
        parent_2.style.justifyContent = "";
        this.configBarChart[ref].options.legend.labels.fontSize = 9;
        this.configBarChart[ref].options.scales.xAxes[0].ticks.fontSize = 9;
        this.configBarChart[ref].options.scales.yAxes[0].ticks.fontSize = 9;
        this.barChart[ref].update();
      } else {
        // element.parentElement.style.width = "80%";
        // parent_2.style.display = "flex";
        // parent_2.style.alignItems = "center";
        // parent_2.style.justifyContent = "center";

        this.configBarChart[ref].options.legend.labels.fontSize = 12;
        this.configBarChart[ref].options.scales.xAxes[0].ticks.fontSize = 12;
        this.configBarChart[ref].options.scales.yAxes[0].ticks.fontSize = 12;
        this.barChart[ref].update();
      }
    },
    fullscreenOutChange(fullscreen) {
      //this.fullscreen = fullscreen
      if (!fullscreen) {
        this.$refs.mobile_out.style.height = "200px";
        this.$refs.mobile_out.height = "200px";
      }
    },
    fullscreenOut2Change(fullscreen) {
      //this.fullscreen = fullscreen
      const barChart2 = this.barChart2["mobile_out_2_card"];
      const configBarChart2 = this.configBarChart2["mobile_out_2_card"];
      if (!fullscreen) {
        this.$refs.mobile_out_2_card.style.height = "400px";
        this.$refs.mobile_out_2_card.height = "400px";

        configBarChart2.options.legend.labels.fontSize = 9;
        configBarChart2.options.scales.xAxes[0].ticks.fontSize = 9;
        configBarChart2.options.scales.yAxes[0].ticks.fontSize = 9;
        barChart2.update();
      } else {
        configBarChart2.options.legend.labels.fontSize = 12;
        configBarChart2.options.scales.xAxes[0].ticks.fontSize = 12;
        configBarChart2.options.scales.yAxes[0].ticks.fontSize = 12;
        barChart2.update();
      }
    },
    fullscreenGeneraleChange(fullscreen, ref) {
      if (!fullscreen) {
        this.$refs[ref].style.height = "200px";
      }
    },
    fullscreenGenerale2Change(fullscreen, ref) {
      this.$nextTick(() => {
        if (!fullscreen) {
          //   // ref.style.height = "400px";
          //   this.configBarChartGen.options.legend.labels.fontSize = 9;
          //   this.configBarChartGen.options.scales.xAxes[0].ticks.fontSize = 9;
          //   this.configBarChartGen.options.scales.yAxes[0].ticks.fontSize = 9;
          //   this.barChartGen.update();
          // } else {
          //   this.configBarChartGen.options.legend.labels.fontSize = 12;
          //   this.configBarChartGen.options.scales.xAxes[0].ticks.fontSize = 12;
          //   this.configBarChartGen.options.scales.yAxes[0].ticks.fontSize = 12;
          //   this.barChartGen.update();
        }
      });
    },
    toggleGlobalMobility() {
      this.showMobiliteGenerale = !this.showMobiliteGenerale;
    },
    toggleTypePresence(type) {
      if (this.typePresence == 1) {
        if (type == 2) {
          this.setTypePresence(1);
        }
        switch (type) {
          case 2:
            this.setTypePresence(3);
            break;
          case 3:
            this.setTypePresence(2);
          default:
            break;
        }
        return;
      }
      if (this.typePresence != type) {
        type = 1;
      }
      this.setTypePresence(type);
    },
    defineTypePresence(type) {
      this.setTypePresence(type);
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
@import "@~/sass/_mixins";

.flux-chart {
  @include card-style;
  .see-province-stat {
    font-size: 1rem;
    cursor: pointer;
  }
  .chart-box-sub-title {
    font-size: 1.2rem;
  }
}
.return-global {
  cursor: pointer;
}
.flux-mobility {
  cursor: pointer;
  &.active {
    background: #2e5bff14;
  }
}

.legend {
  list-style: none;
  li {
    span {
      display: inline-block;
      width: 20px;
      height: 20px;
      margin-right: 5px;
      &.reference {
        background: #9e9e9e;
      }
      &.observation {
        background: #4caf50;
      }
    }
  }
}
.percent-title {
  font-size: 1rem;
}
.percent {
  font-size: 2.5rem;
  font-weight: bold;
}
.percent-p {
  font-size: 0.7rem;
}
.chart-container {
  div {
    position: relative;
  }
}
.fullscreen {
  .cardtype1 {
    canvas {
      width: calc(100vw - 19px) !important;
      max-height: 500px !important;
      height: 500px !important;

    }
  }
  .cardtype2 {
    canvas {
      width: 700px !important;
      height: calc(100vh - 32px) !important;
      max-height:calc(100vh - 32px) !important;;
    }
  }
}
.btns-toggle-presence {
  user-select: none;
  i {
    color: #7b7f88;
    font-size: 15px;
    margin-right: 2px;
    cursor: pointer;
    transition: color 0.2s ease-in-out;
    &.active {
      color: #8bc34a;
    }
    &:active {
      opacity: 0.6;
    }
  }
}
.logoPartenaire {
  height: 38px;
  width: auto;
  margin-left: 5px;
}
.general-top-title {
  font-size: 0.7rem;
  text-align: center;
  margin-bottom: 5px;
  color: #6c757d;
  font-weight: bold;
}
.flux-chart-lenged-color {
  display: inline-block;
  height: 15px;
  width: 15px;
}
.flux-chart-lenged-text {
  font-size: 0.8rem;
}
</style>
