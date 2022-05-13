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
      <b-col>
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
};
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";
.container-creation-list {
  padding-top: 3% !important;
}
</style>
