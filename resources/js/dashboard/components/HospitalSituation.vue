<template>
  <b-container class="p-0">
    <b-row>
      <b-col cols="12 mb-2">
        <div class="row align-items-center">
          <skeleton-loading v-if="isLoading" class="col-12 col-md-12">
            <square-skeleton
              :boxProperties="{
                width: '30%',
                height: '40px',
              }"
            ></square-skeleton>
          </skeleton-loading>
          <h4 class="col-12 col-md-6 mb-3 mb-md-0 m-0 d-flex align-items-baseline" v-if="!isLoading">
            <span>{{ hospital.name || "Rapport global" }}</span>
            <b-badge v-if="hospitalCount" style="font-size: 12px" class="ml-2">
              {{ hospitalCount }}
              <small>infrastructure(s)</small>
            </b-badge>
          </h4>
          <div
            class="text-right text-black-50 col-12 col-md-6"
            v-if="lastUpdate && !isLoading"
          >
            Mise à jour du {{ moment(lastUpdate).format("DD.MM.Y") }}
          </div>
          <div class="col-12 text-right" v-if="!isLoading">
            <button
              class="btn btn-sm btn-primary"
              style="font-size: 12px"
              @click="backToTotalData()"
              v-if="!isGlobal"
            >
              Retour aux données globales
            </button>
          </div>
        </div>
      </b-col>
    </b-row>
    <b-row no-gutters>
      <b-col cols="12" md="6" class="row no-gutters pr-1">
        <skeleton-loading v-if="isLoading" class="mb-2">
          <square-skeleton
            :boxProperties="{
              width: '100%',
              height: '340px',
            }"
          ></square-skeleton>
        </skeleton-loading>
        <b-card class="col-12 default-card mb-2" v-else>
          <h5 class="bold">Capacité de prise en charge</h5>
          <div>
            <div>Lits avec mousse:  {{ parseData(hospital.occupied_foam_beds) }}/{{ parseData(hospital.foam_beds) }}</div>
            <div>
              Lits de réanimation:  {{ parseData(hospital.occupied_resuscitation_beds) }}/{{ parseData(hospital.resuscitation_beds) }}
            </div>
            <div>Respirateurs:  {{ parseData(hospital.occupied_respirators) }}/{{ parseData(hospital.respirators) }}</div>
            <div>
              Ventilateur de réanimation :
              {{ parseData(hospital.resuscitation_ventilator) }}
            </div>
            <div>Oxygénérateur: {{ parseData(hospital.oxygenator) }}</div>
            <hr>
             <h6 class="bold">Médicaments :</h6>
            
            <div>Chloroquine: {{ parseData(hospital.chloroquine) }}</div>
            <div>
              Hydrochloroquine: {{ parseData(hospital.hydrochloroquine) }}
            </div>
          <div>Azytromicine: {{ parseData(hospital.azytromicine) }}</div>
          <div>Vitamince C: {{ parseData(hospital.Vitamince_c) }}</div>
            <div v-if="!isGlobal">
              Equipement de protection individuelle:
              {{ parseData(hospital.individual_protection_equipment) }}
            </div>
            <div v-if="!isGlobal">
              Masques N95/FFP2: {{ parseData(hospital.masks) }}
            </div>
            <div v-if="!isGlobal">
              Dépistage rapide: {{ parseData(hospital.rapid_screening) }}
            </div>
            <div v-if="!isGlobal">
              Radiographie: {{ parseData(hospital.x_ray) }}
            </div>
            <div v-if="!isGlobal">
              Automate Genexpert: {{ parseData(hospital.automate_genexpert) }}
            </div>
            <div v-if="!isGlobal">
              Gel hydro alcoolique:
              {{ parseData(hospital.gel_hydro_alcoolique) }}
            </div>
            <div v-if="!isGlobal">
              check point: {{ parseData(hospital.check_point) }}
            </div>
          </div>
        </b-card>
      </b-col>
      <b-col cols="12" md="6" class="pl-1">
        <skeleton-loading v-if="isLoading" class="mb-2">
          <square-skeleton
            :boxProperties="{
              width: '100%',
              height: '170px',
            }"
          ></square-skeleton>
        </skeleton-loading>
        <b-card class="col-12 default-card mb-2" v-if="!isLoading">
          <h5 class="bold">Situations épidemologiques</h5>
          <div>
            <div>Confirmés: {{ parseData(hospital.confirmed) }}</div>
            <div>Hospitalisés: {{ parseData(hospital.sick) }}</div>
            <div>Guéris: {{ parseData(hospital.healed) }}</div>
            <div>décès: {{ parseData(hospital.dead) }}</div>
          </div>
        </b-card>
        <b-card class="col-12 default-card mb-2" v-if="!isGlobal && !isLoading">
          <h5 class="bold">Médicaments</h5>
          <div>Chloroquine: {{ parseData(hospital.chloroquine) }}</div>
          <div>
            Hydrochloroquine: {{ parseData(hospital.hydrochloroquine) }}
          </div>
          <div>Azytromicine: {{ parseData(hospital.azytromicine) }}</div>
          <div>Vitamince C: {{ parseData(hospital.Vitamince_c) }}</div>
        </b-card>
        <skeleton-loading v-if="isLoading" class="mb-2">
          <square-skeleton
            :boxProperties="{
              width: '100%',
              height: '170px',
            }"
          ></square-skeleton>
        </skeleton-loading>
        <b-card class="col-12 default-card mb-2" v-if="!isLoading">
          <h5 class="bold">Personnels</h5>
          <div>Médicins: {{ parseData(hospital.doctors) }}</div>
          <div>Infirmiers: {{ parseData(hospital.nurses) }}</div>
          <div>Para Médicaux: {{ parseData(hospital.para_medicals) }}</div>
        </b-card>
      </b-col>
    </b-row>

    <b-row no-gutters class="mb-2">
      <b-col cols="12" md="6" class="pr-1">
        <div v-if="situationHospitalLoading|| isLoading">
          <b-skeleton-wrapper :loading="situationHospitalLoading || isLoading">
            <template #loading>
              <b-card no-body class="default-card card-chart p-2 cardtype1">
                <b-skeleton class="m-auto" width="60%" height="20"></b-skeleton>
                <b-skeleton class="mt-2" width="100%" height="180"></b-skeleton>
              </b-card>
            </template>
          </b-skeleton-wrapper>
        </div>
        <FullScreen id="canvasStat1_full" link="canvasStat1" v-show="!situationHospitalLoading && !isLoading">
          <b-card no-body class="default-card card-chart p-2 cardtype1">
            <b-spinner
              label="Chargement..."
              v-if="situationHospitalLoading"
            ></b-spinner>
            <div class="legend-custom">
              <div class="text-center title  general-top-title">
                Evolution d'occupation des respirateurs
              </div>
              <div
                class="d-flex flex-wrap justify-content-center align-items-center"
              >
                <div>
                  <span class="legend-color total"></span>
                  <Span>Ligne Totale</Span>
                </div>
                <div>
                  <span class="legend-color respirator"></span>
                  <Span>Respirateurs</Span>
                </div>
                <div>
                  <span class="legend-color interpolation"></span>
                  <Span>Interpolation</Span>
                </div>
              </div>
            </div>
            <div class="chart-container">
              <canvas
                height="200"
                width="100vh"
                ref="canvasStat1"
                id="canvasStat1"
              ></canvas>
            </div>
          </b-card>
        </FullScreen>
      </b-col>

      <b-col cols="12" md="6" class="pl-1">
        <div v-if="situationHospitalLoading|| isLoading">
          <b-skeleton-wrapper :loading="situationHospitalLoading || isLoading">
            <template #loading>
              <b-card no-body class="default-card card-chart p-2 cardtype1">
                <b-skeleton class="m-auto" width="60%" height="20"></b-skeleton>
                <b-skeleton class="mt-2" width="100%" height="180"></b-skeleton>
              </b-card>
            </template>
          </b-skeleton-wrapper>
        </div>
        <FullScreen id="canvasStat2_full" link="canvasStat2" v-show="!situationHospitalLoading && !isLoading">
          <b-card no-body class="default-card card-chart p-2 cardtype1">
            <b-spinner
              label="Chargement..."
              v-if="situationHospitalLoading"
            ></b-spinner>
            <div class="legend-custom">
              <div class="text-center title  general-top-title">
                Evolution d'occupation des lits de réanimation
              </div>
              <div
                class="d-flex flex-wrap justify-content-center align-items-center"
              >
                <div>
                  <span class="legend-color total"></span>
                  <Span>Ligne Totale</Span>
                </div>
                <div>
                  <span class="legend-color respirator"></span>
                  <Span>Respirateurs</Span>
                </div>
                <div>
                  <span class="legend-color interpolation"></span>
                  <Span>Interpolation</Span>
                </div>
              </div>
            </div>
            <div class="chart-container">
              <canvas
                height="200"
                width="100vh"
                ref="canvasStat2"
                id="canvasStat2"
              ></canvas>
            </div>
          </b-card>
        </FullScreen>
      </b-col>

      <b-col cols="12" class="mt-2">
        <div v-if="situationHospitalLoading|| isLoading">
          <b-skeleton-wrapper :loading="situationHospitalLoading || isLoading">
            <template #loading>
              <b-card no-body class="default-card card-chart p-2 cardtype1">
                <b-skeleton class="m-auto" width="60%" height="20"></b-skeleton>
                <b-skeleton class="mt-2" width="100%" height="180"></b-skeleton>
              </b-card>
            </template>
          </b-skeleton-wrapper>
        </div>
        <FullScreen
          id="canvasStat3_full"
          link="canvasStat3"
          v-show="!situationHospitalLoading && !isLoading"
        >
          <b-card no-body class="default-card card-chart p-2 cardtype1">
            <!-- <b-spinner
              label="Chargement..."
              v-if="situationHospitalLoading"
            ></b-spinner> -->
            <div class="legend-custom">
              <div class="text-center title  general-top-title">
                Evolution global du taux d'occupation
              </div>
              <div
                class="d-flex flex-wrap justify-content-center align-items-center"
              >
                <div>
                  <span class="legend-color total"></span>
                  <Span>Taux de Lits de réanimation</Span>
                </div>
                <div>
                  <span class="legend-color respirator"></span>
                  <Span>Taux de Respirateurs</Span>
                </div>
              </div>
            </div>
            <div class="chart-container">
              <canvas
                height="400"
                width="100vh"
                ref="canvasStat3"
                id="canvasStat3"
              ></canvas>
            </div>
          </b-card>
        </FullScreen>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import { mapState, mapActions, mapMutations } from "vuex";
