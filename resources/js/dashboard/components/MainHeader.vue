<template>
  <b-row class="header">
    <b-col cols="12" class="map-form-header">
      <b-navbar toggleable="lg" type="light">
        <b-navbar-brand class="mr-5">
          <h1
            class="title m-0"
          >
            Dashboard Covid-19
          </h1>
        </b-navbar-brand>
        <b-navbar-toggle target="nav-collapse" class="default-border">
          <span class="fa fa-bars"></span>
        </b-navbar-toggle>
        <b-collapse id="nav-collapse" is-nav>
          <b-navbar-nav class="nav-container">
            <b-nav-item
              v-if="canViewDashBoard"
              :to="{name: 'main.dashboard'}"
              :active="this.$route.name.startsWith('main.dashboard')"
            >
              Dashboard
            </b-nav-item>
            <b-nav-item
              v-if="canViewAdministration"
              :to="{name: 'administrator'}"
              :active="this.$route.name.startsWith('administrator')"
            >
              Administration
            </b-nav-item>
            <b-nav-item
              v-if="canViewCTCOS"
              :to="{name: 'hospitals'}"
              :active="this.$route.name.startsWith('hospital')"
            >
              CTCOS
            </b-nav-item>
                <b-nav-item
              :to="{name: 'bug_tracker'}"
              :active="this.$route.name.startsWith('bug_tracker')"
            >
              Signaler un problème
            </b-nav-item>
          </b-navbar-nav>
          <b-navbar-nav class="ml-auto" align="center">
            <b-nav-item class="position-relative nav-item d-flex align-items-center">
              <a
                class="nav-link position-relative"
                href="#"
                @click.prevent="toggleHeaderNotification"
                v-click-outside="clickOutsideNotification"
              >
                <div
                  class="icon-hallo d-flex justify-content-center align-items-center"
                >
                  <i class="fas fa-bell" aria-hidden="true"></i>
                </div>
                <span class="notification-count"> {{ getChangeLogNotRead.length }} </span>
              </a>
              <div class="dropdown-nav" v-show="showHeaderNotification">
                <div class="item-header">
                  <h6 class="item-title">Change log</h6>
                </div>
                <div class="item-content" v-if="getChangeLogNotRead.length">
                  <div
                    class="media align-items-center d-flex"
                    v-for="(item, index) in getChangeLogNotRead.slice(0, 5)"
                    :key="index"
                    @click="selectNotification(item)"
                  >
                    <div
                      class="item-icon bg-skyblue d-flex align-items-center justify-content-center"
                    >
                      <i class="fas fa-history"></i>
                    </div>
                    <div class="media-body space-sm">
                      <div class="post-title">{{ item.title }}</div>
                      <span>{{ moment(item.from).format("DD.MM.YYYY") }}</span>
                    </div>
                  </div>
                </div>
                <div class="item-content" v-else>
                  <div class="media align-items-center d-flex">
                    <div
                      class="item-icon bg-skyblue d-flex align-items-center justify-content-center"
                    ></div>
                    <div class="media-body space-sm">
                      <div class="post-title">Aucune notification</div>
                    </div>
                  </div>
                </div>
              </div>
            </b-nav-item>
            <b-nav-item class="d-flex align-content-center">
              <div
                class="map-form-logo d-flex justify-content-center justify-content-md-end align-items-center"
              >
                <img
                  src="/img/partener2.png"
                  height="30"
                  width="100"
                  class="img-fluid"
                  alt
                />
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
                      <span class="d-block" v-if="user.email">{{ user.email }}</span>
                    </p>
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
import { mapState, mapActions, mapMutations, mapGetters } from 'vuex'
import { ADMINISTRATOR, ADMIN_DASHBOARD, ADMIN_HOSPITAL, AGENT_HOSPITAL, CREATE_FORM, EDIT_FORM, MANANGER_EPIDEMIC } from '../config/env';

export default {
  components:{
  },
  data () {
    return {
      showUserCard: false,
      showHeaderNotification: false
    }
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
      activeMenu: (state) => state.nav.activeMenu,
      changeLogs: (state) => state.app.changeLogs
    }),
    ...mapGetters(['getChangeLogNotRead']),
    canViewDashBoard() {
      return this.userHaveRole(ADMIN_DASHBOARD)
    },
    canViewAdministration() {
      return this.userHaveRole(ADMINISTRATOR) || this.userHaveRole(MANANGER_EPIDEMIC) || this.userHaveRole(EDIT_FORM) || this.userHaveRole(CREATE_FORM)
    },
    canViewCTCOS () {
      return this.userHaveRole(ADMIN_HOSPITAL) || this.userHaveRole(AGENT_HOSPITAL)
    }
  },
  mounted() {},
  methods: {
    ...mapActions(['logout', 'setChangeLogsRead']),
    ...mapMutations(['setActiveMenu', 'setSelectedChangeLog']),
    userAvatarMouseEnter () {
      this.showUserCard = true
    },
    userAvatarMouseLeave () {
      this.showUserCard = false
    },
    userLogout () {
      this.logout().then(() => {
        this.$router.push({
          name: 'login'
        })
      })
    },
    selectNotification (item) {
      this.setSelectedChangeLog(item)
      this.setActiveMenu(7)
    },
    toggleHeaderNotification () {
      this.showHeaderNotification = !this.showHeaderNotification
    },
    clickOutsideNotification () {
      if (this.showHeaderNotification) {
        this.showHeaderNotification = false
        this.setChangeLogsRead()
      }
    }
  },
};
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.header {
  a {
    text-decoration: none;
  }
  background: white;
  border-bottom: 1px solid $dash-shadow-color;
  .icon-hallo {
    width: 30px;
    height: 30px;
    background: $dash-background;
    border-radius: 50px;
  }
  .notification-count {
    position: absolute;
    top: 4px;
    right: -2px;
    height: 20px;
    width: 20px;
    color: #ffffff;
    font-size: 0.8rem;
    background-color: #ff3131;
    border-radius: 50%;
    display: block;
    text-align: center;
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
      width: 250px;
    }
  }
  .img-fluid {
    width: auto;
    max-width: none;
    height: 30px;
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
.nav-item{
  a.active {
    color: $dash-blue !important;
  }
}
</style>
