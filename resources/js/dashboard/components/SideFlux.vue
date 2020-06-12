<template>
  <b-container class="side-case-covid-container">
    <b-row>
      <b-col cols="12">
        <div v-if="!isFinished">
          <div class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
          </div>
        </div>
        <b-table-simple small outlined bordered striped hover responsive v-else>
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
              >
                {{cell.reference_volume?`${cell.reference_volume}=>`:''}}
                {{cell.volume }}
              </b-td>
            </b-tr>
          </b-tbody>
        </b-table-simple>
      </b-col>
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
  data() {
    return {
      fluxHeader: [],
      fluxDestination: [],
      fluxCartesian: [],
      isFinished: false
    };
  },
  watch: {
    flux24() {
      this.isFinished = false;
      this.show().then(({ fluxHeader, fluxDestination }) => {
        this.fluxHeader = fluxHeader;
        this.fluxDestination = fluxDestination;
        this.isFinished = true;
      });
    }
  },
  mounted() {
    this.isFinished = false;
    this.show().then(({ fluxHeader, fluxDestination }) => {
      this.fluxHeader = fluxHeader;
      this.fluxDestination = fluxDestination;
      this.isFinished = true;
    });
  },
  methods: {
    show() {
      return new Promise((resolver, reject) => {
        if (this.flux24) {
          const fluxHeader = [];
          const fluxDestination = [];

          fluxHeader.push({ origin: "" });
          for (const key in this.flux24) {
            let item = this.flux24[key];
            const element = fluxHeader.find(x => x.origin == item.origin);
            if (!element) {
              fluxHeader.push(Object.assign({}, item));
            }
            const destination = fluxDestination.find(
              x => x.destination == item.destination
            );
            if (!destination) {
              fluxDestination.push(item);
            }
          }

          fluxDestination.forEach(element => {
            let items = [];
            fluxHeader.forEach(itemOrigin => {
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
            element.childrens = items;
          });
          resolver({
            fluxHeader,
            fluxDestination
          });
        }
      });
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