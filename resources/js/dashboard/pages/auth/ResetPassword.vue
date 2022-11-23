<template>
  <section
    id="login"
    class="d-flex app_form justify-content-center align-items-center"
  >
    <b-container>
      <b-row v-if="is_seeking" align-h="center">
        <Loading message />
      </b-row>
      <div v-else>
        <Logo />

        <b-row align-h="center" v-if="expired_link">
          <b-col cols="12" md="4">
            <h1 class="dash-login-title">Réinitialisez votre mot de passe</h1>
            <p class="text-dash-color">
              Votre lien de réinitialisation n'est plus valide.
            </p>
            <p class="text-dash-color">
              <b-link :to="{ name: 'login' }">Retournez à la connexion</b-link>
            </p>
          </b-col>
        </b-row>
        <b-row align-h="center" v-else>
          <b-col md="4" cols="12">
            <h1 class="dash-login-title">Réinitialisez votre mot de passe</h1>
            <div id="login_form">
              <form class="mt-2" @submit.prevent="submitReset">
                <b-form-group>
                  <label for="password">Nouveau mot de passe</label>
                  <b-input
                    v-model="user.password"
                    type="password"
                    class="input-dash"
                    placeholder="Entrer votre nouveau mot de passe"
                    required
                    autofocus
                    autocomplete="password"
                  />
                </b-form-group>

                <b-form-group>
                  <label for="password_confirmation"
                    >Confirmation mot de passe</label
                  >
                  <b-input
                    v-model="user.password_confirmation"
                    type="password"
                    class="input-dash"
                    placeholder="Entrer à nouveau votre mot de passe"
                    required
                    autocomplete="password_confirmation"
                  />
                </b-form-group>

                <b-form-group>
                  <b-button class="btn-dash-blue" type="submit" :block="true">{{
                    is_submitting ? 'En cours ...' : 'Envoyer'
                  }}</b-button>
                </b-form-group>
                <b-alert :show="submit_error" variant="danger"
                  >Your adresse e-mail</b-alert
                >
              </form>
            </div>
          </b-col>
        </b-row>
      </div>
    </b-container>
  </section>
</template>

<script>
import Logo from '../../components/LogoComponent';
import { mapState, mapActions, mapGetters } from 'vuex';
export default {
  components: { Logo },
  data() {
    return {
      user: {},
      is_seeking: false,
      is_submitting: false,
      submit_error: false,
      expired_link: false,
      token: null,
    };
  },
  mounted() {
    this.SeedRequest();
  },
  methods: {
    submitReset() {
      this.submit_error = false;
      this.is_submitting = true;
      axios
        .post(`/api/dashboard/auth/reset-password/${this.user.id}`, this.user, {
          headers: {
            authorization: `Bearer ${this.token}`,
          },
        })
        .then(({ data }) => {
          this.$router.push({
            name: 'password.reset.complete.thanks',
          });
        })
        .catch((response) => {
          this.hasError = true;
        })
        .finally(() => {
          this.is_submitting = false;
        });
    },
    SeedRequest() {
      this.is_seeking = true;
      this.expired_link = false;
      axios
        .get(`/api/dashboard/auth/check-token/${this.$route.params.token}`)
        .then(({ data }) => {
          this.is_seeking = false;
          this.user.id = data.user_id;
          this.token = data.token;
        })
        .catch((response) => {
          this.expired_link = true;
          this.is_seeking = false;
        });
    },
  },
};
</script>

<style scoped lang="scss">
#login {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
