<template>
  <section
    id="EventRegistrationThank"
    class="d-flex mh-100 app_form justify-content-center align-items-center"
  >
    <b-container>
      <Logo />
      <b-row align-h="center">
        <b-col md="4">
          <h1 class="dash-login-title">Demande envoyée</h1>
          <p class="text-dash-color"> Un mail vous a été envoyé avec le lien de réinitialisation</p>
          <p>
            <b-link :to="{name:'login'}">Retournez à la connexion</b-link>
          </p>
        </b-col>
      </b-row>
    </b-container>
  </section>
</template>

<script>
import Logo from "../../components/LogoComponent";
export default {
  components: { Logo },
  data() {
    return {};
  },
  mounted() {
    console.log(window.location);
  },
  methods: {
    sendMail() {
      axios.post(`participant/`);
    }
  }
};
</script>

<style scoped lang="scss">
#EventRegistrationThank {
  min-height: 100vh;
  .img-fluid {
    height: 120px;
    width: 180px;
  }
  h1 {
    text-transform: none;
  }
}
</style>
