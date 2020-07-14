<template>
  <b-container class="p-0 flux-chart">
    <b-row no-gutters>
      <b-col cols="12" md="4" class="pl-0 pr-2" ref="mobility">
        <b-row v-for="(item,index) in flux24DailyInLocal" :key="index" class="mb-3">
          <b-col cols="12">
            <h3>{{item[0].destination}}</h3>
            <b-card
              class="mb-3 flux-mobility"
              :class="{'active':fluxType==1}"
              @click="selectFluxType(1)"
            >
              <h5 class="percent-title">Mobilité entrante</h5>

              <div class="percent flux-in-color">{{fluxInPercent(item)}}%​</div>
              <p v-if="fluxVolumObservation(item)>0" class="percent-p text-dash-color">
                {{fluxVolumObservation(item).toLocaleString(
                undefined,
                { minimumFractionDigits: 0 })}} personnes de plus sont entrés dans la zone
              </p>
              <p v-else class="percent-p text-dash-color">
                {{(fluxVolumObservation(item)*-1).toLocaleString(
                undefined,
                { minimumFractionDigits: 0 })}} personnes de moins sont entrés dans la zone
              </p>
            </b-card>
            <b-card no-body class="mb-3 p-2" :ref="`mobile_entrance_${index}_card`">
              <div class="chart-container">
                <canvas
                  height="200"
                  width="100vh"
                  :ref="`mobile_entrance_${index}`"
                  :id="`mobile_entrance_${index}`"
                ></canvas>
              </div>
            </b-card>

            <b-card no-body :ref="`mobile_entrance_${index}_2_card`">
              <div class="chart-container">
                <div :ref="`mobile_entrance_${index}_2`" :id="`mobile_entrance_${index}_2`"></div>
              </div>
            </b-card>
          </b-col>
        </b-row>
      </b-col>
      <b-col cols="12" md="4" class="pr-0 pl-2">
        <b-row v-for="(item,index) in flux24DailyOutLocal" :key="index" class="mb-3">
          <b-col cols="12">
            <h3>&nbsp;</h3>
            <b-card
              class="mb-3 flux-mobility"
              :class="{'active':fluxType==2}"
              @click="selectFluxType(2)"
            >
              <h5 class="percent-title">Mobilité sortante</h5>
              <div class="percent flux-out-color">{{fluxInPercent(item)}}%​</div>
              <p v-if="fluxVolumObservation(item)>0" class="percent-p text-dash-color">
                {{fluxVolumObservation(item).toLocaleString(
                undefined,
                { minimumFractionDigits: 0 })}} personnes de plus sont sorties de la zone
              </p>
              <p v-else class="percent-p text-dash-color">
                {{(fluxVolumObservation(item)*-1).toLocaleString(
                undefined,
                { minimumFractionDigits: 0 })}} personnes de moins sont sorties de la zone
              </p>
            </b-card>
            <b-card no-body class="mb-3 p-2" :ref="`mobile_out_${index}_card`">
              <div class="chart-container">
                <canvas
                  height="200"
                  width="100vh"
                  :ref="`mobile_out_${index}`"
                  :id="`mobile_out_${index}`"
                ></canvas>
              </div>
            </b-card>
            <b-card no-body :ref="`mobile_out_${index}_2_card`">
              <div class="chart-container">
                <div :ref="`mobile_out_${index}_2`" :id="`mobile_out_${index}_2`"></div>
              </div>
            </b-card>
          </b-col>
        </b-row>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import * as d3 from "d3";
