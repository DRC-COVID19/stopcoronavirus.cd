<template>
  <b-container fluid>
    <b-row>
      <b-col cols="12" md="3" class="pb-3 column-left">
          <LeftColumn/>
      </b-col>
      <b-col cols="12" md="9" class="vh-100">
        <b-row class="map-container">
          <Maps />
        </b-row>
        <b-row class="chart-container"></b-row>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import Maps from "../components/Maps";
import LeftColumn from '../components/LeftColumn';
export default {
  components: {
    Maps,LeftColumn
  }
};
</script>
<style lang="scss" scoped>
.map-container {
  height: 80vh;
}
.chart-container {
  height: 20vh;
}
</style>