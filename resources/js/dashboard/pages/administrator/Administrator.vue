<template>
  <b-row
    class="administrator-container d-block d-lg-flex no-gutters flex-lg-nowrap justify-content-between"
  >
    <b-col cols="12" lg="auto">
      <AdministratorMenu />
    </b-col>
    <b-col class="col-router-view administrator-container-body">
      <notifications group="alert" />
      <router-view></router-view>
    </b-col>
  </b-row>
</template>

<script>
import { mapState } from 'vuex'
import {
  ADMINISTRATOR,
  CREATE_FORM,
  EDIT_FORM,
  MANANGER_EPIDEMIC,
} from '../../config/env'
import AdministratorMenu from './components/AdministratorMenu'

export default {
  components: {
    AdministratorMenu,
  },
  mounted() {
    this.redirect(this.$route)
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
    }),
  },
  watch: {
    $route(to, from) {
      this.redirect(to)
    },
    user() {
      this.redirect(this.$route)
    },
  },
  methods: {
    redirect(route) {
      if (route.name !== 'administrator') {
        return null
      }
      if (!this.user || this.user.roles === undefined) {
        return null
      }

      if (this.user.roles.find((a) => a.name == ADMINISTRATOR)) {
        this.$router.push({
          name: 'administrator.users',
        })
      } else if (this.user.roles.find((a) => a.name == MANANGER_EPIDEMIC)) {
        this.$router.push({
          name: 'administrator.epidemie',
        })
      } else if (
        this.user.roles.find(
          (a) => a.name == EDIT_FORM || a.name == CREATE_FORM
        )
      ) {
        this.$router.push({
          name: 'administrator.forms',
        })
      }
    },
  },
}
</script>

<style lang="scss" scoped>
@import '@~/sass/_variables';
@import '@~/sass/_variables';

.administrator-container {
  &-body {
    overflow-y: scroll;
  }
  @media (min-width: 1024px) {
    height: calc(100vh - 87px);
    > div {
      height: 100%;
    }
  }
}
</style>
