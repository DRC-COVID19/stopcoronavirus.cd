<template>
  <div class="h-100 d-flex align-items-center">
    <b-container>
      <Logo />
      <b-row align-h="center">
        <b-col cols="12" md="4">
          <h1 class="dash-login-title">Connexion</h1>
          <p class="text-dash-color">Entrez vos paramètres de connexion pour continuer</p>
          <b-form @submit.prevent="submitLogin">
            <b-alert :show="authError" variant="danger">{{error_message}}</b-alert>
            <b-form-group>
              <label class="text-dash-color" for="email">ADRESSE E-MAIL</label>
              <b-input
                :disabled="isAuthenticating"
                v-model="form.email"
                class="input-dash"
                required
                type="text"
                name="email"
              />
            </b-form-group>
            <b-form-group>
              <div class="d-flex justify-content-between">
                <label class="text-dash-color" for="password">MOT DE PASSE</label>
                <b-link
                  :disabled="isAuthenticating"
                  class="dash-password-lost-link"
                  :to="{name:'lostPassword'}"
                >Mot de passe oublié ?</b-link>
              </div>
              <b-input
                v-model="form.password"
                :disabled="isAuthenticating"
                class="input-dash"
                type="password"
                required
                name="password"
                autocomplete="password"
              />
            </b-form-group>
            <b-button block type="submit" :disabled="isAuthenticating" class="btn-dash-blue mt-4">
              <SpinnerGrowing v-if="isAuthenticating" message="En cours ..." />
              <span v-else>Connexion</span>
            </b-button>
          </b-form>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
import { ADMIN_DASHBOARD, AGENT_HOSPITAL } from "../../config/env";
import Logo from "../../components/LogoComponent";
export default {
  components: {
    Logo
  },
  data() {
    return {
      form: {},
      error_message: null
    };
  },
  computed: {
    ...mapState({
      isAuthenticating: state => state.auth.isAuthenticating,
      authError: state => state.auth.authError,
      userRole: state => state.auth.userRole
    })
  },
  methods: {
    ...mapActions(["logUserIn"]),
    submitLogin() {
      this.logUserIn(this.form)
        .then(({ user }) => {
          let dashboardRole = user.roles.find(x => x.name == "admin-dashboard");
          let hospitalRole = user.roles.find(x => x.name == "agent-hospital");
          if (dashboardRole) {
            this.$router.push({
              name: "home"
            });
          } else if (hospitalRole) {
            this.$router
              .push({
                name: "hospital.home"
              })
              .catch(e => {
                console.log(e);
              });
          } else {
            this.$router.push({
              name: "acces.denied"
            });
          }
        })
        .catch(({ data }) => {
          this.error_message = data.error;
        });
    }
  }
};
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.dash-password-lost-link {
  text-decoration: none;
  color: $dash-text;
  &:hover {
    text-decoration: underline;
  }
}
</style>