<template>
  <div class="landing-container h-100 d-flex align-items-center">
    <b-container>
      <Logo />
      <b-row align-h="center">
        <b-col cols="12" md="4">
          <div class="card p-0">
            <h5 class="card-header text-center">ACCUEIL</h5>
            <div class="card-body">
              <p class="card-text text-muted small text-center">
                A quel section voulez-vous accéder ?
              </p>
              <ul class="list-group-flush list-group">
                <router-link
                  class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                  v-for="route in routes"
                  :key="route.name"
                  :to="{ name: route.name }"
                >
                  <span>{{ route.slug }}</span>
                  <i class="fa fa-chevron-right"></i>
                </router-link>
              </ul>
            </div>
          </div>
          <div class="userAccount" v-if="user">
            <p>
              <span>Connecté en tant que {{ user.name }}</span>
              <br />
              <span>{{ user.email }}</span>
              <br />
              <a href="#!" @click.prevent="userLogout">Se déconnecter</a>
            </p>
          </div>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import Logo from '../components/LogoComponent'
import { mapState, mapActions } from 'vuex'
import {
  ADMIN_DASHBOARD,
  AGENT_HOSPITAL,
  ADMIN_HOSPITAL,
  ADMINISTRATOR,
  MANANGER_EPIDEMIC,
  EDIT_FORM,
  CREATE_FORM
} from '../config/env'
export default {
  components: {
    Logo
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user
    }),
    routes () {
      if (!this.user) {
        return []
      }
      const routesAccess = []

      if (this.user.roles === undefined) return routesAccess

      if (this.user.roles.find((a) => a.name == ADMINISTRATOR)) {
        routesAccess.push({
          slug: 'Administration',
          name: 'administrator.home'
        })
      } else if (
        this.user.roles.find(
          (a) => a.name == MANANGER_EPIDEMIC && a.name != ADMINISTRATOR
        )
      ) {
        routesAccess.push({
          slug: 'Administration',
          name: 'administrator.epidemie'
        })
      }
      if (this.user.roles.find((a) => a.name == EDIT_FORM || a.name == CREATE_FORM && a.name != ADMINISTRATOR)) {
        routesAccess.push({
          slug: 'Administration',
          name: "administrator.forms.show",
        });
      }

      if (this.user.roles.find((a) => a.name == ADMIN_DASHBOARD)) {
        routesAccess.push({ slug: 'Dashboard', name: 'home' })
      }

      if (this.user.hospital && this.user.roles.find((a) => a.name == AGENT_HOSPITAL)) {
        routesAccess.push({
          slug: "Interface agent CTCO",
          name: "hospital.home",
        });
      }

      if (this.user.roles.find((a) => a.name == ADMIN_HOSPITAL)) {
        routesAccess.push({
          slug: "Admininistration CTCO",
          name: "hospital.admin",
        });
      }
      
      return routesAccess
    }
  },
  methods: {
    ...mapActions(['logout']),
    userLogout () {
      this.logout().then(() => {
        this.$router.push({
          name: 'login'
        })
      })
    }
  }
}
</script>

<style lang="scss" scoped>
.list-group-item-action {
  text-decoration: none;
  font-size: 14px;
}
.userAccount {
  font-size: 12px;
  color: aa;
  text-align: center;
  margin-top: 50px;
}
</style>
