<template>
  <b-nav vertical>
    <b-nav-item
      v-if="canViewAdmin"
      :to="{name: 'hospital.admin'}"
      :active="$route.name.startsWith('hospital.admin') || $route.name.startsWith('administrator.home')"
    >
      <i class="fas fa-list-alt" aria-hidden="true" ></i> &nbsp; Résumé mise à jour
    </b-nav-item>
    <b-nav-item
      v-if="canViewAgent"
      :to="{name: 'hospital.home'}"
      :active="$route.name.startsWith('hospital.home')"
    >
      <i class="fas fa-list" aria-hidden="true" ></i> &nbsp; Situations
    </b-nav-item>
  </b-nav>
</template>

<script>
import { mapState } from 'vuex'
import { ADMIN_HOSPITAL, AGENT_HOSPITAL } from '../../../config/env'
export default {
  computed: {
    ...mapState({
      user: (state) => state.auth.user
    }),
    canViewAdmin () {
      return this.userHaveRole(ADMIN_HOSPITAL)
    },
    canViewAgent () {
      return this.userHaveRole(AGENT_HOSPITAL)
    }
  }
}
</script>

<style lang="scss" scoped>
  @import "@~/sass/_variables";
  .nav {
    border-right: 8px solid $dash-background;
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
  @media (min-width: 1024px) {
    .nav {
      height: 100%;
    }
  }
</style>
