<template>
  <b-container class="side-case-covid-container">
    <b-row>
      <b-col>
        <b-table striped bordered outlined hover responsive :items="medicalOrientations" :fields="fields">
          <template v-slot:cell(FIN8)="data">
            <div class="text-right">{{ data.item.FIN8 }}</div>
          </template>
          <template v-slot:cell(FIN5)="data">
            <div class="text-right">{{ data.item.FIN5 }}</div>
          </template>
          <template v-slot:cell(FIN)="data">
            <div class="text-right">{{ data.item.FIN }}</div>
          </template>
        </b-table>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
export default {
  props: {
    medicalOrientations: {
      type: Array,
      default: null
    }
  },
  data() {
    return {
      fields: [
        {
          key: "province"
        },
        {
          key: "township",
          label: "Ville/Commune"
        },
        {
          key: "FIN8",
          label: "Peu probale",
          variant: "success"
        },
        {
          key: "FIN",
          label: "Probale",
          variant: "warning"
        },
        {
          key: "FIN5",
          label: "Très Probale",
          variant: "danger"
        }
      ]
    };
  },
  computed: {
    CovidCasesProvince() {
      return this.covidCases?.data.features;
    }
  },
  methods: {
    stateColorWith(item, type) {
      let width =
        (item[type] * 100) / (item.FIN ?? 0 + item.FIN5 ?? 0 + item.FIN8 ?? 0);
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