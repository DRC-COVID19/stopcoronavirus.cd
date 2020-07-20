<template>
    <b-card no-body class="rounded-0 p-2">
    <b-form class="flux-form">
      <b-form-row>
        <b-col cols="12" md="2" class="nav-zone pl-3 pr-3">
          <b-form-group>
            <label for class="text-dash-color">Filtres prédefinis</label>
            <v-select
              label="name"
              placeholder="Options"
            />
          </b-form-group>
        </b-col>

        <b-col cols="12" md="4" class="nav-zone pl-3 pr-3">
          <b-row>
            <b-col cols="12" md="6">
              <b-form-group>
                <label for class="text-dash-color">X</label>
                <v-select
                label="name"
                placeholder="Options"
                />
              </b-form-group>
            </b-col>
            <b-col cols="12" md="6">
              <b-form-group>
                <label for class="text-dash-color">Y</label>
                <v-select
                label="name"
                placeholder="Options"
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
                label="name"
                placeholder="Granularité"
                />
              </b-form-group>
            </b-col>
            <b-col cols="12" md="6">
              <b-form-group>
                <v-select
                label="name"
                placeholder="Options"
                />
              </b-form-group>
            </b-col>
          </b-row>
        </b-col>

      </b-form-row>
    </b-form>
  </b-card>
</template>

<script>
export default {

}
</script>
