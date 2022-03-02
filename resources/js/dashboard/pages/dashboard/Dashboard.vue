<template>
  <b-row class="dashboard-container no-gutters">
    <b-col cols="auto">
      <DashboardMenu />
    </b-col>
    <b-col>
      <router-view></router-view>
    </b-col>
  </b-row>
</template>

<script>
import DashboardMenu from './components/DashboardMenu'

export default {
  components: {
    DashboardMenu
  }
}
</script>

<style lang="scss" scoped>
  .dashboard-container {
    height: calc(100vh - 108px);
  }
</style>
