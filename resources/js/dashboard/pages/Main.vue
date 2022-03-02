<template>
  <div>
    <div class="main-header">
      <MainHeader />
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
import MainHeader from '../components/MainHeader'

export default {
  components: {
    MainHeader
  },
  watch: {
    '$route' (to, from) {
      if (to.name === 'main') {
        this.$router.push({ name: 'main.dashboard.mobility' })
      }
    }
  }
}
</script>

<style lang="scss">
  @import "@~/sass/_variables";
  .main-header{
    border-bottom: 8px solid $dash-background;
  }
  body {
    overflow-x: hidden;
  }
</style>
