<template>
  <b-row class="header">
    <b-col cols="12" class="map-form-header">
      <b-navbar toggleable="lg" type="light">
        <b-navbar-brand class="mr-5">
          <h1 class="title m-0">Dashboard Covid-19</h1>
        </b-navbar-brand>
        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
        <b-collapse id="nav-collapse" is-nav>
          <b-navbar-nav class="nav-container">
            <b-nav-item :class="{'active':activeMenu==1}" @click="selectMenu(1)">Mobilité</b-nav-item>
            <b-nav-item :class="{'active':activeMenu==2}" @click="selectMenu(2)">Epidémiologie </b-nav-item>
            <b-nav-item :class="{'active':activeMenu==3}" @click="selectMenu(3)">Indicateurs</b-nav-item>
            <!-- <b-nav-item :class="{'active':activeMenu==4}" @click="selectMenu(4)">Sondages</b-nav-item> -->
            <b-nav-item :class="{'active':activeMenu==5}" @click="selectMenu(5)">Infrastructures</b-nav-item>
            <b-nav-item :class="{'active':activeMenu==6}" @click="selectMenu(6)">Orientation</b-nav-item>
          </b-navbar-nav>
          <b-navbar-nav class="ml-auto">
            <b-nav-item>
              <div class="map-form-logo d-flex justify-content-center justify-content-md-end align-items-center">
                <img src="/img/partners_top.png" height="30" width="100" class="img-fluid" alt />
                <img src="/img/commite_riposte.jpg" height="30" width="100" class="img-fluid" alt />
                <img src="/img/Orange_logo.svg" height="30" width="100" class="img-fluid" alt />
                <div
                  @mouseleave="userAvatarMouseLeave"
                  @mouseenter="userAvatarMouseEnter"
                  class="avatar-container ml-3"
                  v-if="user"
                >
                  <b-img
                    :src="user.avatar"
                    rounded="circle"
                    fluid
                    width="30"
                    v-b-tooltip.hover
                    :title="user.username"
                  />
                  <b-card class="user-card text-center" v-if="showUserCard">
                    <p>
                      <span class="d-block">{{user.username}}</span>
                      <span class="d-block">{{user.name}}</span>
                      <span class="d-block" v-if="user.email">{{user.email}}</span>

                      <router-link class="small" :to="{name : 'landing'}">Revenir à l'accueil</router-link>
                    </p>
                    <b-button @click="userLogout" variant="danger" block>Deconnexion</b-button>
                  </b-card>
                </div>
              </div>
            </b-nav-item>
          </b-navbar-nav>
        </b-collapse>
      </b-navbar>
    </b-col>
  </b-row>
</template>

<script>
import { mapState, mapActions, mapMutations } from "vuex";
export default {
  data() {
    return {
      showUserCard: false
    };
  },
  computed: {
    ...mapState({
      user: state => state.auth.user,
      activeMenu: state => state.nav.activeMenu
    })
  },
  methods: {
    ...mapActions(["logout"]),
    ...mapMutations(["setActiveMenu"]),
    userAvatarMouseEnter() {
      this.showUserCard = true;
    },
    userAvatarMouseLeave() {
      this.showUserCard = false;
    },
    userLogout() {
      this.logout().then(() => {
        this.$router.push({
          name: "login"
        });
      });
    },
    selectMenu(value) {
      this.setActiveMenu(value);
    }
  }
};
</script>


<style lang="scss" scoped>
@import "@~/sass/_variables";
.header {
  background: white;
  border-bottom: 1px solid $dash-shadow-color;

  .title {
    font-size: 20px;
    font-weight: 600;
    line-height: 24px;
  }
  .nav-container {
    a {
      color: black;
      text-decoration: none;
      font-weight: bold;
      &:hover {
        color: $dash-blue;
      }
    }
    .active {
      a {
        color: $dash-blue;
      }
    }
  }
  .avatar-container {
    position: relative;

    img {
      cursor: pointer;
      height: 30px;
    }
    .user-card {
      position: absolute;
      right: 0;
      top: 110%;
      z-index: 99;
    }
  }
  .img-fluid{
    width: auto;
    max-width: none;
    height: 30px;
  }

  @media screen and (min-width:992px) and (max-width:1200px){
    .img-fluid{
      height: 20px;
    }
    .title{
      font-size: 18px;
    }
  }
}
</style>
