<template>
  <b-nav vertical>
    <b-nav-item
      v-if="canViewUsers"
      :to="{name: 'administrator.users'}"
      :active="$route.name.startsWith('administrator.users') || $route.name.startsWith('administrator.home')"
    >
      <i class="fas fa-users" aria-hidden="true" ></i> &nbsp; Utilisateurs
    </b-nav-item>
    <b-nav-item
      v-if="canViewEpidemic"
      :to="{name: 'administrator.epidemie'}"
      :active="$route.name.startsWith('administrator.epidemie')"
    >
      <i class="fas fa-virus" aria-hidden="true" ></i> &nbsp; Situation Épidémiologique
    </b-nav-item>
    <b-nav-item
      v-if="canViewChangeLog"
      :to="{name: 'administrator.changeLog'}"
      :active="$route.name.startsWith('administrator.changeLog')"
    >
      <i class="fas fa-info-circle" aria-hidden="true" ></i> &nbsp; Change log
    </b-nav-item>
    <b-nav-item
      v-if="canViewForms"
      :to="{name: 'administrator.forms'}"
      :active="$route.name.startsWith('administrator.forms')"
    >
      <i class="fas fa-list" aria-hidden="true" ></i> &nbsp; Formulaires
    </b-nav-item>
  </b-nav>
</template>

<script>
import { mapState } from 'vuex'
import { ADMINISTRATOR, CREATE_FORM, EDIT_FORM, MANANGER_EPIDEMIC } from '../../../config/env'

export default {
  computed: {
    ...mapState({
      user: (state) => state.auth.user
    }),
    canViewUsers () {
      return this.userHaveRole(ADMINISTRATOR)
    },
    canViewEpidemic () {
      return this.userHaveRole(MANANGER_EPIDEMIC)
    },
    canViewChangeLog () {
      return this.userHaveRole(ADMINISTRATOR)
    },
    canViewForms () {
      return this.userHaveRole(EDIT_FORM) || this.userHaveRole(CREATE_FORM)
    }
  }
}
</script>

<style lang="scss" scoped>
  @import "@~/sass/_variables";
  .nav {
    border-right: 8px solid $dash-background;
    border-top: 9px solid $dash-background;
    .nav-link {
      border-bottom: 2px solid $dash-background;
      text-decoration: none;
      font-size: 14px;
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
