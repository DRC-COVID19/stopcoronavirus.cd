<template>
  <div class="h-100 d-flex align-items-center">
    <b-container>
      <Logo />
      <b-row align-h="center">
        <b-col cols="12" md="4">
          <h1 class="dash-login-title">Connexion</h1>
          <p class="text-dash-color">Entrez vos paramètres de connexion pour continuer</p>
          <b-form @submit.prevent="submitLogin">
            <b-alert
              :show="authError"
              variant="danger"
            >Mot de passe incorrecte ou login ne correspondent à aucun utilisateur enregistré</b-alert>
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
                autocomplete
                required
                name="password"
              />
            </b-form-group>
            <b-button block type="submit" :disabled="isAuthenticating" class="btn-dash-blue mt-4">
              <span v-if="isAuthenticating">En cours</span>
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
import Logo from "../components/LogoComponent";
export default {
  components: {
    Logo
  },
  data() {
    return {
      form: {}
    };
  },
  computed: {
    ...mapState({
      isAuthenticating: state => state.auth.isAuthenticating,
      authError: state => state.auth.authError
    })
  },
  methods: {
    ...mapActions(["logUserIn"]),
    submitLogin() {
      this.logUserIn(this.form);
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