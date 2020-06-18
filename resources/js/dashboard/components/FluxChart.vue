<template>
  <b-container>
    <b-row>
      <b-col cols="12" md="6">
        <b-row v-for="(item,index) in flux24DailyInLocal" :key="index" class="mb-3">
          <b-col cols="12">
            <h3>{{item[0].destination}}</h3>
            <b-card no-body class="mb-3">
              <b-card-header>
                <h5>Mobilité entrante</h5>
                <hr />
                <div class="text-center percent">{{fluxInPercent(item)}}%​</div>
                <p v-if="fluxVolumObservation(item)>0" class="text-center percent-p">
                  ({{fluxVolumObservation(item).toLocaleString(
                  undefined,
                  { minimumFractionDigits: 0 })}} personnes de plus sont entrés dans la zone )​
                </p>
                <p v-else class="text-center percent-p">
                  ({{(fluxVolumObservation(item)*-1).toLocaleString(
                  undefined,
                  { minimumFractionDigits: 0 })}} personnes de moins sont entrés dans la zone )​
                </p>
              </b-card-header>
              <div class="chart-container">
                <div :ref="`mobile_entrance_${index}`" :id="`mobile_entrance_${index}`"></div>
              </div>
            </b-card>
            <b-card-header>
              <h5>Zone d'origine</h5>
            </b-card-header>
            <b-card no-body>
              <div class="chart-container">
                <div :ref="`mobile_entrance_${index}_2`" :id="`mobile_entrance_${index}_2`"></div>
              </div>
            </b-card>
            <hr />
          </b-col>
        </b-row>
      </b-col>
      <b-col cols="12" md="6">
        <b-row v-for="(item,index) in flux24DailyOutLocal" :key="index" class="mb-3">
          <b-col cols="12">
            <h3>{{item[0].origin}}</h3>
            <b-card no-body class="mb-3">
              <b-card-header>
                <h5>Mobilité sortante</h5>
                <hr />
                <div class="text-center percent">{{fluxInPercent(item)}}%​</div>
                <p
                  v-if="fluxVolumObservation(item)>0"
                  class="text-center percent-p"
                >({{fluxVolumObservation(item).toLocaleString(
                  undefined,
                  { minimumFractionDigits: 0 })}} personnes de plus sont sorties de la zone )​</p>
                <p
                  v-else
                  class="text-center percent-p"
                >({{(fluxVolumObservation(item)*-1).toLocaleString(
                  undefined,
                  { minimumFractionDigits: 0 })}} personnes de moins sont sorties de la zone )​</p>
              </b-card-header>
              <div class="chart-container">
                <div :ref="`mobile_out_${index}`" :id="`mobile_out_${index}`"></div>
              </div>
            </b-card>
            <b-card no-body>
              <b-card-header>
                <h5>Zone de destination</h5>
              </b-card-header>
              <div class="chart-container">
                <div :ref="`mobile_out_${index}_2`" :id="`mobile_out_${index}_2`"></div>
              </div>
            </b-card>
            <hr />
          </b-col>
        </b-row>
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
      default: () => []
    },
    flux24DailyIn: {
      type: Array,
      default: () => []
    },
    flux24DailyOut: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      flux24DailyInLocal: [],
      flux24DailyOutLocal: []
    };
  },
  watch: {
    flux24Daily() {},
    async flux24DailyIn() {
      this.flux24DailyInLocal = this.extractFlux23DailyIn();
      await this.sleep(1000);
      this.flux24DailyInLocal.forEach((item, index) => {
        this.mobileEntrance(item, index);
        this.mobileEntranceOrigin(item, index);
      });
    },
    async flux24DailyOut() {
      this.flux24DailyOutLocal = this.extractFlux23DailyOut();
      await this.sleep(1000);
      this.flux24DailyOutLocal.forEach((item, index) => {
        this.mobileOut(item, index);
        this.mobileOutDestination(item, index);
      });
    }
  },
  async mounted() {
    this.flux24DailyInLocal = this.extractFlux23DailyIn();
    this.flux24DailyOutLocal = this.extractFlux23DailyOut();

    await this.sleep(1000);
    this.flux24DailyInLocal.forEach((item, index) => {
      this.mobileCalc(item, `#mobile_entrance_${index}`);
      this.mobileEntranceOrigin(item, index);
    });
    this.flux24DailyOutLocal.forEach((item, index) => {
      this.mobileCalc(item, `#mobile_out_${index}`);
      this.mobileOutDestination(item, index);
    });
  },
  methods: {
    fluxInPercent(items) {
      let totalReference = 0;
      items
        .filter(x => x.isReference)
        .map(item => {
          totalReference += item.volume;
        });
      let totalObservation = 0;
      items
        .filter(x => !x.isReference)
        .map(item => {
          totalObservation += item.volume;
        });
      let difference = totalObservation - totalReference;

      return Math.round((difference * 100) / totalReference);
    },
    fluxVolumObservation(items) {
      let totalReference = 0;
      items
        .filter(x => x.isReference)
        .map(item => {
          totalReference += item.volume;
        });
      let totalObservation = 0;
      items
        .filter(x => !x.isReference)
        .map(item => {
          totalObservation += item.volume;
        });
      let difference = totalObservation - totalReference;

      return Math.round(difference);
    },
    sleep(ms) {
      return new Promise(resolve => setTimeout(resolve, ms));
    },
    extractFlux23DailyOut() {
      let flux24DailyOutLocal = [];
      if (this.flux24DailyOut.length > 0) {
        this.flux24DailyOut.forEach(item => {
          let index = flux24DailyOutLocal.findIndex(x =>
            x.find(y => y.origin == item.origin)
          );
          if (index == -1) {
            let element = [];
            element.push(item);
            flux24DailyOutLocal.push(element);
          } else {
            flux24DailyOutLocal[index].push(item);
          }
        });
      }
      return flux24DailyOutLocal;
    },
    extractFlux23DailyIn() {
      let flux24DailyInLocal = [];
      if (this.flux24DailyIn.length > 0) {
        this.flux24DailyIn.forEach(item => {
          let index = flux24DailyInLocal.findIndex(x =>
            x.find(y => y.destination == item.destination)
          );
          if (index == -1) {
            let element = [];
            element.push(item);
            flux24DailyInLocal.push(element);
          } else {
            flux24DailyInLocal[index].push(item);
          }
        });
      }
      return flux24DailyInLocal;
    },
    mobileCalc(dataPram, ref) {
      // set the dimensions and margins of the graph
      var margin = { top: 10, right: 30, bottom: 60, left: 80 },
        width = 400 - margin.left - margin.right,
        height = 250 - margin.top - margin.bottom;

      // append the svg object to the body of the page
      var svg = d3
        .select(ref)
        .append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

      let data = [];
      let DataReference = [];
      let totalReference = 0;
      let referenceAverage = 0;
      dataPram
        .filter(x => x.isReference)
        .forEach(item => {
          let element = DataReference.find(x => x.date == item.date);
          if (element) {
            element.volume += item.volume;
          } else {
            DataReference.push({
              date: item.date,
              volume: item.volume
            });
          }
        });

      DataReference.forEach(item => {
        totalReference += item.volume;
      });

      referenceAverage = totalReference / DataReference.length;

      dataPram
        .filter(x => !x.isReference)
        .forEach(item => {
          let element = data.find(x => x.date == item.date);
          if (element) {
            element.volume += item.volume;
          } else {
            data.push({
              date: item.date,
              volume: item.volume
            });
          }
        });
      data.forEach(item => {
        let difference = item.volume - referenceAverage;
        let percent = (difference * 100) / referenceAverage;
        item.volume = percent;
      });

      // Add X axis --> it is a date format
      var x = d3
        .scaleBand()
        .domain(data.map(d => d.date))
        .range([0, width]);

      svg
        .append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x).tickSize(0))
        .selectAll("text")
        .style("text-anchor", "end")
        .attr("dx", "-.8em")
        .attr("dy", ".15em")
        .attr("transform", "rotate(-65)");

      // let first = 2 * referenceAverage - d3.max(data, d => d.volume);
      // Add Y axis
      var y = d3
        .scaleLinear()
        .domain([-100, 100])
        .range([height, 0]);
      svg.append("g").call(d3.axisLeft(y));

      // create a tooltip
      var tooltip = d3
        .select(ref)
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
          .html(
            `${Math.round(
              ((d.volume * referenceAverage) / 100)+referenceAverage
            ).toLocaleString(undefined, { minimumFractionDigits: 0 })}`
          )
          .style("left", d3.mouse(this)[0] + 60 + "px")
          .style("top", d3.mouse(this)[1] - 40 + "px")
          .style("cursor", "pointer");
      };
      var mouseleave = function(d) {
        tooltip.style("opacity", 0);
      };

      var mousemoveAverage = function(d) {
        tooltip
          .html(
            `${Math.round(referenceAverage).toLocaleString(
              undefined, // leave undefined to use the browser's locale,
              // or use a string like 'en-US' to override it.
              { minimumFractionDigits: 0 }
            )}`
          )
          .style("left", d3.mouse(this)[0] + 60 + "px")
          .style("top", d3.mouse(this)[1] - 40 + "px")
          .style("cursor", "pointer");
      };

      svg
        .append("line") // attach a line
        .style("stroke", "#9e9e9e") // colour the line
        .attr("x1", 0) // x position of the first end of the line
        .attr("y1", height / 2) // y position of the first end of the line
        .attr("x2", width) // x position of the second end of the line
        .attr("y2", height / 2)
        .on("mouseover", mouseover)
        .on("mousemove", mousemoveAverage)
        .on("mouseleave", mouseleave);

      // Draw the line
      svg
        .datum(data)
        .append("path")
        .attr("fill", "none")
        .attr("stroke", "#00b065")
        .attr("stroke-width", 1.5)
        .attr(
          "d",
          d3
            .line()
            .x(function(d) {
              return x(d.date);
            })
            .y(function(d) {
              return y(d.volume);
            })
        );

      svg
        .append("g")
        .selectAll("dot")
        .data(data)
        .enter()
        .append("circle")
        .attr("cx", function(d) {
          return x(d.date);
        })
        .attr("cy", function(d) {
          return y(d.volume);
        })
        .attr("r", 5)
        .attr("fill", "#69b3a2")
        .on("mouseover", mouseover)
        .on("mousemove", mousemove)
        .on("mouseleave", mouseleave);
    },
    mobileEntranceOrigin(data, index) {
      let localData = [];
      data.forEach(item => {
        let element = localData.find(x => x.origin == item.origin);
        if (element) {
          if (item.isReference) {
            element.volume_reference = item.volume;
          } else {
            element.volume = item.volume;
          }
        } else {
          if (item.isReference) {
            localData.push({
              origin: item.origin,
              volume_reference: item.volume
            });
          } else {
            localData.push({
              origin: item.origin,
              volume: item.volume
            });
          }
        }
      });

      var margin = { top: 20, right: 30, bottom: 40, left: 90 },
        width = 400 - margin.left - margin.right,
        height = 400 - margin.top - margin.bottom;

      // append the svg object to the body of the page
      var svg = d3
        .select(`#mobile_entrance_${index}_2`)
        .append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

      var subgroups = ["origin", "volume_reference", "volume"];

      // List of groups = species here = value of the first column called group -> I show them on the X axis
      var groups = d3
        .map(localData, function(d) {
          return d.origin;
        })
        .keys();

      // Add X axis
      var x = d3
        .scaleLinear()
        .domain([0, d3.max(data, d => d.volume + d.volume / 2)])
        .range([0, width]);
      svg
        .append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x).tickSizeOuter(0))
        .selectAll("text")
        .attr("transform", "translate(-10,0)rotate(-45)")
        .style("text-anchor", "end");

      // Add Y axis
      var y = d3
        .scaleBand()
        .domain(groups)
        .range([height, 0])
        .padding([0.2]);
      svg.append("g").call(d3.axisLeft(y));

      // color palette = one color per subgroup
      var color = d3
        .scaleOrdinal()
        .domain(subgroups)
        .range(["#00b065", "#9e9e9e"]);

      //stack the data? --> stack per subgroup
      var stackedData = d3.stack().keys(subgroups)(localData);

      // Show the bars
      svg
        .append("g")
        .selectAll("g")
        // Enter in the stack data = loop key per key = group per group
        .data(stackedData)
        .enter()
        .append("g")
        .attr("fill", function(d) {
          return color(d.key);
        })
        .selectAll("rect")
        // enter a second time = loop subgroup per subgroup to add all rectangles
        .data(function(d) {
          return d;
        })
        .enter()
        .append("rect")
        .attr("y", function(d) {
          return y(d.data.origin);
        })
        .attr("x", function(d) {
          return x(d[0]);
        })
        .attr("width", function(d) {
          return x(d[1]) - x(d[0]) ?? 0;
        })
        .attr("height", y.bandwidth());
    },
    mobileOutDestination(data, index) {
      let localData = [];
      data.forEach(item => {
        let element = localData.find(x => x.destination == item.destination);
        if (element) {
          if (item.isReference) {
            element.volume_reference = item.volume;
          } else {
            element.volume = item.volume;
          }
        } else {
          if (item.isReference) {
            localData.push({
              destination: item.destination,
              volume_reference: item.volume
            });
          } else {
            localData.push({
              origin: item.destination,
              volume: item.volume
            });
          }
        }
      });

      var margin = { top: 20, right: 30, bottom: 40, left: 90 },
        width = 400 - margin.left - margin.right,
        height = 400 - margin.top - margin.bottom;

      // append the svg object to the body of the page
      var svg = d3
        .select(`#mobile_out_${index}_2`)
        .append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

      var subgroups = ["destination", "volume_reference", "volume"];

      // List of groups = species here = value of the first column called group -> I show them on the X axis
      var groups = d3
        .map(localData, function(d) {
          return d.destination;
        })
        .keys();

      // Add X axis
      var x = d3
        .scaleLinear()
        .domain([0, d3.max(data, d => d.volume)])
        .range([0, width]);
      svg
        .append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x).tickSizeOuter(0))
        .selectAll("text")
        .attr("transform", "translate(-10,0)rotate(-45)")
        .style("text-anchor", "end");

      // Add Y axis
      var y = d3
        .scaleBand()
        .domain(groups)
        .range([height, 0])
        .padding([0.2]);
      svg.append("g").call(d3.axisLeft(y));

      // color palette = one color per subgroup
      var color = d3
        .scaleOrdinal()
        .domain(subgroups)
        .range(["#00b065", "#9e9e9e"]);

      //stack the data? --> stack per subgroup
      var stackedData = d3.stack().keys(subgroups)(localData);

      // Show the bars
      svg
        .append("g")
        .selectAll("g")
        // Enter in the stack data = loop key per key = group per group
        .data(stackedData)
        .enter()
        .append("g")
        .attr("fill", function(d) {
          return color(d.key);
        })
        .selectAll("rect")
        // enter a second time = loop subgroup per subgroup to add all rectangles
        .data(function(d) {
          return d;
        })
        .enter()
        .append("rect")
        .attr("y", function(d) {
          return y(d.data.destination);
        })
        .attr("x", function(d) {
          return x(d[0]);
        })
        .attr("width", function(d) {
          return x(d[1]) - x(d[0]);
        })
        .attr("height", y.bandwidth());
    },
    show() {
      return new Promise((resolver, reject) => {
        if (this.flux24Daily.length == 0) {
          resolver(null);
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
          .attr(
            "transform",
            "translate(" + margin.left + "," + margin.top + ")"
          );

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
        resolver(null);
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
.percent {
  font-size: 2.5rem;
}
.percent-p {
  font-size: 1.1rem;
}
.chart-container {
  div {
    position: relative;
  }
}
</style>