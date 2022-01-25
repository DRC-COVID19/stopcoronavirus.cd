<script>
import { Line } from 'vue-chartjs'

export default {
  props: ['data'],
  extends: Line,
  data () {
    return {
      options: { responsive: true },
      chartdata: {
        labels: [
        ],
        datasets: [
          {
            label: 'Data 1',
            data: [2, 10, 5, 9, 0, 6, 20],
            backgroundColor: 'transparent',
            borderColor: 'rgba(1, 116, 188, 0.50)',
            pointBackgroundColor: 'rgba(171, 71, 188, 1)'
          }
        ]
      }
    }
  },
  mounted () {
    this.renderData()
    this.renderChart(this.chartdata, this.options)
  },
  methods: {
    renderData () {
      for (const item of this.data) {
        if (item.form_field_name === 'Nombre des ventilateurs de réanimation occupés par des cas COVID-19') {
          this.chartdata.labels.push(item.last_update)
        }
      }
    }
  }
}
</script>
