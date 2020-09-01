<template>
  <b-container class="p-0">
    <b-row>
      <b-col cols="12 mb-2">
        <div class="row align-items-center">
          <h4 class="col m-0">{{hospital.name || "Rapport global"}}</h4>
          <div
            class="text-right text-black-50 col"
          >Mise à jour du {{moment(lastUpdate()).format('DD.MM.Y')}}</div>
          <div class="col-12 text-right">
            <button
              class="btn btn-sm btn-primary"
              style="font-size: 12px;"
              @click="backToTotalData()"
              v-if="!isGlobal"
            >Retour aux données globales</button>
          </div>
        </div>
      </b-col>
    </b-row>
    <b-row no-gutters>
      <b-col cols="12" md="6" class="row no-gutters pr-1"  >
        <b-card class="col-12 default-card mb-2">
          <h5 class="bold">Capacité de prise en charge</h5>
          <div>
            <div>Lits avec mousse: {{hospital.foam_beds}}</div>
            <div>Lits avec mousse occupés: {{hospital.occupied_foam_beds}}</div>
            <div>Lits de réanimation: {{hospital.resuscitation_beds}}</div>
            <div>Lits de réanimation occupés: {{hospital.occupied_resuscitation_beds}}</div>
            <div>Respirateurs: {{hospital.respirators}}</div>
            <div>Respirateurs occupés: {{hospital.occupied_respirators}}</div>
            <div>Ventilateur de réanimation : {{hospital.resuscitation_ventilator}}</div>
            <div>Oxygénérateur: {{hospital.oxygenator}}</div>
            <div
              v-if="!isGlobal"
            >Equipement de protection individuelle: {{hospital.individual_protection_equipment}}</div>
            <div v-if="!isGlobal">Masques N95/FFP2: {{hospital.masks}}</div>
            <div v-if="!isGlobal">Dépistage rapide: {{hospital.rapid_screening}}</div>
            <div v-if="!isGlobal">Radiographie: {{hospital.x_ray}}</div>
            <div v-if="!isGlobal">Automate Genexpert: {{hospital.automate_genexpert}}</div>
            <div v-if="!isGlobal">Gel hydro alcoolique: {{hospital.gel_hydro_alcoolique}}</div>
            <div v-if="!isGlobal">check point: {{hospital.check_point}}</div>
          </div>
        </b-card>
      </b-col>
      <b-col cols="12" md="6" class="pl-1">
        <b-card class="col-12 default-card mb-2">
          <h5 class="bold">Situations épidemologiques</h5>
          <div>
            <div>Confirmés: {{hospital.confirmed}}</div>
            <div>Hospitalisés: {{hospital.sick}}</div>
            <div>Guéris: {{hospital.healed}}</div>
            <div>décès: {{hospital.dead}}</div>
          </div>
        </b-card>
        <b-card class="col-12 default-card mb-2" v-if="!isGlobal">
          <h5 class="bold">Médicaments</h5>
          <div>Chloroquine: {{hospital.chloroquine}}</div>
          <div>Hydrochloroquine: {{hospital.hydrochloroquine}}</div>
          <div>Azytromicine: {{hospital.azytromicine}}</div>
          <div>Vitamince C: {{hospital.Vitamince_c}}</div>
        </b-card>
        <b-card class="col-12 default-card mb-2">
          <h5 class="bold">Personnels</h5>
          <div>Médicins: {{hospital.doctors}}</div>
          <div>
            Infirmiers
            : {{hospital.nurses}}
          </div>
          <div>
            Para Médicaux
            : {{hospital.para_medicals}}
          </div>
        </b-card>
      </b-col>
    </b-row>

    <b-row class="pl-3 pr-3 mb-2">
      <b-col cols="12" md="6" class="p-1">
        <b-card no-body class="default-card col-12 p-0 pt-3 pb-3 card-chart">
          <b-spinner label="Chargement..." v-if="situationHospitalLoading"></b-spinner>
          <legend-popover>
            <template v-slot:title>Comment est-ce calculé ? </template>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Sapiente tempore libero fugit perferendis repellendus?
          </legend-popover>
          <div class="chart-container">
            <canvas height="400" width="100vh" ref="canvasStat1" id="canvasStat1"></canvas>
          </div>
        </b-card>
      </b-col>

      <b-col cols="12" md="6" class="p-1">
        <b-card no-body class="default-card col-12 p-0 pt-3 pb-3 card-chart">
          <b-spinner label="Chargement..." v-if="situationHospitalLoading"></b-spinner>
          <legend-popover>
            <template v-slot:title>Comment est-ce calculé ? </template>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Sapiente tempore libero fugit perferendis repellendus?
          </legend-popover>
          <div class="chart-container">
            <canvas height="400" width="100vh" ref="canvasStat2" id="canvasStat2"></canvas>
          </div>
        </b-card>
      </b-col>

      <b-col cols="12" class="p-1">
        <b-card no-body class="default-card col-12 p-0 pt-3 pb-3 card-chart">
          <b-spinner label="Chargement..." v-if="situationHospitalLoading"></b-spinner>
          <div class="chart-container">
            <canvas height="400" width="100vh" ref="canvasStat3" id="canvasStat3"></canvas>
          </div>
        </b-card>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import { mapState, mapActions, mapMutations } from "vuex";

