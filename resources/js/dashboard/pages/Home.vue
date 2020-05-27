<template>
  <b-container fluid>
    <b-row >
      <b-col cols="12" md="3"></b-col>
      <b-col cols="12" md="9" class="vh-100">
        <Maps />
        
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import Maps from "../components/Maps";
export default {
  components: {
    Maps
  }
};
</script>
