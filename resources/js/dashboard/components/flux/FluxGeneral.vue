<template>
  <b-container fluid>
    <b-row>
      <b-col>
        <b-card class="mb-3 flux-mobility" :class="{'active':fluxType==4}">
          <h5 class="percent-title">Mobilité générale</h5>
          <div class="percent flux-in-color">{{percentGenerale}}%​</div>

          <p v-if="differenceGenerale>0" class="percent-p text-dash-color">
            {{differenceGenerale}} personnes de plus sont
            <br />entrées et sorties de la zone
          </p>
          <p v-else class="percent-p text-dash-color">
            {{ `${differenceGenerale}`}} personnes de moins sont
            <br />entrées et sorties de la zone
          </p>
        </b-card>
        <FullScreen id="mobile_generale_full" link="general_flux">
          <b-card no-body class="cardtype1 mb-3 p-2">
            <div class="chart-container">
              <canvas height="200" width="100vh" ref="general_flux" id="general_flux"></canvas>
            </div>
          </b-card>
        </FullScreen>
      </b-col>
    </b-row>
    <b-row>
      <b-col cols="12" md="4">
        <FullScreen id="general_top_asc" link="general_top_asc">
          <b-card no-body class="cardtype2 p-2">
            <canvas height="200" width="100vh" ref="general_top_asc" id="general_top_asc"></canvas>
          </b-card>
        </FullScreen>
      </b-col>
      <b-col cols="12" md="4">
        <FullScreen id="general_top_desc" link="general_top_desc">
          <b-card no-body class="cardtype2 p-2">
            <canvas height="200" width="100vh" ref="general_top_desc" id="general_top_desc"></canvas>
          </b-card>
        </FullScreen>
      </b-col>
      <b-col cols="12" md="4"></b-col>
    </b-row>
  </b-container>
</template>

