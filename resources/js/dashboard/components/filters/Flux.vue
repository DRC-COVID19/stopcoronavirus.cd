<template>
  <b-container class="p-0">
    <b-row>
      <b-col cols="12">
        <b-form>
          <h4>Filtres prédefinis</h4>
          <b-form-group>
            <v-select />
          </b-form-group>
          <h3 class="mb-3">Paramètres détailés</h3>
          <h4>Géographiques</h4>
          <b-form-group>
            <label class="text-dash-color" for>Granularité</label>
            <v-select />
          </b-form-group>
          <div>
            <b-form-group
              :invalid-feedback="flux24Errors.filter_zone ? flux24Errors.filter_zone[0] : null"
              :state="flux24Errors.filter_zone && flux24Errors.filter_zone.lenght>0"
            >
              <label class="text-dash-color" for>Option</label>
            </b-form-group>
            <b-list-group>
              <b-list-group-item>
                <b-form-input placeholder="Filtre" v-model="fluxFilterInput" />
              </b-list-group-item>
              <b-list-group-item class="checkbox-zone-group">
                <b-form-checkbox
                  v-model="allZoneChecked"
                  :indeterminate.sync="allZoneCheckedIndeterminate"
                >Sélectionnez tout</b-form-checkbox>
                <hr />
                <b-form-checkbox-group
                  v-model="fluxForm.filter_zone"
                  :options="fluxZonesArray"
                  value-field="origin"
                  text-field="origin"
                  name="flavour-1"
                  stacked
                  :invalid-feedback="flux24Errors.filter_zone ? flux24Errors.filter_zone[0] : null"
                  :state="flux24Errors.filter_zone && flux24Errors.filter_zone.lenght>0"
                ></b-form-checkbox-group>
              </b-list-group-item>
            </b-list-group>
          </div>
        </b-form>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
export default {
  data() {
    return {
      flux24Errors: {},
      fluxForm:{},
      fluxZonesArray:[],
      allZoneCheckedIndeterminate:false,
      allZoneChecked:false,
      fluxFilterInput:''
    };
  }
};
</script>

<style>
</style>