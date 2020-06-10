<template>
  <b-modal size="xl" :id="id">
    <b-container class="side-case-covid-container">
      <b-row>
        <b-col cols="12">
          <b-table-simple small outlined bordered striped hover responsive>
            <b-thead>
              <b-tr>
                <b-td v-for="(item,index) in fluxHeader" :key="index">{{item.origin}}</b-td>
              </b-tr>
            </b-thead>
            <b-tbody>
              <b-tr v-for="(item,index) in fluxDestination" :key="index">
                <b-td>{{item.destination}}</b-td>
                <b-td
                  v-for="(cell,cellIndex) in item.childrens"
                  :key="cellIndex"
                  v-b-tooltip.hover
                  :title="`${cell.origin}=>${cell.destination}`"
                >{{cell.volume }}</b-td>
              </b-tr>
            </b-tbody>
            <b-tbody></b-tbody>
          </b-table-simple>
        </b-col>
      </b-row>
    </b-container>
  </b-modal>
</template>

<script>
export default {
  props: {
    flux24: {
      type: Array,
      default: null
    },
    id: {
      type: String,
      default: "side_flux"
    }
  },
  data() {
    return {
      fluxHeader: [],
      fluxDestination: [],
      fluxCartesian: []
    };
  },
  watch: {
    flux24() {
      if (this.flux24) {
        this.fluxHeader = [];
        this.fluxDestination = [];

        this.fluxHeader.push({ origin: "" });
        this.flux24.map(item => {
          const element = this.fluxHeader.find(x => x.origin == item.origin);
          if (!element) {
            this.fluxHeader.push(Object.assign({}, item));
          }
          const destination = this.fluxDestination.find(
            x => x.destination == item.destination
          );
          if (!destination) {
            this.fluxDestination.push(item);
          }
        });
        for (const key in this.fluxDestination) {
          const element = this.fluxDestination[key];
          let items = [];
          this.fluxHeader.map(itemOrigin => {
            if (!itemOrigin.origin) {
              return;
            }
            let value = this.flux24.find(
              x =>
                x.origin == itemOrigin.origin &&
                x.destination == element.destination
            );
            if (value) {
              items.push({
                origin: itemOrigin.origin,
                destination: element.destination,
                volume: value.volume
              });
            } else {
              items.push({
                origin: itemOrigin.origin,
                destination: element.destination
              });
            }
          });
          this.fluxDestination[key].childrens = items;
        }
      }
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
    font-size: 1rem;
  }
  .area-total {
    font-size: 0.7rem;
  }
}
</style>