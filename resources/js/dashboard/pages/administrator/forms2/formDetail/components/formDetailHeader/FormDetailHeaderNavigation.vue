<template>
  <b-row class="header">
    <b-col cols="12" class="">
      <b-navbar toggleable="lg" type="light">
        <b-navbar-brand class="">
          <b-form-input
            @blur="onChangeTilte"
            v-model="titleForm"
            class="input-header"
            :class="stateTitleForm ? 'border-1' : 'border-0 '"
            placeholder="Entrer le titre du formulaire"
            :value="titleForm"
            :state="stateTitleForm"
          ></b-form-input>
        </b-navbar-brand>
        <b-navbar-toggle target="nav-collapse" class="">
          <span class="fa fa-bars"></span>
        </b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
          <div class="d-flex justify-content-between w-100 container-nav-space">
            <b-navbar-nav class="nav-container w-100" align="center" lg="3">
              <span class="d-flex align-center text-center w-100">
                Etat du formulaire :
                <span
                  class="ml-3"
                  :class="isPublish ? 'text-success' : 'text-danger'"
                >
                  {{ isPublish ? "publié" : "non publié" }}</span
                >
              </span>
            </b-navbar-nav>
            <b-navbar-nav
              class="
                d-flex
                nav-container
                align-center
                justify-content-around
                w-100
              "
            >
              <b-button
                class="d-block btn-dash-blue px-4 nav-btn-action"
                @click="changeStatusPublishForm"
              >
                {{ isPublish ? "Ne plus Publier" : "Publier" }}
              </b-button>

              <b-nav-item
                v-if="canViewForm"
                :to="{ name: 'administrator.forms.show.form-preview' }"
                :active="
                  this.$route.name.startsWith(
                    'administrator.forms.show.form-preview'
                  )
                "
                class="d-block preview text-center px-4 nav-btn-action"
              >
                Prévisualisation
              </b-nav-item>
            </b-navbar-nav>
            <b-navbar-nav class="d-lg-none profil-container-responsive">
              <b-nav-item
                v-if="canViewForm"
                class="d-block text-center w-100"
                :to="{ name: 'administrator.forms' }"
                :active="this.$route.name.startsWith('administrator.forms')"
              >
                Revenir aux Formulaires
              </b-nav-item>
              <b-button
                @click="userLogout"
                class="btn-deconnexion"
                variant="danger"
                block
              >
                Deconnexion
              </b-button>
            </b-navbar-nav>
            <b-navbar-nav class="my-auto profil-container">
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
                      <b-nav-item
                        v-if="canViewForm"
                        :to="{ name: 'administrator.forms' }"
                        :active="
                          this.$route.name.startsWith('administrator.forms')
                        "
                      >
                        Revenir aux Formulaires
                      </b-nav-item>
                      <b-button @click="userLogout" variant="danger" block>
                        Deconnexion
                      </b-button>
                    </b-card>
                  </div>
                </div>
              </b-nav-item>
            </b-navbar-nav>
          </div>
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
      isPublish: false,
      form: {},
    };
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
      activeMenu: (state) => state.nav.activeMenu,
      changeLogs: (state) => state.app.changeLogs,
      isUpdateFormTitle: (state) => state.form.isUpdateFormTitle,
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
  mounted() {
    this.init();
  },
  methods: {
    ...mapActions([
      "logout",
      "setChangeLogsRead",
      "formShow",
      "updateFormTitle",
      "changeStatusForm",
    ]),
    ...mapMutations(["setActiveMenu", "setSelectedChangeLog"]),
    async init() {
      this.isLoading = true;
      this.form = await this.formShow({ id: this.$route.params.form_id });
      this.titleForm = this.form.title;
      this.isPublish = this.form.publish;
      if (this.form.length !== 0) {
        this.isLoading = false;
      }
    },
    async onChangeTilte() {
      this.form.title = this.titleForm;
      await this.updateFormTitle(this.form);
    },
    async changeStatusPublishForm() {
      this.form.publish = !this.isPublish;
      this.form.form_id = this.form.id;
      await this.changeStatusForm(this.form);
      this.isPublish = !this.isPublish;
    },
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
  background: white;

  .container-nav-space {
    margin-left: 25%;
  }
  .nav-container {
    .nav-btn-action {
      font-size: 14px !important;
    }
    span {
      color: #14244f;
      font-weight: bold;
      font-size: 12px;
      align-items: center;
      justify-content: center;
    }
    a {
      color: #14244f;
      text-decoration: none;

      font-size: 14px;
      &:hover {
        color: $dash-blue;
      }
    }
    .active {
      a {
        color: $dash-blue;
      }
    }
    .preview {
      background: #f4f6fc !important;
      border-color: #f4f6fc !important;
    }
    a {
      color: #3767fa !important;
    }
  }
  .input-header {
    outline: 0 none;
    font-size: 20px;
    font-weight: 600;
    line-height: 24px;
    &:hover {
      cursor: pointer;
    }
  }

  .avatar-container {
    position: relative;
    display: block;

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
@media screen and (min-width: 991px) and (max-width: 1200px) {
  .container-nav-space {
    margin-left: 5% !important;
  }
}
@media (max-width: $max-width) {
  .container-nav-space {
    display: block !important;
    margin-left: 0 !important;
    padding: 0 12%;
  }

  .profil-container {
    display: none !important;
  }
  .profil-container-responsive {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    padding: 0 5%;
    a {
      background: #f4f6fc !important;
      border-color: #f4f6fc !important;
      font-size: 14px;
      padding: 0.5rem;
    }
    .btn-deconnexion {
      margin: 15px !important;
      font-size: 14px !important;
    }
  }
}

.nav-item {
  a.active {
    color: $dash-blue !important;
  }
}
</style>
