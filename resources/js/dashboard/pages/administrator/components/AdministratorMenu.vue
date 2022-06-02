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
      <i class="fas fa-users" aria-hidden="true"></i> &nbsp;
      <span v-if="showLabel">Utilisateurs</span>
    </b-nav-item>
    <b-nav-item
      v-if="canViewChangeLog"
      :to="{ name: 'administrator.changeLog' }"
      :active="$route.name.startsWith('administrator.changeLog')"
    >
      <i class="fa fa-history" aria-hidden="true"></i>
      <span v-if="showLabel">&nbsp; Change log</span>
    </b-nav-item>
    <b-nav-item
      v-if="canViewForms"
      :to="{ name: 'administrator.forms' }"
      :active="$route.name.startsWith('administrator.forms')"
    >
      <i class="fa fa-address-card" aria-hidden="true"></i>
      <span v-if="showLabel">&nbsp; Formulaires</span>
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
      <span v-if="showLabel">&nbsp; Hopitaux</span>
    </b-nav-item>
    <b-nav-item
      v-if="canViewEpidemic"
      :to="{ name: 'administrator.epidemie' }"
      :active="$route.name.startsWith('administrator.epidemie')"
    >
      <i class="fas fa-virus" aria-hidden="true"></i>
      <span v-if="showLabel">&nbsp; Situation Épidémiologique</span>
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
  props: {
    showLabel: {
      type: Boolean,
      default: true,
    },
  },
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
