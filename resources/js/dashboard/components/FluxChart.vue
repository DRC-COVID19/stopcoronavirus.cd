<template>
  <b-container>
    <b-row>
      <b-col cols="12" md="10">
        <div ref="my_dataviz" id="my_dataviz"></div>
      </b-col>
      <b-col md="2">
        <ul class="legend">
          <li class="d-flex align-items-center">
            <span class="reference"></span>Réference
          </li>
          <li class="d-flex align-items-center">
            <span class="observation"></span>Observation
          </li>
        </ul>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import * as d3 from "d3";
export default {
  props: {
    flux24Daily: {
      type: Array,
      default: () => ([])
    }
  },
  watch: {
    flux24Daily() {
      this.show();
    }
  },
  methods: {
    show() {
      
      if (this.flux24Daily.length == 0) {
        return;
      }
      const margin = { top: 20, right: 20, bottom: 90, left: 120 },
        width = 800 - margin.left - margin.right,
        height = 400 - margin.top - margin.bottom;

      const x = d3
        .scaleBand()
        .range([0, width])
        .padding(0.1);

      const y = d3.scaleLinear().range([height, 0]);

      const svg = d3
        .select(this.$refs.my_dataviz)
        .append("svg")
        .attr("id", "svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

      const div = d3
        .select("body")
        .append("div")
        .attr("class", "tooltip")
        .style("opacity", 0);

      let data = this.flux24Daily;

      // Mise en relation du scale avec les données de notre fichier
      // Pour l'axe X, c'est la liste des pays
      // Pour l'axe Y, c'est le max des populations
      x.domain(data.map(d => d.date));
      y.domain([0, d3.max(data, d => d.volume)]);

      // Ajout de l'axe X au SVG
      // Déplacement de l'axe horizontal et du futur texte (via la fonction translate) au bas du SVG
      // Selection des noeuds text, positionnement puis rotation
      svg
        .append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x).tickSize(0))
        .selectAll("text")
        .style("text-anchor", "end")
        .attr("dx", "-.8em")
        .attr("dy", ".15em")
        .attr("transform", "rotate(-65)");

      // Ajout de l'axe Y au SVG avec 6 éléments de légende en utilisant la fonction ticks (sinon D3JS en place autant qu'il peut).
      svg.append("g").call(d3.axisLeft(y).ticks(6));

      // Ajout des bars en utilisant les données de notre fichier data.tsv
      // La largeur de la barre est déterminée par la fonction x
      // La hauteur par la fonction y en tenant compte de la population
      // La gestion des events de la souris pour le popup
      svg
        .selectAll(".bar")
        .data(data)
        .enter()
        .append("rect")
        .attr("class", "bar")
        .attr("x", d => x(d.date))
        .attr("width", x.bandwidth())
        .attr("fill", d => {
          return d.isReference ? "#9E9E9E" : "#4CAF50";
        })
        .attr("y", d => y(d.volume))
        .attr("height", d => height - y(d.volume))
        .on("mouseover", function(d) {
          div
            .transition()
            .duration(200)
            .style("opacity", 0.9);
          div
            .html("Population : " + d.volume)
            .style("left", d3.event.pageX + 10 + "px")
            .style("top", d3.event.pageY - 50 + "px");
        })
        .on("mouseout", function(d) {
          div
            .transition()
            .duration(500)
            .style("opacity", 0);
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.legend {
  list-style: none;
  li {
    span {
      display: inline-block;
      width: 20px;
      height: 20px;
      margin-right: 5px;
      &.reference {
        background: #9e9e9e;
      }
      &.observation {
        background: #4caf50;
      }
    }
  }
}
</style>