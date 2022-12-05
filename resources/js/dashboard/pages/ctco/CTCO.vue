<template>
  <b-row class="ctco-container d-block d-lg-flex no-gutters flex-lg-nowrap">
    <b-col cols="12" lg="auto">
      <CTCOMenu />
    </b-col>
    <b-col class="col-router-view ctco-container-body">
      <router-view></router-view>
    </b-col>
  </b-row>
</template>

<script>
import { mapState } from 'vuex';
import { ADMIN_HOSPITAL, AGENT_HOSPITAL } from '../../config/env';
import CTCOMenu from './components/CTCOMenu';
export default {
  components: {
    CTCOMenu,
  },
  mounted() {
    this.redirect(this.$route);
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
    }),
  },
  watch: {
    $route(to, from) {
      this.redirect(to);
    },
    user() {
      this.redirect(this.$route);
    },
  },
  methods: {
    redirect(route) {
      if (route.name !== 'hospitals') {
        return null;
      }
      if (!this.user || this.user.roles === undefined) {
        return null;
      }

      if (this.user.roles.find((a) => a.name == ADMIN_HOSPITAL)) {
        this.$router.push({
          name: 'hospital.admin',
        });
      } else if (
        this.user.hospital &&
        this.user.roles.find((a) => a.name == AGENT_HOSPITAL)
      ) {
        this.$router.push({
          name: 'hospital.home',
        });
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import '@~/sass/_variables';
.ctco-container {
  &-body {
    overflow-y: scroll;
  }
  @media (min-width: 1024px) {
    height: calc(100vh - 87px);
    > div {
      height: 100%;
    }
  }
}
</style>
