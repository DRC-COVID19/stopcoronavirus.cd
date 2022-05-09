<template>
  <b-nav lg="12" class="d-flex justify-content-center nav-container">
    <b-nav-item
      v-if="canViewForm"
      :to="{ name: 'administrator.forms.show.creation' }"
      :active="this.$route.name.startsWith('administrator.forms.show.creation')"
    >
      Création
    </b-nav-item>
    <b-nav-item
      v-if="canViewForm"
      :to="{ name: 'administrator.forms.show.response' }"
      :active="this.$route.name.startsWith('administrator.forms.show.response')"
    >
      Réponses
    </b-nav-item>
    <b-nav-item
      v-if="canViewForm"
      :to="{ name: 'administrator.forms.show.setting' }"
      :active="this.$route.name.startsWith('administrator.forms.show.setting')"
    >
      Paramètre
    </b-nav-item>
    <b-nav-item
      v-if="canViewForm"
      :to="{ name: 'administrator.forms.show.schema' }"
      :active="this.$route.name.startsWith('administrator.forms.show.schema')"
    >
      Schèmas
    </b-nav-item>
  </b-nav>
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
.nav {
  background: transparent;
  border-bottom-left-radius: 3px;
  border-bottom-right-radius: 3px;
  a {
    color: black;
    text-decoration: none;
    font-size: 12px;

    &:hover {
      color: #3767fa;
    }
  }
}

.nav-item {
  width: auto;
  a.active {
    color: #3767fa !important;
    background: white !important;

    border-bottom-left-radius: 3px !important;
    border-bottom-right-radius: 3px !important;
  }
}
@media (max-width: $max-width) {
  .nav {
    justify-content: start !important;
    height: auto;
    width: 100% !important;
    overflow-x: scroll !important;
    white-space: nowrap;
    flex-wrap: nowrap !important;
    &::-webkit-scrollbar {
      width: 0; /* Remove scrollbar space */
      background: transparent; /* Optional: just make scrollbar invisible */
    }
  }
}
</style>
