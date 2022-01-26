<template>
  <b-row class="header">
    <b-col cols="12" class="map-form-header">
      <b-navbar toggleable="lg" type="light">
        <b-navbar-brand class="mr-5">
          <h1 class="title m-0">Dashboard Covid-19</h1>
        </b-navbar-brand>
        <b-navbar-toggle target="nav-collapse" class="default-border">
          <span class="fa fa-bars"></span>
        </b-navbar-toggle>
        <b-collapse id="nav-collapse" is-nav>
          <b-navbar-nav class="nav-container">
            <!-- <b-nav-item
              :class="{ active: activeMenu == 1 }"
              @click="selectMenu(1)"
              >Mobilité</b-nav-item
            > -->
            <!-- <b-nav-item
              :class="{ active: activeMenu == 2 }"
              @click="selectMenu(2)"
              >Epidémiologie
            </b-nav-item>
            <b-nav-item
              :class="{ active: activeMenu == 3 }"
              @click="selectMenu(3)"
              >Indicateurs</b-nav-item
            > -->
            <!-- <b-nav-item :class="{'active':activeMenu==4}" @click="selectMenu(4)">Sondages</b-nav-item> -->
            <b-nav-item
              :class="{ active: activeMenu == 5 }"
              @click="selectMenu(5)"
              >Infrastructures</b-nav-item
            >
            <!-- <b-nav-item :class="{'active':activeMenu==6}" @click="selectMenu(6)">Orientation</b-nav-item> -->
            <b-nav-item
              :class="{ active: activeMenu == 7 }"
              @click="selectMenu(7)"
              >A propos</b-nav-item
            >
          </b-navbar-nav>
          <b-navbar-nav class="ml-auto" align="center">
            <div v-b-modal.modal-center style="cursor: pointer" class="position-relative nav-item d-flex align-items-center">
                 <span>
                <Icon
                  style="font-size: 30px"
                  icon="vscode-icons:file-type-excel2"
                />
              </span>
              </div>
            <!-- <export-excel data="" name="filename.xls" class="position-relative nav-item d-flex align-items-center">
              
            </export-excel> -->
            <li class="position-relative nav-item d-flex align-items-center">
              <a
                class="nav-link"
                href="#"
                @click.prevent="toggleHeaderNotification"
                v-click-outside="clickOutsideNotification"
              >
                <div
                  class="icon-hallo d-flex justify-content-center align-items-center"
                >
                  <i class="fas fa-bell"></i>
                </div>

                <span class="notification-count">{{
                  getChangeLogNotRead.length
                }}</span>
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
            </li>
            <b-nav-item>
              <div
                class="map-form-logo d-flex justify-content-center justify-content-md-end align-items-center"
              >
                <img
                  src="/img/partener2.png"
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
                      <span class="d-block" v-if="user.email">{{
                        user.email
                      }}</span>

                      <router-link class="small" :to="{ name: 'landing' }"
                        >Revenir à l'accueil</router-link
                      >
                    </p>
                    <b-button @click="userLogout" variant="danger" block
                      >Deconnexion</b-button
                    >
                  </b-card>
                </div>
              </div>
            </b-nav-item>
          </b-navbar-nav>
        </b-collapse>
      </b-navbar>
      <b-modal id="modal-center" centered hide-footer hide-header title="BootstrapVue">
        <p class="my-4">Vertically centered modal!</p>
      </b-modal>
    </b-col>
  </b-row>
</template>

<script>
import { mapState, mapActions, mapMutations, mapGetters } from 'vuex'
import { Icon } from '@iconify/vue2'

export default {
  components:{
    Icon
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
    countReadChangeLogs () {
      return getChangeLogNotRead.length
    }
  },
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
    selectMenu (value) {
      this.setActiveMenu(value)
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
  }
}
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
    top: 0px;
    right: -1px;
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
</style>
