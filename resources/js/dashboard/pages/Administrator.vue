<template>
  <div>
    <div class="main-menu">
      <Header />
    </div>
    <div class="row">
      <Menu />
      <router-view class="col-sm-10"></router-view>
    </div>
  </div>
</template>

<script>
  import Header from './../components/Header';
  import Menu from './administrator/components/Menu';
  export default {
    components: {
      Header,
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
