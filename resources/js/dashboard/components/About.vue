<template>
  <div class="apropos">
    <b-card no-body class="default-card">
      <b-tabs pills card vertical>
        <b-tab title="Mobilité" active>
          <b-card-text>Tab contents 1</b-card-text>
        </b-tab>
        <b-tab title="Indicateurs">
          <b-card-text>Tab contents 2</b-card-text>
        </b-tab>
        <b-tab title="Infrastructures">
          <b-card-text>Tab contents 3</b-card-text>
        </b-tab>
      </b-tabs>
    </b-card>
  </div>
</template>

<script>
export default {

}
</script>

<style lang="scss">
  @import "@~/sass/_variables";

  .apropos{
    height : 100vh ;
    .nav-pills .nav-link{
      text-decoration: none ;
      color : $dash-text-100 ;
      &.active{
        background-color: $dash-blue;
      }
    }
  }
</style>