import { PALETTE } from "../config/env";

export default {
  props: ["hospitalTotalData"],
  data() {
    return {
      lineCharts: [],
      etatGlobal: true,
      dataGlobal: null,
      chartLabels: [
        {
          title: "Evolution du taux d'occupation des respirateurs",
          lableY: "Nombre de respirateurs",
        },

        {
          title: "Evolution du taux d'occupation des lits de réanimation",
          lableY: "Nombre de lits",
        },

        {
          title: "Evolution global du taux d'occupation",
          lableY: "Taux d'occupation",
        },
      ],
    };
  },
  mounted() {
    const id = this.selectedHospital ? this.selectedHospital.id : null;
    this.getSituationHospital(id);
  },
  computed: {
    ...mapState({
      selectedHospital: (state) => state.hospital.selectedHospital,
      situationHospitalLoading: (state) =>
        state.hospital.situationHospitalLoading,
      hospitalData: (state) => state.hospital.hospitalData,
      situationHospital: (state) => state.hospital.situationHospital,
      hospitalCount: (state) => state.hospital.hospitalCount,
      isLoading: (state) => state.hospital.isLoading,
    }),
    hospital() {
      if (this.selectedHospital != null) return this.selectedHospital;
      else {
        return this.hospitalTotalData ? this.hospitalTotalData : {};
      }
    },
    isGlobal() {
      return this.selectedHospital != null ? false : true;
    },
    lastUpdate() {
      if (this.selectedHospital != null)
        return this.selectedHospital.last_update;
      else if (this.dataGlobal) {
        return this.dataGlobal.last_update[
          this.dataGlobal.last_update.length - 1
        ];
      } else return null;
    },
  },
  watch: {
    hospitalData() {
      this.selectHospital(null);
      this.getSituationHospital();
    },
    selectedHospital(val) {
      const id = val ? val.id : null;
      this.getSituationHospital(id);
    },
    situationHospital(val) {
      this.dataGlobal = val;
      this.paintStats(val);
    },
  },
  methods: {
    ...mapActions(["getSituationHospital"]),
    ...mapMutations(["selectHospital"]),
    paintStats(data) {
      const lastUpdates = data.last_update;
      const occupiedRespirators = data.occupied_respirators;
      const occupiedResuscitation_beds = data.occupied_resuscitation_beds;
      const unknow = [];
      const Respirators = [...occupiedRespirators];
      const Resuscitation_beds = [...occupiedResuscitation_beds];

      const valideIndex = [];
      data.occupied_respirators = occupiedRespirators.map((item, index) => {
        if (!item || Number(item) == 0) {
          const y1Array = [];
          const y2Array = [];

          occupiedRespirators.map((x, i) => {
            if (i < index && x && Number(x) > 0) {
              y1Array.push({
                value: x,
                i,
              });
            }
            if (i > index && x && Number(x) > 0) {
              y2Array.push({
                value: x,
                i,
              });
            }
          });
          let y1 = null;
          let y2 = null;
          let x1 = null;
          let x2 = null;
          if (y1Array && y1Array.length > 0) {
            y1 = y1Array[y1Array.length - 1];
            x1 = lastUpdates[y1.i];
          }
          if (y2Array && y2Array.length > 0) {
            y2 = y2Array[0];
            x2 = lastUpdates[y2.i];
          }
          const x = lastUpdates[index];

          if (y1 && y2 && x1 && x2) {
            const x_x1 = Math.abs(new Date(x) - new Date(x1));
            const x2_x1 = Math.abs(new Date(x2) - new Date(x1));
            const y2_y1 = Number(y2.value) - Number(y1.value);
            const y = Number(y1.value) + (y2_y1 / x2_x1) * x_x1;

            return y;
          }
        }
        return item;
      });

      data.occupied_resuscitation_beds = occupiedResuscitation_beds.map(
        (item, index) => {
          if (!item || Number(item) == 0) {
            const y1Array = [];
            const y2Array = [];

            occupiedResuscitation_beds.map((x, i) => {
              if (i < index && x && Number(x) > 0) {
                y1Array.push({
                  value: x,
                  i,
                });
              }
              if (i > index && x && Number(x) > 0) {
                y2Array.push({
                  value: x,
                  i,
                });
              }
            });
            let y1 = null;
            let y2 = null;
            let x1 = null;
            let x2 = null;
            if (y1Array && y1Array.length > 0) {
              y1 = y1Array[y1Array.length - 1];
              x1 = lastUpdates[y1.i];
            }
            if (y2Array && y2Array.length > 0) {
              y2 = y2Array[0];
              x2 = lastUpdates[y2.i];
            }
            const x = lastUpdates[index];

            if (y1 && y2 && x1 && x2) {
              const x_x1 = Math.abs(new Date(x) - new Date(x1));
              const x2_x1 = Math.abs(new Date(x2) - new Date(x1));
              const y2_y1 = Number(y2.value) - Number(y1.value);
              const y = Number(y1.value) + (y2_y1 / x2_x1) * x_x1;

              return y;
            }
          }
          return item;
        }
      );

      const totalRescitationBed = Number(
        data.resuscitation_beds[data.resuscitation_beds.length - 1]
      );
      const totalRespirator = Number(
        data.respirators[data.respirators.length - 1]
      );

      for (let i = 0; i < 3; i++) {
        let callbacks = {
            title: (a, d) => {
              return this.moment(a[0].xLabel).format("DD.MM.Y");
            },
          },
          ticksY = {};
        let datasets = [];
        let annotation = {};
        if (i == 0) {
          annotation = {
            drawTime: "afterDraw",
            annotations: [
              {
                id: "line" + i,
                type: "line",
                mode: "horizontal",
                scaleID: "y-axis-0",
                value: totalRespirator,
                borderColor: "magenta",
                label: { content: "label" },
                borderWidth: 3,
              },
            ],
          };

          datasets = [
            {
              label: "Respirateurs occupés",
              fill: false,
              backgroundColor: PALETTE.dash_green,
              borderColor: PALETTE.dash_green,
              data: Respirators.map((x) => (x == 0 ? null : x)),
              fill: false,
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4,
            },
            {
              label: "Interpolation",
              fill: false,
              backgroundColor: PALETTE.dash_red,
              borderColor: PALETTE.dash_red,
              data: data.occupied_respirators.map((x, i) => {
                if (x == 0) return null;
                if (
                  !+Respirators[i] ||
                  (!+Respirators[i - 1] && +data.occupied_respirators[i - 1]) ||
                  (!+Respirators[i + 1] && +data.occupied_respirators[i + 1])
                ) {
                  return x;
                }

                return null;
              }),
              fill: false,
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4,
            },
          ];
          const respiratorMax = Math.max(...Respirators.map((x) => Number(x)));
          let tickMax = respiratorMax;
          if (totalRespirator > respiratorMax) {
            tickMax = totalRespirator + 1;
          }
          ticksY = {
            min: 0,
            max: tickMax,
            precision: 0,
          };
        } else if (i == 1) {
          annotation = {
            drawTime: "afterDraw",
            annotations: [
              {
                id: "line" + i,
                type: "line",
                mode: "horizontal",
                scaleID: "y-axis-0",
                value: totalRescitationBed,
                borderColor: "magenta",
                borderWidth: 3,
                label: "label",
              },
            ],
          };

          datasets = [
            {
              label: "Lits de réanimation occupés",
              backgroundColor: PALETTE.dash_green,
              borderColor: PALETTE.dash_green,
              data: Resuscitation_beds.map((x) => (x == 0 ? null : x)),
              fill: false,
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4,
            },
            {
              label: "interpolation",
              backgroundColor: PALETTE.dash_red,
              borderColor: PALETTE.dash_red,
              data: data.occupied_resuscitation_beds.map((x, i) => {
                if (x == 0) return null;
                if (
                  !+Resuscitation_beds[i] ||
                  (!+Resuscitation_beds[i - 1] &&
                    +data.occupied_resuscitation_beds[i - 1]) ||
                  (!+Resuscitation_beds[i + 1] &&
                    +data.occupied_resuscitation_beds[i + 1])
                ) {
                  return x;
                }

                return null;
              }),
              fill: false,
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4,
            },
          ];

          const resuscitationBedsMax = Math.max(
            ...Resuscitation_beds.map((x) => Number(x))
          );
          let tickMax = resuscitationBedsMax;
          if (totalRescitationBed > resuscitationBedsMax) {
            tickMax = totalRescitationBed + 1;
          }

          ticksY = {
            min: 0,
            precision: 0,
            max: tickMax,
          };
        } else {
          const dataset1 = data.occupied_resuscitation_beds.map((a, i) => {
            // if (a == 0 || data.resuscitation_beds[i] == 0) return null;
            return Math.round(
              (a * 100) /
                data.resuscitation_beds[data.resuscitation_beds.length - 1]
            );
          });

          const dataset2 = data.occupied_respirators.map((a, i) => {
            // if (a == 0 || data.respirators[i] == 0) return null;
            return Math.round(
              (a * 100) / data.respirators[data.respirators.length - 1]
            );
          });

          datasets = [
            {
              label: "Taux occupation des Réspirateurs",
              backgroundColor: PALETTE.dash_green,
              borderColor: PALETTE.dash_green,
              data: dataset2,
              fill: false,
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4,
            },
            {
              label: "Taux occupation des lits de réanimation",
              backgroundColor: "magenta",
              borderColor: "magenta",
              data: dataset1,
              fill: false,
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4,
            },
          ];

          callbacks.label = function (tooltipItem, data) {
            var label = data.datasets[tooltipItem.datasetIndex].label || "";
            if (label) label += ": ";
            label += tooltipItem.yLabel + "%";
            return label;
          };

          ticksY = {
            min: 0,
            callback: function (value, index, values) {
              return value + "%";
            },
          };
        }
        const config = {
          type: "line",
          data: {
            labels: data.last_update.map((d) => new Date(d)),
            datasets: datasets,
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
              display: false,
            },
            title: {
              display: false,
              text: this.chartLabels[i].title,
              fontSize: 11,
            },
            tooltips: {
              mode: "index",
              intersect: false,
              callbacks: callbacks,
            },
            annotation,
            plugins: {
              crosshair: {
                sync: {
                  enabled: false, // enable trace line syncing with other charts
                },
                zoom: {
                  enabled: false,
                },
              },
            },
            hover: {
              mode: "nearest",
              intersect: true,
            },
            scales: {
              xAxes: [
                {
                  display: true,
                  type: "time",
                  distribution: "series",
                  time: {
                    unit: "day",
                    unitStepSize: 1,
                    displayFormats: {
                      day: "DD.MM",
                    },
                  },
                  scaleLabel: {
                    display: true,
                    labelString: "Periode",
                  },
                  ticks: {
                    fontSize: 9,
                    autoSkip: false,
                    maxRotation: 90,
                    minRotation: 90,
                  },
                },
              ],
              yAxes: [
                {
                  display: true,
                  scaleLabel: {
                    display: true,
                    labelString: this.chartLabels[i].lableY,
                  },
                  ticks: ticksY,
                },
              ],
            },
          },
        };
        const reference=this.$refs[`canvasStat${i + 1}`];
        if (this.lineCharts[i]) this.lineCharts[i].destroy();
        this.lineCharts[i] = new Chart(
          reference.getContext("2d"),
          config
        );
        reference.style.height = "200px";
        reference.style.maxHeight = "200px";
        // this.lineCharts[i].generateLegend();
      }
    },
    backToTotalData() {
      this.selectHospital(null);
    },
    parseData(data) {
      if (data == null) return "N/A";
      else return data;
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.fullscreen {
  .cardtype1 {
    canvas {
      width: calc(100vw - 19px) !important;
      height: 500px !important;
    }
  }
  .cardtype2 {
    canvas {
      width: 700px !important;
      height: calc(100vh - 32px) !important;
    }
  }
}
.card-chart {
  position: relative;
  #canvasStat1,
  #canvasStat2 {
    height: 400px !important ;
  }
  .legend-custom {
    .title {
      font-size: 0.8rem;
    }
    .legend-color {
      display: inline-block;
      width: 10px;
      height: 10px;
      background: red;
      + span {
        margin-right: 5px;
        font-size: 0.6rem;
      }
      &.total {
        background: magenta;
      }
      &.respirator {
        background: $dash_green;
      }
      &.interpolation {
        background: $flux-presence;
      }
    }
  }
  .spinner-border {
    position: absolute;
    top: calc(50% - 20px);
    left: calc(50% - 20px);
  }
}
</style>
