<template>
  <b-container fluid class="main">
      <MainHeader />
    <b-row>
      <router-view ></router-view>
    </b-row>
  </b-container>
</template>

<script>
  import MainHeader from './administrator/components/MainHeader';
  export default {
    components: {
      MainHeader,
    }
  };
</script>

<style lang='scss' scoped >
  @import "@~/sass/_variables";
  .main {
    background-color: $dash-background;
    height: 100vh;
  }
</style>
