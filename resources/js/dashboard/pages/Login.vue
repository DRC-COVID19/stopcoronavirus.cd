<template>
  <div class="h-100 d-flex align-items-center">
    <b-container>
      <b-row align-h="center" class="mb-5">
        <b-col cols="6" md="2" class="map-form-logo d-flex justify-content-end">
          <img src="/img/partners_top.png" class="img-fluid" alt />
        </b-col>
        <b-col cols="6" md="2" class="map-form-logo d-flex justify-content-end">
          <img src="/img/commite_riposte.jpg" class="img-fluid" alt />
        </b-col>
      </b-row>
      <b-row align-h="center">
        <b-col cols="12" md="4">
          <h2>Connexion</h2>
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
                <b-link :disabled="isAuthenticating" class="dash-password-lost-link" href="#">Mot de passe oublié ?</b-link>
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
export default {
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