<template>
  <b-container>
    <b-row class="header">
      <b-col cols="12" md="6" class="map-form-header">
        <h1>Projet control room Covid-19</h1>
      </b-col>
      <b-col cols="12" md="6" class="map-form-logo d-flex justify-content-center justify-content-md-end">
        <img src="/img/partners_top.png" width="100" class="img-fluid" alt />
        <img src="/img/commite_riposte.jpg" width="100" class="img-fluid" alt />
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
export default {};
</script>


<style lang="scss" scoped>
@import "@~/sass/_variables";
.header {
  padding: 12px 24px;
  background: white;
  border-bottom: 1px solid $dash-shadow-color;

  h1 {
    font-size: 20px;
    font-weight: 600;
    line-height: 24px;
  }
}
</style>