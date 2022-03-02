<template>
  <b-row class="dashboard-container no-gutters flex-lg-nowrap">
    <b-col cols="12" lg="auto">
      <DashboardMenu />
    </b-col>
    <b-col class="col-router-view">
      <router-view></router-view>
    </b-col>
  </b-row>
</template>

<script>
import DashboardMenu from './components/DashboardMenu'

export default {
  components: {
    DashboardMenu
  },
  mounted () {
    if (this.$route.name === 'main.dashboard') {
      this.$router.push({ name: 'main.dashboard.mobility' })
    }
  },
  watch: {
    '$route' (to, from) {
      console.log(to.name);
      if (to.name === 'main.dashboard') {
        this.$router.push({ name: 'main.dashboard.mobility' })
      }
    }
  }
}
</script>

<style lang="scss" scoped>
  .dashboard-container {
    @media (min-width: 1024px)  {
      height: calc(100vh - 87px);
      > div {
        height: 100%;
      }
      .col-router-view {
        width: calc(100% - 160px);
      }
    }
  }
</style>
