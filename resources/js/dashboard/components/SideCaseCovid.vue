<template>
  <b-container class="side-case-covid-container">
    <b-row>
      <b-col cols="12">
        <b-card>
          <h3>Vue d'ensemble</h3>
          <hr />
          <b-list-group class="group-item">
            <b-list-group-item v-for="(item, index) in CovidCasesProvince" :key="index">
              <div class="area-name text-center mb-2">{{item.properties.name}}</div>
              <div class="area-total d-flex justify-content-around align-items-center">
                <div class="confirmed d-flex flex-column justify-content-center align-items-center">
                  <div class="stat-color" :style="stateColorWith(item.properties,'confirmed')"></div>
                  {{item.properties.confirmed}}
                </div>
                <div class="healed d-flex flex-column justify-content-center align-items-center">
                  <div class="stat-color" :style="stateColorWith(item.properties,'healed')"></div>
                  {{item.properties.healed}}
                </div>
                <div class="dead d-flex flex-column justify-content-center align-items-center">
                  <div class="stat-color" :style="stateColorWith(item.properties,'dead')"></div>
                  {{item.properties.dead}}
                </div>
              </div>
            </b-list-group-item>
          </b-list-group>
        </b-card>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
export default {
  props: {
    covidCases: {
      type: Object,
      default: null
    }
  },
  computed: {
    CovidCasesProvince() {
      return this.covidCases?.data.features;
    }
  },
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