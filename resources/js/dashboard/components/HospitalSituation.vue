/* eslint-disable no-empty */
<template>
  <b-container class="p-0" >
    <b-row lg="12" class="no-gutters">
      <b-col cols="12" fluid>
        <div class="col-12 mb-2 row align-items-center px-2 no-gutters">
          <skeleton-loading v-if="isLoading" class="col-12 col-md-12">
            <skeleton-square
              :boxProperties="{
                width: '30%',
                height: '40px',
              }"
            ></skeleton-square>
          </skeleton-loading>
          <b-row v-if="!isLoading" class="mb-2 align-items-center">
            <b-col lg="12" class="align-items-center">
              <h4>{{ hospital.name || "Rapport global" }}</h4>
            </b-col>
            <b-col lg="4" class="align-items-center">
              <b-badge v-if="hospitalCount" style="font-size: 12px">
                {{ hospitalCount }}
                <small>infrastructure(s)</small>
              </b-badge>
            </b-col>
          </b-row>
          <div
            v-if="isGlobal"
            class="col-12 d-flex flex-wrap text-right justify-content-end"
          >
            <div class="col-12 px-0 mb-1" v-if="hospitalSituationLastUpdate">
              Mise à jour du {{ hospitalSituationLastUpdate }}
            </div>
            <export-excel :data="hospitalSituationData" :name="fileName">
              <button
                :disabled="hospitalSituationData.length === 0"
                class="
                  btn btn-dash-blue btn-secondary btn-block
                  cursor-pointer
                  btn-export
                "
              >
                <small>Télécharger les données</small>
                <i
                  class="fas fa-file-excel ml-2"
                  style="font-size: 20px"
                  aria-hidden="true"
                ></i>
              </button>
            </export-excel>
          </div>
          <div class="col-12 text-right" v-if="!isLoading && !isGlobal">
            <p class="mb-0" v-if="hospitalSituationLastUpdate">
              Mise à jour du {{ hospitalSituationLastUpdate }}
            </p>
            <button class="btn btn-danger" @click="backToTotalData()">
              <small> Retour aux données globales </small>
            </button>
          </div>
        </div>
      </b-col>
    </b-row>
    <b-row no-gutters>
      <b-col cols="12" md="12" class="row no-gutters">
        <skeleton-loading v-if="isLoading" class="mb-2">
          <skeleton-square
            :boxProperties="{
              width: '100%',
              height: '340px',
            }"
          ></skeleton-square>
        </skeleton-loading>
        <b-row class="col-12 no-gutters px-2" v-else>
          <b-card
            v-if="hospitalsDataGroupedByStep.length === 0"
            class="default-card col-12"
          >
            <p class="text-center">Aucunes données disponibles</p>
          </b-card>
          <b-card
            class="col-12 default-card mb-2"
            v-for="(step, index) in hospitalsDataGroupedByStep"
            :key="index"
          >
            <h5 class="bold">{{ step.title }}</h5>
            <div
              v-for="(aggregatedFormField, key) in step.aggregated_form_fields"
              :key="key"
            >
              <p>
                {{ aggregatedFormField.form_field.name }} :
                <strong>{{ aggregatedFormField.value }}</strong>
                <span
                  v-if="aggregatedFormField.form_field.agreggation"
                  style="color: aaa"
                  >(somme)</span
                >
                <span v-else style="color: aaa">(moyenne)</span>
              </p>
            </div>
          </b-card>
        </b-row>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import { mapState, mapActions, mapMutations } from "vuex";
import { PALETTE } from "../config/env";
import { groupAggregatedDataByFormStepField } from "../functions/customFormFieldFunction";