import { mapState, mapMutations } from "vuex";
import { PALETTE } from "../config/env";
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
  computed: {
    ...mapState({
      fluxType: state => state.flux.fluxType
    })
  },
  watch: {
    async flux24DailyIn() {
      this.flux24DailyInLocal = this.extractFlux23DailyIn();

      this.$nextTick(() => {
        this.flux24DailyInLocal.forEach((item, index) => {
          this.mobileCalc(
            item,
            `mobile_entrance_${index}`,
            PALETTE.flux_in_color
          );
          this.mobileEntranceOrigin(item, index);
        });
      });
    },
    async flux24DailyOut() {
      this.flux24DailyOutLocal = this.extractFlux23DailyOut();

      this.$nextTick(() => {
        this.flux24DailyOutLocal.forEach((item, index) => {
          this.mobileCalc(item, `mobile_out_${index}`, PALETTE.flux_out_color);
          this.mobileOutDestination(item, index);
        });
      });
    }
  },
  async mounted() {
    this.flux24DailyInLocal = this.extractFlux23DailyIn();
    this.flux24DailyOutLocal = this.extractFlux23DailyOut();

    this.$nextTick(() => {
      this.flux24DailyInLocal.forEach((item, index) => {
        this.mobileCalc(
          item,
          `mobile_entrance_${index}`,
          PALETTE.flux_in_color
        );
        this.mobileEntranceOrigin(item, index);
      });
    });
    this.$nextTick(() => {
      this.flux24DailyOutLocal.forEach((item, index) => {
        this.mobileCalc(item, `mobile_out_${index}`, PALETTE.flux_out_color);
        this.mobileOutDestination(item, index);
      });
    });
  },
  methods: {
    ...mapMutations(["setFluxType"]),
    selectFluxType(value) {
      this.setFluxType(value);
    },
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
    mobileCalc(dataPram, ref, color) {
      // set the dimensions and margins of the graph
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

      const tempData = {
        type: "line",
        data: {
          labels: data.map(x => new Date(x.date)),
          datasets: [
            {
              label: "Volume",
              fill: false,
              borderColor: color,
              backgroundColor: "rgb(166,180,205, 0.2)",
              data: data.map(x => ({ x: new Date(x.date), y: x.volume })),
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.4
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            display: false
          },
          title: {
            display: false,
            text: ""
          },
          plugins: {
            crosshair: {
              line: {
                color: "#F66", // crosshair line color
                width: 1, // crosshair line width
                dashPattern: [5, 5] // crosshair line dash pattern
              },
              zoom: {
                enabled: false
              },
              sync: {
                enabled: false // enable trace line syncing with other charts
              }
            }
          },
          tooltips: {
            mode: "interpolate",
            intersect: false,
            callbacks: {
              title: (a, d) => {
                return this.moment(a[0].xLabel).format("DD.MM");
              },
              label: function(i, d) {
                return (
                  d.datasets[i.datasetIndex].label +
                  ": " +
                  Math.round(
                    referenceAverage * i.yLabel,
                    0
                  ).toLocaleString(undefined, { minimumFractionDigits: 0 })
                );
              }
            }
          },
          scales: {
            xAxes: [
              {
                display: true,
                gridLines: {
                  display: true
                },
                scaleLabel: {
                  display: false,
                  labelString: "Month",
                },
                type: "time",
                 ticks:{
                   fontSize:9
                 },
                time: {
                  unit: "day",
                  unitStepSize: 1,
                  displayFormats: {
                    day: "DD.MM"
                  }
                }
              }
            ],
            yAxes: [
              {
                display: true,
                ticks: {
                  fontSize:9,
                  min: -100,
                  max: 100,
                  callback: function(value) {
                    return value + "%";
                  }
                },
                scaleLabel: {
                  display: false,
                  labelString: "Percentage"
                }
              }
            ]
          }
        }
      };
      const myLineChart = new Chart(
        this.$refs[ref][0].getContext("2d"),
        tempData
      );
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

      localData = localData.slice(0, 10);

      localData = localData.sort((a, b) => {
        return Number(a.volume_reference ?? 0) + Number(a.volume ?? 0) >
          Number(b.volume_reference ?? 0) + Number(b.volume ?? 0)
          ? 1
          : -1;
      });

      const refInput = `mobile_out_${index}_2_card`;
      let elementPosition = this.$refs[refInput][0].clientWidth;
      var margin = { top: 20, right: 30, bottom: 40, left: 60 },
        width = elementPosition - margin.left - margin.right,
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

      let maxData = d3.max(localData, d => d.volume_reference + d.volume);

      // Add X axis
      var x = d3
        .scaleLinear()
        .domain([0, maxData])
        .range([0, width]);
      svg
        .append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x).tickSizeOuter(0))
        .selectAll("text")
        .attr("transform", "translate(-10,0)rotate(-45)")
        .style("text-anchor", "end")
        .style("color", "black")
        .style("font-size", "0.4rem");

      // Add Y axis
      var y = d3
        .scaleBand()
        .domain(groups)
        .range([height, 0])
        .padding([0.2]);
      svg
        .append("g")
        .call(d3.axisLeft(y))
        .selectAll("text")
        .style("text-anchor", "end")
        .style("font-size", "0.4rem")
        .style("color", "black");

      // color palette = one color per subgroup
      var color = d3
        .scaleOrdinal()
        .domain(subgroups)
        .range([PALETTE.flux_out_color, "#e0e0e0"]);

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

      localData = localData.slice(0, 10);
      localData = localData.sort((a, b) => {
        return Number(a.volume_reference ?? 0) + Number(a.volume ?? 0) >
          Number(b.volume_reference ?? 0) + Number(b.volume ?? 0)
          ? 1
          : -1;
      });

      const refInput = `mobile_entrance_${index}_2_card`;
      let elementPosition = this.$refs[refInput][0].clientWidth;
      var margin = { top: 20, right: 30, bottom: 40, left: 60 },
        width = elementPosition - margin.left - margin.right,
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

      let maxData = d3.max(localData, d => d.volume_reference + d.volume);

      // Add X axis
      var x = d3
        .scaleLinear()
        .domain([0, maxData])
        .range([0, width]);
      svg
        .append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x).tickSizeOuter(0))
        .selectAll("text")
        .attr("transform", "translate(-10,0)rotate(-45)")
        .style("text-anchor", "end")
        .style("color", "black")
        .style("font-size", "0.4rem");

      // Add Y axis
      var y = d3
        .scaleBand()
        .domain(groups)
        .range([height, 0])
        .padding([0.2]);
      svg
        .append("g")
        .call(d3.axisLeft(y))
        .selectAll("text")
        .style("text-anchor", "end")
        .style("color", "black")
        .style("font-size", "0.4rem");

      // color palette = one color per subgroup
      var color = d3
        .scaleOrdinal()
        .domain(subgroups)
        .range([PALETTE.flux_in_color, "#e0e0e0"]);

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
    }
  }
};
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
@import "@~/sass/_mixins";

.flux-chart {
  @include card-style;
}
.flux-mobility {
  cursor: pointer;
  &.active {
    background: #2e5bff14;
  }
}

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
.percent-title {
  font-size: 1rem;
}
.percent {
  font-size: 2.5rem;
  font-weight: bold;
}
.percent-p {
  font-size: 0.8rem;
}
.chart-container {
  div {
    position: relative;
  }
}
</style>