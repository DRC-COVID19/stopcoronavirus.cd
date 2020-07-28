<template>
  <b-card no-body class="rounded-0 p-2">
    <b-form class="flux-form" @submit="submit">
      <b-form-row>
        <b-col cols="12" md="2" class="nav-zone pl-3 pr-3">
          <b-form-group>
            <label for class="text-dash-color">Filtres prédefinis</label>
            <v-select label="name" placeholder="Options" />
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
                  v-model="form.fluxGeoGranularity"
                  :options="geoGranularities"
                  label="name"
                  placeholder="Granularité"
                  :reduce="item=>item.id"
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
                />
              </b-form-group>
            </b-col>
          </b-row>
        </b-col>
        <b-col cols="12" md="2" class="pl-3 pr-3">
          <b-button type="submit" block class="mt-2 btn-dash-blue">Filtrer les données</b-button>
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
      predefinedInput: FLUX_PREDEFINED_INPUT,
      geoGranularities: GEO_GRANULARITIES,
      tempGranularities: TEMP_GRANULARITIES,
      indicateurY: INDICATEUR_Y,
      indicateurX: INDICATEUR_X,
      geoOptions: [],
      form: {},
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
      this.submitFilters(this.form);
    },
    geoGranularityChange(value) {
      // this.setFluxGeoGranularity(value);
      this.form.geoOptions = [];
      if (value == 1) {
        this.geoOptions = this.fluxProvinces;
      } else {
        this.geoOptions = this.fluxZones;
      }
    },
  },
};
</script>
