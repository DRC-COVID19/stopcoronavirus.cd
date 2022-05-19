<template>
  <b-nav vertical ref="menu">
    <b-nav-item
      v-if="canViewUsers"
      :to="{ name: 'administrator.users' }"
      :active="
        $route.name.startsWith('administrator.users') ||
        $route.name.startsWith('administrator.home')
      "
    >
      <i class="fas fa-users" aria-hidden="true"></i>
    </b-nav-item>
    <b-nav-item
      v-if="canViewChangeLog"
      :to="{ name: 'administrator.changeLog' }"
      :active="$route.name.startsWith('administrator.changeLog')"
    >
      <i class="fa fa-history" aria-hidden="true"></i>
    </b-nav-item>
    <b-nav-item
      v-if="canViewForms"
      :to="{ name: 'administrator.forms' }"
      :active="$route.name.startsWith('administrator.forms')"
    >
      <i class="fa fa-address-card" aria-hidden="true"></i>
    </b-nav-item>
    <b-nav-item
      v-if="canViewUsers"
      :to="{ name: 'administrator.hospitals' }"
      :active="
        $route.name.startsWith('administrator.hospitals') ||
        $route.name.startsWith('administrator.home')
      "
    >
      <i class="fas fa-hospital-alt" aria-hidden="true"></i>
    </b-nav-item>
    <b-nav-item
      v-if="canViewEpidemic"
      :to="{ name: 'administrator.epidemie' }"
      :active="$route.name.startsWith('administrator.epidemie')"
    >
      <i class="fas fa-virus" aria-hidden="true"></i>
    </b-nav-item>
  </b-nav>
</template>

<script>
import { mapState } from "vuex";
import {
  ADMINISTRATOR,
  CREATE_FORM,
  EDIT_FORM,
  MANANGER_EPIDEMIC,
} from "../../../config/env";

export default {
  data() {
    return {};
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
    }),
    canViewUsers() {
      return this.userHaveRole(ADMINISTRATOR);
    },
    canViewEpidemic() {
      return this.userHaveRole(MANANGER_EPIDEMIC);
    },
    canViewChangeLog() {
      return this.userHaveRole(ADMINISTRATOR);
    },
    canViewForms() {
      return this.userHaveRole(EDIT_FORM) || this.userHaveRole(CREATE_FORM);
    },
  },
  methods: {},
};
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";

.nav {
  height: 100%;
  padding: 0px 10px;
  .nav-link {
    display: inline-block;
    border-bottom: 2px solid $dash-background;
    text-decoration: none;
    font-size: 20px;
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
