<template>
  <b-container fluid class="administrator">
    <b-row class="administrator-container no-gutters flex-lg-nowrap">
      <b-col cols="12" lg="auto">
        <AdministratorMenu />
      </b-col>
      <b-col class="col-router-view">
        <notifications group="alert" />
        <router-view></router-view>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import AdministratorMenu from './components/AdministratorMenu'
export default {
  components: {
    AdministratorMenu
  },
  mounted() {
    if (this.$route.name === 'administrator') {
      this.$router.push({ name: 'administrator.users' })
    }
  },
  watch: {
    '$route' (to, from) {
      console.log(to)
      if (to.name === 'administrator') {
        this.$router.push({ name: 'administrator.users' })
      }
    }
  }
}
</script>

<style lang='scss' scoped >
  @import "@~/sass/_variables";

</style>
