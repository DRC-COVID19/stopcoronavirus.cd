<template>
  <b-container fluid class="p-0" ref="tendanceContainer">
    <b-row no-gutters>
      <b-col cols="12" class="pl-0 pr-2">
        <canvas width="100vh" ref="tendanceChart" id="tendanceChart" />
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import * as d3 from "../../lib/d3.v5.min";
import { DRC_COVID_EVENT, PALETTE } from "../../config/env";
import Chart from "chart.js";
import "chartjs-plugin-annotation";
import { mapState, mapMutations } from "vuex";
export default {
  props: {
    flux24Daily: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      myLineChart: null,
    };
  },
  watch: {
    flux24Daily() {
      if (this.flux24Daily.length > 0) {
        this.$nextTick(() => {
          this.drawChart(this.flux24Daily, this.$refs.tendanceChart);
        });
      }
    },
  },
  computed: {
    ...mapState({
      fluxGeoOptions: (state) => state.flux.fluxGeoOptions,
    }),
  },
  mounted() {
    if (this.flux24Daily.length > 0) {
      this.$nextTick(() => {
        this.drawChart(this.flux24Daily, this.$refs.tendanceChart);
      });
    }
  },
  methods: {
    ...mapMutations(["setTendanceChartSelectedValue"]),
    drawChart(data, ref) {
      if (!data) {
        return;
      }
      const tempData = {
        type: "line",
        data: {
          labels: data.map((x) => new Date(x.date)),
          datasets: [
            {
              label: "Volume",
              fill: false,
              borderColor: "rgb(51, 172, 46)",
              backgroundColor: "rgb(166,180,205, 0.2)",
              data: data.map((x) => ({ x: new Date(x.date), y: x.volume })),
              interpolate: true,
              showLine: true,
              pointRadius: 2,
              lineTension: 0.5,
              xAxisID: "x-axis-0",
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          // events: ["click"],
          onClick: (e, argument) => {
            if (argument.length>0) {
              const firstPoint=argument[0];
              const value =
                myLineChart2.data.datasets[firstPoint._datasetIndex].data[
                  firstPoint._index
                ];
              this.setTendanceChartSelectedValue(value);
            }
          },
          legend: {
            display: false,
          },
          title: {
            display: true,
            text: "Flux de tendance" + this.getZone,
            fontSize: 9
          },
          scales: {
            xAxes: [
              {
                display: true,
                id: "x-axis-0",
                scaleLabel: {
                  display: false,
                  labelString: "Month",
                },
                type: "time",
                fontSize: 9,
                time: {
                  unit: "day",
                  unitStepSize: 1,
                  displayFormats: {
                    day: "DD.MM",
                  },
                },
              },
            ],
            yAxes: [
              {
                display: true,
                scaleLabel: {
                  display: false,
                  labelString: "Value",
                },
                ticks: {
                  beginAtZero: false,
                },
              },
            ],
          },
          tooltips: {
            enabled: true,
            mode: "interpolate",
            intersect: false,
            callbacks: {
              title: (a, d) => {
                return this.moment(a[0].xLabel).format("DD.MM.Y");
              },
              label: function (i, d) {
                return (
                  d.datasets[i.datasetIndex].label + ": " + i.yLabel.toFixed(0)
                );
              },
            },
          },
          annotation: {
            events: ["mouseenter", "mouseleave"],
            drawTime: "afterDraw",
            annotations: DRC_COVID_EVENT.filter((x) =>
              x.measures.some((z) =>
                z.zones.some((y) => [...this.fluxGeoOptions, "ALL"].includes(y))
              )
            ).map((item, index) => {
              return {
                id: "line" + index,
                type: "line",
                mode: "vertical",
                scaleID: "x-axis-0",
                value: new Date(item.date),
                borderColor: PALETTE.flux_presence,
                borderWidth: item.isImportant ? 3 : 2,
                label: {
                  content: item.measures
                    .filter((x) =>
                      x.zones.some((y) =>
                        [...this.fluxGeoOptions, "ALL"].includes(y)
                      )
                    )
                    .map((x) => x.item),
                  enabled: false,
                  position: "top",
                },
                onMouseenter(e) {
                  this.options.borderColor = PALETTE.flux_in_color;
                  this.options.label.enabled = true;
                  myLineChart2.update();
                },
                onMouseleave(e) {
                  this.options.borderColor = PALETTE.flux_presence;
                  this.options.label.enabled = false;
                  myLineChart2.update();
                },
              };
            }),
          },
          plugins: {
            crosshair: {
              sync: {
                enabled: false,
              },
              zoom: {
                enabled: false, // enable zooming
                zoomboxBackgroundColor: "rgba(66,133,244,0.2)", // background color of zoom box
                zoomboxBorderColor: "#48F", // border color of zoom box
                zoomButtonText: "Reset Zoom", // reset zoom button text
                zoomButtonClass: "reset-zoom", // reset zoom button class
              },
            },
          },
        },
      };
      if (this.myLineChart) this.myLineChart.destroy();
      this.myLineChart = new Chart(ref.getContext("2d"), tempData);
      var myLineChart2 = this.myLineChart;
    },
    drawChart1(data) {
      const timeConv = d3.timeParse("%Y-%m-%d");
      data.forEach(element => {
        element.date = timeConv(element.date);
      });
      let elementPosition = 900; // this.$refs.tendanceContainer.clientWidth - 20;
      const margin = { top: 10, right: 30, bottom: 60, left: 60 },
        width = elementPosition - margin.left - margin.right,
        height = 250 - margin.top - margin.bottom;

      const svg = d3
        .select(this.$refs.tendanceChart)
        .append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

      const xScale = d3.scaleTime().range([0, width]);
      const yScale = d3.scaleLinear().rangeRound([height, 0]);

      xScale.domain(
        d3.extent(data, function(d) {
          return d.date;
        })
      );

      yScale.domain([
        0,
        d3.max(data, function(d) {
          return d.volume;
        })
      ]);

      const yaxis = d3
        .axisLeft()
        .ticks(data[0].volume.length)
        .scale(yScale);

      const xaxis = d3
        .axisBottom()
        // .ticks(d3.timeDay.every(1))
        .tickFormat(d3.timeFormat("%d-%m"))
        .scale(xScale);

      svg
        .append("g")
        .attr("class", "axis")
        .attr("transform", "translate(0," + height + ")")
        .call(xaxis);

      svg
        .append("g")
        .attr("class", "axis")
        .call(yaxis)
        .append("text")
        .attr("transform", "rotate(-90)")
        .attr("dy", ".75em")
        .attr("y", 6)
        .style("text-anchor", "end")
        .text("Frequency");

      var strokeDasharray = d3
        .scaleOrdinal()
        .domain([true, false])
        .range(["none", "5,5"]);

      const line = d3
        .line()
        .x(function(d) {
          return xScale(d.date);
        })
        .y(function(d) {
          return yScale(d.volume);
        });

      svg
        .append("path")
        .datum(data)
        .attr("fill", "none")
        .attr("stroke", "steelblue")
        .attr("stroke-width", 1.5)
        .attr("stroke-dasharray", d => {
          console.log(strokeDasharray(d.isReference));
          return strokeDasharray(d.isReference);
        })
        .attr(
          "d",
          d3
            .line()
            .x(function(d) {
              return xScale(d.date);
            })
            .y(function(d) {
              return yScale(d.volume);
            })
        );
    }
  },
  computed: {
    ...mapState({
      fluxGeoOptions : state => state.flux.fluxGeoOptions
    }),
    getZone(){
      if(this.fluxGeoOptions && this.fluxGeoOptions.length > 0)
        return ' à ' + this.fluxGeoOptions[0]
      else return ''
    }
  }
};
</script>

<style lang="scss" scoped>
#tendanceChart {
  height: 100%;
}
</style>
