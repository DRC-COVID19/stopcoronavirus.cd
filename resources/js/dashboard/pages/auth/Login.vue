<template>
  <div class="h-100 d-flex align-items-center">
    <b-container class="login">
      <div class="text-center">
        <Logo />
      </div>
      <b-row align-h="center">
        <b-col cols="12" md="4" class="bg-dash p-4">
          <h1 class="dash-login-title text-center">Connexion</h1>
          <p class="text-dash-color text-center">
            Entrez vos paramètres de connexion pour continuer
          </p>
          <b-form @submit.prevent="submitLogin">
            <b-alert :show="authError" variant="danger">{{
              error_message
            }}</b-alert>
            <b-form-group>
              <label class="text-dash-color" for="email"
                >E-MAIL, UTILISATEUR OU TELEPHONE</label
              >
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
                <label class="text-dash-color" for="password"
                  >MOT DE PASSE</label
                >
                <b-link
                  :disabled="isAuthenticating"
                  class="dash-password-lost-link"
                  :to="{ name: 'lostPassword' }"
                  >Mot de passe oublié ?</b-link
                >
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
            <b-button
              block
              type="submit"
              :disabled="isAuthenticating"
              class="btn-dash-blue mt-4"
            >
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
import {
  ADMIN_DASHBOARD,
  AGENT_HOSPITAL,
  ADMIN_HOSPITAL,
  MANANGER_EPIDEMIC,
} from "../../config/env";
import Logo from "../../components/LogoComponent";
export default {
  components: {
    Logo,
  },
  data() {
    return {
      form: {},
      error_message: null,
    };
  },
  computed: {
    ...mapState({
      isAuthenticating: (state) => state.auth.isAuthenticating,
      authError: (state) => state.auth.authError,
      userRole: (state) => state.auth.userRole,
    }),
  },
  methods: {
    ...mapActions(["logUserIn"]),
    submitLogin() {
      this.logUserIn(this.form)
        .then(({ user }) => {
          let dashboardRole = user.roles.find(
            (x) => x.name == "admin-dashboard"
          );
          let hospitalRole = user.roles.find((x) => x.name == "agent-hospital");
          let adminHospitalRole = user.roles.find(
            (x) => x.name == "admin-hospital"
          );
          // this.$gtag.set({userId: user.email});
          if (
            dashboardRole ||
            hospitalRole ||
            adminHospitalRole ||
            MANANGER_EPIDEMIC
          ) {
            this.$router
              .push({
                name: "main",
              })
              .catch((e) => {
                console.log(e);
              });
          } else {
            this.$router.push({
              name: "acces.denied",
            });
          }
        })
        .catch(({ data }) => {
          this.error_message = data.error;
        });
    },
  },
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
.login{
  padding: 0 2rem;
}
.bg-dash {
  /* box-shadow: -5px 5px 205px -1px rgba(0, 0, 0, 0.1); */
box-shadow: 0px 4px 20px -3px rgba(0,0,0,0.1);
  border: 0 !important;
  margin: 2rem 0;
  border-radius: .8rem;
}
@media screen and($small){
    h2{
      font-size: 1.6rem;
      margin-top: 1rem;
    }
    .login{
       padding: 0;
  }
  }
</style>
