<template>
  <b-container class="global_province_container p-0">
    <b-row>
      <b-col cols="12">
        <b-card no-body class="p-2 rounded-0">
          <canvas height="600" :ref="reference" class="global_province"></canvas>
        </b-card>
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
    reference: {
      type: String,
      default: null,
      required: true,
    },
    color: {
      type: String,
      default: "33ac2e",
    },
    title: {
      type: String,
      default: null,
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
      const dataChart = {
        labels: data.map((d) => d.zone),
        datasets: [
          {
            backgroundColor: this.color,
            borderColor: this.color,
            borderWidth: 1,
            data: data.map((d) => d.volume),
          },
        ],
      };

      const myBarChart = new Chart(
        this.$refs[this.reference].getContext("2d"),
        {
          type: "horizontalBar",
          data: dataChart,
          options: {
            responsive: true,
            legend: {
              display: false,
              position: "bottom",
              labels: {},
            },
            title: {
              display: !!this.title,
              text: this.title,
              color: "#6c757d",
            },
            scales: {
              xAxes: [
                {
                  ticks: {
                    beginAtZero: false,
                    fontSize: 9,
                  },
                },
              ],
              yAxes: [
                {
                  ticks: {
                    beginAtZero: false,
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
                zoom: {
                  enabled: false,
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
<style lang="scss" scoped>
</style>