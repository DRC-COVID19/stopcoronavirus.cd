<template>
  <div id="notfound">
    <div class="notfound">
      <div class="notfound-404">
        <h1>Oops!</h1>
        <h2>403 - Vous ne disposez pas d'autorisation pour accéder à cette page</h2>
      </div>
      <b-button class="btn-dash-blue" @click="goHome">Retournez à l'accueil</b-button>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import { AGENT_HOSPITAL, ADMIN_DASHBOARD } from "../config/env";
export default {
  computed: {
    ...mapState({
      userRole: state => state.auth.userRole
    })
  },
  methods: {
    goHome() {
      switch (this.userRole) {
        case ADMIN_DASHBOARD:
          this.$router.push({
            name: "home"
          });
          break;
        case AGENT_HOSPITAL:
          this.$router.push({
            name: "hospital.home"
          });
          break;

        default:
          break;
      }
    }
  }
};
</script>

<style lang="scss" scoped>
#notfound {
  position: relative;
  height: 100vh;
}

#notfound .notfound {
  position: absolute;
  left: 50%;
  top: 50%;
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}

.notfound {
  max-width: 520px;
  width: 100%;
  line-height: 1.4;
  text-align: center;
}

.notfound .notfound-404 {
  position: relative;
  height: 200px;
  margin: 0px auto 20px;
  z-index: -1;
}

.notfound .notfound-404 h1 {
  font-family: "Montserrat", sans-serif;
  font-size: 236px;
  font-weight: 200;
  margin: 0px;
  color: #211b19;
  text-transform: uppercase;
  position: absolute;
  left: 50%;
  top: 50%;
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}

.notfound .notfound-404 h2 {
  font-family: "Montserrat", sans-serif;
  font-size: 28px;
  font-weight: 400;
  text-transform: uppercase;
  color: #211b19;
  background: #fff;
  padding: 10px 5px;
  margin: auto;
  display: inline-block;
  position: absolute;
  bottom: 0px;
  left: 0;
  right: 0;
}

@media only screen and (max-width: 767px) {
  .notfound .notfound-404 h1 {
    font-size: 148px;
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