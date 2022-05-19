<template>
  <div class="form-container">
    <div class="form-container-header position-fixed container-fluid mx-0 px-0">
      <div class="container-fluid mx-0 px-0">
        <MainHeader style="z-index: 1000" />
      </div>
      <div class="d-flex">
        <AdministrationMenuForm
          style="z-index: 1000"
          class="bg-white form-container-header-administration"
        />
        <Header style="z-index: 1000" class="form-container-header-detail" />
      </div>
    </div>

    <notifications group="alert" />
    <div class="router-view-container">
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
import Header from "./components/formDetailHeader/FormDetailHeaderIndex.vue";
import MainHeader from "../../../../components/MainHeader.vue";
import AdministrationMenuForm from "../../components/AdministrationMenuForm.vue";
export default {
  components: {
    MainHeader,
    Header,
    AdministrationMenuForm,
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
@import "@~/sass/_variables";

.form-container {
  background: #f4f6fc;
  min-height: 100vh;
  height: max-content;
  &-header {
    top: 0;
  }
  &-header-detail {
    top: 10;
  }
  &-header-administration {
    min-height: 100vh;
    width: 70px;
  }
}
.router-view-container {
  margin-top: 150px;
  margin-left: 75px;
}
</style>

<style lang="scss">
.container-dash {
  overflow: unset !important;
}
</style>
