<template>
  <b-nav vertical>
    <b-nav-item
      :to="{ name: 'main.dashboard.mobility' }"
      :active="activeMenu === 1"
      @click="selectMenu(1)"
    >
      <i class="fas fa-walking" aria-hidden="true"></i> &nbsp; Mobilité
    </b-nav-item>
    <b-nav-item
      :active="activeMenu === 5"
      :to="{ name: 'main.dashboard.infrastructure' }"
      @click="selectMenu(5)"
    >
      <i class="fas fa-hospital" aria-hidden="true"></i> &nbsp; Infrastructure
    </b-nav-item>
    <b-nav-item
      @click="selectMenu(9)"
      :to="{ name: 'main.dashboard.graphique' }"
      :active="activeMenu === 9"
    >
      <i class="fas fa-chart-line" aria-hidden="true"></i> &nbsp; Graphique
    </b-nav-item>
    <b-nav-item
      :active="activeMenu === 7"
      :to="{ name: 'main.dashboard.aPropos' }"
      @click="selectMenu(7)"
    >
      <i class="fas fa-info-circle" aria-hidden="true"></i> &nbsp; A propos
    </b-nav-item>
  </b-nav>
</template>

<script>
import { mapState, mapMutations } from 'vuex'

export default {
  computed: {
    ...mapState({
      activeMenu: (state) => state.nav.activeMenu
    })
  },
  mounted () {
    this.fillParametersFromUrlParams()
  },
  methods: {
    ...mapMutations(['setActiveMenu']),
    selectMenu (value) {
      if (this.activeMenu !== null) {
        this.removeAllParamsFromUrl()
      }
      this.setActiveMenu(value)
    },
    fillParametersFromUrlParams () {
      if (this.$route.name === 'main.dashboard.infrastructure') {
        this.selectMenu(5)
      } else if (this.$route.name === 'main.dashboard.aPropos') {
        this.selectMenu(7)
      } else if (this.$route.name === 'main.dashboard.graphique') {
        this.selectMenu(9)
      } else {
        this.selectMenu(1)
      }
    }
  }
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.nav {
  border-right: 8px solid $dash-background;
  height: 100%;
  padding-left: 5px;
  .nav-link {
    border-bottom: 2px solid $dash-background;
    text-decoration: none;
    font-size: 14px;
    color: black;
    &:hover {
      background-color: $dash-background;
    }
    &.active {
      background-color: $dash-blue;
      color: white;
    }
  }
}
@media (max-width: $max-width) {
  .nav {
    z-index: 5;
    height: 10vh;
    width: 100%;
    border-right: 0;
    overflow-x: scroll !important;
    white-space: nowrap;
    &::-webkit-scrollbar {
      width: 0; /* Remove scrollbar space */
      background: transparent; /* Optional: just make scrollbar invisible */
    }
  }
}
</style>
