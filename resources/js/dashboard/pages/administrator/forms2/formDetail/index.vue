<template>
  <div class="form-container">
    <div class="form-container-header position-fixed container-fluid mx-0 px-0">
      <div class="container-fluid mx-0 px-0">
        <MainHeader />
      </div>
      <div class="d-flex flex-wrap">
        <b-col
          cols="12"
          lg="auto"
          class="px-0 form-container-header-administration-container"
        >
          <AdministratorMenu
            :show-label="false"
            class="bg-white form-container-header-administration"
          />
        </b-col>
        <b-col cols="12" class="form-container-header-detail-container" lg>
          <Header class="form-container-header-detail" />
        </b-col>
      </div>
    </div>

    <notifications group="alert" />
    <div class="router-view-container">
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
import Header from './components/formDetailHeader/FormDetailHeaderIndex.vue';
import MainHeader from '../../../../components/MainHeader.vue';
import AdministratorMenu from '../../components/AdministratorMenu.vue';
export default {
  components: {
    MainHeader,
    Header,
    AdministratorMenu,
  },
  data() {
    return {
      isLoading: false,
      form: {},
    };
  },

  mounted() {},

  methods: {},
};
</script>

<style lang="scss" scoped>
@import '@~/sass/_variables';

.form-container {
  background: #f4f6fc;
  min-height: 100vh;
  height: max-content;

  &-header {
    z-index: 100;
  }
  &-header-administration-container {
    height: 32px;
    @media (min-width: 992px) {
      height: 0px;
    }
  }
  &-header-detail-container {
    @media (max-width: 992px) {
      padding: 0px !important;
    }
  }
  &-header-administration {
    @media (min-width: 992px) {
      min-height: 100vh;
    }
  }
}
.router-view-container {
  padding-top: 160px;
}
.container-dash {
}
</style>
