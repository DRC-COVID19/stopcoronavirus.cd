<template>
  <b-row class="">
    <b-col cols="12" lg="12" class="header d-flex justify-content-center w-100">
      <b-nav
        lg="12"
        class="d-flex justify-content-center w-auto nav-container"
        style=""
      >
        <b-nav-item
          v-if="canViewForm"
          :to="{ name: 'administrator.forms2.show.creation' }"
          :active="
            this.$route.name.startsWith('administrator.forms2.show.creation')
          "
        >
          Création
        </b-nav-item>
        <b-nav-item
          v-if="canViewForm"
          :to="{ name: 'administrator.forms2.show.answer' }"
          :active="
            this.$route.name.startsWith('administrator.forms2.show.answer')
          "
        >
          Réponses
        </b-nav-item>
        <b-nav-item
          v-if="canViewForm"
          :to="{ name: 'administrator.forms2.show.setting' }"
          :active="
            this.$route.name.startsWith('administrator.forms2.show.setting')
          "
        >
          Paramètre
        </b-nav-item>
        <b-nav-item
          v-if="canViewForm"
          :to="{ name: 'administrator.forms2.show.schema' }"
          :active="
            this.$route.name.startsWith('administrator.forms2.show.schema')
          "
        >
          Schèmas
        </b-nav-item>
      </b-nav>
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
    };
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
      activeMenu: (state) => state.nav.activeMenu,
      changeLogs: (state) => state.app.changeLogs,
    }),
    ...mapGetters(["getChangeLogNotRead"]),

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
.header {
  a {
    text-decoration: none;
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
    background: transparent;
    border-bottom-left-radius: 3px;
    border-bottom-right-radius: 3px;
    a {
      color: black;
      text-decoration: none;
      font-size: 12px;

      &:hover {
        color: #3767fa;
        background: white !important;
        border-bottom-left-radius: 3px !important;
        border-bottom-right-radius: 3px !important;
      }
    }
    .active {
      a {
        color: #3767fa;
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
    color: #3767fa !important;
    background: white !important;

    border-bottom-left-radius: 3px !important;
    border-bottom-right-radius: 3px !important;
  }
}
</style>