export default {
  components: {},
  data() {
    return {
      etatGlobal: true,
      dataGlobal: null,
      objetChart: {},
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
  async mounted() {
    const id = this.selectedHospital ? this.selectedHospital.id : null;
    this.completedForm__getDataByHospitals();

    if (
      this.filterdHospitalSituation &&
      this.filterdHospitalSituation.last_update.length > 0
    ) {
      this.hospitalSituationFiltered();
    }
  },
  computed: {
    ...mapState({
      selectedHospital: (state) => state.hospital.selectedHospital,
      situationHospitalLoading: (state) =>
        state.hospital.situationHospitalLoading,
      hospitalData: (state) => state.hospital.hospitalData,
      situationHospital: (state) => state.hospital.situationHospital,
      hospitalCount: (state) => state.hospital.hospitalCount,
      isLoading: (state) => state.completedForm.isLoading,
      formSteps: (state) => state.formStep.formSteps,
      hospitalSituationAll: (state) =>
        state.hospitalSituation.hospitalSituationAll,
      hospitalSituationSelected: (state) =>
        state.hospitalSituation.hospitalSituationSelected,
      observation_start: (state) => state.hospitalSituation.observation_start,
      observation_end: (state) => state.hospitalSituation.observation_end,
      filterdHospitalSituation: (state) =>
        state.hospitalSituation.filterdHospitalSituation,
      hospitalObservationSituation: (state) =>
        state.hospitalSituation.hospitalObservationSituation,
      completedFormsAggregated: (state) =>
        state.completedForm.completedFormsAggregated,
      completedFormsData: (state) => state.completedForm.completedFormsData,
    }),
    hospital() {
      if (this.selectedHospital != null) return this.selectedHospital;
      else {
        return this.hospitalTotalData ? this.hospitalTotalData : {};
      }
    },
    isGlobal() {
      return this.selectedHospital == null;
    },
    lastUpdate() {
      if (this.selectedHospital != null) {
        return this.selectedHospital.last_update;
      } else if (this.dataGlobal) {
        return this.dataGlobal.last_update[
          this.dataGlobal.last_update.length - 1
        ];
      } else return null;
    },
    hospitalSituationReduced() {
      return this.createSituationsReduce(
        this.hospitalSituationAll.allFormFields
      );
    },
    hospitalSituationFiltered() {
      const arrayFilterd = [].concat.apply(
        [],
        this.filterdHospitalSituation.form_fields_names
      );
      return this.createSituationsReduce(arrayFilterd);
    },
    fileName() {
      if (this.observation_start == null) {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        return `Données_du_${this.observation_end}.xls`;
      } else {
        return `Données_du_${this.observation_start}_au_${this.observation_end}.xls`;
      }
    },
    hospitalSituationData() {
      const hospitalsSituationsData = this.completedFormsData.data || [];
      return hospitalsSituationsData
        .flatMap((hospital) => {
          return hospital.completed_forms.map((completedForm) => {
            const datas = {
              "Date de soumission": moment(completedForm.last_update).format(
                "DD/MM/YY"
              ),
              "Identifiant hopital": hospital.id,
              "Nom hopital": hospital.name,
              "Identifiant agent": completedForm.admin_user?.username || "-",
              "N° Téléphone Agent": completedForm.admin_user.phone_number,
            };
            completedForm.completed_form_fields.forEach(
              (completedFormField) => {
                datas[completedFormField.form_field.name] =
                  completedFormField.value;
              }
            );
            return datas;
          });
        })
        .filter((a, b) =>
          a["Date de soumission"].localeCompare(b["Date de soumission"])
        );
    },
    hospitalSituationLastUpdate() {
      if (this.selectedHospital && this.selectedHospital.id) {
        return this.selectedHospital.last_update
          ? moment(this.selectedHospital.last_update).format("DD.MM.YYYY")
          : null;
      } else if (this.completedFormsAggregated.last_update) {
        return moment(this.completedFormsAggregated.last_update).format(
          "DD.MM.YYYY"
        );
      } else {
        return null;
      }
    },
    prepareGraphicSituation() {
      return this.hospitalSituationAll.formFieldsFiltered;
    },
    hospitalSelectedFiltered() {
      const arrayFilterd = [].concat.apply(
        [],
        this.hospitalSituationSelected.form_fields_names
      );
      return this.createSituationsReduce(arrayFilterd);
    },
    hospitalsDataGroupedByStep() {
      if (this.selectedHospital && this.selectedHospital.id) {
        const aggregatedData = JSON.parse(this.selectedHospital.aggregated);
        return groupAggregatedDataByFormStepField(aggregatedData || []);
      } else {
        return groupAggregatedDataByFormStepField(
          this.completedFormsAggregated.aggregated || []
        );
      }
    },
  },
  watch: {
    hospitalData() {
      this.selectHospital(null);
      this.getSituationHospital();
    },
    selectedHospital(val) {
      const id = val ? val.id : null;
      console.log(val);
      const form = {
        hospital: id,
        observation_start: this.observation_start,
        observation_end: this.observation_end,
      };
      this.completedForm__getAggregatedByHospitals(form);
    },
    situationHospital(val) {
      this.dataGlobal = val;
      this.paintStats(val);
    },
    chartData() {
      this.$data._chart.update();
    },
  },
  methods: {
    ...mapActions([
      "getSituationHospital",
      "completedForm__getAggregatedByHospitals",
      "completedForm__getDataByHospitals",
    ]),
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
          if (!item || Number(item) === 0) {
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
        const callbacks = {
          title: (a, d) => {
            return this.moment(a[0].xLabel).format("DD.MM.Y");
          },
        };
        let ticksY = {};
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
              data: Resuscitation_beds.map((x) => (x === 0 ? null : x)),
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
            let label = data.datasets[tooltipItem.datasetIndex].label || "";
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
        const reference = this.$refs[`canvasStat${i + 1}`];
        if (this.lineCharts[i]) this.lineCharts[i].destroy();
        this.lineCharts[i] = new Chart(reference.getContext("2d"), config);
        reference.style.height = "200px";
        reference.style.maxHeight = "200px";
        // this.lineCharts[i].generateLegend();
      }
    },
    backToTotalData() {
      this.selectHospital(null);
    },
    createSituationsReduce(array = []) {
      const formIds = [];
      if (array.length > 0) {
        array
          ?.slice()
          .sort(
            (prevFormItem, nextFormItem) =>
              prevFormItem.form_step_id - nextFormItem.form_step_id
          )
          .forEach((item) => {
            if (
              formIds.every((form) => form.form_step_id !== item.form_step_id)
            ) {
              formIds.push({
                form_step_id: item.form_step_id,
                form_step_title: item.form_step_title,
              });
            }
          });
        const formStepsList = formIds.map((form) => {
          const formStep = {
            form_step_id: form.form_step_id,
            form_step_title: form.form_step_title,
          };
          formStep.form_field_values = array.filter(
            (arr) => arr.form_step_id == formStep.form_step_id
          );
          return formStep;
        });
        return formStepsList;
      }
      return [];
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
.btn-export[disabled="disabled"] {
  opacity: 0.2;
  cursor: not-allowed;
}
</style>
