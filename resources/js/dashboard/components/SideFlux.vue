<template>
  <b-container class="side-case-covid-container">
    <b-row>
      <div class="card card-body cols-12">
        <b-list-group class="group-item">
          <b-list-group-item v-for="(item, index) in flux24" :key="index">
            <div class="area-name text-center mb-2">{{item.origin}}=>{{item.destination}}</div>
            <div class="area-total d-flex justify-content-around align-items-center">{{item.reference_volume}}{{`<=>`}}{{item.volume}}</div>
          </b-list-group-item>
        </b-list-group>
      </div>
    </b-row>
  </b-container>
</template>

<script>
export default {
  props: {
    flux24: {
      type: Array,
      default: null
    }
  },
  computed: {},
  methods: {
    stateColorWith(item, type) {
      let width = (item[type] * 100) / item.confirmed;
      if (width == 0) {
        return {
          width: "10px"
        };
      }
      return {
        width: `${width}%`
      };
    }
  }
};
</script>
<style lang="scss" scoped>
.side-case-covid-container {
  h3 {
    font-size: 0.8rem;
  }
  .area-name {
    font-size: 0.7rem;
  }
  .area-total {
    font-size: 0.7rem;
  }
}
</style>