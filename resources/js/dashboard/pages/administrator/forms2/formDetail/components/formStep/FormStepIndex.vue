<template>
  <b-container class="h-100">
    <b-row>
      <b-col class="bg-white">
        <FormStepList />
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import FormStepList from "./FormStepList.vue";
export default {
  components: {
    FormStepList,
  },
};
</script>

