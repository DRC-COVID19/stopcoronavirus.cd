<template>
  <b-container fluid class="p-0">
    <b-row class="flex-md-row-reverse h-100" no-gutters>
      <b-col cols="12" md="12" class="h-100">
        <b-card no-body class="h-100 rounded-0">
          <b-tabs content-class="mt-3" card>
            <b-tab title="Nouvelle prédiction" active>
              <ExistingData />
            </b-tab>
            <b-tab title="Prédictions enregistrée">
              <p>Prédictions enregistrée</p>
            </b-tab>
          </b-tabs>
        </b-card>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import ExistingData from '../../components/prediction/ExistingData';
export default {
  components: { ExistingData },
};
</script>

<style lang="scss" scoped>
.card {
  .tabs {
    .card-header {
      background-color: #dee2e6 !important;
    }
  }
}
</style>
