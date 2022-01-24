<script>
import { Line } from "vue-chartjs";

export default {
  extends: Line,
  data() {
    return {
      options: { responsive: true },
      chartdata:{ 
         labels: [
          "Galiema",
          "CUK",
          "Diamant",
          "MONKOLE",
          "SAINT JOSEPH",
          "VIJANA",
          "KINKOLE"
        ],
        datasets: [
          {
            label: "Data 1",
            data: [2, 10, 5, 9, 0, 6, 20],
            backgroundColor: "transparent",
            borderColor: "rgba(1, 116, 188, 0.50)",
            pointBackgroundColor: "rgba(171, 71, 188, 1)"
          }
        ]
      }
    };
  },
  mounted() {
    this.renderChart(this.chartdata, this.options);
  },
};
</script>
