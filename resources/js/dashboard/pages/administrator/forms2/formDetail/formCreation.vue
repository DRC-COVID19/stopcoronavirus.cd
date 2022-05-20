<template>
  <b-container class="px-0 mx-0" fluid>
    <b-row class="h-100 px-0 mx-0">
      <b-col
        lg="2"
        class="
          w-100
          d-flex
          justify-content-start
          bg-white
          container-creation-list
          px-0
          mx-0
        "
      >
        <FormStepIndex :formId="+$route.params.form_id" />
      </b-col>
      <b-col cols="12" class="container-creation-list-responsive">
        <div>
          <b-button
            v-b-toggle.sidebar-left
            class="btn-dash-blue d-block"
            side="sm"
          >
            <small>Étapes</small>
          </b-button>
        </div>
        <b-sidebar
          id="sidebar-left"
          left
          bg-variant="white"
          width="25rem"
          backdrop
          :no-close-on-route-change="true"
          shadow
          backdrop-variant="transparent"
        >
          <FormStepIndex :formId="+$route.params.form_id" />
        </b-sidebar>
      </b-col>
      <b-col cols="auto" lg="10">
        <router-view></router-view>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import FormStepIndex from "./components/formStep/FormStepIndex";

export default {
  components: {
    FormStepIndex,
  },
  mounted() {},
  methods: {},
};
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.container-fluid {
  @media (min-width: 992px) {
    margin-left: 70px !important;
  }
}
.container-creation-list-responsive {
  display: none;
  margin-top: 35px;
}
@media (max-width: 1440px) {
  .container-creation-list {
    display: none !important;
  }
  .container-creation-list-responsive {
    display: block !important;
  }
}
</style>
