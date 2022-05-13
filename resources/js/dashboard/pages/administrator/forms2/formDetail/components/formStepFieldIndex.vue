<template>
  <b-container class="container-creation" fluid>
    <b-row class="h-100">
      <b-col lg="2" class="w-100 bg-white container-creation-list px-0 mx-0">
        <FormStepIndex :formId="+$route.params.form_id" />
      </b-col>
      <b-col lg="10" class="w-100">
        <router-view></router-view>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import FormStepIndex from "./formStep/FormStepIndex.vue";
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
