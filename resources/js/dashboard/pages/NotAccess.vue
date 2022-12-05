<template>
  <b-container class="px-0 py-0 justify-content-center">
    <b-row lg="12">
      <b-col lg="6" class="illustration px-0 py-0">
        <img
          src="/img/401 Error Unauthorized-pana.png"
          alt
          class="w-100 h-100"
        />
      </b-col>
      <b-col lg="8" class="text-center">
        <div class="title">
          <h1>Oops!</h1>
          <h2>Vous ne disposez pas d'autorisation pour accéder à cette page</h2>
        </div>
      </b-col>
      <b-col lg="6" class="text-center">
        <b-button class="btn-dash-blue" @click="goHome"
          >Retournez à l'accueil</b-button
        >
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
export default {
  methods: {
    goHome() {
      this.$router.push({
        name: 'main',
      });
    },
  },
};
</script>

<style lang="scss" scoped>
.container {
  height: 100vh;
}

.title h2 {
  font-size: 2rem !important;
  font-weight: 200 !important;
  text-transform: uppercase;
}
.title h1 {
  font-size: 2rem !important;
  font-weight: 200 !important;
  text-transform: uppercase;
}

@media only screen and (max-width: 956px) {
  .title h2 {
    font-size: 1.3rem !important;
    font-weight: 200 !important;
    text-transform: uppercase;
  }
  .title h1 {
    font-size: 1.3rem !important;
    font-weight: 200 !important;
    text-transform: uppercase;
  }
}

@media only screen and (max-width: 480px) {
  .notfound .notfound-404 {
    height: 148px;
    margin: 0px auto 10px;
  }
  .notfound .notfound-404 h1 {
    font-size: 86px;
  }
  .notfound .notfound-404 h2 {
    font-size: 16px;
  }
  .notfound a {
    padding: 7px 15px;
    font-size: 14px;
  }
}
</style>
