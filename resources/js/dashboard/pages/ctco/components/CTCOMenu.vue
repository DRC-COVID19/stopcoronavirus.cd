<template>
  <b-nav vertical>
    <b-nav-item
      v-if="canViewAdmin"
      :to="{ name: 'hospital.admin' }"
      :active="
        $route.name.startsWith('hospital.admin') ||
        $route.name.startsWith('administrator.home')
      "
    >
      <i class="fas fa-list-alt" aria-hidden="true"></i> &nbsp; Résumé mise à
      jour
    </b-nav-item>
    <b-nav-item
      v-if="canViewAgent"
      :to="{ name: 'hospital.home' }"
      :active="$route.name.startsWith('hospital.home')"
    >
      <i class="fas fa-list" aria-hidden="true"></i> &nbsp; Situations
    </b-nav-item>
    <b-nav-item
      v-if="canViewAgent"
      :to="{ name: 'hospital.notification' }"
      :active="$route.name.startsWith('hospital.notification')"
      @click.prevent="setNotificationToRead"
    >
      <i class="fas fa-bell" aria-hidden="true"></i> &nbsp; Notifications
    </b-nav-item>
  </b-nav>
</template>

<script>
import { mapState, mapActions } from 'vuex'
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
      if (this.user.hospital) {
        return this.userHaveRole(AGENT_HOSPITAL)
      }
      return ''
    }
  },

  methods: {
    ...mapActions(['setNotification', 'notificationCreated']),
    async setNotificationToRead () {
      await this.setNotification({ id: this.user.hospital.id })
      this.notificationCreated()
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
    overflow-x: auto !important;
    white-space: nowrap;
    &::-webkit-scrollbar {
      width: 0; /* Remove scrollbar space */
      background: transparent; /* Optional: just make scrollbar invisible */
    }
  }
}
</style>
