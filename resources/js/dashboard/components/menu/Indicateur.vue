<template>
  <b-card no-body class="rounded-0 p-2">
    <b-form class="flux-form mb-2" @submit.prevent="submit">
      <b-form-row>
        <b-col cols="12" md="2" class="nav-zone pl-3 pr-3">
          <b-form-group>
            <label for class="text-dash-color">Filtres prédefinis</label>
            <v-select
              @input="predefinedInputChange"
              v-model="fluxPredefinedControl"
              :options="predefinedInput"
              :reduce="item=>item.id"
              label="name"
              placeholder="Options"
              class="style-chooser"
            />
          </b-form-group>
        </b-col>

        <b-col cols="12" md="4" class="nav-zone pl-3 pr-3">
          <b-row>
            <b-col cols="12" md="6">
              <b-form-group>
                <label for class="text-dash-color">X</label>
                <v-select
                  v-model="form.x"
                  :options="indicateurX"
                  label="name"
                  placeholder="Options"
                  :reduce="item=>item.id"
                  @input="resetFluxPredefinedControl"
                  class="style-chooser"
                />
              </b-form-group>
            </b-col>
            <b-col cols="12" md="6">
              <b-form-group>
                <label for class="text-dash-color">Y</label>
                <v-select
                  v-model="form.y"
                  :options="indicateurY"
                  label="name"
                  placeholder="Options"
                  :reduce="item=>item.id"
                  @input="resetFluxPredefinedControl"
                  class="style-chooser"
                />
              </b-form-group>
            </b-col>
          </b-row>
        </b-col>

        <b-col cols="12" md="4" class="nav-zone pl-3 pr-3">
          <label for class="text-dash-color">Paramètres Géographiques</label>
          <b-row>
            <b-col cols="12" md="6">
              <b-form-group>
                <v-select
                  @input="geoGranularityChange"
                  v-model="form.geoGranularity"
                  :options="geoGranularities"
                  label="name"
                  placeholder="Granularité"
                  :reduce="item=>item.id"
                  class="style-chooser"
                />
              </b-form-group>
            </b-col>
            <b-col cols="12" md="6">
              <b-form-group
                :invalid-feedback="formErrors.geoOptions ? formErrors.geoOptions[0] : null"
                :state="formErrors.geoOptions && formErrors.geoOptions.lenght>0"
              >
                <v-select
                  v-model="form.geoOptions"
                  multiple
                  :disabled="!form.geoGranularity"
                  :options="geoOptions"
                  placeholder="Localisation"
                  label="origin"
                  :reduce="item=>item.origin"
                  class="style-chooser style-chooser-multiple"
                  @input="resetFluxPredefinedControl"
                />
              </b-form-group>
            </b-col>
          </b-row>
        </b-col>
        <b-col cols="12" md="2" class="row pl-3 pr-3">
          <b-button type="submit" block class="btn-submit mt-2 btn-dash-blue">Filtrer les données</b-button>
        </b-col>
      </b-form-row>
    </b-form>
  </b-card>
</template>

<script>
import {
  FLUX_PREDEFINED_INPUT,
  GEO_GRANULARITIES,
  TEMP_GRANULARITIES,
  INDICATEUR_Y,
  INDICATEUR_X,
  INDICATEUR_PREDEFINED_INPUT,
} from "../../config/env";
import { mapActions, mapState } from "vuex";
export default {
  props: {
    fluxZones: {
      type: Array,
      default: () => [],
    },
    fluxProvinces: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      predefinedInput: INDICATEUR_PREDEFINED_INPUT,
      geoGranularities: GEO_GRANULARITIES,
      tempGranularities: TEMP_GRANULARITIES,
      indicateurY: INDICATEUR_Y,
      indicateurX: INDICATEUR_X,
      geoOptions: [],
      form: {
        observation_end: "2020-03-19",
        observation_start: "2020-03-28",
      },
      fluxPredefinedControl : null
    };
  },
  computed: {
    ...mapState({
      formErrors: (state) => state.indicator.formErrors,
    }),
  },
  methods: {
    ...mapActions(["submitFilters"]),
    submit() {
      this.form.observation_end = "2020-03-28";
      this.form.observation_start = "2020-03-19";
      this.submitFilters(this.form);
    },
    predefinedInputChange(value) {
      if (value) {
        switch (value) {
          case 1:
            this.form.observation_end = "2020-03-28";
            this.form.observation_start = "2020-03-19";
            this.$set(this.form,'x',1);
            this.$set(this.form,'y',1);
            this.$set(this.form,'geoGranularity',2);
            this.geoGranularityChange(2);
            this.$set(this.form,'geoOptions',['Gombe']);
            this.submitFilters(this.form);
            break;

          default:
            break;
        }
      }
    },
    geoGranularityChange(value) {
      // this.setFluxGeoGranularity(value);
      if(value != 2) this.resetFluxPredefinedControl()

      this.form.geoOptions = [];
      if (value == 1) {
        this.geoOptions = this.fluxProvinces;
      } else {
        this.geoOptions = this.fluxZones;
      }
    },
    resetFluxPredefinedControl(){
      this.fluxPredefinedControl = null
    }
  },
};
</script>

<style lang="scss" scoped>
  .btn-submit{
    font-size: 14px ;
  }
</style>
