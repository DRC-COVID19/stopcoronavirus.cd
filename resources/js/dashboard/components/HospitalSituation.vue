<template>
  <b-card>
    <b-container class="p-0">
      <b-row>
        <b-col cols="12">
          <h4 class="bold">{{hospital.name}}</h4>
          <hr />
          <h5 class="bold">Situations épidemologiques</h5>
          <div>Confirmés: {{hospital.confirmed}}</div>
          <div>Hospitalisés: {{hospital.sick}}</div>
          <div>Guéris: {{hospital.healed}}</div>
          <div>décès: {{hospital.dead}}</div>
          <hr />
          <h5 class="bold">Capacité de prise en charge</h5>
          <div>Lits avec mousse: {{hospital.occupied_foam_beds}}/{{hospital.foam_beds}}</div>
          <div>Lits de réanimation: {{hospital.occupied_resuscitation_beds}}/{{hospital.resuscitation_beds}}</div>
          <div>
            Respirateurs
            : {{hospital.respirators}}/{{hospital.occupied_respirators}}
          </div>
          <div>
            Ventilateur de réanimation
            : {{hospital.resuscitation_ventilator}}
          </div>
          <div>
            Oxygénérateur
            : {{hospital.oxygenator}}
          </div>
          <div>
            Equipement de protection individuelle
            : {{hospital.individual_protection_equipment}}
          </div>
          <div>
            Masques N95/FFP2
            : {{hospital.masks}}
          </div>
          <div>
            Dépistage rapide
            : {{hospital.rapid_screening}}
          </div>
          <div>
            Radiographie
            : {{hospital.x_ray}}
          </div>
          <div>
            Automate Genexpert
            : {{hospital.automate_genexpert}}
          </div>
          <div>
            Gel hydro alcoolique
            : {{hospital.gel_hydro_alcoolique}}
          </div>
          <div>
            check point
            : {{hospital.check_point}}
          </div>
          <hr />
          <h5 class="bold">Médicaments</h5>
          <div>
            Chloroquine
            : {{hospital.chloroquine}}
          </div>
          <div>
            Hydrochloroquine
            : {{hospital.hydrochloroquine
            }}
          </div>
          <div>
            Azytromicine
            : {{hospital.azytromicine
            }}
          </div>
          <div>
            Vitamince C
            : {{hospital.Vitamince_c
            }}
          </div>
          <hr />
          <h5 class="bold">Personnels</h5>
          <div>
            Médicins
            : {{hospital.doctors}}
          </div>
          <div>
            Infirmiers
            : {{hospital.nurses}}
          </div>
          <div>
            Para Médicaux
            : {{hospital.para_medicals}}
          </div>
        </b-col>
      </b-row>
    </b-container>
  </b-card>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState({
      hospital: state => state.hospital.selectedHospital
    })
  }
};
</script>

<style>
</style>