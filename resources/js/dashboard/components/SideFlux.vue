<template>
  <b-container class="side-case-covid-container">
    <b-row>
      <b-col cols="12">
        <div id="site_flux"></div>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import * as d3 from "d3";
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
    };
  },
  watch: {
    flux24() {
     this.show().then(({ fluxHeader, fluxDestination, fluxValues }) => {
      this.drawChart(fluxValues, fluxHeader, fluxDestination);
    });
    }
  },
  mounted() {
    this.show().then(({ fluxHeader, fluxDestination, fluxValues }) => {
      this.drawChart(fluxValues, fluxHeader, fluxDestination);
    });
  },
  methods: {
    show() {
      return new Promise((resolver, reject) => {
        if (this.flux24) {
          const fluxHeader = [];
          const fluxDestination = [];
          const fluxValues = [];

          for (const key in this.flux24) {
            let item = this.flux24[key];
            const element = fluxHeader.find(x => x == item.origin);
            if (!element) {
              fluxHeader.push(item.origin);
            }
            const destination = fluxDestination.find(
              x => x == item.destination
            );
            if (!destination) {
              fluxDestination.push(item.destination);
            }
          }

          fluxDestination.forEach(destination => {
            fluxHeader.forEach(itemOrigin => {
              if (!itemOrigin) {
                return;
              }
              let value = this.flux24.find(
                x => x.origin == itemOrigin && x.destination == destination
              );
              if (value) {
                fluxValues.push({
                  origin: itemOrigin,
                  destination: destination,
                  volume: value.volume,
                  reference_volume: value?.reference_volume
                });
              } else {
                fluxValues.push({
                  origin: itemOrigin,
                  destination: destination
                });
              }
            });
          });
          resolver({
            fluxHeader,
            fluxDestination,
            fluxValues
          });
        }
      });
    },
    drawChart(data, groupX, groupY) {
      // set the dimensions and margins of the graph
      var margin = { top: 30, right: 30, bottom: 80, left: 80 },
        width = 1024 - margin.left - margin.right,
        height = 700 - margin.top - margin.bottom;

      // append the svg object to the body of the page
      var svg = d3
        .select("#site_flux")
        .append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

      // Build X scales and axis:
      var x = d3
        .scaleBand()
        .range([0, width])
        .domain(groupX)
        .padding(0.01);
      svg
        .append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x).tickSizeOuter(0))
        .selectAll("text")
        .attr("transform", "translate(-10,0)rotate(-45)")
        .style("text-anchor", "end");

      // Build X scales and axis:
      var y = d3
        .scaleBand()
        .range([height, 0])
        .domain(groupY)
        .padding(0.01);
      svg.append("g").call(d3.axisLeft(y));

      // Build color scale
      var myColor = d3
        .scaleLinear()
        .range(["#f1f1f1", "#00b065"])
        .domain([0, d3.max(data, d => d.volume)]);

      // create a tooltip
      var tooltip = d3
        .select("#site_flux")
        .append("div")
        .style("opacity", 0)
        .attr("class", "tooltip")
        .style("background-color", "white")
        .style("border", "solid")
        .style("border-width", "2px")
        .style("border-radius", "5px")
        .style("padding", "5px");

      // Three function that change the tooltip when user hover / move / leave a cell
      var mouseover = function(d) {
        tooltip.style("opacity", 1);
      };
      var mousemove = function(d) {
        tooltip
          .html(`${d.origin} - ${d.destination} ${d.volume?`:${d.volume}`:''}`)
          .style("left", d3.mouse(this)[0] + 70 + "px")
          .style("top", d3.mouse(this)[1] + "px")
          .style("cursor", "pointer");
      };
      var mouseleave = function(d) {
        // tooltip.style("opacity", 0);
      };

      svg
        .selectAll()
        .data(data, function(d) {
          return d.origin + ":" + d.destination;
        })
        .enter()
        .append("rect")
        .attr("x", function(d) {
          return x(d.origin);
        })
        .attr("y", function(d) {
          return y(d.destination);
        })
        .attr("width", x.bandwidth())
        .attr("height", y.bandwidth())
        .style("fill", function(d) {
          return myColor(d.volume);
        })
        .on("mouseover", mouseover)
        .on("mousemove", mousemove)
        .on("mouseleave", mouseleave);
    }
  }
};
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";
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
  .observation {
    color: $success;
  }
  .reference {
    color: $reference;
  }
}
</style>