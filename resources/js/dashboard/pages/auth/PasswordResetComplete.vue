<template>
  <section
    id="EventRegistrationThank"
    class="d-flex mh-100 app_form justify-content-center align-items-center"
  >
    <b-container>
      <Logo />
      <b-row align-h="center">
        <b-col md="4">
          <h1 class="dash-login-title">Mot de passe changé avec succes</h1>
          <p>
            <b-link :to="{ name: 'login' }">Retournez à la connexion</b-link>
          </p>
        </b-col>
      </b-row>
    </b-container>
  </section>
</template>
<script>
import Logo from '../../components/LogoComponent';
export default {
  name: 'EventRegistrationThank',
  components: { Logo },
  data() {
    return {};
  },
  mounted() {},
  methods: {},
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