export default {
  props: ["hospitalTotalData"],
  data() {
    return {
      lineCharts: [],
      etatGlobal: true,
      dataGlobal: null,
      chartLabels : [
        { title : "Evolution du taux d'occupation des respirateurs" ,
          lableY : "Nombre de respirateurs" } ,

        { title : "Evolution du taux d'occupation des lits de réanimation",
          lableY : "Nombre de lits" } ,

        { title : "Evolution global du taux d'occupation",
          lableY : "Taux d'occupation" } ,
      ]
    };
  },
  mounted() {
    this.getSituationHospital();
  },
  computed: {
    ...mapState({
      selectedHospital: (state) => state.hospital.selectedHospital,
      situationHospitalLoading: (state) => state.hospital.situationHospitalLoading,
      hospitalData: (state) => state.hospital.hospitalData,
      situationHospital: (state) => state.hospital.situationHospital,
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
  },
  watch: {
    hospitalData() {
      this.selectHospital(null)
      this.getSituationHospital()
    },
    selectedHospital(val) {
      const id = val ? val.id : null;
      this.getSituationHospital(id);
    },
    situationHospital(val) {
      this.dataGlobal = val
      this.paintStats(val);
    },
  },
  methods: {
    ...mapActions(["getSituationHospital"]),
    ...mapMutations(["selectHospital"]),
    paintStats(data) {

      for (let i = 0; i < 3; i++) {

        let callbacks = {} , ticksY = {}
        let datasets = []
        if(i == 0){
          datasets = [
            {
              label: "Respirateurs" ,
              fill: false,
              backgroundColor: "#F44336",
              borderColor: "#F44336",
              data: data.respirators.map(x => (x == 0) ? null : x),
              fill: false,
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4
            },
            {
              label: "Respirateurs occupés" ,
              fill: false,
              backgroundColor: "#2e5bff",
              borderColor: "#2e5bff",
              data: data.occupied_respirators.map(x => (x == 0) ? null : x) ,
              fill: false,
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4
            }
          ] ;

          ticksY = {
            min : 0 ,
            precision : 0
          }
        }
        else if(i == 1){
          datasets = [
            {
              label: "Lits de réanimation" ,
              backgroundColor: "#F44336",
              borderColor: "#F44336",
              data: data.resuscitation_beds.map(x => (x == 0) ? null : x),
              fill: false,
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4
            },
            {
              label: "Lits de réanimation occupés" ,
              backgroundColor: "#2e5bff",
              borderColor: "#2e5bff",
              data: data.occupied_resuscitation_beds.map(x => (x == 0) ? null : x),
              fill: false,
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4
            }
          ] ;

          ticksY = {
            min : 0 ,
            precision : 0
          }
        }else{
          const dataset1 = data.occupied_resuscitation_beds.map(
            (a, i) => {
              if(a == 0 || data.resuscitation_beds[i] == 0) return null
              return Math.round(a * 100 / data.resuscitation_beds[i] )
            })

          const dataset2 = data.occupied_respirators.map(
            (a,i) => {
              if(a == 0 || data.respirators[i] == 0) return null
              return Math.round(a * 100 / data.respirators[i] )
            })

          datasets = [
            {
              label: "Taux occupation des lits de réanimation" ,
              backgroundColor: "#F44336",
              borderColor: "#F44336",
              data: dataset1,
              fill: false,
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4
            },
            {
              label: "Taux occupation des Réspirateurs" ,
              backgroundColor: "#2e5bff",
              borderColor: "#2e5bff",
              data: dataset2,
              fill: false,
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4
            }
          ] ;

          callbacks = {
            label: function (tooltipItem, data) {
                var label = data.datasets[tooltipItem.datasetIndex].label || "";
                if (label) label += ": ";
                label += tooltipItem.yLabel + "%";
                return label;
            }
          }

          ticksY = {
            min : 0 ,
            callback: function (value, index, values) {
                return value + "%";
            }
          }
        }

        const config = {
          type: "line",
          data: {
            labels: data.last_update.map((d) => new Date(d)),
            datasets: datasets
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
              display: true,
              text: this.chartLabels[i].title,
              fontSize : 11
            },
            tooltips: {
              mode: "index",
              intersect: false,
              callbacks: callbacks
            },
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
                  }
                  ,ticks: ticksY
                },
              ],
            },
          },
        };

        if (this.lineCharts[i]) this.lineCharts[i].destroy();
        this.lineCharts[i] = new Chart(
          this.$refs[`canvasStat${i+1}`].getContext("2d"),
          config
        );
      }
    },
    backToTotalData() {
      this.selectHospital(null);
    },
    lastUpdate(){
      if (this.selectedHospital != null) return this.selectedHospital.last_update
      else if(this.dataGlobal)
        return this.dataGlobal.last_update[this.dataGlobal.last_update.length - 1]
      else return null
    }
  },
};
</script>

<style lang="scss" scoped>
.card-chart {
  position: relative;
  #canvasStat1, #canvasStat2 {
    height: 400px !important ;
  }
  .spinner-border {
    position: absolute;
    top: calc(50% - 20px);
    left: calc(50% - 20px);
  }
}
</style>
