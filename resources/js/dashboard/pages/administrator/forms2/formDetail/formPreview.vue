<template>
  <b-container class="mx-0 px-0 d-flex justify-content-center" fluid>
    <b-row class="w-100 h-100 mx-0 px-0">
      <b-col lg="12" class="w-100 mx-0 px-0">
        <HospitalCard />
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import HospitalCard from "../../../../components/hospitalCard/HospitalCard.vue";
export default {
  components: {
    HospitalCard,
  },
};
</script>
