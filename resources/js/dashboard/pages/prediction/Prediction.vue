<template>
  <div>
    <div class="main-header">
      <MainHeader />
    </div>
    <b-row
      class="prediction-container d-block d-lg-flex no-gutters flex-lg-nowrap justify-content-between"
    >
      <b-col cols="12" lg="auto">
        <PredictionMenu />
      </b-col>
      <b-col class="col-router-view prediction-container-body">
        <notifications group="alert" />
        <router-view></router-view>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import {
  ADMINISTRATOR,
  CREATE_FORM,
  EDIT_FORM,
  MANANGER_EPIDEMIC,
} from '../../config/env';
import MainHeader from '../../components/MainHeader';
import PredictionMenu from '../../components/prediction/PredictionMenu';

export default {
  components: {
    PredictionMenu,
    MainHeader,
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
      if (route.name !== 'prediction') {
        return null;
      }
      if (!this.user || this.user.roles === undefined) {
        return null;
      }

      if (
        this.user.roles.find(
          (a) =>
            a.name === ADMINISTRATOR ||
            a.name == CREATE_FORM ||
            a.name == EDIT_FORM ||
            a.name == MANANGER_EPIDEMIC
        )
      ) {
        this.$router.push({
          name: 'prediction.existingData',
        });
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import '@~/sass/_variables';
@import '@~/sass/_variables';

.prediction-container {
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
