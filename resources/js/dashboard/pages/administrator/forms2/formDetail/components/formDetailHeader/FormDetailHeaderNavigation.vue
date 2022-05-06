<template>
  <b-row class="header">
    <b-col cols="12" class="">
      <b-navbar toggleable="lg" type="light">
        <b-navbar-brand class="mr-5">
          <b-form-input
            v-model="titleForm"
            class="title input-header"
            placeholder="Entrer le titre du formulaire"
            :value="titleForm"
            :state="stateTitleForm"
          ></b-form-input>
        </b-navbar-brand>
        <b-navbar-toggle target="nav-collapse" class="default-border">
          <span class="fa fa-bars"></span>
        </b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
          <b-navbar-nav
            class="d-flex nav-container justify-content-around w-100"
            style="margin-left: 30%"
            align="center"
          >
            <b-nav-item>
              Etat du formulaire :<span class="text-danger"> nom publié</span>
            </b-nav-item>
            <b-nav-item class="btn-dash-blue d-block px-3"
              ><span class="text-white">Publier</span>
            </b-nav-item>
            <b-nav-item> Prévisualisation </b-nav-item>
          </b-navbar-nav>
          <b-navbar-nav>
            <b-nav-item class="d-flex align-content-center">
              <div
                class="
                  map-form-logo
                  d-flex
                  justify-content-center justify-content-md-end
                  align-items-center
                "
              >
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
                      <span class="d-block">{{ user.username }}</span>
                      <span class="d-block">{{ user.name }}</span>
                      <span class="d-block" v-if="user.email">{{
                        user.email
                      }}</span>
                    </p>
                    <p>Revenir à l'accueil</p>
                    <b-button @click="userLogout" variant="danger" block>
                      Deconnexion
                    </b-button>
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
import { mapState, mapActions, mapMutations, mapGetters } from "vuex";
import {
  ADMINISTRATOR,
  CREATE_FORM,
  EDIT_FORM,
} from "../../../../../../config/env";

export default {
  components: {},
  data() {
    return {
      showUserCard: false,
      showHeaderNotification: false,
      titleForm: "Titre du Formulaire",
    };
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
      activeMenu: (state) => state.nav.activeMenu,
      changeLogs: (state) => state.app.changeLogs,
    }),
    ...mapGetters(["getChangeLogNotRead"]),
    stateTitleForm() {
      return this.titleForm.length === 0 ? false : null;
    },
    canViewForm() {
      return (
        this.userHaveRole(ADMINISTRATOR) ||
        this.userHaveRole(EDIT_FORM) ||
        this.userHaveRole(CREATE_FORM)
      );
    },
  },
  mounted() {},
  methods: {
    ...mapActions(["logout", "setChangeLogsRead"]),
    ...mapMutations(["setActiveMenu", "setSelectedChangeLog"]),
    userAvatarMouseEnter() {
      this.showUserCard = true;
    },
    userAvatarMouseLeave() {
      this.showUserCard = false;
    },
    userLogout() {
      this.logout().then(() => {
        this.$router.push({
          name: "login",
        });
      });
    },
    selectNotification(item) {
      this.setSelectedChangeLog(item);
      this.setActiveMenu(7);
    },
    toggleHeaderNotification() {
      this.showHeaderNotification = !this.showHeaderNotification;
    },
    clickOutsideNotification() {
      if (this.showHeaderNotification) {
        this.showHeaderNotification = false;
        this.setChangeLogsRead();
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.input-header {
  border: none !important;
  outline: 0 none;
}
.from-control {
  border: none !important;
}
.header {
  a {
    text-decoration: none;
  }
  background: white;

  .icon-hallo {
    width: 30px;
    height: 30px;
    background: $dash-background;
    border-radius: 50px;
  }

  .dropdown-nav {
    position: absolute;
    top: 55px;
    min-width: 300px;
    padding: 0;
    border-radius: 4px;
    box-shadow: 0px 0px 10px 0px rgb(33 30 30 / 15%);
    animation: dropdownanimate 200ms ease-in;
    z-index: 20;
    background-color: #fff;
    :after {
      content: "";
      height: 0;
      width: 0;
      border-bottom: 10px solid $dash-blue;
      border-left: 8px solid transparent;
      border-right: 8px solid transparent;
      position: absolute;
      top: -8px;
      left: 14px;
    }
    .item-header {
      text-align: center;
      background-color: $dash-blue;
      padding: 20px 25px;
      border-radius: 4px 4px 0 0;
      position: relative;
      .item-title {
        margin-bottom: 0;
        color: #fff;
      }
    }
    .item-content {
      .media {
        border-bottom: 1px solid #eaeaea;
        padding-bottom: 14px;
        padding: 20px 25px;
        cursor: pointer;
        &:hover {
          background: $waiting_background;
        }
        .item-icon {
          height: 30px;
          width: 30px;
          border-radius: 50%;
          line-height: 31px;
          text-align: center;
        }
        .media-body.space-sm {
          margin-left: 15px;
        }
      }
    }
  }

  .title {
    font-size: 20px;
    font-weight: 600;
    line-height: 24px;
    &:hover {
      cursor: pointer;
    }
  }
  .nav-container {
    a {
      color: #14244f;
      text-decoration: none;
      font-weight: bold;
      font-size: 12px;
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
      width: 250px;
    }
  }
  .img-fluid {
    width: auto;
    max-width: none;
    height: 46px;
  }

  @media screen and (min-width: 992px) and (max-width: 1200px) {
    .img-fluid {
      height: 20px;
    }
    .title {
      font-size: 18px;
    }
  }
}
.nav-item {
  a.active {
    color: $dash-blue !important;
  }
}
</style>
