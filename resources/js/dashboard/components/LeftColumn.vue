<template>
  <b-container class="column-left col-md-3">
    <b-row class="mb-3">
      <b-col cols="12">
        <b-card no-body>
          <b-card-header>
            <b-form-checkbox
              class="styled-checkbox"
              name="covid_case"
              @change="covidCaseToggle"
            >Cas covid-19
            <b-badge v-if="covidCasesCount">{{covidCasesCount}}</b-badge>
            </b-form-checkbox>
            
          </b-card-header>
        </b-card>
      </b-col>
    </b-row>

    <b-row class="mb-3">
      <b-col cols="12">
        <b-card>
          <b-form-checkbox class="styled-checkbox" name="list_hospital"
            @change="hospitalToggle"
          >
            Liste hôpitaux
            <b-badge v-if="hospitalCount">{{hospitalCount}}</b-badge>
          </b-form-checkbox>
        </b-card>
      </b-col>
    </b-row>
    <b-row class="mb-3">
      <b-col cols="12">
        <b-card no-body>
          <b-card-header>
            <b-form-checkbox
              v-model="orientationChecked"
              @change="medicalOrientationToggle"
              class="styled-checkbox"
              name="medical_orientation"
            >
              Cas probable (issu du formulaire d'orientation médical)
              <b-badge v-if="orientationCount">{{orientationCount}}</b-badge>
            </b-form-checkbox>
          </b-card-header>
          <b-collapse id="orientation_result_collapse">
            <b-card-body>
              <v-select
                name="orientation_result"
                v-model="orientationSelected"
                :disable="orientationChecked"
                :options="OrientationLIst"
                label="name"
                :reduce="item=>item.id"
                @input="orientationChange"
              />
              <h4>Legende</h4>
              <div class="legende">
                <div>
                  <span class="fin-8 legende-color"></span>
                  <span>Peu probale</span>
                  <b-badge v-if="fin8Count">{{fin8Count}}</b-badge>
                </div>
                <div>
                  <span class="fin legende-color"></span>
                  <span>Probable</span>
                  <b-badge v-if="finCount">{{finCount}}</b-badge>
                </div>
                <div>
                  <span class="fin-5 legende-color"></span>
                  <span>Très probable</span>
                  <b-badge v-if="fin5Count">{{fin5Count}}</b-badge>
                </div>
                <div class="d-block text-right">
                  <a href="#" target="_blank">Voir formulaire</a>
                </div>
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
      </b-col>
    </b-row>
    <b-row class="mb-3">
      <b-col cols="12">
        <b-card no-body>
          <b-card-header>
            <b-form-checkbox @change="hasSondageToggle" class="styled-checkbox" name="has_sondage">
              Sondages
              <span></span>
            </b-form-checkbox>
          </b-card-header>
          <b-collapse id="has_sondage_collapse">
            <b-card-body id="sondage-item">
              <b-form-checkbox
                class="styled-checkbox mb-2"
                name="worried"
                id="worried"
              >A quel point cela vous inquiète ?</b-form-checkbox>
              <b-form-checkbox
                class="styled-checkbox mb-2"
                name="catch_virus"
                id="catch_virus"
              >Est-ce que vous pensez que vous pourriez attraper le virus ?</b-form-checkbox>
              <b-form-checkbox
                class="styled-checkbox mb-3"
                name="price_increase"
                id="price_increase"
              >Constatent une augmentation des prix des denrées essentielles</b-form-checkbox>
              <div class="group-control mb-3">
                <label>Quels sont les denrées que vous avez du mal à trouver?</label>
              </div>
              <b-form-checkbox class="styled-checkbox mb-2" name="mask" id="mask">Masque</b-form-checkbox>

              <b-form-checkbox class="styled-checkbox mb-2" name="makala" id="makala">Makala</b-form-checkbox>
              <b-form-checkbox class="styled-checkbox mb-2" name="flour" id="flour">Farine</b-form-checkbox>
              <b-form-checkbox
                class="styled-checkbox mb-2"
                name="antibacterial_gel"
                id="antibacterial_gel"
              >Gel antibactérien</b-form-checkbox>
            </b-card-body>
          </b-collapse>
        </b-card>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
export default {
  props:{
    covidCasesCount:{
      type:Number,
      default:null
    },
    hospitalCount:{
      type:Number,
      default:null
    },
    orientationCount:{
      type:Number,
      default:null
    },
    finCount:{
      type:Number,
      default:null
    },
    fin8Count:{
      type:Number,
      default:null
    },
    fin5Count:{
      type:Number,
      default:null
    }
  },
  data() {
    return {
      OrientationLIst: [
        {
          id: "ALL",
          name: "Tout"
        },
        {
          id: "FIN",
          name: "Probable"
        },
        {
          id: "FIN8",
          name: "Peu probable"
        },
        {
          id: "FIN5",
          name: "Très probable"
        }
      ],
      orientationChecked: false,
      orientationSelected: "ALL"
    };
  },
  methods: {
    covidCaseToggle(checked) {
      this.$emit("covidCaseChecked", checked);
    },
    hospitalToggle(checked){
      this.$emit("hopitalChecked", checked);
    },
    medicalOrientationToggle(checked) {
      this.$root.$emit("bv::toggle::collapse", "orientation_result_collapse");
      if (checked) {
        this.orientationSelected = "ALL";
      }
       this.$emit("medicalOrientationChecked", checked);
    },
    orientationChange(item){
      this.$emit("medicalOrientationChanged", item);
    },
    hasSondageToggle(checked) {
      this.$root.$emit("bv::toggle::collapse", "has_sondage_collapse");
      this.$emit("hasSondageChecked", checked);
    }
  }
};
</script>

<style lang="scss" scoped>
.column-left {
  background: #14244f;
  padding-top: 15px;
  padding-bottom: 15px;
  overflow: auto;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  z-index: 2;
}
</style>