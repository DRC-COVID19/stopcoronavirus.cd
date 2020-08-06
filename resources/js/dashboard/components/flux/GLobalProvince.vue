<template>
  <b-container>
    <b-row>
      <b-col>
        <div class="chart-container">
          <canvas width="100vh" ref="global_province"></canvas>
        </div>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
export default {
  props: {
    globalData: {
      type: Array,
      default: () => [],
    },
  },
  mounted() {
    this.mobility(this.globalData);
  },
  watch: {
    globalData() {
      this.mobility(this.globalData);
    },
  },
  methods: {
    mobility(data) {
      
      const localData = localData.sort((a, b) => {
        return Number(a.volume ?? 0) < Number(b.volume ?? 0) ? 1 : -1;
      });

      const dataChart = {
        labels: localData.map((d) => d.destination),
        datasets: [
          {
            label: "Référence",
            backgroundColor: "#33ac2e",
            borderColor: "#33ac2e",
            borderWidth: 1,
            data: localData.map((d) => d.volume_reference),
          },
          {
            label: "Observation",
            backgroundColor: PALETTE.flux_out_color,
            borderColor: PALETTE.flux_out_color,
            data: localData.map((d) => d.volume),
          },
        ],
      };

      const myBarChart = new Chart(
        this.$refs.global_province.getContext("2d"),
        {
          type: "horizontalBar",
          data: dataChart,
          options: {
            elements: {
              rectangle: {
                borderWidth: 2,
              },
            },
            responsive: true,
            legend: {
              position: "bottom",
              labels: {
                fontSize: 9,
              },
            },
            title: {
              display: false,
              text: "Rapport des sorties avant et après confinement",
              color: "#6c757d",
            },
            scales: {
              xAxes: [
                {
                  ticks: {
                    beginAtZero: true,
                    fontSize: 9,
                  },
                },
              ],
              yAxes: [
                {
                  ticks: {
                    fontSize: 9,
                  },
                },
              ],
            },
            plugins: {
              crosshair: {
                sync: {
                  enabled: false, // enable trace line syncing with other charts
                },
              },
            },
          },
        }
      );
    },
  },
};
</script>

<style>
</style>