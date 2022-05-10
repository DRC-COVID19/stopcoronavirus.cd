<template>
  <b-container
    class="h-100 mx-0 my-0 px-0 justify-content-start container-creation"
  >
    <b-row class="h-100">
      <b-col lg="3" class="bg-white container-creation-list">
        <FormStepIndex />
      </b-col>
      <b-col lg="9" class="w-100">
       
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import FormStepIndex from "./components/formStep/FormStepIndex.vue";
export default {
  components: {
    FormStepIndex,
  },
};
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";
.container-creation-list {
  padding-top: 8% !important;
}
</style>
