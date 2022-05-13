<template>
  <b-container class="container-creation" fluid>
    <b-row class="h-100">
      <b-col lg="12" class="w-100 px-0 mx-0">
        <formStepFieldIndex />
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import formStepFieldIndex from "./components/formStepFieldIndex.vue";
export default {
  components: {
    formStepFieldIndex,
  },
};
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";
</style>
