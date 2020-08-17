<template>
  <section id="login" class="d-flex justify-content-center align-items-center ">
    <b-container>
      <Logo />
      <b-row align-h="center">
        <b-col md="4" cols="12">
          <div>
            <form class="mt-2" @submit.prevent="submitReset">
              <h1 class="dash-login-title">Réinitialisez votre mot de passe</h1>
              <b-alert :show="hasError" variant="danger">Votre adresse e-mail est introuvable</b-alert>
              <p class="text-dash-color">Saisissez votre adresse e-mail et nous vous enverrons un lien de réinitialisation de mot de passe.</p>
              <b-form-group>
                <label for="inputEmail" class="sr-only">E-mail</label>
                <b-input
                  id="inputEmail"
                  v-model="email"
                  :disabled="is_submitting"
                  type="email"
                  placeholder="Adresse E-mail"
                  required
                  autofocus
                  class="input-dash"
                />
              </b-form-group>
              <b-form-group>
                <b-button :disabled="is_submitting" class="btn-dash-blue" type="submit" block>
                  <SpinnerGrowing v-if="is_submitting" message="En cours ..." />
                  <span v-else>Envoyez</span>
                </b-button>
              </b-form-group>
            </form>
          </div>
        </b-col>
      </b-row>
    </b-container>
  </section>
</template>

<script>
import { mapState, mapActions, mapGetters } from "vuex";
import Logo from "../../components/LogoComponent";
export default {
  name: "LostPassword",
  components: { Logo },
  data() {
    return {
      email: "",
      hasError: false,
      is_submitting: false
    };
  },
  computed: {},
  methods: {
    submitReset() {
      this.hasError = false;
      this.is_submitting = true;
      axios
        .post(`/api/dashboard/auth/lost-password`, { email: this.email })
        .then(({ data }) => {
          this.$router.push({
            name: "password.reset.thanks"
          });
        })
        .catch(response => {
          this.hasError = true;
        })
        .finally(() => {
          this.is_submitting = false;
        });
    }
  }
};
</script>


<style scoped lang="scss" >
#login {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
