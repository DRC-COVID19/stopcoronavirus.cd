<template>
  <b-nav vertical ref="menu">
    <b-nav-item
      v-if="canPredict"
      :to="{ name: 'prediction.existingData' }"
      :active="
        $route.name.startsWith('prediction.existingData') ||
        $route.name.startsWith('prediction.home')
      "
    >
      <i class="fas fa-users" aria-hidden="true"></i>
      <span v-if="showLabel">&nbsp; Prédiction sur les données existantes</span>
    </b-nav-item>
    <b-nav-item
      v-if="canPredict"
      :to="{ name: 'prediction.freeData' }"
      :active="$route.name.startsWith('prediction.freeData')"
    >
      <i class="fa fa-history" aria-hidden="true"></i>
      <span v-if="showLabel">&nbsp; Prédiction libre</span>
    </b-nav-item>
    <b-nav-item
      v-if="canPredict"
      :to="{ name: 'prediction.caseSimulation' }"
      :active="$route.name.startsWith('prediction.caseSimulation')"
    >
      <i class="fa fa-address-card" aria-hidden="true"></i>
      <span v-if="showLabel">&nbsp; Simulation des cas</span>
    </b-nav-item>
  </b-nav>
</template>

<script>
import { mapState } from 'vuex'
import {
  ADMINISTRATOR,
  CREATE_FORM,
  EDIT_FORM,
  MANANGER_EPIDEMIC,
  ADMIN_DASHBOARD,
} from '../../../config/env'

export default {
  props: {
    showLabel: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {}
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
    }),
    canPredict() {
      return this.userHaveRole(ADMIN_DASHBOARD)
    },
  },
  methods: {},
}
</script>

<style lang="scss" scoped>
@import '@~/sass/_variables';

.nav {
  border-right: 8px solid $dash-background;
  height: 100%;
  padding-left: 5px;
  li {
    width: 100%;
  }
  .nav-link {
    border-bottom: 2px solid $dash-background;
    text-decoration: none;
    font-size: 14px;
    color: black;
    height: 39px;
    text-align: center;
    @media (min-width: 992px) {
      text-align: left;
    }
    &:hover {
      background-color: $dash-background;
    }
    &.active {
      background-color: $dash-blue;
      color: white;
    }
  }
  @media (min-width: 992px) {
    text-align: left;
    flex-direction: column;
  }
}
@media (max-width: $max-width) {
  .nav {
    z-index: 5;
    height: auto;
    width: 100%;
    border-right: 0;
    overflow-x: scroll !important;
    white-space: nowrap;
    flex-direction: row !important;
    flex-wrap: nowrap;
    &::-webkit-scrollbar {
      width: 0; /* Remove scrollbar space */
      background: transparent; /* Optional: just make scrollbar invisible */
    }
  }
}
</style>
