<script>
import { Line } from 'vue-chartjs'
// const { reactiveProp } = mixins

export default {
  props: ['data'],
  extends: Line,
  // mixins: [reactiveProp],
  data () {
    return {
      options: { responsive: true },
      chartdata: {
        labels: [
        ],
        datasets: [
          {
            label: 'Data 1',
            data: [],
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
      this.data.forEach((item) => {
        if (item.form_field_name === 'Nombre des ventilateurs de réanimation occupés par des cas COVID-19') {
          this.chartdata.datasets[0].data.push(item.form_field_value)
          this.chartdata.labels.push(moment(item.last_update).format('Do MM YY'))
        }
      })
    }
  }
}
</script>
