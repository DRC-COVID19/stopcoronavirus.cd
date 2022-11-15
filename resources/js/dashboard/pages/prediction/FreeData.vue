<template>
  <b-container fluid class="p-0">
    <b-row class="flex-md-row-reverse h-100" no-gutters>
      <b-col cols="12" md="12" class="h-100">
        <b-card no-body class="h-100 rounded-0">
          <b-tabs content-class="mt-3" card>
            <b-tab title="Importation du fichier" active
              ><p>Importation du fichier</p></b-tab
            >
            <b-tab title="Enregistrement manuel"
              ><p>Enregistrement manuel</p></b-tab
            >
            <b-tab title="Prédictions enregistrées"
              ><p>Prédictions enregistrées</p></b-tab
            >
            <b-tab title="Brouillons"><p>Brouillons</p></b-tab>
          </b-tabs>
        </b-card>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
export default {}
</script>

<style></style>
