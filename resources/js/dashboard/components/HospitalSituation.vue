<template>
	<b-container class="p-0">
		<b-row>
            <b-col cols="12 mb-2">
                <b-card no-body class="default-card p-3">
                    <div class="row align-items-center">
                        <h4 class="bold col m-0">{{hospital.name}}</h4>
                        <div v-if="hospital.last_update" class="text-right text-black-50 col">
                            Mise à jour du {{moment(hospital.last_update).format('DD.MM.Y')}}
                        </div>
                    </div>
                </b-card>
            </b-col>

            <b-col cols="12" md="6" class="pr-md-2">
                <b-card class="col-12 default-card mb-2">
                    <h5 class="bold">Situations épidemologiques</h5>
                    <div>
                        <div>Confirmés: {{hospital.confirmed}}</div>
                        <div>Hospitalisés: {{hospital.sick}}</div>
                        <div>Guéris: {{hospital.healed}}</div>
                        <div>décès: {{hospital.dead}}</div>
                    </div>
                </b-card>

                <b-card class="col-12 default-card mb-2">
                    <h5 class="bold">Capacité de prise en charge</h5>
                    <div>
                        <div>Lits avec mousse: {{hospital.occupied_foam_beds}}/{{hospital.foam_beds}}</div>
                        <div>Lits de réanimation: {{hospital.occupied_resuscitation_beds}}/{{hospital.resuscitation_beds}}</div>
                        <div>
                            Respirateurs: {{hospital.occupied_respirators}}/{{hospital.respirators}}
                        </div>
                        <div>
                            Ventilateur de réanimation : {{hospital.resuscitation_ventilator}}
                        </div>
                        <div>
                            Oxygénérateur: {{hospital.oxygenator}}
                        </div>
                        <div>
                            Equipement de protection individuelle: {{hospital.individual_protection_equipment}}
                        </div>
                        <div>
                            Masques N95/FFP2: {{hospital.masks}}
                        </div>
                        <div>
                            Dépistage rapide: {{hospital.rapid_screening}}
                        </div>
                        <div>
                            Radiographie: {{hospital.x_ray}}
                        </div>
                        <div>
                            Automate Genexpert: {{hospital.automate_genexpert}}
                        </div>
                        <div>
                            Gel hydro alcoolique: {{hospital.gel_hydro_alcoolique}}
                        </div>
                        <div>
                            check point: {{hospital.check_point}}
                        </div>
                    </div>
                </b-card>
            </b-col>

            <b-col cols="12" md="6" class="pl-md-2">
                <b-card class="col-12 default-card mb-2">
                    <h5 class="bold">Médicaments</h5>
                    <div>
                        Chloroquine: {{hospital.chloroquine}}
                    </div>
                    <div>
                        Hydrochloroquine: {{hospital.hydrochloroquine}}
                    </div>
                    <div>
                        Azytromicine: {{hospital.azytromicine}}
                    </div>
                    <div>
                        Vitamince C: {{hospital.Vitamince_c}}
                    </div>
                </b-card>

                <b-card class="col-12 default-card">
                    <h5 class="bold">Personnels</h5>
                    <div>
                        Médicins: {{hospital.doctors}}
                    </div>
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
            <b-card no-body class="default-card col-12 pt-3 pb-3">
                <div class="chart-container">
                    <canvas
                    height="400"
                    width="100vh"
                    ref="canvasStat"
                    id="canvasStat"
                    ></canvas>
                </div>
            </b-card>
        </b-row>
	</b-container>
</template>

<script>
import { mapState } from "vuex";
export default {
	data : function(){
		return {
			totalData : {},
            lineChart : null
		}
	},
	mounted() {
		let totalDataGetted = {}
		axios
			.get(`/api/dashboard/hospitals-totaux`)
			.then(({ data }) => {
				totalDataGetted = data
				totalDataGetted.name = "Rapport global"
				this.totalData =  totalDataGetted ;
            })
        this.getEvolutionHospital()
	},
    computed: {
        ...mapState({
            selectedHospital: state => state.hospital.selectedHospital
        }),
        hospital(){
            if(this.selectedHospital != null) return this.selectedHospital
            else{
                return this.totalData
            }
        }
    },
    watch: {
        selectedHospital(val) {
            this.getEvolutionHospital()
        }
    },
	methods : {
        paintStats(data){
            const config = {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'occupation lits en réanimation',
                        backgroundColor: "#ff6384",
                        borderColor: "#ff6384",
                        data: data.dataLits,
                        fill: false,
                         interpolate: true,
                        showLine: true,
                        pointRadius: 2,
                        lineTension: 0.4
                    }, {
                        label: 'occupation respirateurs',
                        fill: false,
                        backgroundColor: "#36a2eb",
                        borderColor: "#36a2eb",
                        data: data.dataRespirateurs,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    title: {
                        display: false,
                        text: 'Chart.js Line Chart'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var label = data.datasets[tooltipItem.datasetIndex].label || '';
                                if (label) label += ': '
                                label += tooltipItem.yLabel + '%'
                                return label;
                            }
                        }
                    },
                    plugins: {
                        crosshair: {
                            sync: {
                                enabled: false // enable trace line syncing with other charts
                            },
                            zoom : {
                                enabled: false
                            }
                        }
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Periode',
                            },
                            ticks : {
                                fontSize: 9,
                                autoSkip: false,
                                maxRotation: 90,
                                minRotation: 90
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Taux'
                            },
                            ticks : {
                                callback: function(value, index, values) {
                                    return value + '%';
                                }
                            }
                        }]
                    }
                }
            };

            if(this.linechart) this.linechart.destroy()
            this.linechart = new Chart(this.$refs['canvasStat'].getContext("2d"), config)
        },
        getEvolutionHospital(){
            const selectedHospital = this.selectedHospital?.id ?? ''
            axios
			.get(`/api/dashboard/hospitals/evolution/${selectedHospital}`)
			.then(({ data }) => {
                console.log(data)
                this.paintStats(data)
            })
        }
	}
};
</script>

<style lang="scss" scoped>
    #canvasStat{
        height : 400px !important ;
    }
</style>