<script>
import { mapState } from "vuex";
import { PALETTE } from "../../config/env";
export default {
  props: {
    flux24DailyIn: {
      type: Array,
      default: () => [],
    },
    flux24DailyOut: {
      type: Array,
      default: () => [],
    },
    fluxDataGroupedByDateIn: {
      type: Object,
      default: () => ({}),
    },
    fluxDataGroupedByDateOut: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      barChart2: {},
      percentGenerale: null,
      differenceGenerale: null,
    };
  },
  computed: {
    ...mapState({
      fluxType: (state) => state.flux.fluxType,
    }),
  },
  watch: {
    flux24DailyIn() {
      this.updateGeneralMobilityDaily();
      this.fluxMobilityFluxGeneralZone(
        this.flux24DailyIn,
        this.flux24DailyOut,
        "general_top_asc",
        "asc"
      );
      this.fluxMobilityFluxGeneralZone(
        this.flux24DailyIn,
        this.flux24DailyOut,
        "general_top_desc",
        "desc"
      );
    },
    flux24DailyOut() {
      // this.updateGeneralMobilityDaily();
      this.fluxMobilityFluxGeneralZone(
        this.flux24DailyIn,
        this.flux24DailyOut,
        "general_top_asc",
        "asc"
      );
      this.fluxMobilityFluxGeneralZone(
        this.flux24DailyIn,
        this.flux24DailyOut,
        "general_top_desc",
        "desc"
      );
    },
  },
  mounted() {
    this.fluxMobilityFluxGeneralZone(
      this.flux24DailyIn,
      this.flux24DailyOut,
      "general_top_asc",
      "asc"
    );
    this.fluxMobilityFluxGeneralZone(
      this.flux24DailyIn,
      this.flux24DailyOut,
      "general_top_desc",
      "desc"
    );

    this.updateGeneralMobilityDaily();
  },
  methods: {
    // updateGeneralMobilityZone() {
    //   this.$nextTick(() => {
    //     const referencesByDateIn = this.flux24DailyIn.referencesByDate ?? [];
    //     const observationsByDateIn =
    //       this.flux24DailyIn.observationsByDate ?? [];

    //     const referencesByDateOut = this.flux24DailyOut.referencesByDate ?? [];
    //     const observationsByDateOut =
    //       this.flux24DailyOut.observationsByDate ?? [];

    //     const referencesByDate = [];
    //     const observationsByDate = [];
    //     [...referencesByDateIn, ...referencesByDateOut].map((item) => {
    //       const element = referencesByDate.find((x) => x.date == item.date);
    //       if (element) {
    //         element.volume += item.volume;
    //       } else {
    //         referencesByDate.push({
    //           volume: item.volume,
    //           date: item.date,
    //         });
    //       }
    //     });

    //     [...observationsByDateIn, ...observationsByDateOut].map((item) => {
    //       const element = observationsByDate.find((x) => x.date == item.date);
    //       if (element) {
    //         element.volume += item.volume;
    //       } else {
    //         observationsByDate.push({
    //           volume: item.volume,
    //           date: item.date,
    //         });
    //       }
    //     });
    //     const general = {
    //       referencesByDate,
    //       observationsByDate,
    //     };
    //     const result = this.formatFluxDataByMedian({
    //       references:referencesByDate,
    //       observations:observationsByDate
    //     });
    //     this.percentGenerale = result.percent;
    //     this.differenceGenerale = this.formatCash(result.difference);

    //     this.mobileCalc(general, "general_flux", PALETTE.flux_in_color);
    //   });
    // },
    updateGeneralMobilityDaily() {
      this.$nextTick(() => {
        const referencesByDateIn =
          this.fluxDataGroupedByDateIn.referencesByDate ?? [];
        const observationsByDateIn =
          this.fluxDataGroupedByDateIn.observationsByDate ?? [];

        const referencesByDateOut =
          this.fluxDataGroupedByDateOut.referencesByDate ?? [];
        const observationsByDateOut =
          this.fluxDataGroupedByDateOut.observationsByDate ?? [];

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
        const result = this.fluxInPercent(general);
        this.percentGenerale = result.percent;
        this.differenceGenerale = this.formatCash(result.difference);
        this.mobileCalc(general, `general_flux`, PALETTE.flux_in_color);
      });
    },
    fluxMobilityFluxGeneralZone(
      fluxDataIn,
      fluxDataOut,
      ref,
      title = null,
      order = "asc"
    ) {
      const generalData = [...fluxDataIn];
      let localData = [];
      generalData.map(({ references, observations }) => {
        if (references) {
          references.map((item) => {
            const elementOut = fluxDataOut.find(
              (x) =>
                x.references &&
                x.references.some(
                  (y) => y.destination == item.origin && y.Date == item.date
                )
            );
            if (elementOut) {
              const itemOut = elementOut.references.find(
                (y) => y.destination == item.origin && y.Date == item.date
              );
              item.volume += itemOut.volume;
            }
          });
        }

        if (observations) {
          observations.map((item) => {
            const elementOut = fluxDataOut.find(
              (x) =>
                x.observations &&
                x.observations.some(
                  (y) => y.destination == item.origin && y.Date == item.date
                )
            );
            if (elementOut) {
              const itemOut = elementOut.observations.find(
                (y) => y.destination == item.origin && y.Date == item.date
              );
              item.volume += itemOut.volume;
            }
          });
        }

        const result = this.formatFluxDataByMedian({
          references,
          observations,
        });
        localData.push({
          zone: observations[0].origin,
          volume: result.observationVolume,
          percent: result.percent,
          volume_reference: result.referenceVolume,
        });
      });

      localData.sort((a, b) => {
        if (order == "asc") {
          return Number(a.percent ?? 0) < Number(b.percent ?? 0) ? 1 : -1;
        } else {
          return Number(a.percent ?? 0) > Number(b.percent ?? 0) ? 1 : -1;
        }
      });

      localData = localData.slice(0, 6);

      this.drawHorizontalChart(
        localData,
        "zone",
        ref,
        PALETTE.flux_in_color,
        title
      );
    },
    drawHorizontalChart(localData, key, ref, color, title = null) {
      const dataChart = {
        labels: localData.map((d) => d[key]),
        datasets: [
          {
            label: "Référence",
            backgroundColor: "#33ac2e",
            borderColor: "#33ac2e",
            borderWidth: 1,
            data: localData.map((d) => d.volume_reference),
          },
          {
            label: "Observation",
            backgroundColor: color,
            borderColor: color,
            data: localData.map((d) => d.volume),
          },
        ],
      };

      this.configBarChart2 = {
        type: "horizontalBar",
        data: dataChart,
        options: {
          elements: {
            rectangle: {
              borderWidth: 2,
            },
          },
          responsive: true,
          legend: {
            position: "bottom",
            labels: {
              fontSize: 9,
            },
          },
          title: {
            display: !!title,
            text: title,
            color: "#6c757d",
          },
          scales: {
            xAxes: [
              {
                ticks: {
                  beginAtZero: true,
                  fontSize: 9,
                },
              },
            ],
            yAxes: [
              {
                ticks: {
                  fontSize: 9,
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

      if (this.barChart2[ref]) this.barChart2[ref].destroy();
      this.barChart2[ref] = new Chart(
        this.$refs[ref].getContext("2d"),
        this.configBarChart2
      );
    },
  },
};
</script>

<style>
</style>