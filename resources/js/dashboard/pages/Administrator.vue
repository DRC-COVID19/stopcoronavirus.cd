<template>
  <div>
    <div>
      <Header />
    </div>
    <div class="row">
      <Menu />
      <router-view class="col-10"></router-view>
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

<style>
  
</style>
