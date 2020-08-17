<template>
  <b-container>
    <b-row class="header">
      <b-col cols="12" md="6" class="map-form-header">
        <h1>Projet control room Covid-19</h1>
      </b-col>
      <b-col
        cols="12"
        md="6"
        class="map-form-logo d-flex justify-content-center justify-content-md-end"
      >
        <img src="/img/partners_top.png" width="100" class="img-fluid" alt />
        <img src="/img/commite_riposte.jpg" width="100" class="img-fluid" alt />
        <div
          @mouseleave="userAvatarMouseLeave"
          @mouseenter="userAvatarMouseEnter"
          class="avatar-container"
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
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import { mapState, mapActions } from "vuex";
export default {
  data() {
    return {
      showUserCard: false
    };
  },
  computed: {
    ...mapState({
      user: state => state.auth.user
    })
  },
  methods: {
    ...mapActions(["logout"]),
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
    }
  }
};
</script>


<style lang="scss" scoped>
@import "@~/sass/_variables";
.header {
  padding: 12px 24px;
  background: white;
  border-bottom: 1px solid $dash-shadow-color;

  h1 {
    font-size: 20px;
    font-weight: 600;
    line-height: 24px;
  }
  .avatar-container {
    position: relative;
    img {
      cursor: pointer;
    }
    .user-card {
      position: absolute;
      right: 0;
      top: 110%;
      z-index: 99;
    }
  }
}
</style>
