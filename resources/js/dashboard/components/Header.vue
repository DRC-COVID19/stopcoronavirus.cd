<template>
  <b-row class="header">
    <b-col cols="12" md="6" class="map-form-header">
      <h1>Dashboard Covid-19</h1>
    </b-col>
    <b-col cols="12" md="4" class="map-form-logo d-flex justify-content-end">
      <img src="/img/partners_top.png" width="100" class="img-fluid" alt />
      <img src="/img/commite_riposte.jpg" width="100" class="img-fluid" alt />
      <div>
        <b-img :src="user.avatar" />
      </div>
    </b-col>
  </b-row>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState({
      user: state => state.auth.user
    })
  }
};
</script>


<style lang="scss" scoped>
.header {
  padding: 12px 24px;
  background: white;
  h1 {
    font-size: 20px;
    font-weight: 600;
    line-height: 24px;
  }
}
</style>