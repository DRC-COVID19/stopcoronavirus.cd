<template>
  <b-row class="w-100 h-100 mx-0">
    <b-col class="w-100 h-100 mx-0" lg="12">
      <apexchart
        width="100%"
        height="100%"
        :type="type"
        :options="options"
        :series="series"
      ></apexchart>
    </b-col>
  </b-row>
</template>
<script>
export default {
  name: 'ApexChart',
  components: {},
  props: {
    options: {
      type: Object,
      default: () => {
        return {}
      }
    },
    type: {
      type: String,
      default: ''
    },
    series: {
      type: Array,
      default: () => {
        return []
      }
    }
  },

  data () {
    return {
      reportingChart: {},

      operationId: null
    }
  },
  mounted () {},
  computed: {},
  methods: {}
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
</style>
