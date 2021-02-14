<template>
  <b-container fluid>

      <MainHeader />
    <b-row>
      <router-view ></router-view>
    </b-row>
  </b-container>
</template>

<script>
  import MainHeader from './administrator/components/MainHeader';
  import Menu from './administrator/components/Menu';
  export default {
    components: {
      MainHeader,
      Menu
    }
  };
</script>

<style lang='scss' scoped >
  .main-menu {
    @media screen and (max-width: 576px) {
      display: none;
    }
  }
</style>
