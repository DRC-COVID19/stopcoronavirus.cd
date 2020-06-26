<template>
  <b-container class="side-case-covid-container p-0">
    <b-row>
      <b-col cols="12">
        <b-table striped outlined hover responsive :items="CovidCasesProvince" :fields="fields">
          <template v-slot:cell(name)="data">
            <span>{{ data.item.properties.name }}</span>
          </template>
           <template v-slot:cell(last_update)="data">
             <div class="text-right">{{ moment(data.item.properties.last_update).format("DD.MM.YYYY") }}</div>
          </template>
          <template v-slot:cell(confirmed)="data" >
            <div class="text-right">{{ data.item.properties.confirmed }}</div>
          </template>
          <template v-slot:cell(healed)="data" >
            <div class="text-right">{{ data.item.properties.healed }}</div>
          </template>
           <template v-slot:cell(dead)="data" >
            <div class="text-right">{{ data.item.properties.dead }}</div>
          </template>
        </b-table>
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
  data() {
    return {
      fields: [
        {
          key: "name",
          label: "Nom"
        },
        {
          key:'last_update',
          label:"Mise à jour",
          variant:"info"
        },
        {
          key: "confirmed",
          label: "Confirmés",
          variant: "warning"
        },
        {
          key: "Healed",
          label: "Guéris",
          variant: "success"
        },
        {
          key: "dead",
          label: "Décès",
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