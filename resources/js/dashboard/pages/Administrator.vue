<template>
  <div>
    <div class="main-menu">
      <MainHeader />
    </div>
    <div class="row">
      <!--<Menu />-->
      <router-view class="col-sm-12"></router-view>
    </div>
  </div>
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
